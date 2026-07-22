@extends('layouts.guest')

@section('title', 'Create New Account - EduInsight Platform')

@section('content')
<!-- Center Container for Registration Page -->
<div class="flex items-center justify-center min-h-[calc(100vh-4rem)] py-12 px-4 sm:px-6 lg:px-8 bg-slate-50 border-b border-slate-200">
    
    <div class="max-w-md w-full bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/60 relative overflow-hidden">
        <!-- Card Top Accent Bar -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-linear-to-r from-blue-700 via-blue-600 to-indigo-600"></div>

        <!-- Card Logo & Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 bg-linear-to-tr from-blue-700 to-blue-500 flex items-center justify-center text-white shadow-sm" style="background: linear-gradient(to top right, #1d4ed8, #3b82f6);">
                        <i class="fas fa-graduation-cap text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-display font-black text-slate-900 text-base tracking-tight leading-none">EduInsight</span>
                        <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase leading-tight mt-0.5">Enterprise Portal</span>
                    </div>
                </div>
                <span class="px-2.5 py-0.5 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-[10px] font-bold uppercase">Register</span>
            </div>
            <p class="text-xs text-slate-500 font-medium">Create your credentials to join the academic analytics workspace.</p>
        </div>

        <!-- Session Errors & Flash Messages -->
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs space-y-1 shadow-2xs">
                <div class="font-bold flex items-center gap-1.5 text-red-700">
                    <i class="fas fa-exclamation-circle text-red-600"></i> Please resolve the following:
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-[11px] text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
            @csrf

            <!-- Name Input -->
            <div>
                <label for="name" class="text-xs font-bold text-slate-700 block mb-1">Full Name</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="John Doe"
                        class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition"
                        required 
                        autofocus
                    >
                </div>
            </div>

            <!-- Email Input -->
            <div>
                <label for="email" class="text-xs font-bold text-slate-700 block mb-1">Email Address</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="you@example.com"
                        class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition"
                        required 
                    >
                </div>
            </div>

            <!-- Account Type Selector -->
            <div>
                <label for="account_type" class="text-xs font-bold text-slate-700 block mb-1">Account Type</label>
                <div class="relative">
                    <i class="fas fa-user-check absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <select 
                        id="account_type" 
                        name="account_type" 
                        class="w-full pl-9 pr-8 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition appearance-none cursor-pointer"
                        required 
                        onchange="updateAccountInfo()"
                    >
                        <option value="">Select Account Type</option>
                        <option value="student" @selected(old('account_type') === 'student')>Student</option>
                        <option value="faculty" @selected(old('account_type') === 'faculty')>Faculty</option>
                    </select>
                    <!-- Custom Arrow Icon for Select -->
                    <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-[10px]">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                <!-- Dynamic Helper Note -->
                <div class="mt-1.5 p-2.5 rounded-lg bg-blue-50 border border-blue-100 text-blue-800 text-[11px] font-semibold leading-relaxed" id="account_info">
                    Select an account type to view access details
                </div>
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="text-xs font-bold text-slate-700 block mb-1">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••"
                        class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition"
                        required
                    >
                </div>
                <small class="text-[10px] text-slate-400 font-medium mt-1 block">Minimum 6 characters</small>
            </div>

            <!-- Confirm Password Input -->
            <div>
                <label for="password_confirmation" class="text-xs font-bold text-slate-700 block mb-1">Confirm Password</label>
                <div class="relative">
                    <i class="fas fa-check-circle absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="••••••••"
                        class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition"
                        required
                    >
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs hover:shadow transition duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                <i class="fas fa-user-plus"></i> Create Account
            </button>
        </form>

        <!-- Redirect to Login Link -->
        <div class="mt-5 pt-4 border-t border-slate-100 text-center flex items-center justify-between text-xs text-slate-500 font-medium">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700 transition">Sign in here &rarr;</a>
        </div>
    </div>

</div>

<!-- Interactive Client-side Script to update selected account info note -->
<script>
function updateAccountInfo() {
    const select = document.getElementById('account_type');
    const info = document.getElementById('account_info');
    
    if (select.value === 'student') {
        info.innerHTML = '<i class="fas fa-info-circle text-blue-600"></i> Student account gives you access to track your personal marks, class attendance logs, and academic performance charts.';
    } else if (select.value === 'faculty') {
        info.innerHTML = '<i class="fas fa-info-circle text-blue-600"></i> Faculty accounts require admin authorization. You will be placed in the approval queue once registered.';
    } else {
        info.innerHTML = 'Select an account type to view access details';
    }
}

// Fire once on load to populate if old input exists
window.addEventListener('DOMContentLoaded', () => {
    updateAccountInfo();
});
</script>
@endsection
