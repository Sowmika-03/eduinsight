<?php

namespace App\Http\Controllers;

use App\Models\NlQuery;
use App\Services\NlpQueryParser;
use App\Services\QueryResultsFormatter;
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
        return view('nlp.create-query');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'natural_language_query' => 'required|string|min:5|max:500',
        ]);

        $nlQuery = new NlQuery();
        $nlQuery->user_id = Auth::id();
        $nlQuery->natural_language_query = $validated['natural_language_query'];
        $nlQuery->query_status = 'pending';

        try {
            $startTime = microtime(true);

            $parseResult = $this->nlpParser->parse($validated['natural_language_query']);

            $endTime = microtime(true);
            $executionTime = round(($endTime - $startTime) * 1000);

            if ($parseResult['success']) {
                $generatedSql = $parseResult['sql'];
                $queryResult = \DB::select($generatedSql);

                // Format results for display
                $formattedResults = QueryResultsFormatter::format($queryResult);

                $nlQuery->generated_sql = $generatedSql;
                $nlQuery->query_result = json_encode($queryResult);
                $nlQuery->query_results_formatted = json_encode($formattedResults['rows']);
                $nlQuery->result_columns = json_encode($formattedResults['columns']);
                $nlQuery->result_count = $formattedResults['count'];
                $nlQuery->query_status = 'success';
                $nlQuery->query_intent = $parseResult['intent'];
                
                // Only show SQL to admin by default
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

        // Detect chart type
        $chartConfig = null;
        if (!empty($results) && !empty($columns)) {
            $chartConfig = QueryResultsFormatter::detectChartType($columns, $results);
            if ($chartConfig) {
                $chartConfig['data'] = QueryResultsFormatter::prepareChartData($results, $chartConfig);
            }
        }

        // Determine if SQL should be visible
        $showSql = Auth::user()->role->slug === 'admin' || $nlQuery->show_sql_to_user;

        return view('nlp.show-query', compact('nlQuery', 'results', 'columns', 'chartConfig', 'showSql'));
    }
}

