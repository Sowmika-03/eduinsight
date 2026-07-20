@extends('layouts.app')

@section('title', 'Send Notification')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-paper-plane"></i>
                <span>Institutional Communication Gateway</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Send Parent & Student Email Notification
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Dispatch automated academic risk warnings, attendance alerts, and official university communications.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('email.history') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 transition border border-purple-200 flex items-center gap-1.5 shadow-2xs">
                <i class="fas fa-history"></i>
                <span>Email Delivery Logs</span>
            </a>
            <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200">
                <i class="fas fa-arrow-left mr-1"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Main Compose Form (Full Width 90-95%) -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-xs">
        
        <form action="{{ route('email.send.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Recipient Type Selection -->
                <div>
                    <label for="recipient_type" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
                        Recipient Target Group:
                    </label>
                    <select name="recipient_type" id="recipient_type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-900 font-semibold focus:bg-white focus:border-blue-500 focus:ring-0" required>
                        <option value="student" {{ old('recipient_type', request('recipient_type', 'student')) === 'student' ? 'selected' : '' }}>Single Student / Parent Contact</option>
                        <option value="class" {{ old('recipient_type', request('recipient_type')) === 'class' ? 'selected' : '' }}>Entire Course Batch</option>
                        <option value="low_attendance" {{ old('recipient_type', request('recipient_type')) === 'low_attendance' ? 'selected' : '' }}>Students Below Attendance Threshold</option>
                    </select>
                </div>

                <!-- Student Selection (Conditional) -->
                <div id="student-select">
                    <label for="student_id" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
                        Select Targeted Student:
                    </label>
                    <select name="student_id" id="student_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-900 font-semibold focus:bg-white focus:border-blue-500 focus:ring-0">
                        <option value="">-- Select Student --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" {{ (old('student_id', request('student_id')) == $student->id) ? 'selected' : '' }}>
                                {{ $student->user->name }} ({{ $student->student_id }} &bull; {{ $student->program }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Course Selection (Conditional) -->
                <div id="course-select" class="hidden">
                    <label for="course_id" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
                        Select Course Subject:
                    </label>
                    <select name="course_id" id="course_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-900 font-semibold focus:bg-white focus:border-blue-500 focus:ring-0">
                        <option value="">-- All Courses --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ (old('course_id', request('course_id')) == $course->id) ? 'selected' : '' }}>
                                {{ $course->course_name }} ({{ $course->course_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Attendance Threshold (Conditional) -->
                <div id="attendance-threshold" class="hidden">
                    <label for="attendance_threshold" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
                        Attendance Cut-off Threshold (%):
                    </label>
                    <input type="number" name="attendance_threshold" id="attendance_threshold" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-900 font-semibold focus:bg-white focus:border-blue-500 focus:ring-0" 
                           value="{{ old('attendance_threshold', 75) }}" min="1" max="100">
                </div>

            </div>

            <!-- Quick Template Buttons -->
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
                    📋 Institutional Quick Templates:
                </label>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="setTemplate('Attendance Alert', 'Your attendance is currently below 75%. Please attend upcoming classes regularly to satisfy university academic eligibility thresholds.')"
                            class="px-3 py-1.5 text-xs font-bold rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 transition border border-slate-200 flex items-center gap-1.5">
                        🎓 Attendance Warning
                    </button>
                    <button type="button" onclick="setTemplate('Assignment Reminder', 'Please submit your pending coursework assignments by the specified deadline. Contact your course advisor for guidance.')"
                            class="px-3 py-1.5 text-xs font-bold rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 transition border border-slate-200 flex items-center gap-1.5">
                        📝 Assignment Reminder
                    </button>
                    <button type="button" onclick="setTemplate('Exam Notification', 'The upcoming semester examination schedule has been published. Please review course topics and confirm seating arrangements.')"
                            class="px-3 py-1.5 text-xs font-bold rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 transition border border-slate-200 flex items-center gap-1.5">
                        ✏️ Exam Information
                    </button>
                    <button type="button" onclick="setTemplate('Low Grades Alert', 'Your recent internal exam scores are below passing thresholds. Please schedule a remedial mentoring session during office hours.')"
                            class="px-3 py-1.5 text-xs font-bold rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 transition border border-slate-200 flex items-center gap-1.5">
                        📊 Grades Alert
                    </button>
                </div>
            </div>

            <!-- Subject -->
            <div>
                <label for="subject" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
                    Email Subject Line:
                </label>
                <input type="text" name="subject" id="subject" 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:ring-0" 
                       placeholder="Enter email subject..." required value="{{ old('subject', request('subject')) }}">
            </div>

            <!-- Message Body -->
            <div>
                <label for="message" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
                    Email Message Content:
                </label>
                <textarea name="message" id="message" rows="6" 
                          class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:ring-0 resize-none" 
                          placeholder="Compose official email content here..." required>{{ old('message', request('message')) }}</textarea>
            </div>

            <!-- Submit Button Bar -->
            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-2xs flex items-center gap-2">
                    <i class="fas fa-paper-plane text-xs"></i>
                    <span>Send Notification Email</span>
                </button>
                <a href="{{ route('email.history') }}" class="px-4 py-2.5 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200">
                    View Delivery Logs
                </a>
            </div>

        </form>
    </div>

</div>

@endsection

@section('scripts')
<script>
function setTemplate(subject, message) {
    document.getElementById('subject').value = subject;
    document.getElementById('message').value = message;
}

document.addEventListener('DOMContentLoaded', function() {
    const recipientType = document.getElementById('recipient_type');
    const studentSelect = document.getElementById('student-select');
    const courseSelect = document.getElementById('course-select');
    const attendanceThreshold = document.getElementById('attendance-threshold');

    function updateVisibility() {
        const type = recipientType.value;
        if (studentSelect) studentSelect.classList.toggle('hidden', type !== 'student');
        if (courseSelect) courseSelect.classList.toggle('hidden', type !== 'class' && type !== 'low_attendance');
        if (attendanceThreshold) attendanceThreshold.classList.toggle('hidden', type !== 'low_attendance');
    }

    if (recipientType) {
        recipientType.addEventListener('change', updateVisibility);
        updateVisibility();
    }
});
</script>
@endsection
