<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Alert;
use App\Models\Attendance;
use App\Models\Mark;
use App\Models\AcademicRisk;
use App\Models\EmailLog;
use App\Mail\AlertNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class AlertsService
{
    /**
     * Check for academic alerts and send notifications
     * This can be run via a scheduled command
     */
    public static function checkAndNotifyAlerts()
    {
        $alerts = [];

        // Check low attendance
        $alerts = array_merge($alerts, static::checkLowAttendance());

        // Check low marks
        $alerts = array_merge($alerts, static::checkLowMarks());

        // Check high academic risk
        $alerts = array_merge($alerts, static::checkAcademicRisk());

        return $alerts;
    }

    /**
     * Check for students with low attendance
     * Threshold: < 60%
     */
    private static function checkLowAttendance($threshold = 60)
    {
        $alerts = [];

        $lowAttendanceStudents = DB::select("
            SELECT 
                s.id, 
                s.user_id, 
                COUNT(a.id) as total_sessions,
                SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) as present_count,
                (SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) / COUNT(a.id)) * 100 as attendance_percentage
            FROM students s
            LEFT JOIN attendance a ON s.id = a.student_id
            GROUP BY s.id, s.user_id
            HAVING attendance_percentage < ?
        ", [$threshold]);

        foreach ($lowAttendanceStudents as $record) {
            $student = Student::with(['user', 'parent'])->find($record->id);
            
            if (!$student) {
                continue;
            }

            $percentage = round($record->attendance_percentage, 2);

            // Create alert
            $alert = Alert::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'alert_type' => 'low_attendance',
                    'is_read' => false,
                ],
                [
                    'message' => "Attendance is critically low at {$percentage}%",
                    'severity' => 'high',
                    'alert_date' => now(),
                ]
            );

            // Send emails
            $alertMessage = "Your attendance is critically low at {$percentage}%. Please contact faculty to improve attendance.";
            
            // Send to student
            if ($student->user->email) {
                static::sendAlertEmail(
                    $student->user->email,
                    $student->user->name,
                    $alertMessage,
                    'Attendance Alert'
                );
            }

            // Send to parent
            if ($student->parent_email) {
                static::sendAlertEmail(
                    $student->parent_email,
                    $student->parent?->name ?? 'Parent',
                    $alertMessage . " Your child {$student->user->name} needs immediate attention.",
                    'Attendance Alert'
                );
            }

            $alerts[] = [
                'type' => 'attendance',
                'student_id' => $student->id,
                'message' => $alertMessage,
                'severity' => 'high',
            ];
        }

        return $alerts;
    }

    /**
     * Check for students with low marks
     * Threshold: < 40
     */
    private static function checkLowMarks($threshold = 40)
    {
        $alerts = [];

        $lowMarksStudents = DB::select("
            SELECT 
                s.id,
                s.user_id,
                AVG(m.marks) as average_marks,
                COUNT(m.id) as total_marks
            FROM students s
            LEFT JOIN marks m ON s.id = m.student_id
            WHERE m.marks IS NOT NULL
            GROUP BY s.id, s.user_id
            HAVING average_marks < ?
        ", [$threshold]);

        foreach ($lowMarksStudents as $record) {
            $student = Student::with(['user', 'parent'])->find($record->id);
            
            if (!$student) {
                continue;
            }

            $avgMarks = round($record->average_marks, 2);

            // Create alert
            $alert = Alert::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'alert_type' => 'low_marks',
                    'is_read' => false,
                ],
                [
                    'message' => "Average marks are below threshold: {$avgMarks}",
                    'severity' => 'high',
                    'alert_date' => now(),
                ]
            );

            // Send emails
            $alertMessage = "Your average marks ({$avgMarks}) are below the passing threshold. Please consult with faculty.";
            
            // Send to student
            if ($student->user->email) {
                static::sendAlertEmail(
                    $student->user->email,
                    $student->user->name,
                    $alertMessage,
                    'Academic Performance Alert'
                );
            }

            // Send to parent
            if ($student->parent_email) {
                static::sendAlertEmail(
                    $student->parent_email,
                    $student->parent?->name ?? 'Parent',
                    $alertMessage . " Your child {$student->user->name} needs academic support.",
                    'Academic Performance Alert'
                );
            }

            $alerts[] = [
                'type' => 'marks',
                'student_id' => $student->id,
                'message' => $alertMessage,
                'severity' => 'high',
            ];
        }

        return $alerts;
    }

    /**
     * Check for students with high academic risk
     */
    private static function checkAcademicRisk()
    {
        $alerts = [];

        $riskStudents = AcademicRisk::where('risk_level', 'High')
            ->where('is_notified', false)
            ->with('student.user', 'student.parent')
            ->get();

        foreach ($riskStudents as $riskRecord) {
            $student = $riskRecord->student;

            if (!$student) {
                continue;
            }

            // Create alert if not exists
            $alert = Alert::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'alert_type' => 'academic_risk',
                    'is_read' => false,
                ],
                [
                    'message' => "High academic risk detected: {$riskRecord->risk_description}",
                    'severity' => 'critical',
                    'alert_date' => now(),
                ]
            );

            // Send emails
            $alertMessage = "Your academic performance indicates a HIGH RISK status. Reason: {$riskRecord->risk_description}. Please take immediate action.";
            
            // Send to student
            if ($student->user->email) {
                static::sendAlertEmail(
                    $student->user->email,
                    $student->user->name,
                    $alertMessage,
                    'Critical Academic Risk Alert'
                );
            }

            // Send to parent
            if ($student->parent_email) {
                static::sendAlertEmail(
                    $student->parent_email,
                    $student->parent?->name ?? 'Parent',
                    "CRITICAL: Your child {$student->user->name} is at HIGH academic risk. " . $alertMessage,
                    'Critical Academic Risk Alert'
                );
            }

            // Mark as notified
            $riskRecord->update(['is_notified' => true]);

            $alerts[] = [
                'type' => 'academic_risk',
                'student_id' => $student->id,
                'message' => $alertMessage,
                'severity' => 'critical',
            ];
        }

        return $alerts;
    }

    /**
     * Send alert email
     */
    private static function sendAlertEmail($recipientEmail, $recipientName, $alertMessage, $alertType)
    {
        try {
            Mail::to($recipientEmail)->send(new AlertNotification($alertMessage, $recipientName, $alertType));

            // Log the email
            EmailLog::create([
                'sender_id' => 1, // System user ID (typically admin)
                'receiver_email' => $recipientEmail,
                'subject' => $alertType,
                'message' => $alertMessage,
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error('Alert email failed: ' . $e->getMessage());

            // Log failed email
            EmailLog::create([
                'sender_id' => 1,
                'receiver_email' => $recipientEmail,
                'subject' => $alertType,
                'message' => $alertMessage,
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Get pending alerts for a student
     */
    public static function getPendingAlertsForStudent($studentId)
    {
        return Alert::where('student_id', $studentId)
            ->where('is_read', false)
            ->orderByDesc('severity')
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Mark alert as read
     */
    public static function markAlertAsRead($alertId)
    {
        return Alert::find($alertId)?->update(['is_read' => true]);
    }

    /**
     * Get alert statistics
     */
    public static function getAlertStats()
    {
        return [
            'total_alerts' => Alert::count(),
            'unread_alerts' => Alert::where('is_read', false)->count(),
            'critical_alerts' => Alert::where('severity', 'critical')->count(),
            'high_alerts' => Alert::where('severity', 'high')->count(),
            'low_attendance_alerts' => Alert::where('alert_type', 'low_attendance')->count(),
            'low_marks_alerts' => Alert::where('alert_type', 'low_marks')->count(),
            'risk_alerts' => Alert::where('alert_type', 'academic_risk')->count(),
        ];
    }
}
