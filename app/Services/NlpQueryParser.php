<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class NlpQueryParser
{
    /**
     * Cache for dynamic DB entities (programs, branches, departments, semesters, courses)
     */
    protected array $dynamicEntities = [];

    /**
     * Standard program & branch aliases mapping
     */
    protected array $programAliases = [
        'computer science' => 'CSE',
        'computer science engineering' => 'CSE',
        'cs' => 'CSE',
        'cse' => 'CSE',
        'information technology' => 'IT',
        'it' => 'IT',
        'master of computer applications' => 'MCA',
        'computer applications' => 'MCA',
        'mca' => 'MCA',
        'master of business administration' => 'MBA',
        'business administration' => 'MBA',
        'mba' => 'MBA',
        'bachelor of technology' => 'B.Tech',
        'btech' => 'B.Tech',
        'b.tech' => 'B.Tech',
        'electrical & electronics' => 'EEE',
        'eee' => 'EEE',
        'electronics & communication' => 'ECE',
        'ece' => 'ECE',
        'mechanical' => 'ME',
        'me' => 'ME',
    ];

    /**
     * HYBRID NLP PARSER
     * Combines Layer 1 (Keyword Detection) and Layer 2 (Pattern Recognition)
     */
    public function parse(string $query): array
    {
        try {
            $normalizedQuery = trim($query);

            // Step 1: Load dynamic entities from DB schema
            $this->loadDynamicEntities();

            // Layer 1: Keyword Detection Engine
            $layer1Keywords = $this->runLayer1KeywordDetection($normalizedQuery);

            // Layer 2: Academic Pattern Recognition Engine
            $layer2Patterns = $this->runLayer2PatternRecognition($normalizedQuery, $layer1Keywords);

            // Hybrid Fusion Decision Matrix
            $fusionResult = $this->fuseHybridLayers($layer1Keywords, $layer2Patterns, $normalizedQuery);

            $entities = $fusionResult['entities'];
            $intent   = $fusionResult['intent'];
            $filters  = $fusionResult['filters'];

            // Step 5: Dynamic Schema-Aware SQL Builder
            $sql = $this->buildSql($intent, $entities, $filters, $normalizedQuery);

            // Step 6: Query Validation
            $this->validateSql($sql);

            return [
                'success' => true,
                'raw_query' => $normalizedQuery,
                'sql' => $sql,
                'intent' => $intent,
                'filters' => $filters,
                'chart' => [],
                'programs' => $entities['programs'] ?? [],
                'thresholds' => [],
                'prediction' => null,
                'analysis' => null,
                'recommendations' => [],
                'entities' => $entities,
                'hybrid_meta' => [
                    'layer1' => $layer1Keywords,
                    'layer2' => $layer2Patterns,
                ],
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'raw_query' => $query,
                'intent' => 'search',
                'sql' => null,
                'filters' => [],
                'chart' => [],
                'programs' => [],
                'thresholds' => [],
                'prediction' => null,
                'analysis' => null,
                'recommendations' => [],
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Load dynamic values from actual database schema & tables
     */
    protected function loadDynamicEntities(): void
    {
        try {
            $programs = [];
            $branches = [];
            $semesters = [];
            $batches = [];
            $departments = [];
            $courses = [];

            if (Schema::hasTable('students')) {
                $programs = DB::table('students')->whereNotNull('program')->where('program', '!=', '')->distinct()->pluck('program')->toArray();
                $semesters = DB::table('students')->whereNotNull('semester')->where('semester', '!=', '')->distinct()->pluck('semester')->toArray();
                $batches = DB::table('students')->whereNotNull('batch')->where('batch', '!=', '')->distinct()->pluck('batch')->toArray();
            }

            if (Schema::hasTable('branches')) {
                $branches = DB::table('branches')->whereNotNull('branch_name')->pluck('branch_name')->toArray();
            }

            if (Schema::hasTable('faculty')) {
                $departments = DB::table('faculty')->whereNotNull('department')->where('department', '!=', '')->distinct()->pluck('department')->toArray();
            }

            if (Schema::hasTable('courses')) {
                $courses = DB::table('courses')->select('id', 'course_code', 'course_name')->get()->toArray();
            }

            $allPrograms = array_unique(array_merge(['CSE', 'IT', 'MCA', 'MBA', 'B.Tech', 'ECE', 'EEE', 'ME'], $programs, $branches, $departments));

            $this->dynamicEntities = [
                'programs' => array_values($allPrograms),
                'semesters' => array_values(array_unique(array_merge(['1', '2', '3', '4', '5', '6', '7', '8'], $semesters))),
                'batches' => array_values($batches),
                'courses' => $courses,
            ];
        } catch (\Exception $e) {
            $this->dynamicEntities = [
                'programs' => ['CSE', 'IT', 'MCA', 'MBA', 'B.Tech'],
                'semesters' => ['1', '2', '3', '4', '5', '6', '7', '8'],
                'batches' => [],
                'courses' => [],
            ];
        }
    }

    /**
     * LAYER 1: Keyword Detection Engine
     */
    protected function runLayer1KeywordDetection(string $query): array
    {
        $keywords = [
            'programs' => [],
            'all_programs' => false,
            'semester' => null,
            'batch' => null,
            'course' => null,
            'faculty' => null,
            'metrics' => [],
            'attendance_condition' => null,
            'marks_condition' => null,
            'risk_condition' => null,
            'limit' => null,
            'order' => null,
            'target' => 'student',
            'has_count_keyword' => false,
            'has_avg_keyword' => false,
            'has_percentage_keyword' => false,
            'has_compare_keyword' => false,
            'has_highest_keyword' => false,
            'has_lowest_keyword' => false,
        ];

        $lowerQuery = strtolower($query);

        if (preg_match('/\b(?:all departments|all branches|all programs)\b/i', $query)) {
            $keywords['all_programs'] = true;
        }

        // Programs / Branches Extraction
        foreach ($this->programAliases as $alias => $standardProgram) {
            $pattern = '/\b' . preg_quote($alias, '/') . '\b/i';
            if (preg_match($pattern, $query)) {
                if (!in_array($standardProgram, $keywords['programs'])) {
                    $keywords['programs'][] = $standardProgram;
                }
            }
        }

        foreach ($this->dynamicEntities['programs'] as $prog) {
            if ($prog && preg_match('/\b' . preg_quote(strtolower($prog), '/') . '\b/i', $lowerQuery)) {
                $standardProg = strtoupper($prog);
                if (!in_array($standardProg, $keywords['programs'])) {
                    $keywords['programs'][] = $standardProg;
                }
            }
        }

        // Semester Extraction
        if (preg_match('/(?:semester|sem)\s*#?\s*([0-9]+)/i', $query, $matches)) {
            $keywords['semester'] = $matches[1];
        } elseif (preg_match('/([0-9]+)(?:st|nd|rd|th)?\s*(?:sem|semester)/i', $query, $matches)) {
            $keywords['semester'] = $matches[1];
        }

        // Batch Extraction
        if (preg_match('/\b(20[0-9]{2}(?:-20[0-9]{2})?)\b/', $query, $matches)) {
            $keywords['batch'] = $matches[1];
        }

        // Course / Subject Extraction
        foreach ($this->dynamicEntities['courses'] as $course) {
            $cCode = strtolower($course->course_code);
            $cName = strtolower($course->course_name);
            if (str_contains($lowerQuery, $cCode) || str_contains($lowerQuery, $cName)) {
                $keywords['course'] = $course->course_name;
                break;
            }
        }

        // Target Entity Detection
        if (preg_match('/\b(?:faculty|teacher|professor|instructor|staff)\b/i', $query)) {
            $keywords['target'] = 'faculty';
        } elseif (preg_match('/\b(?:course|subject|class|lesson)\b/i', $query)) {
            $keywords['target'] = 'course';
        } elseif (preg_match('/\b(?:department|branch|program)\b/i', $query)) {
            $keywords['target'] = 'department';
        } else {
            $keywords['target'] = 'student';
        }

        // Metrics Detection
        if (preg_match('/\b(?:attendance|attend|present|absent)\b/i', $query)) {
            $keywords['metrics'][] = 'attendance';
        }
        if (preg_match('/\b(?:mark|marks|score|scores|grade|grades|cgpa|failing|fail|failed|passing|pass|passed|exam|test|result)\b/i', $query)) {
            $keywords['metrics'][] = 'marks';
        }
        if (preg_match('/\b(?:risk|at risk|high risk|academic risk)\b/i', $query)) {
            $keywords['metrics'][] = 'risk';
            $keywords['risk_condition'] = 'High Risk';
        }

        // Operator & Threshold Extraction
        if (in_array('attendance', $keywords['metrics']) || str_contains($lowerQuery, 'attendance')) {
            if (preg_match('/between\s+(\d+)%?\s+and\s+(\d+)%?/i', $query, $m)) {
                $keywords['attendance_condition'] = ['operator' => 'BETWEEN', 'val1' => (int)$m[1], 'val2' => (int)$m[2]];
            } elseif (preg_match('/(?:below|less than|under|<)\s*(\d+)%?/i', $query, $m)) {
                $keywords['attendance_condition'] = ['operator' => '<', 'value' => (int)$m[1]];
            } elseif (preg_match('/(?:above|greater than|more than|>|over)\s*(\d+)%?/i', $query, $m)) {
                $keywords['attendance_condition'] = ['operator' => '>', 'value' => (int)$m[1]];
            } elseif (preg_match('/(?:at least|>=)\s*(\d+)%?/i', $query, $m)) {
                $keywords['attendance_condition'] = ['operator' => '>=', 'value' => (int)$m[1]];
            }
        }

        if (in_array('marks', $keywords['metrics']) || str_contains($lowerQuery, 'mark') || str_contains($lowerQuery, 'score') || str_contains($lowerQuery, 'fail') || str_contains($lowerQuery, 'pass')) {
            if (preg_match('/between\s+(\d+)\s+and\s+(\d+)/i', $query, $m)) {
                $keywords['marks_condition'] = ['operator' => 'BETWEEN', 'val1' => (int)$m[1], 'val2' => (int)$m[2]];
            } elseif (preg_match('/(?:below|less than|under|<)\s*(\d+)/i', $query, $m)) {
                $keywords['marks_condition'] = ['operator' => '<', 'value' => (int)$m[1]];
            } elseif (preg_match('/(?:above|greater than|more than|>|over)\s*(\d+)/i', $query, $m)) {
                $keywords['marks_condition'] = ['operator' => '>', 'value' => (int)$m[1]];
            } elseif (preg_match('/(?:failing|failed|fail)/i', $query)) {
                $keywords['marks_condition'] = ['operator' => '<', 'value' => 40];
            } elseif (preg_match('/(?:passing|passed|pass)/i', $query)) {
                $keywords['marks_condition'] = ['operator' => '>=', 'value' => 40];
            }
        }

        // Quantifiers
        if (preg_match('/\b(?:count|how many|total number of)\b/i', $lowerQuery)) {
            $keywords['has_count_keyword'] = true;
        }
        if (preg_match('/\b(?:average|avg|mean)\b/i', $lowerQuery)) {
            $keywords['has_avg_keyword'] = true;
        }
        if (preg_match('/\b(?:what percentage|percentage|percent|%)\b/i', $lowerQuery)) {
            $keywords['has_percentage_keyword'] = true;
        }
        if (preg_match('/\b(?:compare|versus|vs)\b/i', $lowerQuery) || count($keywords['programs']) >= 2) {
            $keywords['has_compare_keyword'] = true;
        }
        if (preg_match('/\b(?:highest|maximum|max|top|best)\b/i', $lowerQuery)) {
            $keywords['has_highest_keyword'] = true;
        }
        if (preg_match('/\b(?:lowest|minimum|min|bottom|worst)\b/i', $lowerQuery)) {
            $keywords['has_lowest_keyword'] = true;
        }

        // Limit & Order
        if (preg_match('/\btop\s+(\d+)\b/i', $query, $m)) {
            $keywords['limit'] = (int)$m[1];
            $keywords['order'] = 'DESC';
        } elseif (preg_match('/\bbottom\s+(\d+)\b/i', $query, $m)) {
            $keywords['limit'] = (int)$m[1];
            $keywords['order'] = 'ASC';
        } elseif ($keywords['has_highest_keyword']) {
            $keywords['limit'] = 1;
            $keywords['order'] = 'DESC';
        } elseif ($keywords['has_lowest_keyword']) {
            $keywords['limit'] = 1;
            $keywords['order'] = 'ASC';
        }

        return $keywords;
    }

    /**
     * LAYER 2: Academic Pattern Recognition Engine
     */
    protected function runLayer2PatternRecognition(string $query, array $layer1Keywords): array
    {
        $patterns = [
            'matched_pattern' => null,
            'pattern_intent' => null,
            'pattern_confidence' => 0.0,
        ];

        $lowerQuery = strtolower($query);

        // Pattern 0: Student Personal Advisory & Prediction Intents (Task 3 & 4)
        if (preg_match('/\b(predict my gpa|predict gpa|predict semester|predict result|predict my semester|expected gpa|predict gpa based on current marks)\b/i', $lowerQuery)) {
            $patterns['matched_pattern'] = 'student_prediction';
            $patterns['pattern_intent'] = 'student_prediction';
            $patterns['pattern_confidence'] = 0.99;
            return $patterns;
        }

        if (preg_match('/\b(weak subjects|weakest|where am i losing marks|tell me where i am weak|weakest subject|needs improvement|which subject is my weakest)\b/i', $lowerQuery)) {
            $patterns['matched_pattern'] = 'student_analysis';
            $patterns['pattern_intent'] = 'student_analysis';
            $patterns['pattern_confidence'] = 0.99;
            return $patterns;
        }

        if (preg_match('/\b(my marks|my attendance|attendance trend|show attendance|classes can i miss|sit for examinations|placement eligible|eligible for placement|suggest study plan|study suggestions|my performance|strong subjects|how many marks for grade a)\b/i', $lowerQuery)) {
            $patterns['matched_pattern'] = 'student_advisory';
            $patterns['pattern_intent'] = 'student_advisory';
            $patterns['pattern_confidence'] = 0.99;
            return $patterns;
        }

        // Pattern 1: Department / Dimension Performance Breakdown
        if (preg_match('/(department|semester|batch|faculty|course|subject)[\s-]*wise\s+(performance|attendance|marks|summary|report)/i', $query, $m) ||
            preg_match('/(rank|compare)\s+all\s+(departments|branches|programs)/i', $query, $m)) {
            $dimension = strtolower($m[1] ?? 'department');
            if (str_contains($query, 'rank') || str_contains($query, 'all departments')) {
                $dimension = 'department';
            }

            $patterns['matched_pattern'] = 'dimension_performance_breakdown';
            $patterns['pattern_intent'] = match($dimension) {
                'semester' => 'semester_performance',
                'batch' => 'batch_performance',
                'faculty' => 'faculty_performance',
                'course', 'subject' => 'course_performance',
                default => 'department_performance',
            };
            $patterns['pattern_confidence'] = 0.95;
            return $patterns;
        }

        // Pattern 2: Ranking & Department Extremes
        if (preg_match('/(?:which|what)\s+department\s+(?:performs|has the|is the)\s+(best|worst|highest|lowest)/i', $query, $m)) {
            $extreme = strtolower($m[1]);
            $patterns['matched_pattern'] = 'department_extreme';
            $patterns['pattern_intent'] = in_array($extreme, ['best', 'highest']) ? 'highest' : 'lowest';
            $patterns['pattern_confidence'] = 0.95;
            return $patterns;
        }

        // Pattern 3: Count & Pass/Fail Structure
        if (preg_match('/how many\s+(?:students\s+)?(?:failed|passed|are there|enrolled)/i', $query)) {
            $patterns['matched_pattern'] = 'count_pass_fail';
            $patterns['pattern_intent'] = 'count';
            $patterns['pattern_confidence'] = 0.90;
            return $patterns;
        }

        // Pattern 4: Comparative Sentence Structure
        if (preg_match('/compare\s+([a-z0-9\s]+?)\s+(?:and|with|vs|versus)\s+([a-z0-9\s]+)/i', $query)) {
            $patterns['matched_pattern'] = 'comparative_sentence';
            $patterns['pattern_intent'] = 'compare';
            $patterns['pattern_confidence'] = 0.90;
            return $patterns;
        }

        // Pattern 5: Percentage Analytical Question Structure
        if (preg_match('/what percentage\s+of\s+([a-z0-9\s]+?)\s+(?:students\s+)?(?:scored|have|with)\s+(.*)/i', $query)) {
            $patterns['matched_pattern'] = 'percentage_analytical';
            $patterns['pattern_intent'] = 'percentage';
            $patterns['pattern_confidence'] = 0.95;
            return $patterns;
        }

        // Pattern 6: Threshold Filter Search Structure
        if (preg_match('/(?:show|list|find|display|get)\s+([a-z0-9\s]+?)\s+(?:students\s+)?(?:below|above|under|between|<|>)\s*(.*)/i', $query)) {
            $patterns['matched_pattern'] = 'threshold_search';
            $patterns['pattern_intent'] = 'search';
            $patterns['pattern_confidence'] = 0.85;
            return $patterns;
        }

        // Pattern 7: Average Metric Structure
        if (preg_match('/average\s+(marks|attendance|score)\s+of\s+(.*)/i', $query)) {
            $patterns['matched_pattern'] = 'average_metric';
            $patterns['pattern_intent'] = 'average';
            $patterns['pattern_confidence'] = 0.85;
            return $patterns;
        }

        return $patterns;
    }

    /**
     * HYBRID DECISION MATRIX & FUSION
     */
    protected function fuseHybridLayers(array $layer1Keywords, array $layer2Patterns, string $query): array
    {
        $intent = 'search';

        if (!empty($layer2Patterns['pattern_intent']) && $layer2Patterns['pattern_confidence'] >= 0.85) {
            $intent = $layer2Patterns['pattern_intent'];
        } else {
            if ($layer1Keywords['has_compare_keyword'] || count($layer1Keywords['programs']) >= 2) {
                $intent = 'compare';
            } elseif ($layer1Keywords['has_percentage_keyword']) {
                $intent = 'percentage';
            } elseif ($layer1Keywords['has_count_keyword']) {
                $intent = 'count';
            } elseif ($layer1Keywords['has_highest_keyword']) {
                $intent = 'highest';
            } elseif ($layer1Keywords['has_lowest_keyword']) {
                $intent = 'lowest';
            } elseif ($layer1Keywords['has_avg_keyword']) {
                $intent = 'average';
            } elseif (in_array('risk', $layer1Keywords['metrics'])) {
                $intent = 'risk';
            }
        }

        $entities = [
            'programs' => $layer1Keywords['programs'],
            'all_programs' => $layer1Keywords['all_programs'],
            'semester' => $layer1Keywords['semester'],
            'batch' => $layer1Keywords['batch'],
            'course' => $layer1Keywords['course'],
            'faculty' => $layer1Keywords['faculty'],
            'metrics' => $layer1Keywords['metrics'],
            'attendance_condition' => $layer1Keywords['attendance_condition'],
            'marks_condition' => $layer1Keywords['marks_condition'],
            'risk_condition' => $layer1Keywords['risk_condition'],
            'limit' => $layer1Keywords['limit'],
            'order' => $layer1Keywords['order'],
            'target' => $layer1Keywords['target'],
        ];

        $filters = $this->buildFilters($query, $entities);

        return [
            'intent' => $intent,
            'entities' => $entities,
            'filters' => $filters,
        ];
    }

    /**
     * Filter Builder
     */
    protected function buildFilters(string $query, array $entities): array
    {
        return [
            'programs' => $entities['programs'],
            'all_programs' => $entities['all_programs'],
            'semester' => $entities['semester'],
            'batch' => $entities['batch'],
            'course' => $entities['course'],
            'attendance_condition' => $entities['attendance_condition'],
            'marks_condition' => $entities['marks_condition'],
            'risk_condition' => $entities['risk_condition'],
            'limit' => $entities['limit'],
            'order' => $entities['order'],
            'target' => $entities['target'],
        ];
    }

    /**
     * DYNAMIC SCHEMA-AWARE WHERE CLAUSE BUILDER
     */
    protected function buildProgramWhere(array $programs, string $studentAlias = 's', string $branchAlias = 'b'): ?string
    {
        if (empty($programs)) {
            return null;
        }

        $escapedLower = array_map(fn($p) => "'" . addslashes(strtolower($p)) . "'", $programs);
        $inList = implode(', ', $escapedLower);

        $likeClauses = array_map(fn($p) => "{$studentAlias}.student_id LIKE '%" . addslashes(strtoupper($p)) . "%'", $programs);
        $likeSql = implode(' OR ', $likeClauses);

        return "(LOWER({$studentAlias}.program) IN ({$inList}) OR LOWER({$branchAlias}.branch_name) IN ({$inList}) OR {$likeSql})";
    }

    /**
     * Step 5: Dynamic Schema-Aware SQL Builder
     */
    protected function buildSql(string $intent, array $entities, array $filters, string $rawQuery): string
    {
        // --- STUDENT PERSONAL ADVISORY INTENTS (Task 3 & 4) ---
        if ($intent === 'student_analysis' || $intent === 'student_prediction' || $intent === 'student_advisory') {
            return "
                SELECT 
                    c.course_name,
                    c.course_code,
                    COALESCE(m.total_marks, 75.0) as average_marks,
                    COALESCE(m.grade, 'B') as grade,
                    ROUND(COALESCE(att.att_pct, 85.0), 1) as attendance_pct,
                    CASE 
                        WHEN COALESCE(m.total_marks, 75.0) < 40 THEN 'High Risk'
                        WHEN COALESCE(m.total_marks, 75.0) < 60 THEN 'Medium Risk'
                        ELSE 'Low Risk'
                    END as risk_level,
                    CASE 
                        WHEN COALESCE(m.total_marks, 75.0) >= 80 THEN 'Outstanding (Grade A)'
                        WHEN COALESCE(m.total_marks, 75.0) >= 60 THEN 'Good (Grade B)'
                        WHEN COALESCE(m.total_marks, 75.0) >= 40 THEN 'Satisfactory (Grade C)'
                        ELSE 'Remedial Attention Required (Grade F)'
                    END as prediction
                FROM courses c
                LEFT JOIN marks m ON c.id = m.course_id
                LEFT JOIN (
                    SELECT course_id, COUNT(CASE WHEN status = 'present' THEN 1 END) * 100.0 / NULLIF(COUNT(*), 0) as att_pct
                    FROM attendance
                    GROUP BY course_id
                ) att ON c.id = att.course_id
                ORDER BY average_marks ASC
            ";
        }

        // --- SPECIAL BREAKDOWN INTENTS ---
        if ($intent === 'department_performance') {
            return "
                SELECT 
                    COALESCE(b.branch_name, s.program) as department, 
                    COUNT(DISTINCT s.id) as total_students, 
                    ROUND(AVG(COALESCE(m.total_marks, 0)), 2) as average_marks,
                    ROUND(AVG(COALESCE(att.att_pct, 0)), 1) as average_attendance_pct,
                    ROUND(COUNT(CASE WHEN m.total_marks >= 40 THEN 1 END) * 100.0 / NULLIF(COUNT(m.id), 0), 1) as pass_percentage
                FROM students s
                LEFT JOIN branches b ON s.branch_id = b.id
                LEFT JOIN marks m ON s.id = m.student_id
                LEFT JOIN (
                    SELECT student_id, COUNT(CASE WHEN status = 'present' THEN 1 END) * 100.0 / COUNT(*) as att_pct 
                    FROM attendance 
                    GROUP BY student_id
                ) att ON s.id = att.student_id
                GROUP BY COALESCE(b.branch_name, s.program)
                ORDER BY average_marks DESC
            ";
        }

        if ($intent === 'semester_performance') {
            return "
                SELECT 
                    s.semester, 
                    COUNT(DISTINCT s.id) as total_students, 
                    ROUND(AVG(COALESCE(m.total_marks, 0)), 2) as average_marks,
                    ROUND(AVG(COALESCE(att.att_pct, 0)), 1) as average_attendance_pct
                FROM students s
                LEFT JOIN marks m ON s.id = m.student_id
                LEFT JOIN (
                    SELECT student_id, COUNT(CASE WHEN status = 'present' THEN 1 END) * 100.0 / COUNT(*) as att_pct 
                    FROM attendance 
                    GROUP BY student_id
                ) att ON s.id = att.student_id
                GROUP BY s.semester
                ORDER BY s.semester ASC
            ";
        }

        if ($intent === 'batch_performance') {
            return "
                SELECT 
                    s.batch, 
                    COUNT(DISTINCT s.id) as total_students, 
                    ROUND(AVG(COALESCE(m.total_marks, 0)), 2) as average_marks,
                    ROUND(AVG(COALESCE(att.att_pct, 0)), 1) as average_attendance_pct
                FROM students s
                LEFT JOIN marks m ON s.id = m.student_id
                LEFT JOIN (
                    SELECT student_id, COUNT(CASE WHEN status = 'present' THEN 1 END) * 100.0 / COUNT(*) as att_pct 
                    FROM attendance 
                    GROUP BY student_id
                ) att ON s.id = att.student_id
                GROUP BY s.batch
                ORDER BY s.batch DESC
            ";
        }

        if ($intent === 'faculty_performance') {
            return "
                SELECT 
                    f.employee_id, 
                    u.name as faculty_name, 
                    f.department, 
                    COUNT(DISTINCT c.id) as courses_assigned, 
                    ROUND(AVG(m.total_marks), 2) as average_student_marks 
                FROM faculty f 
                JOIN users u ON f.user_id = u.id 
                LEFT JOIN courses c ON f.id = c.faculty_id 
                LEFT JOIN marks m ON c.id = m.course_id 
                GROUP BY f.id, f.employee_id, u.name, f.department 
                ORDER BY average_student_marks DESC
            ";
        }

        if ($intent === 'course_performance') {
            return "
                SELECT 
                    c.course_code, 
                    c.course_name, 
                    c.semester, 
                    ROUND(AVG(m.total_marks), 2) as average_marks, 
                    ROUND(COUNT(CASE WHEN m.total_marks >= 40 THEN 1 END) * 100.0 / NULLIF(COUNT(m.id), 0), 1) as pass_percentage 
                FROM courses c 
                LEFT JOIN marks m ON c.id = m.course_id 
                GROUP BY c.id, c.course_code, c.course_name, c.semester 
                ORDER BY average_marks DESC
            ";
        }

        // --- SCENARIO 1: Comparison Queries ("Compare MCA and MBA", "CSE and IT") ---
        if ($intent === 'compare' || count($filters['programs']) >= 2) {
            $progWhere = $this->buildProgramWhere($filters['programs'], 's', 'b');
            $whereSql = $progWhere ? "WHERE {$progWhere}" : "";

            return "
                SELECT 
                    COALESCE(b.branch_name, s.program) as program, 
                    COUNT(DISTINCT s.id) as total_students, 
                    ROUND(AVG(COALESCE(m.total_marks, 0)), 2) as average_marks,
                    ROUND(AVG(COALESCE(att.att_pct, 0)), 1) as average_attendance_pct
                FROM students s
                LEFT JOIN branches b ON s.branch_id = b.id
                LEFT JOIN marks m ON s.id = m.student_id
                LEFT JOIN (
                    SELECT student_id, COUNT(CASE WHEN status = 'present' THEN 1 END) * 100.0 / COUNT(*) as att_pct 
                    FROM attendance 
                    GROUP BY student_id
                ) att ON s.id = att.student_id
                {$whereSql}
                GROUP BY COALESCE(b.branch_name, s.program)
            ";
        }

        // --- SCENARIO 2: Department Extremes ("Department with highest average marks", "Department with lowest attendance") ---
        if ($filters['target'] === 'department' || str_contains($lowerQuery, 'department')) {
            if (($intent === 'highest' || str_contains($lowerQuery, 'highest') || str_contains($lowerQuery, 'best')) && (in_array('marks', $entities['metrics']) || str_contains($lowerQuery, 'mark') || str_contains($lowerQuery, 'score') || str_contains($lowerQuery, 'perform'))) {
                return "
                    SELECT COALESCE(b.branch_name, s.program) as department, ROUND(AVG(m.total_marks), 2) as average_marks 
                    FROM students s 
                    LEFT JOIN branches b ON s.branch_id = b.id
                    JOIN marks m ON s.id = m.student_id 
                    GROUP BY COALESCE(b.branch_name, s.program) 
                    ORDER BY average_marks DESC 
                    LIMIT 1
                ";
            }
            if (($intent === 'lowest' || str_contains($lowerQuery, 'lowest') || str_contains($lowerQuery, 'worst')) && (in_array('marks', $entities['metrics']) || str_contains($lowerQuery, 'mark') || str_contains($lowerQuery, 'score') || str_contains($lowerQuery, 'perform'))) {
                return "
                    SELECT COALESCE(b.branch_name, s.program) as department, ROUND(AVG(m.total_marks), 2) as average_marks 
                    FROM students s 
                    LEFT JOIN branches b ON s.branch_id = b.id
                    JOIN marks m ON s.id = m.student_id 
                    GROUP BY COALESCE(b.branch_name, s.program) 
                    ORDER BY average_marks ASC 
                    LIMIT 1
                ";
            }
            if (($intent === 'highest' || str_contains($lowerQuery, 'highest')) && (in_array('attendance', $entities['metrics']) || str_contains($lowerQuery, 'attendance'))) {
                return "
                    SELECT att.department, ROUND(AVG(att.att_pct), 1) as average_attendance 
                    FROM (
                        SELECT s.id, COALESCE(b.branch_name, s.program) as department, COUNT(CASE WHEN a.status = 'present' THEN 1 END) * 100.0 / COUNT(*) as att_pct 
                        FROM students s 
                        LEFT JOIN branches b ON s.branch_id = b.id
                        JOIN attendance a ON s.id = a.student_id 
                        GROUP BY s.id, COALESCE(b.branch_name, s.program)
                    ) as att 
                    GROUP BY att.department 
                    ORDER BY average_attendance DESC 
                    LIMIT 1
                ";
            }
            if (($intent === 'lowest' || str_contains($lowerQuery, 'lowest')) && (in_array('attendance', $entities['metrics']) || str_contains($lowerQuery, 'attendance'))) {
                return "
                    SELECT att.department, ROUND(AVG(att.att_pct), 1) as average_attendance 
                    FROM (
                        SELECT s.id, COALESCE(b.branch_name, s.program) as department, COUNT(CASE WHEN a.status = 'present' THEN 1 END) * 100.0 / COUNT(*) as att_pct 
                        FROM students s 
                        LEFT JOIN branches b ON s.branch_id = b.id
                        JOIN attendance a ON s.id = a.student_id 
                        GROUP BY s.id, COALESCE(b.branch_name, s.program)
                    ) as att 
                    GROUP BY att.department 
                    ORDER BY average_attendance ASC 
                    LIMIT 1
                ";
            }
        }

        // --- SCENARIO 3: Count & Percentage Queries ---
        if ($intent === 'count' || $intent === 'percentage') {
            $whereClauses = [];
            if ($progWhere = $this->buildProgramWhere($filters['programs'], 's', 'b')) {
                $whereClauses[] = $progWhere;
            }
            if (!empty($filters['semester'])) {
                $sem = addslashes($filters['semester']);
                $whereClauses[] = "(s.semester = '{$sem}' OR s.semester = 'Semester {$sem}')";
            }
            if (!empty($filters['batch'])) {
                $batch = addslashes($filters['batch']);
                $whereClauses[] = "s.batch = '{$batch}'";
            }
            if (!empty($filters['marks_condition'])) {
                $c = $filters['marks_condition'];
                if ($c['operator'] === 'BETWEEN') {
                    $whereClauses[] = "s.id IN (SELECT student_id FROM marks WHERE total_marks BETWEEN {$c['val1']} AND {$c['val2']})";
                } else {
                    $whereClauses[] = "s.id IN (SELECT student_id FROM marks WHERE total_marks {$c['operator']} {$c['value']})";
                }
            }
            if (!empty($filters['attendance_condition'])) {
                $c = $filters['attendance_condition'];
                if ($c['operator'] === 'BETWEEN') {
                    $v1 = (float)$c['val1'];
                    $v2 = (float)$c['val2'];
                    $whereClauses[] = "s.id IN (SELECT student_id FROM attendance GROUP BY student_id HAVING (COUNT(CASE WHEN status = 'present' THEN 1 END) * 100.0 / COUNT(*)) BETWEEN {$v1} AND {$v2})";
                } else {
                    $op = $c['operator'];
                    $val = (float)$c['value'];
                    $whereClauses[] = "s.id IN (SELECT student_id FROM attendance GROUP BY student_id HAVING (COUNT(CASE WHEN status = 'present' THEN 1 END) * 100.0 / COUNT(*)) {$op} {$val})";
                }
            }

            $whereSql = !empty($whereClauses) ? "WHERE " . implode(' AND ', $whereClauses) : "";

            return "
                SELECT COUNT(*) as total_students 
                FROM students s 
                LEFT JOIN branches b ON s.branch_id = b.id 
                {$whereSql}
            ";
        }

        // --- SCENARIO 4: Average Queries ("Average attendance of IT", "Average marks of MBA") ---
        if ($intent === 'average') {
            if (in_array('attendance', $entities['metrics'])) {
                $whereClauses = [];
                if ($progWhere = $this->buildProgramWhere($filters['programs'], 's', 'b')) {
                    $whereClauses[] = $progWhere;
                }
                if (!empty($filters['semester'])) {
                    $sem = addslashes($filters['semester']);
                    $whereClauses[] = "(s.semester = '{$sem}' OR s.semester = 'Semester {$sem}')";
                }
                $whereSql = !empty($whereClauses) ? "WHERE " . implode(' AND ', $whereClauses) : "";

                return "
                    SELECT ROUND(AVG(att.att_pct), 1) as average_attendance_percentage 
                    FROM (
                        SELECT s.id, COUNT(CASE WHEN a.status = 'present' THEN 1 END) * 100.0 / COUNT(*) as att_pct 
                        FROM students s 
                        LEFT JOIN branches b ON s.branch_id = b.id
                        JOIN attendance a ON s.id = a.student_id 
                        {$whereSql}
                        GROUP BY s.id
                    ) as att
                ";
            } else {
                $whereClauses = [];
                if ($progWhere = $this->buildProgramWhere($filters['programs'], 's', 'b')) {
                    $whereClauses[] = $progWhere;
                }
                if (!empty($filters['semester'])) {
                    $sem = addslashes($filters['semester']);
                    $whereClauses[] = "(s.semester = '{$sem}' OR s.semester = 'Semester {$sem}')";
                }
                $whereSql = !empty($whereClauses) ? "WHERE " . implode(' AND ', $whereClauses) : "";

                return "
                    SELECT ROUND(AVG(m.total_marks), 2) as average_marks 
                    FROM students s 
                    LEFT JOIN branches b ON s.branch_id = b.id
                    JOIN marks m ON s.id = m.student_id 
                    {$whereSql}
                ";
            }
        }

        // --- SCENARIO 5: Faculty Queries ("Show MCA faculty", "List CSE faculty") ---
        if ($filters['target'] === 'faculty') {
            $whereClauses = [];
            if (!empty($filters['programs'])) {
                $dept = addslashes(strtolower($filters['programs'][0]));
                $whereClauses[] = "LOWER(f.department) = '{$dept}'";
            }
            $whereSql = !empty($whereClauses) ? "WHERE " . implode(' AND ', $whereClauses) : "";

            return "
                SELECT f.employee_id, u.name as faculty_name, u.email, f.department, f.specialization, f.qualification, f.experience_years 
                FROM faculty f 
                JOIN users u ON f.user_id = u.id 
                {$whereSql} 
                ORDER BY u.name
            ";
        }

        // --- SCENARIO 6: Course Queries ("Show MCA courses") ---
        if ($filters['target'] === 'course') {
            $whereClauses = [];
            if (!empty($filters['semester'])) {
                $sem = addslashes($filters['semester']);
                $whereClauses[] = "(c.semester = '{$sem}' OR c.semester = 'Semester {$sem}')";
            }
            if (!empty($filters['programs'])) {
                $prog = addslashes(strtolower($filters['programs'][0]));
                $whereClauses[] = "(LOWER(c.course_code) LIKE '%{$prog}%' OR LOWER(c.course_name) LIKE '%{$prog}%')";
            }
            $whereSql = !empty($whereClauses) ? "WHERE " . implode(' AND ', $whereClauses) : "";

            return "
                SELECT c.course_code, c.course_name, c.credits, c.semester, c.total_classes, u.name as instructor 
                FROM courses c 
                LEFT JOIN faculty f ON c.faculty_id = f.id 
                LEFT JOIN users u ON f.user_id = u.id 
                {$whereSql} 
                ORDER BY c.course_code
            ";
        }

        // --- SCENARIO 7: High Risk Queries ("Show high risk MCA students") ---
        if ($intent === 'risk' || !empty($filters['risk_condition'])) {
            $whereClauses = ["ar.risk_level = 'High Risk'"];

            if ($progWhere = $this->buildProgramWhere($filters['programs'], 's', 'b')) {
                $whereClauses[] = $progWhere;
            }
            if (!empty($filters['semester'])) {
                $sem = addslashes($filters['semester']);
                $whereClauses[] = "(s.semester = '{$sem}' OR s.semester = 'Semester {$sem}')";
            }
            if (!empty($filters['batch'])) {
                $batch = addslashes($filters['batch']);
                $whereClauses[] = "s.batch = '{$batch}'";
            }

            $whereSql = "WHERE " . implode(' AND ', $whereClauses);

            return "
                SELECT DISTINCT s.student_id, u.name as student_name, COALESCE(b.branch_name, s.program) as program, s.semester, ar.risk_level, ar.risk_score, COALESCE(c.course_name, 'Overall Academic Risk') as course_name 
                FROM students s 
                LEFT JOIN branches b ON s.branch_id = b.id
                JOIN users u ON s.user_id = u.id 
                JOIN academic_risk ar ON s.id = ar.student_id 
                LEFT JOIN courses c ON ar.course_id = c.id 
                {$whereSql} 
                ORDER BY ar.risk_score DESC
            ";
        }

        // --- SCENARIO 8: Attendance Condition Queries ("Show MBA students below 60 attendance") ---
        if (!empty($filters['attendance_condition'])) {
            $whereClauses = [];
            if ($progWhere = $this->buildProgramWhere($filters['programs'], 's', 'b')) {
                $whereClauses[] = $progWhere;
            }
            if (!empty($filters['semester'])) {
                $sem = addslashes($filters['semester']);
                $whereClauses[] = "(s.semester = '{$sem}' OR s.semester = 'Semester {$sem}')";
            }
            if (!empty($filters['batch'])) {
                $batch = addslashes($filters['batch']);
                $whereClauses[] = "s.batch = '{$batch}'";
            }

            $whereSql = !empty($whereClauses) ? "WHERE " . implode(' AND ', $whereClauses) : "";
            $cond = $filters['attendance_condition'];

            if ($cond['operator'] === 'BETWEEN') {
                $v1 = (float)$cond['val1'];
                $v2 = (float)$cond['val2'];
                $havingSql = "HAVING attendance_percentage BETWEEN {$v1} AND {$v2}";
            } else {
                $op = $cond['operator'];
                $val = (float)$cond['value'];
                $havingSql = "HAVING attendance_percentage {$op} {$val}";
            }

            return "
                SELECT s.student_id, u.name as student_name, COALESCE(b.branch_name, s.program) as program, s.semester, ROUND(COUNT(CASE WHEN a.status = 'present' THEN 1 END) * 100.0 / COUNT(*), 1) as attendance_percentage 
                FROM students s 
                LEFT JOIN branches b ON s.branch_id = b.id
                JOIN users u ON s.user_id = u.id 
                JOIN attendance a ON s.id = a.student_id 
                JOIN courses c ON a.course_id = c.id 
                {$whereSql} 
                GROUP BY s.id, s.student_id, u.name, COALESCE(b.branch_name, s.program), s.semester 
                {$havingSql} 
                ORDER BY attendance_percentage ASC
            ";
        }

        // --- SCENARIO 9: Marks Condition Queries ("Show CSE students above 80 marks", "between 60 and 80 marks") ---
        if (!empty($filters['marks_condition'])) {
            $whereClauses = [];
            if ($progWhere = $this->buildProgramWhere($filters['programs'], 's', 'b')) {
                $whereClauses[] = $progWhere;
            }
            if (!empty($filters['semester'])) {
                $sem = addslashes($filters['semester']);
                $whereClauses[] = "(s.semester = '{$sem}' OR s.semester = 'Semester {$sem}')";
            }
            if (!empty($filters['batch'])) {
                $batch = addslashes($filters['batch']);
                $whereClauses[] = "s.batch = '{$batch}'";
            }

            $cond = $filters['marks_condition'];
            if ($cond['operator'] === 'BETWEEN') {
                $v1 = (float)$cond['val1'];
                $v2 = (float)$cond['val2'];
                $whereClauses[] = "m.total_marks BETWEEN {$v1} AND {$v2}";
            } else {
                $op = $cond['operator'];
                $val = (float)$cond['value'];
                $whereClauses[] = "m.total_marks {$op} {$val}";
            }

            $whereSql = "WHERE " . implode(' AND ', $whereClauses);

            return "
                SELECT s.student_id, u.name as student_name, COALESCE(b.branch_name, s.program) as program, s.semester, c.course_name, m.total_marks, m.grade 
                FROM students s 
                LEFT JOIN branches b ON s.branch_id = b.id
                JOIN users u ON s.user_id = u.id 
                JOIN marks m ON s.id = m.student_id 
                JOIN courses c ON m.course_id = c.id 
                {$whereSql} 
                ORDER BY m.total_marks DESC
            ";
        }

        // --- SCENARIO 10: Top / Bottom N Queries ("Show top 10 students", "Show bottom 10 students") ---
        if (!empty($filters['limit']) || !empty($filters['order'])) {
            $whereClauses = [];
            if ($progWhere = $this->buildProgramWhere($filters['programs'], 's', 'b')) {
                $whereClauses[] = $progWhere;
            }
            if (!empty($filters['semester'])) {
                $sem = addslashes($filters['semester']);
                $whereClauses[] = "(s.semester = '{$sem}' OR s.semester = 'Semester {$sem}')";
            }

            $whereSql = !empty($whereClauses) ? "WHERE " . implode(' AND ', $whereClauses) : "";
            $orderDir = $filters['order'] === 'ASC' ? 'ASC' : 'DESC';
            $limitVal = $filters['limit'] ? (int)$filters['limit'] : 10;

            return "
                SELECT s.student_id, u.name as student_name, COALESCE(b.branch_name, s.program) as program, s.semester, ROUND(AVG(m.total_marks), 2) as average_marks 
                FROM students s 
                LEFT JOIN branches b ON s.branch_id = b.id
                JOIN users u ON s.user_id = u.id 
                LEFT JOIN marks m ON s.id = m.student_id 
                {$whereSql} 
                GROUP BY s.id, s.student_id, u.name, COALESCE(b.branch_name, s.program), s.semester 
                ORDER BY average_marks {$orderDir} 
                LIMIT {$limitVal}
            ";
        }

        // --- SCENARIO 11: General Filtered Student Search ("Show MCA students", "Show IT students", "Show students below 60% in CSE and IT") ---
        $whereClauses = [];
        if ($progWhere = $this->buildProgramWhere($filters['programs'], 's', 'b')) {
            $whereClauses[] = $progWhere;
        }
        if (!empty($filters['semester'])) {
            $sem = addslashes($filters['semester']);
            $whereClauses[] = "(s.semester = '{$sem}' OR s.semester = 'Semester {$sem}')";
        }
        if (!empty($filters['batch'])) {
            $batch = addslashes($filters['batch']);
            $whereClauses[] = "s.batch = '{$batch}'";
        }

        $whereSql = !empty($whereClauses) ? "WHERE " . implode(' AND ', $whereClauses) : "";

        return "
            SELECT s.student_id, u.name as student_name, u.email, COALESCE(b.branch_name, s.program) as program, s.semester, s.batch 
            FROM students s 
            LEFT JOIN branches b ON s.branch_id = b.id
            JOIN users u ON s.user_id = u.id 
            {$whereSql} 
            ORDER BY u.name
        ";
    }

    /**
     * Validate generated SQL for security and safety
     */
    protected function validateSql(string $sql): void
    {
        $trimSql = trim($sql);

        if (!str_starts_with(strtoupper($trimSql), 'SELECT')) {
            throw new \InvalidArgumentException("Invalid SQL query generated: Only SELECT queries are permitted.");
        }

        $disallowedKeywords = ['DELETE', 'DROP', 'UPDATE', 'INSERT', 'ALTER', 'TRUNCATE', 'RENAME', 'GRANT', 'REVOKE', '--', ';'];
        foreach ($disallowedKeywords as $kw) {
            if (preg_match('/\b' . preg_quote($kw, '/') . '\b/i', $trimSql)) {
                throw new \InvalidArgumentException("Invalid SQL query generated: Disallowed keyword '{$kw}' detected.");
            }
        }
    }
}
