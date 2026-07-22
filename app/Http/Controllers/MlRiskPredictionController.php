<?php

namespace App\Http\Controllers;

use App\Models\AcademicRisk;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MlRiskPredictionController extends Controller
{
    protected $mlApiUrl;

    public function __construct()
    {
        $this->mlApiUrl = env('ML_API_URL', 'http://127.0.0.1:5005');
    }

    public function predictRisk($studentId, $courseId)
    {
        $student = Student::findOrFail($studentId);
        
        // Authorize the user can access this student's risk prediction
        $this->authorizeRiskPrediction($student, $courseId);

        // Get student's attendance data
        $attendanceData = $student->attendance()
            ->where('course_id', $courseId)
            ->selectRaw('COUNT(*) as total, SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present')
            ->first();

        $attendancePercentage = $attendanceData->total > 0 
            ? ($attendanceData->present / $attendanceData->total) * 100 
            : 0;

        // Get student's marks data
        $marksData = $student->marks()
            ->where('course_id', $courseId)
            ->selectRaw('AVG(internal_marks) as internal_avg, AVG(external_marks) as external_avg')
            ->first();

        $features = [
            'attendance_percentage' => $attendancePercentage,
            'internal_marks' => $marksData->internal_avg ?? 0,
            'external_marks' => $marksData->external_avg ?? 0,
        ];

        try {
            $response = Http::post("{$this->mlApiUrl}/predict-risk", $features);

            if ($response->successful()) {
                $prediction = $response->json();

                $academicRisk = AcademicRisk::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'course_id' => $courseId,
                    ],
                    [
                        'attendance_percentage' => $attendancePercentage,
                        'internal_marks' => $marksData->internal_avg ?? 0,
                        'external_marks' => $marksData->external_avg ?? 0,
                        'risk_level' => $prediction['risk_level'],
                        'risk_score' => $prediction['risk_score'] ?? 0,
                        'recommendations' => json_encode($prediction['recommendations'] ?? []),
                        'prediction_date' => now(),
                    ]
                );

                // Generate alerts if high risk
                if ($prediction['risk_level'] === 'High Risk') {
                    $this->generateAlert($studentId, $courseId, 'high_risk', 
                        "High academic risk detected. Please review recommendations.");
                }

                return $academicRisk;
            }
        } catch (\Exception $e) {
            \Log::error('ML API Error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Authorize the user can predict risk for this student.
     */
    private function authorizeRiskPrediction(Student $student, $courseId)
    {
        $user = \Auth::user();
        
        // Admin can do anything
        if ($user->role->slug === 'admin') {
            return;
        }
        
        // Faculty can predict risk for their students
        if ($user->role->slug === 'faculty') {
            $isFacultyForCourse = $user->faculty
                ->courses()
                ->where('course_id', $courseId)
                ->exists();
            
            if ($isFacultyForCourse) {
                return;
            }
        }
        
        // Students can predict risk for themselves
        if ($user->role->slug === 'student' && $user->student?->id === $student->id) {
            return;
        }
        
        abort(403, 'Unauthorized access to risk prediction');
    }

    private function generateAlert($studentId, $courseId, $alertType, $message)
    {
        \App\Models\Alert::create([
            'student_id' => $studentId,
            'course_id' => $courseId,
            'alert_type' => $alertType,
            'message' => $message,
            'severity' => 'high',
            'alert_date' => now(),
        ]);
    }
}
