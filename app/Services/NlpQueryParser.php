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

            return [
                'success' => false,
                'error' => 'Query pattern not recognized. Please reformulate your query.',
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
