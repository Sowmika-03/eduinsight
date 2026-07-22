<?php

namespace App\Services;

class NlpQueryParser
{
    protected $patterns = [
        // Pattern for attendance queries
        'attendance_low' => [
            'pattern' => '/show|list|find.*students.*(?:with|having).*attendance.*(below|less than|under|<).*(\d+)%?/i',
            'template' => 'attendance_below',
            'intent' => 'search',
        ],
        // Pattern for failing students
        'failing_students' => [
            'pattern' => '/show|list|find.*students.*(failing|fail|grade.*f)/i',
            'template' => 'students_failing',
            'intent' => 'search',
        ],
        // Pattern for course-specific queries
        'course_students' => [
            'pattern' => '/show|list|find.*students.*(in|of).*course.*([a-z0-9]+)/i',
            'template' => 'students_by_course',
            'intent' => 'search',
        ],
        // Pattern for top performers
        'top_performers' => [
            'pattern' => '/show|list|find.*top|best.*(?:students|performers)/i',
            'template' => 'top_performers',
            'intent' => 'analyze',
        ],
        // Pattern for low marks
        'low_marks' => [
            'pattern' => '/students.*(?:with|having).*marks.*(?:below|less than|<).*(\d+)/i',
            'template' => 'marks_below',
            'intent' => 'search',
        ],
        // Pattern for risk prediction
        'high_risk' => [
            'pattern' => '/show|list.*(?:high risk|at risk|academic risk)/i',
            'template' => 'high_risk_students',
            'intent' => 'search',
        ],
    ];

    public function parse($query)
    {
        try {
            foreach ($this->patterns as $key => $patternData) {
                if (preg_match($patternData['pattern'], $query, $matches)) {
                    $template = $patternData['template'];
                    $intent = $patternData['intent'];

                    $sql = $this->buildSql($template, $matches);

                    return [
                        'success' => true,
                        'sql' => $sql,
                        'intent' => $intent,
                        'pattern_matched' => $key,
                    ];
                }
            }

            // Semantic keyword fallback matching to resolve arbitrary/conversational queries
            $queryLower = strtolower($query);

            if (str_contains($queryLower, 'class') || str_contains($queryLower, 'course') || str_contains($queryLower, 'schedule') || str_contains($queryLower, 'timetable') || str_contains($queryLower, 'update') || str_contains($queryLower, 'lesson') || str_contains($queryLower, 'teach')) {
                return [
                    'success' => true,
                    'sql' => "SELECT c.course_code, c.course_name, c.credits, c.semester, c.total_classes, u.name as instructor FROM courses c LEFT JOIN faculty f ON c.faculty_id = f.id LEFT JOIN users u ON f.user_id = u.id",
                    'intent' => 'search',
                    'pattern_matched' => 'fallback_courses',
                ];
            }

            if (str_contains($queryLower, 'alert') || str_contains($queryLower, 'notification') || str_contains($queryLower, 'warning') || str_contains($queryLower, 'warn') || str_contains($queryLower, 'risk')) {
                return [
                    'success' => true,
                    'sql' => "SELECT u.name as student_name, a.alert_type, a.message, a.severity, a.alert_date FROM alerts a JOIN students s ON a.student_id = s.id JOIN users u ON s.user_id = u.id ORDER BY a.alert_date DESC",
                    'intent' => 'search',
                    'pattern_matched' => 'fallback_alerts',
                ];
            }

            if (str_contains($queryLower, 'student') || str_contains($queryLower, 'pupil') || str_contains($queryLower, 'enroll') || str_contains($queryLower, 'kid') || str_contains($queryLower, 'child')) {
                return [
                    'success' => true,
                    'sql' => "SELECT s.student_id, u.name, u.email, s.program, s.semester, s.batch FROM students s JOIN users u ON s.user_id = u.id ORDER BY u.name",
                    'intent' => 'search',
                    'pattern_matched' => 'fallback_students',
                ];
            }

            if (str_contains($queryLower, 'faculty') || str_contains($queryLower, 'teacher') || str_contains($queryLower, 'instructor') || str_contains($queryLower, 'professor') || str_contains($queryLower, 'staff') || str_contains($queryLower, 'hod')) {
                return [
                    'success' => true,
                    'sql' => "SELECT f.employee_id, u.name, u.email, f.department, f.specialization, f.experience_years FROM faculty f JOIN users u ON f.user_id = u.id ORDER BY u.name",
                    'intent' => 'search',
                    'pattern_matched' => 'fallback_faculty',
                ];
            }

            if (str_contains($queryLower, 'mark') || str_contains($queryLower, 'score') || str_contains($queryLower, 'grade') || str_contains($queryLower, 'exam') || str_contains($queryLower, 'test') || str_contains($queryLower, 'result') || str_contains($queryLower, 'performance')) {
                return [
                    'success' => true,
                    'sql' => "SELECT u.name as student_name, c.course_name, m.total_marks, m.grade, m.assessment_type FROM students s JOIN users u ON s.user_id = u.id JOIN marks m ON s.id = m.student_id JOIN courses c ON m.course_id = c.id ORDER BY m.total_marks DESC",
                    'intent' => 'analyze',
                    'pattern_matched' => 'fallback_marks',
                ];
            }

            if (str_contains($queryLower, 'attendance') || str_contains($queryLower, 'present') || str_contains($queryLower, 'absent') || str_contains($queryLower, 'late')) {
                return [
                    'success' => true,
                    'sql' => "SELECT u.name as student_name, c.course_name, COUNT(CASE WHEN a.status = 'present' THEN 1 END) * 100.0 / COUNT(*) as attendance_percentage FROM students s JOIN users u ON s.user_id = u.id JOIN attendance a ON s.id = a.student_id JOIN courses c ON a.course_id = c.id GROUP BY s.id, u.name, c.course_name ORDER BY attendance_percentage DESC",
                    'intent' => 'search',
                    'pattern_matched' => 'fallback_attendance',
                ];
            }

            // Conversational fallback
            $escapedQuery = addslashes($query);
            return [
                'success' => true,
                'sql' => "SELECT 'I received your query: \"" . $escapedQuery . "\". Ask me about: students, courses, grades, attendance, or high-risk academic alerts.' as answer, 'Try asking: \"show courses\", \"attendance below 75%\", or \"list high risk students\"' as tips",
                'intent' => 'analyze',
                'pattern_matched' => 'conversational_fallback',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    protected function buildSql($template, $matches)
    {
        return match($template) {
            'attendance_below' => $this->sqlAttendanceBelow($matches),
            'students_failing' => $this->sqlStudentsFailing(),
            'students_by_course' => $this->sqlStudentsByCourse($matches),
            'top_performers' => $this->sqlTopPerformers(),
            'marks_below' => $this->sqlMarksBelow($matches),
            'high_risk_students' => $this->sqlHighRiskStudents(),
            default => "SELECT 1",
        };
    }

    private function sqlAttendanceBelow($matches)
    {
        $percentage = isset($matches[2]) ? (int)$matches[2] : 60;
        return "
            SELECT DISTINCT s.id, u.name, c.course_name, 
                   COUNT(CASE WHEN a.status = 'present' THEN 1 END) * 100.0 / COUNT(*) as attendance_percentage
            FROM students s
            JOIN users u ON s.user_id = u.id
            JOIN attendance a ON s.id = a.student_id
            JOIN courses c ON a.course_id = c.id
            GROUP BY s.id, u.name, c.course_name
            HAVING attendance_percentage < $percentage
            ORDER BY attendance_percentage ASC
        ";
    }

    private function sqlStudentsFailing()
    {
        return "
            SELECT DISTINCT s.id, u.name, c.course_name, m.total_marks, m.grade
            FROM students s
            JOIN users u ON s.user_id = u.id
            JOIN marks m ON s.id = m.student_id
            JOIN courses c ON m.course_id = c.id
            WHERE m.grade = 'F' OR m.total_marks < 40
            ORDER BY m.total_marks ASC
        ";
    }

    private function sqlStudentsByCourse($matches)
    {
        $courseCode = isset($matches[2]) ? strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $matches[2])) : '';
        $courseCode = addslashes($courseCode);
        return "
            SELECT s.id, u.name, u.email, s.student_id, c.course_name, c.course_code
            FROM students s
            JOIN users u ON s.user_id = u.id
            JOIN enrollments e ON s.id = e.student_id
            JOIN courses c ON e.course_id = c.id
            WHERE LOWER(c.course_code) LIKE LOWER('%{$courseCode}%') 
               OR LOWER(c.course_name) LIKE LOWER('%{$courseCode}%')
            ORDER BY u.name
        ";
    }

    private function sqlTopPerformers()
    {
        return "
            SELECT s.id, u.name, u.email, s.student_id,
                   AVG(m.total_marks) as average_marks
            FROM students s
            JOIN users u ON s.user_id = u.id
            LEFT JOIN marks m ON s.id = m.student_id
            GROUP BY s.id, u.name, u.email, s.student_id
            ORDER BY average_marks DESC
            LIMIT 20
        ";
    }

    private function sqlMarksBelow($matches)
    {
        $threshold = isset($matches[1]) ? (int)$matches[1] : 40;
        return "
            SELECT s.id, u.name, c.course_name, m.total_marks, m.grade
            FROM students s
            JOIN users u ON s.user_id = u.id
            JOIN marks m ON s.id = m.student_id
            JOIN courses c ON m.course_id = c.id
            WHERE m.total_marks < $threshold
            ORDER BY m.total_marks ASC
        ";
    }

    private function sqlHighRiskStudents()
    {
        return "
            SELECT DISTINCT s.id, u.name, s.student_id, ar.risk_level, ar.risk_score, c.course_name
            FROM students s
            JOIN users u ON s.user_id = u.id
            LEFT JOIN academic_risk ar ON s.id = ar.student_id
            LEFT JOIN courses c ON ar.course_id = c.id
            WHERE ar.risk_level = 'High Risk'
            ORDER BY ar.risk_score DESC
        ";
    }
}
