@extends('layouts.app')

@section('title', 'Send Notification')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Send Email Notification</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('email.send.store') }}" method="POST">
                        @csrf

                        <!-- Recipient Type Selection -->
                        <div class="mb-3">
                            <label for="recipient_type" class="form-label">Send To:</label>
                            <select name="recipient_type" id="recipient_type" class="form-control @error('recipient_type') is-invalid @enderror" required>
                                <option value="">-- Select Recipient Type --</option>
                                <option value="student">Single Student</option>
                            </select>
                            @error('recipient_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Student Selection (shown conditionally) -->
                        <div class="mb-3" id="student-select" style="display: none;">
                            <label for="student_id" class="form-label">Select Student:</label>
                            <select name="student_id" id="student_id" class="form-control @error('student_id') is-invalid @enderror">
                                <option value="">-- Choose Student --</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->user->name }} ({{ $student->student_id }})</option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Course Selection (shown for class/low attendance) -->
                        <div class="mb-3" id="course-select" style="display: none;">
                            <label for="course_id" class="form-label">Select Course:</label>
                            <select name="course_id" id="course_id" class="form-control @error('course_id') is-invalid @enderror">
                                <option value="">-- All Courses --</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_name }} ({{ $course->course_code }})</option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Attendance Threshold -->
                        <div class="mb-3" id="attendance-threshold" style="display: none;">
                            <label for="attendance_threshold" class="form-label">Attendance Threshold (%):</label>
                            <input type="number" name="attendance_threshold" id="attendance_threshold" 
                                   class="form-control @error('attendance_threshold') is-invalid @enderror" 
                                   value="75" min="1" max="100">
                            <small class="form-text text-muted">Send to students below this percentage</small>
                            @error('attendance_threshold')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Quick Templates -->
                        <div class="mb-3">
                            <label class="form-label">📋 Quick Templates:</label>
                            <div class="btn-group w-100 flex-wrap gap-2" role="group">
                                <button type="button" class="btn btn-outline-secondary btn-sm" 
                                        onclick="setTemplate('Attendance Alert', 'Your attendance is below 75%. Please attend upcoming classes regularly to improve your academic performance.')"
                                        title="Quick template for low attendance">
                                    🎓 Attendance Alert
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" 
                                        onclick="setTemplate('Assignment Reminder', 'Please submit your pending assignments by the deadline. Contact me if you need any clarification.')"
                                        title="Quick template for assignment reminders">
                                    📝 Assignment Reminder
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" 
                                        onclick="setTemplate('Exam Notification', 'The upcoming exam is scheduled on the announced date. Please prepare well and review all covered topics.')"
                                        title="Quick template for exam notification">
                                    ✏️ Exam Info
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" 
                                        onclick="setTemplate('Low Grades Alert', 'Your recent grades are below average. I recommend meeting during office hours to discuss your progress.')"
                                        title="Quick template for low grades">
                                    📊 Grades Alert
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" 
                                        onclick="setTemplate('Class Announcement', 'Please note the important class announcement. Check your email regularly for course updates.')"
                                        title="Quick template for class announcements">
                                    📢 Announcement
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" 
                                        onclick="setTemplate('Academic Performance', 'Great job! Your consistent performance is commendable. Keep maintaining this excellence.')"
                                        title="Quick template for positive feedback">
                                    ⭐ Appreciation
                                </button>
                            </div>
                            <small class="form-text text-muted d-block mt-2">Click any template to auto-fill subject and message</small>
                        </div>

                        <!-- Subject -->
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject:</label>
                            <input type="text" name="subject" id="subject" 
                                   class="form-control @error('subject') is-invalid @enderror" 
                                   placeholder="Enter email subject" required
                                   value="{{ old('subject') }}">
                            @error('subject')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div class="mb-3">
                            <label for="message" class="form-label">Message:</label>
                            <textarea name="message" id="message" 
                                      class="form-control @error('message') is-invalid @enderror" 
                                      rows="6" placeholder="Enter your message here" required>{{ old('message') }}</textarea>
                            <small class="form-text text-muted">Min 10 characters | <span id="charCount">0</span>/{{ strlen(old('message', '')) }}</small>
                            @error('message')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-envelope"></i> Send Email
                            </button>
                            <a href="{{ route('email.history') }}" class="btn btn-secondary">
                                <i class="fas fa-history"></i> View History
                            </a>
                            <button type="reset" class="btn btn-outline-secondary">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Set template subject and message
function setTemplate(subject, message) {
    document.getElementById('subject').value = subject;
    document.getElementById('message').value = message;
    updateCharCount();
    
    // Visual feedback
    const messageField = document.getElementById('message');
    messageField.classList.add('border-success', 'border-2');
    setTimeout(() => {
        messageField.classList.remove('border-success', 'border-2');
    }, 1000);
}

// Update character count
function updateCharCount() {
    const message = document.getElementById('message').value;
    document.getElementById('charCount').textContent = message.length;
    
    // Visual feedback if below minimum
    if (message.length < 10) {
        document.getElementById('message').classList.add('is-invalid');
    } else {
        document.getElementById('message').classList.remove('is-invalid');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const recipientType = document.getElementById('recipient_type');
    const studentSelect = document.getElementById('student-select');
    const courseSelect = document.getElementById('course-select');
    const attendanceThreshold = document.getElementById('attendance-threshold');
    const messageField = document.getElementById('message');

    function updateVisibility() {
        const type = recipientType.value;
        
        studentSelect.style.display = (type === 'student' || type === 'parent') ? 'block' : 'none';
        courseSelect.style.display = (type === 'class' || type === 'low_attendance') ? 'block' : 'none';
        attendanceThreshold.style.display = (type === 'low_attendance') ? 'block' : 'none';
    }

    recipientType.addEventListener('change', updateVisibility);
    
    // Initialize character counter
    if (messageField) {
        messageField.addEventListener('input', updateCharCount);
        updateCharCount();
    }
    
    updateVisibility();
});
</script>
@endsection
