@extends('layouts.guest')

@section('title', 'Create New Account')

@section('content')
<style>
    .register-card {
        animation: fadeInUp 0.8s ease-out;
    }
    
    .register-header {
        text-align: center;
        margin-bottom: 2.5rem;
        animation: fadeInDown 0.8s ease-out 0.2s both;
    }
    
    .logo-icon {
        font-size: 3.5rem;
        color: var(--primary-blue);
        margin-bottom: 1rem;
        display: inline-block;
    }
    
    .register-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0.5rem 0;
        letter-spacing: -0.5px;
    }
    
    .register-subtitle {
        font-size: 0.95rem;
        color: #64748b;
        margin: 0;
        font-weight: 500;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.8s ease-out;
    }
    
    .form-group:nth-child(1) { animation-delay: 0.3s; }
    .form-group:nth-child(2) { animation-delay: 0.4s; }
    .form-group:nth-child(3) { animation-delay: 0.5s; }
    .form-group:nth-child(4) { animation-delay: 0.6s; }
    .form-group:nth-child(5) { animation-delay: 0.7s; }
    .form-group:nth-child(6) { animation-delay: 0.8s; }
    
    .form-label {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 0.75rem;
        display: block;
        letter-spacing: 0.3px;
    }
    
    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .input-icon {
        position: absolute;
        left: 1.25rem;
        color: #94a3b8;
        font-size: 1.1rem;
        pointer-events: none;
        transition: all 0.3s ease;
    }
    
    .form-control,
    .form-select {
        padding: 0.95rem 0.95rem 0.95rem 3.2rem !important;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 12px !important;
        font-size: 1rem !important;
        background: rgba(248, 250, 252, 0.5) !important;
        transition: all 0.3s ease !important;
        font-weight: 500;
        color: var(--dark-text) !important;
    }
    
    .form-control:focus,
    .form-select:focus {
        background: rgba(255, 255, 255, 0.8) !important;
        border-color: var(--primary-blue) !important;
        box-shadow: 0 0 0 3px rgba(91, 124, 255, 0.1) !important;
    }
    
    .form-control::placeholder,
    .form-select::placeholder {
        color: #cbd5e1 !important;
    }
    
    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #ef4444 !important;
    }
    
    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
    }
    
    .invalid-feedback {
        font-size: 0.85rem;
        color: #ef4444;
        margin-top: 0.5rem;
        display: block;
        font-weight: 500;
    }
    
    .form-text {
        font-size: 0.85rem;
        color: #94a3b8;
        margin-top: 0.5rem;
        display: block;
        font-weight: 500;
    }
    
    .btn-register {
        background: linear-gradient(135deg, #5B7CFF 0%, #7B4DFF 100%);
        border: none;
        font-size: 1rem;
        padding: 1rem !important;
        border-radius: 12px;
        font-weight: 700;
        letter-spacing: 0.3px;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(91, 124, 255, 0.4);
        color: white;
        animation: fadeInUp 0.8s ease-out 0.9s both;
    }
    
    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(91, 124, 255, 0.6);
        background: linear-gradient(135deg, #4A6BE6 0%, #6B3CE6 100%);
    }
    
    .btn-register:active {
        transform: translateY(0);
    }
    
    .divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
        margin: 1.5rem 0;
        animation: fadeInUp 0.8s ease-out 1s both;
    }
    
    .login-link-section {
        text-align: center;
        animation: fadeInUp 0.8s ease-out 1.05s both;
    }
    
    .login-link-section p {
        color: #64748b;
        margin: 0;
        font-size: 0.95rem;
    }
    
    .login-link-section a {
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    
    .login-link-section a:hover {
        color: var(--primary-purple);
        text-decoration: underline;
    }
    
    .alert {
        background: rgba(239, 68, 68, 0.08);
        border: 1.5px solid rgba(239, 68, 68, 0.2);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        animation: slideInDown 0.5s ease-out;
    }
    
    .alert-danger {
        color: #ef4444;
    }
    
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="container" style="max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto;">
    <div class="register-card">
        <div class="register-header">
            <div class="logo-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h1 class="register-title">EduInsight</h1>
            <p class="register-subtitle">Create Your Account</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong style="font-size: 0.95rem; display: block; margin-bottom: 0.5rem;">Please fix the following errors:</strong>
                @foreach ($errors->all() as $error)
                    <div style="font-size: 0.9rem; margin-top: 0.35rem;">• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="John Doe"
                        required 
                        autofocus
                    >
                </div>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="you@example.com"
                        required
                    >
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="account_type" class="form-label">Account Type</label>
                <div class="input-wrapper">
                    <i class="fas fa-user-check input-icon"></i>
                    <select 
                        class="form-select @error('account_type') is-invalid @enderror" 
                        id="account_type" 
                        name="account_type" 
                        required 
                        onchange="updateAccountInfo()"
                    >
                        <option value="">Select Account Type</option>
                        <option value="student" @selected(old('account_type') === 'student')>
                            Student
                        </option>
                        <option value="faculty" @selected(old('account_type') === 'faculty')>
                            Faculty
                        </option>
                    </select>
                </div>
                @error('account_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text" id="account_info">
                    Select an account type to continue
                </small>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        placeholder="Enter your password"
                        required
                    >
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text">Minimum 6 characters</small>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-check-circle input-icon"></i>
                    <input 
                        type="password" 
                        class="form-control @error('password_confirmation') is-invalid @enderror" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="Confirm your password"
                        required
                    >
                </div>
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-register w-100">
                <i class="fas fa-user-plus"></i> Create Account
            </button>
        </form>

        <div class="divider"></div>

        <div class="login-link-section">
            <p>Already have an account? 
                <a href="{{ route('login') }}">Sign in here</a>
            </p>
        </div>
    </div>
</div>

<script>
    function updateAccountInfo() {
        const accountType = document.getElementById('account_type').value;
        const accountInfo = document.getElementById('account_info');
        
        if (accountType === 'student') {
            accountInfo.textContent = '👨‍🎓 You can track your marks, attendance, and academic performance';
        } else if (accountType === 'faculty') {
            accountInfo.textContent = '👨‍🏫 You can manage courses, mark attendance, and monitor student progress';
        } else {
            accountInfo.textContent = 'Select an account type to continue';
        }
    }
</script>

@endsection

                    <div class="alert alert-info alert-sm" role="alert">
                        <small>
                            <strong>Student Account:</strong> Access your marks, attendance, and academic performance<br>
                            <strong>Faculty Account:</strong> Pending admin approval to manage courses and students
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateAccountInfo() {
    const select = document.getElementById('account_type');
    const info = document.getElementById('account_info');
    
    if (select.value === 'student') {
        info.innerHTML = '<i class="fas fa-info-circle"></i> Student account gives you access to your marks, attendance, and academic performance';
    } else if (select.value === 'faculty') {
        info.innerHTML = '<i class="fas fa-info-circle"></i> Faculty account requires admin approval. You will receive an email once approved.';
    } else {
        info.innerHTML = 'Select an account type to continue';
    }
}
</script>
@endsection
