@extends('layouts.app')

@section('title', 'Enterprise Notification Center')

@section('content')
<div x-data="{ 
    previewMode: false,
    subjectText: '{{ old('subject', request('subject', '')) }}',
    messageText: '{{ old('message', request('message', '')) }}',
    recipientType: '{{ old('recipient_type', request('recipient_type', 'student')) }}',
    setTemplate(subj, msg) {
        this.subjectText = subj;
        this.messageText = msg;
    }
}" class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                <i class="fas fa-paper-plane"></i>
                <span>Institutional Communication Gateway</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Enterprise Notification Center
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                Dispatch automated academic warnings, attendance notices, exam updates, and official communications.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('email.history') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 transition border border-purple-200 flex items-center gap-1.5 shadow-2xs">
                <i class="fas fa-history"></i>
                <span>Delivery Logs</span>
            </a>
            <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Top 4 KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- KPI 1: Notifications Sent -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Notifications Sent</span>
                <i class="fas fa-paper-plane text-blue-500"></i>
            </div>
            <div class="text-2xl font-black text-slate-900 mt-1">1,248</div>
            <div class="text-[11px] text-emerald-600 font-bold mt-1">&uparrow; 98.4% Delivery Success</div>
        </div>

        <!-- KPI 2: Pending -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Pending Dispatch</span>
                <i class="fas fa-spinner text-amber-500"></i>
            </div>
            <div class="text-2xl font-black text-amber-600 mt-1">3</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">Queued for sending</div>
        </div>

        <!-- KPI 3: Failed / Bounced -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Failed / Bounced</span>
                <i class="fas fa-exclamation-circle text-red-500"></i>
            </div>
            <div class="text-2xl font-black text-red-600 mt-1">2</div>
            <div class="text-[11px] text-red-600 font-medium mt-1">Invalid Email Addresses</div>
        </div>

        <!-- KPI 4: Templates Used -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400 uppercase">
                <span>Templates Active</span>
                <i class="fas fa-file-alt text-purple-500"></i>
            </div>
            <div class="text-2xl font-black text-purple-600 mt-1">4 Presets</div>
            <div class="text-[11px] text-purple-700 font-semibold mt-1">Institutional Standards</div>
        </div>
    </div>

    <!-- Main Compose Form & Live Preview Section -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-xs">
        
        <form action="{{ route('email.send.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Form Mode Toggle & Quick Presets -->
            <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <i class="fas fa-pen-nib text-blue-600 text-xs"></i>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Notification Dispatch Form</h3>
                </div>

                <button type="button" @click="previewMode = !previewMode" class="px-3 py-1.5 text-xs font-bold rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition border border-slate-200 flex items-center gap-1.5">
                    <i class="fas" :class="previewMode ? 'fa-edit' : 'fa-eye'"></i>
                    <span x-text="previewMode ? 'Edit Form' : 'Toggle Live Email Preview'"></span>
                </button>
            </div>

            <!-- Quick Template Selector -->
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
                    📋 Institutional Quick Templates:
                </label>
                <div class="flex flex-wrap gap-2">
                    <button type="button" @click="setTemplate('Attendance Notice: Below 75% Threshold', 'Dear Student/Parent,\n\nYour current attendance has dropped below the 75% mandatory eligibility threshold. Please meet your course coordinator immediately.')"
                            class="px-3 py-1.5 text-xs font-bold rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 transition border border-slate-200 flex items-center gap-1.5">
                        🎓 Attendance Warning
                    </button>

                    <button type="button" @click="setTemplate('Assignment Deadline Submission Notice', 'Dear Student,\n\nThis is a reminder that your pending continuous assessment assignment is due by Friday end-of-day. Late submissions will incur grade deductions.')"
                            class="px-3 py-1.5 text-xs font-bold rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 transition border border-slate-200 flex items-center gap-1.5">
                        📝 Assignment Reminder
                    </button>

                    <button type="button" @click="setTemplate('End-Semester Examination Timetable Published', 'Dear Student,\n\nThe end-semester examination timetable has been officially published. Please verify your course codes and examination hall seating details.')"
                            class="px-3 py-1.5 text-xs font-bold rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 transition border border-slate-200 flex items-center gap-1.5">
                        ✏️ Exam Information
                    </button>

                    <button type="button" @click="setTemplate('Academic Performance Advisory Notice', 'Dear Student/Parent,\n\nYour internal assessment scores require improvement. You have been scheduled for a mandatory remedial mentoring session next Tuesday.')"
                            class="px-3 py-1.5 text-xs font-bold rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 transition border border-slate-200 flex items-center gap-1.5">
                        📊 Grades Warning
                    </button>
                </div>
            </div>

            <!-- Inputs Grid -->
            <div x-show="!previewMode" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Target Recipient Group -->
                    <div>
                        <label for="recipient_type" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
                            Target Recipient Group:
                        </label>
                        <select name="recipient_type" x-model="recipientType" id="recipient_type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 font-semibold focus:bg-white focus:border-blue-500 focus:ring-0" required>
                            <option value="student">Single Student / Parent Contact</option>
                            <option value="class">Entire Course Batch</option>
                            <option value="low_attendance">Low Attendance Students (&lt;75%)</option>
                        </select>
                    </div>

                    <!-- Single Student Select -->
                    <div x-show="recipientType === 'student'">
                        <label for="student_id" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
                            Select Targeted Student:
                        </label>
                        <select name="student_id" id="student_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 font-semibold focus:bg-white focus:border-blue-500 focus:ring-0">
                            <option value="">-- Select Student --</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" {{ (old('student_id', request('student_id')) == $student->id) ? 'selected' : '' }}>
                                    {{ $student->user->name }} ({{ $student->student_id }} &bull; {{ $student->program }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Course Select -->
                    <div x-show="recipientType === 'class' || recipientType === 'low_attendance'">
                        <label for="course_id" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
                            Select Course Subject:
                        </label>
                        <select name="course_id" id="course_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 font-semibold focus:bg-white focus:border-blue-500 focus:ring-0">
                            <option value="">-- All Courses --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ (old('course_id', request('course_id')) == $course->id) ? 'selected' : '' }}>
                                    {{ $course->course_name }} ({{ $course->course_code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Subject Line -->
                <div>
                    <label for="subject" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
                        Email Subject Line:
                    </label>
                    <input type="text" name="subject" id="subject" x-model="subjectText"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:ring-0" 
                           placeholder="Enter official email subject line..." required>
                </div>

                <!-- Message Body -->
                <div>
                    <label for="message" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
                        Email Message Content:
                    </label>
                    <textarea name="message" id="message" x-model="messageText" rows="6" 
                              class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:ring-0 resize-none" 
                              placeholder="Type institutional email message here..." required></textarea>
                </div>
            </div>

            <!-- Live Email Preview Box -->
            <div x-show="previewMode" class="p-6 bg-slate-900 text-white rounded-2xl space-y-4 border border-slate-800">
                <div class="text-xs font-bold uppercase tracking-wider text-blue-400 flex items-center gap-2">
                    <i class="fas fa-desktop"></i> Live Recipient Inbox Preview
                </div>
                <div class="p-4 bg-slate-800 rounded-xl border border-slate-700 space-y-2">
                    <div class="text-xs text-slate-400"><strong>From:</strong> EduInsight System &lt;no-reply@eduinsight.edu&gt;</div>
                    <div class="text-xs text-slate-400"><strong>To:</strong> Selected Student/Parent Roster</div>
                    <div class="text-xs text-slate-200 font-bold border-t border-slate-700 pt-2">
                        <strong>Subject:</strong> <span x-text="subjectText || '(No Subject Line)'"></span>
                    </div>
                </div>
                <div class="p-4 bg-slate-950 rounded-xl border border-slate-800 text-xs font-mono text-slate-300 leading-relaxed whitespace-pre-wrap" x-text="messageText || '(No Message Content)'"></div>
            </div>

            <!-- Submit Button Bar -->
            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 text-xs font-extrabold rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-2xs flex items-center gap-2">
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
