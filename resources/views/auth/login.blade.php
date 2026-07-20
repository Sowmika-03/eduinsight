@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<style>
    .login-card {
        animation: fadeInUp 0.8s ease-out;
    }
    
    .login-header {
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
    
    .login-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0.5rem 0 0.25rem;
        letter-spacing: -0.5px;
    }
    
    .login-subtitle {
        font-size: 0.95rem;
        color: #64748b;
        margin: 0;
        font-weight: 500;
    }
    
    .form-group {
        margin-bottom: 1.75rem;
        animation: fadeInUp 0.8s ease-out;
    }
    
    .form-group:nth-child(1) { animation-delay: 0.4s; }
    .form-group:nth-child(2) { animation-delay: 0.5s; }
    
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
    
    .form-control {
        padding: 0.95rem 0.95rem 0.95rem 3.2rem !important;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 12px !important;
        font-size: 1rem !important;
        background: rgba(248, 250, 252, 0.5) !important;
        transition: all 0.3s ease !important;
        font-weight: 500;
        color: var(--dark-text) !important;
    }
    
    .form-control:focus {
        background: rgba(255, 255, 255, 0.8) !important;
        border-color: var(--primary-blue) !important;
        box-shadow: 0 0 0 3px rgba(91, 124, 255, 0.1) !important;
    }
    
    .form-control::placeholder {
        color: #cbd5e1 !important;
    }
    
    .form-control.is-invalid {
        border-color: #ef4444 !important;
    }
    
    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
    }
    
    .invalid-feedback {
        font-size: 0.85rem;
        color: #ef4444;
        margin-top: 0.5rem;
        display: block;
        font-weight: 500;
    }
    
    .btn-login {
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
        animation: fadeInUp 0.8s ease-out 0.6s both;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(91, 124, 255, 0.6);
        background: linear-gradient(135deg, #4A6BE6 0%, #6B3CE6 100%);
    }
    
    .btn-login:active {
        transform: translateY(0);
    }
    
    .divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
        margin: 1.5rem 0;
        animation: fadeInUp 0.8s ease-out 0.65s both;
    }
    
    .btn-register {
        border: 2px solid var(--primary-blue);
        color: var(--primary-blue);
        font-size: 0.95rem;
        padding: 0.85rem !important;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        background: transparent;
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.8s ease-out 0.7s both;
    }
    
    .btn-register:hover {
        background: rgba(91, 124, 255, 0.1);
        color: var(--primary-blue);
    }
    
    .demo-credentials {
        background: linear-gradient(135deg, rgba(91, 124, 255, 0.08) 0%, rgba(123, 77, 255, 0.08) 100%);
        border: 1.5px solid rgba(91, 124, 255, 0.2);
        border-radius: 12px;
        padding: 1.25rem;
        margin: 0;
        font-size: 0.9rem;
        animation: fadeInUp 0.8s ease-out 0.8s both;
    }
    
    .demo-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 0.75rem;
        display: block;
    }
    
    .demo-item {
        line-height: 1.8;
        color: #475569;
        font-size: 0.9rem;
    }
    
    .demo-item strong {
        color: var(--primary-blue);
        font-weight: 700;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="container login-card">
    <div class="login-header">
        <div class="logo-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <h1 class="login-title">EduInsight</h1>
        <p class="login-subtitle">Natural Language Decision Support System</p>
    </div>

    <form method="POST" action="{{ route('login.store') }}" class="login-form">
        @csrf

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
                    autofocus
                >
            </div>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
        </div>

        <button type="submit" class="btn btn-login w-100">
            <i class="fas fa-sign-in-alt"></i> Sign In
        </button>
    </form>

    <div class="divider"></div>

    <a href="{{ route('register') }}" class="btn btn-register w-100">
        <i class="fas fa-user-plus"></i> Create New Account
    </a>

    <div class="divider"></div>

    <div class="demo-credentials">
        <span class="demo-title"><i class="fas fa-graduation-cap" style="margin-right: 0.5rem;"></i>Demo Credentials</span>
        <div class="demo-item"><strong>Admin:</strong> admin@eduinsight.com / password</div>
        <div class="demo-item"><strong>Faculty:</strong> john.smith@eduinsight.com / password</div>
        <div class="demo-item"><strong>HOD:</strong> hod@eduinsight.com / password</div>
        <div class="demo-item"><strong>Student:</strong> student6@eduinsight.com / password</div>
    </div>
</div>
@endsection
