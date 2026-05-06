@extends('layouts.guest')

@section('title', 'Create New Account')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="min-height: 100vh; display: flex; align-items: center;">
        <div class="col-md-6">
            <div class="card shadow" style="border-radius: 15px; border-top: 4px solid #667eea;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h1 class="text-primary">
                            <i class="fas fa-graduation-cap"></i>
                        </h1>
                        <h2>EduInsight</h2>
                        <p class="text-muted">Create Your Account</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="account_type" class="form-label">Account Type</label>
                            <select class="form-select @error('account_type') is-invalid @enderror" 
                                    id="account_type" name="account_type" required onchange="updateAccountInfo()">
                                <option value="">Select Account Type</option>
                                <option value="student" @selected(old('account_type') === 'student')>
                                    <i class="fas fa-user-graduate"></i> Student
                                </option>
                                <option value="faculty" @selected(old('account_type') === 'faculty')>
                                    <i class="fas fa-chalkboard-user"></i> Faculty
                                </option>
                            </select>
                            @error('account_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2" id="account_info">
                                Select an account type to continue
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimum 6 characters</small>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3" 
                                style="background: linear-gradient(135deg, #667eea, #764ba2); border: none;">
                            <i class="fas fa-user-plus"></i> Create Account
                        </button>
                    </form>

                    <hr>

                    <div class="text-center">
                        <p class="text-muted">Already have an account?
                            <a href="{{ route('login') }}" class="text-primary fw-bold">Login here</a>
                        </p>
                    </div>

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
