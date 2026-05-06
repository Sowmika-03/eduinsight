@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="min-height: 100vh; display: flex; align-items: center;">
        <div class="col-md-5">
            <div class="card shadow" style="border-radius: 15px; border-top: 4px solid #667eea;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h1 class="text-primary">
                            <i class="fas fa-graduation-cap"></i>
                        </h1>
                        <h2>EduInsight</h2>
                        <p class="text-muted">Natural Language Decision Support System</p>
                    </div>

                    <form method="POST" action="{{ route('login.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3" 
                                style="background: linear-gradient(135deg, #667eea, #764ba2); border: none;">
                            Login
                        </button>
                    </form>

                    <hr>

                    <a href="{{ route('register') }}" class="btn btn-outline-primary w-100 mb-3">
                        <i class="fas fa-user-plus"></i> Create New Account
                    </a>

                    <hr>

                    <div class="alert alert-info" role="alert">
                        <strong>Demo Credentials:</strong>
                        <div><small><strong>Admin:</strong> admin@eduinsight.com / password</small></div>
                        <div><small><strong>Faculty:</strong> john.smith@eduinsight.com / password</small></div>
                        <div><small><strong>HOD:</strong> hod@eduinsight.com / password</small></div>
                        <div><small><strong>Student:</strong> student6@eduinsight.com / password</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
