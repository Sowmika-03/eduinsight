@extends('layouts.guest')

@section('title', 'Sign In - EduInsight Platform')

@section('content')
<!-- Alpine.js State for Auto-Filling Logins & Active Role Selection -->
<div x-data="{
    email: '{{ old('email', 'admin@eduinsight.com') }}',
    password: 'password',
    showPassword: false,
    activeRole: 'admin',
    fillCredentials(userEmail, userPass, roleName = '') {
        this.email = userEmail;
        this.password = userPass;
        if(roleName) this.activeRole = roleName;
    }
}">

    <!-- Dedicated Centered Login Card -->
    <div class="flex items-center justify-center min-h-[calc(100vh-4rem)] py-12 px-4 sm:px-6 lg:px-8 bg-slate-50 border-b border-slate-200">
        
        <div class="max-w-md w-full bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/60 relative overflow-hidden" id="login-section">
            <!-- Card Top Accent Bar -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-linear-to-r from-blue-700 via-blue-600 to-indigo-600"></div>

            <!-- Card Logo & Header -->
            <div class="mb-5">
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
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10px] font-bold uppercase flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Online
                    </span>
                </div>
                <p class="text-xs text-slate-500 font-medium">Select a demo role tab below or enter credentials to sign in.</p>
            </div>

            <!-- Session Errors & Flash Messages -->
            @if(isset($errors) && $errors->any())
                <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs space-y-1 shadow-2xs">
                    <div class="font-bold flex items-center gap-1.5 text-red-700">
                        <i class="fas fa-exclamation-circle text-red-600"></i> Login Failed
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-[11px] text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2 shadow-2xs">
                    <i class="fas fa-check-circle text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-medium flex items-center gap-2 shadow-2xs">
                    <i class="fas fa-exclamation-circle text-red-600 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- ONE-CLICK ROLE QUICK SELECTOR TABS -->
            <div class="mb-5 space-y-3">
                <label class="text-[10px] font-extrabold uppercase tracking-wider text-blue-700 block">⚡ Express Demo Autofill</label>
                <div class="grid grid-cols-2 gap-1.5 bg-slate-100 p-1 rounded-xl border border-slate-200">
                    <button type="button" @click="fillCredentials('admin@eduinsight.com', 'password', 'admin')" :class="activeRole === 'admin' ? 'bg-white text-blue-700 shadow-2xs border-slate-200' : 'text-slate-600 hover:text-slate-900'" class="py-1.5 px-2 rounded-lg text-xs font-bold transition flex items-center justify-center gap-1">
                        <i class="fas fa-user-shield text-[10px]"></i> Admin
                    </button>
                    <button type="button" @click="fillCredentials('drbalamuralikrishna@gmail.com', 'password', 'faculty')" :class="activeRole === 'faculty' ? 'bg-white text-blue-700 shadow-2xs border-slate-200' : 'text-slate-600 hover:text-slate-900'" class="py-1.5 px-2 rounded-lg text-xs font-bold transition flex items-center justify-center gap-1">
                        <i class="fas fa-chalkboard-teacher text-[10px]"></i> Faculty
                    </button>
                </div>
                
                <div>
                    <label class="text-[9px] font-extrabold uppercase tracking-wider text-slate-500 block mb-1">Heads of Department (HOD)</label>
                    <div class="grid grid-cols-4 gap-1 bg-slate-100 p-1 rounded-xl border border-slate-200">
                        <button type="button" @click="fillCredentials('csehod@eduinsight.com', 'password', 'csehod')" :class="activeRole === 'csehod' ? 'bg-white text-blue-700 shadow-2xs border-slate-200' : 'text-slate-600 hover:text-slate-900'" class="py-1.5 px-1 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1">
                            CSE
                        </button>
                        <button type="button" @click="fillCredentials('ithod@eduinsight.com', 'password', 'ithod')" :class="activeRole === 'ithod' ? 'bg-white text-blue-700 shadow-2xs border-slate-200' : 'text-slate-600 hover:text-slate-900'" class="py-1.5 px-1 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1">
                            IT
                        </button>
                        <button type="button" @click="fillCredentials('mcahod@eduinsight.com', 'password', 'mcahod')" :class="activeRole === 'mcahod' ? 'bg-white text-blue-700 shadow-2xs border-slate-200' : 'text-slate-600 hover:text-slate-900'" class="py-1.5 px-1 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1">
                            MCA
                        </button>
                        <button type="button" @click="fillCredentials('mbahod@eduinsight.com', 'password', 'mbahod')" :class="activeRole === 'mbahod' ? 'bg-white text-blue-700 shadow-2xs border-slate-200' : 'text-slate-600 hover:text-slate-900'" class="py-1.5 px-1 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1">
                            MBA
                        </button>
                    </div>
                </div>

                <div>
                    <label class="text-[9px] font-extrabold uppercase tracking-wider text-slate-500 block mb-1">Students (Sowmika)</label>
                    <div class="grid grid-cols-4 gap-1 bg-slate-100 p-1 rounded-xl border border-slate-200">
                        <button type="button" @click="fillCredentials('sowmikacse@gmail.com', 'password', 'student-cse')" :class="activeRole === 'student-cse' ? 'bg-white text-blue-700 shadow-2xs border-slate-200' : 'text-slate-600 hover:text-slate-900'" class="py-1.5 px-1 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1">
                            CSE
                        </button>
                        <button type="button" @click="fillCredentials('sowmikait@gmail.com', 'password', 'student-it')" :class="activeRole === 'student-it' ? 'bg-white text-blue-700 shadow-2xs border-slate-200' : 'text-slate-600 hover:text-slate-900'" class="py-1.5 px-1 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1">
                            IT
                        </button>
                        <button type="button" @click="fillCredentials('sowmikamca@gmail.com', 'password', 'student-mca')" :class="activeRole === 'student-mca' ? 'bg-white text-blue-700 shadow-2xs border-slate-200' : 'text-slate-600 hover:text-slate-900'" class="py-1.5 px-1 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1">
                            MCA
                        </button>
                        <button type="button" @click="fillCredentials('sowmikamba@gmail.com', 'password', 'student-mba')" :class="activeRole === 'student-mba' ? 'bg-white text-blue-700 shadow-2xs border-slate-200' : 'text-slate-600 hover:text-slate-900'" class="py-1.5 px-1 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1">
                            MBA
                        </button>
                    </div>
                </div>
            </div>

            <!-- LOGIN FORM -->
            <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="text-xs font-bold text-slate-700 block mb-1">Email Address</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            x-model="email"
                            placeholder="user@eduinsight.com"
                            class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition"
                            required 
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="text-xs font-bold text-slate-700">Password</label>
                        <button type="button" @click="showPassword = !showPassword" class="text-[11px] text-blue-600 font-semibold hover:underline">
                            <span x-text="showPassword ? 'Hide' : 'Show'"></span>
                        </button>
                    </div>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            id="password" 
                            name="password" 
                            x-model="password"
                            placeholder="••••••••"
                            class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition"
                            required
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs hover:shadow transition duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i> Sign In to Portal
                </button>
            </form>

            <!-- Links to Register and Landing Page -->
            <div class="mt-5 pt-4 border-t border-slate-100 text-center flex items-center justify-between text-xs text-slate-500 font-medium">
                <a href="/" class="text-slate-400 hover:text-slate-600 transition">&larr; Home Page</a>
                <span>New here? <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700 transition">Register &rarr;</a></span>
            </div>
        </div>

    </div>

</div>
@endsection
