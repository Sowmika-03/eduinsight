<?php

namespace App\Http\Controllers;

use App\Models\NlQuery;
use App\Services\NlpQueryParser;
use App\Services\QueryResultsFormatter;
use App\Services\RoleAccessControlService;
use Illuminate\Http\Request;
use Auth;

class NlQueryController extends Controller
{
    protected $nlpParser;

    public function __construct(NlpQueryParser $nlpParser)
    {
        $this->nlpParser = $nlpParser;
    }

    public function index(Request $request)
    {
        $query = NlQuery::with('user');
        if (Auth::user()->role->slug !== 'admin') {
            $query->where('user_id', Auth::id());
        }
        if ($search = $request->get('search')) {
            $query->where('natural_language_query', 'LIKE', "%{$search}%");
        }
        if ($status = $request->get('status')) {
            $query->where('query_status', $status);
        }
        $queries = $query->latest()->paginate(15)->withQueryString();
        return view('nlp.queries', compact('queries'));
    }

    public function create()
    {
        $roleContext = RoleAccessControlService::getRoleContextForUser(Auth::user());
        return view('nlp.create-query', compact('roleContext'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'natural_language_query' => 'required|string|min:3|max:500',
        ]);

        $nlQuery = new NlQuery();
        $nlQuery->user_id = Auth::id();
        $nlQuery->natural_language_query = $validated['natural_language_query'];
        $nlQuery->query_status = 'pending';

        try {
            $startTime = microtime(true);

            $rawParseResult = $this->nlpParser->parse($validated['natural_language_query']);

            // Apply Role-Based Access Scoping
            $parseResult = RoleAccessControlService::applyRoleScope($rawParseResult, Auth::user());

            $endTime = microtime(true);
            $executionTime = round(($endTime - $startTime) * 1000);

            if ($parseResult['success']) {
                $generatedSql = $parseResult['sql'];

                if (!empty($parseResult['unauthorized'])) {
                    $queryResult = [];
                    $formattedResults = ['rows' => [], 'columns' => [], 'count' => 0];
                } else {
                    $queryResult = \DB::select($generatedSql);
                    $formattedResults = QueryResultsFormatter::format($queryResult);
                    $formattedResults['rows'] = QueryResultsFormatter::enrichStudentPredictions($formattedResults['rows']);
                }

                $nlQuery->generated_sql = $generatedSql;
                $nlQuery->query_result = json_encode($queryResult);
                $nlQuery->query_results_formatted = json_encode($formattedResults['rows']);
                $nlQuery->result_columns = json_encode($formattedResults['columns']);
                $nlQuery->result_count = $formattedResults['count'];
                $nlQuery->query_status = 'success';
                $nlQuery->query_intent = $parseResult['intent'] ?? 'search';
                
                $nlQuery->show_sql_to_user = Auth::user()->role->slug === 'admin';
            } else {
                $nlQuery->query_status = 'error';
                $nlQuery->error_message = $parseResult['error'];
            }

            $nlQuery->execution_time = $executionTime;
        } catch (\Exception $e) {
            $nlQuery->query_status = 'error';
            $nlQuery->error_message = $e->getMessage();
        }

        $nlQuery->save();

        return redirect()->route('nlp.show', $nlQuery)->with('success', 'Query processed successfully');
    }

    public function show(NlQuery $nlQuery)
    {
        // Verify user owns this query or is admin
        if ($nlQuery->user_id !== Auth::id() && Auth::user()->role->slug !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        // Get formatted results
        $results = $nlQuery->query_results_formatted 
            ? json_decode($nlQuery->query_results_formatted, true) 
            : [];
        
        $columns = $nlQuery->result_columns 
            ? json_decode($nlQuery->result_columns, true) 
            : [];

        // Reparse query metadata dynamically & apply role scope
        $rawParseResult = $this->nlpParser->parse($nlQuery->natural_language_query);
        $parseResult = RoleAccessControlService::applyRoleScope($rawParseResult, Auth::user());

        $intent = $parseResult['intent'] ?? 'search';
        $entities = $parseResult['entities'] ?? [];
        $filters = $parseResult['filters'] ?? [];
        $unauthorized = $parseResult['unauthorized'] ?? false;
        $authorizationMessage = $parseResult['authorization_message'] ?? null;
        $roleContext = $parseResult['role_context'] ?? [];

        // Enrich student predictive insights
        $results = QueryResultsFormatter::enrichStudentPredictions($results);

        // Calculate dynamic KPIs
        $kpis = QueryResultsFormatter::calculateKpis($results, $entities, $filters);

        // Generate Phase 3 AI Intelligence Assets
        $aiSummary = QueryResultsFormatter::generateSummary(
            $nlQuery->natural_language_query,
            $results,
            $kpis,
            $intent,
            $entities
        );

        $recommendations = QueryResultsFormatter::generateRecommendations($results, $kpis, $intent);
        $insights = QueryResultsFormatter::generateIntelligentInsights($results, $kpis, $nlQuery->natural_language_query, $entities);
        $explainability = QueryResultsFormatter::generateExplainability($nlQuery->natural_language_query, $results, $kpis, $intent);
        $executiveReport = QueryResultsFormatter::generateExecutiveReport($nlQuery->natural_language_query, $results, $kpis, $intent, $entities);

        // Detect chart configuration dynamically based on intent & dataset
        $chartConfig = null;
        if (!empty($results) && !empty($columns)) {
            $chartConfig = QueryResultsFormatter::detectChartType($columns, $results, $intent, $entities);
            if ($chartConfig) {
                $chartConfig['data'] = QueryResultsFormatter::prepareChartData($results, $chartConfig);
            }
        }

        // Generate dynamic context-aware follow-up suggestions
        $dynamicFollowups = QueryResultsFormatter::generateFollowupQuestions(
            $nlQuery->natural_language_query,
            $entities,
            $intent
        );

        $showSql = Auth::user()->role->slug === 'admin' || $nlQuery->show_sql_to_user;

        return view('nlp.show-query', compact(
            'nlQuery', 'results', 'columns', 'kpis', 'aiSummary', 'chartConfig', 'showSql', 'entities', 'filters', 'intent', 'dynamicFollowups',
            'recommendations', 'insights', 'explainability', 'executiveReport', 'unauthorized', 'authorizationMessage', 'roleContext'
        ));
    }
}
