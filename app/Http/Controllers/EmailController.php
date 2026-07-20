<?php

namespace App\Http\Controllers;

use App\Models\EmailLog;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Attendance;
use App\Mail\StudentNotification;
use App\Mail\ParentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;

class EmailController extends Controller
{
    /**
     * Show the send notification form
     */
    public function showSendForm()
    {
        $user = Auth::user();
        if ($user->role->slug === 'faculty' && $user->faculty) {
            $courses = Course::where('faculty_id', $user->faculty->id)->get();
            $studentIds = Enrollment::whereIn('course_id', $courses->pluck('id'))->pluck('student_id')->unique();
            $students = Student::whereIn('id', $studentIds)->with('user')->get();
        } elseif ($user->role->slug === 'hod' && $user->hod) {
            $deptFacultyIds = \App\Models\Faculty::where('department', $user->hod->department)->pluck('id');
            $courses = Course::whereIn('faculty_id', $deptFacultyIds)->get();
            $studentIds = Enrollment::whereIn('course_id', $courses->pluck('id'))->pluck('student_id')->unique();
            $students = Student::whereIn('id', $studentIds)->with('user')->get();
        } else {
            $courses = Course::all();
            $students = Student::with('user')->get();
        }

        return view('emails.send-email', compact('courses', 'students'));
    }

    /**
     * Send notification emails
     */
    public function sendNotification(Request $request)
    {
        $validated = $request->validate([
            'recipient_type' => 'required|in:student,parent,class,low_attendance',
            'student_id' => 'nullable|exists:students,id',
            'course_id' => 'nullable|exists:courses,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'attendance_threshold' => 'nullable|integer|min:1|max:100',
        ]);

        $sender = Auth::user();

        try {
            $recipients = $this->getRecipients(
                $validated['recipient_type'],
                $validated['student_id'] ?? null,
                $validated['course_id'] ?? null,
                $validated['attendance_threshold'] ?? 75
            );

            if (empty($recipients)) {
                return redirect()->back()->with('warning', 'No recipients found for the selected criteria.');
            }

            $sentCount = 0;
            $failedCount = 0;

            foreach ($recipients as $recipient) {
                try {
                    $this->sendEmailToRecipient(
                        $recipient,
                        $validated['subject'],
                        $validated['message'],
                        $sender,
                        $validated['recipient_type']
                    );
                    $sentCount++;
                } catch (\Exception $e) {
                    $failedCount++;
                    \Log::error('Email sending failed: ' . $e->getMessage());
                }
            }

            $message = "Emails sent: $sentCount";
            if ($failedCount > 0) {
                $message .= ", Failed: $failedCount";
            }

            return redirect()->route('email.history')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send emails: ' . $e->getMessage());
        }
    }

    /**
     * Get recipients based on type
     */
    private function getRecipients($type, $studentId = null, $courseId = null, $attendanceThreshold = 75)
    {
        $recipients = [];

        match ($type) {
            'student' => $recipients = [Student::with('user')->find($studentId)],
            
            'parent' => $recipients = [
                (object)[
                    'type' => 'parent',
                    'email' => Student::find($studentId)->parent_email,
                    'name' => Student::with('parent')->find($studentId)->parent?->name ?? 'Parent',
                    'student_id' => $studentId,
                ]
            ],
            
            'class' => $recipients = $this->getClassRecipients($courseId),
            
            'low_attendance' => $recipients = $this->getLowAttendanceRecipients($attendanceThreshold, $courseId),
            
            default => $recipients = []
        };

        return array_filter($recipients); // Remove nulls
    }

    /**
     * Get all students in a course
     */
    private function getClassRecipients($courseId)
    {
        $enrollments = Enrollment::where('course_id', $courseId)
            ->where('status', 'active')
            ->with('student.user')
            ->get();

        return $enrollments->map(function ($enrollment) {
            return $enrollment->student;
        })->values()->all();  // Keep as Student objects
    }

    /**
     * Get students with low attendance
     */
    private function getLowAttendanceRecipients($threshold, $courseId = null)
    {
        $query = Attendance::selectRaw('student_id, COUNT(*) as total, SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present')
            ->groupByRaw('student_id')
            ->havingRaw('(SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) / COUNT(*)) * 100 < ?', [$threshold]);

        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        $studentIds = $query->pluck('student_id');

        return Student::with('user')
            ->whereIn('id', $studentIds)
            ->get()
            ->all();  // Keep as Student objects
    }

    /**
     * Send email to individual recipient
     */
    private function sendEmailToRecipient($recipient, $subject, $message, $sender, $type)
    {
        $email = null;
        $name = null;
        $student = null;

        // Get Student model properly
        if (is_object($recipient) && isset($recipient->type) && $recipient->type === 'parent') {
            $email = $recipient->email;
            $name = $recipient->name;
            $student = Student::with('user')->find($recipient->student_id);
        } else if (is_object($recipient) && $recipient instanceof Student) {
            $email = $recipient->user->email;
            $name = $recipient->user->name;
            $student = $recipient;
        } else if (is_array($recipient)) {
            // Handle array case
            $studentModel = Student::find($recipient['student_id'] ?? $recipient['id'] ?? null);
            if ($studentModel) {
                $email = $recipient['parent_email'] ?? $studentModel->user->email;
                $name = $recipient['parent_name'] ?? $studentModel->user->name;
                $student = $studentModel;
            }
        }

        if (!$email || !$student) {
            throw new \Exception("No valid email or student found for recipient");
        }

        try {
            // Send the email
            if ($type === 'parent') {
                Mail::to($email)->send(new ParentNotification($subject, $message, $student));
            } else {
                Mail::to($email)->send(new StudentNotification($subject, $message, $student));
            }

            // Log successful email
            EmailLog::create([
                'sender_id' => $sender->id,
                'receiver_email' => $email,
                'subject' => $subject,
                'message' => $message,
                'status' => 'sent',
                'sent_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Log failed email
            EmailLog::create([
                'sender_id' => $sender->id,
                'receiver_email' => $email,
                'subject' => $subject,
                'message' => $message,
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Show email history
     */
    public function showHistory(Request $request)
    {
        $query = EmailLog::query();

        // Filter by user role
        if (Auth::user()->role->slug !== 'admin') {
            // Faculty can only see their own sent emails
            $query->where('sender_id', Auth::id());
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('subject', 'like', "%$search%")
                  ->orWhere('receiver_email', 'like', "%$search%");
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $emailLogs = $query->latest()->paginate(20);

        return view('emails.history', compact('emailLogs'));
    }

    /**
     * Resend a failed email
     */
    public function resend(EmailLog $emailLog)
    {
        $this->authorize('update', $emailLog);

        try {
            // Get the student to send the email properly
            $student = Student::where('email', $emailLog->receiver_email)
                            ->orWhereHas('user', function ($query) use ($emailLog) {
                                $query->where('email', $emailLog->receiver_email);
                            })
                            ->first();

            if ($student) {
                // Use the proper mailable class
                Mail::to($emailLog->receiver_email)->send(new StudentNotification(
                    $emailLog->subject,
                    $emailLog->message,
                    $student
                ));
            } else {
                // Fallback to raw email if student not found
                Mail::raw($emailLog->message, function ($message) use ($emailLog) {
                    $message->to($emailLog->receiver_email)
                            ->subject($emailLog->subject);
                });
            }

            $emailLog->update([
                'status' => 'sent',
                'sent_at' => now(),
                'error_message' => null,
            ]);

            return redirect()->back()->with('success', 'Email resent successfully');
        } catch (\Exception $e) {
            $emailLog->update([
                'error_message' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Failed to resend email: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics for email dashboard
     */
    public function getStats()
    {
        $stats = [
            'total_sent' => EmailLog::where('status', 'sent')->count(),
            'total_failed' => EmailLog::where('status', 'failed')->count(),
            'this_month' => EmailLog::where('status', 'sent')
                ->whereMonth('sent_at', now()->month)
                ->count(),
        ];

        return response()->json($stats);
    }
}
