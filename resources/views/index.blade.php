@extends('layouts.guest')

@section('title', 'EduInsight - AI Academic Intelligence & Early Risk Prediction Platform')

@section('content')
<div>

    <!-- ==========================================================================
         HERO SECTION: PLATFORM OVERVIEW + GET STARTED PORTAL SELECTOR
         ========================================================================== -->
    <section class="relative pt-10 pb-16 lg:pt-12 lg:pb-20 bg-slate-50 border-b border-slate-200" id="about">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">
                
                <!-- LEFT COLUMN: Platform Introduction & Value Proposition -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- Feature Pill Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold shadow-2xs">
                        <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
                        <i class="fas fa-graduation-cap text-blue-600"></i>
                        <span>AI-Powered Academic Intelligence & Early Risk Prediction</span>
                    </div>

                    <!-- Clean Professional Display Headline -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-display font-extrabold tracking-tight text-slate-900 leading-tight">
                        Transform Student Success With <span class="text-blue-600">Predictive Analytics</span>
                    </h1>

                    <!-- Detailed Description: What the site does & how it works -->
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-normal">
                        <strong class="text-slate-900 font-semibold">EduInsight</strong> is an enterprise Decision Support System built for higher education institutions. It continuously evaluates daily attendance patterns and assessment marks using a trained <strong class="text-blue-600 font-semibold">Random Forest Machine Learning Engine</strong> to classify academic risk weeks before final exams happen, triggering automated interventions and parent email alerts.
                    </p>

                    <!-- Feature Bullet Points -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700 bg-white p-3 rounded-xl border border-slate-200 shadow-2xs">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <i class="fas fa-chart-pie text-xs"></i>
                            </div>
                            <span>Continuous Risk Assessment (Low/Med/High)</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700 bg-white p-3 rounded-xl border border-slate-200 shadow-2xs">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <i class="fas fa-robot text-xs"></i>
                            </div>
                            <span>Natural Language AI Queries (NLP)</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700 bg-white p-3 rounded-xl border border-slate-200 shadow-2xs">
                            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <i class="fas fa-envelope text-xs"></i>
                            </div>
                            <span>Automated Student & Parent Emails</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700 bg-white p-3 rounded-xl border border-slate-200 shadow-2xs">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <i class="fas fa-sitemap text-xs"></i>
                            </div>
                            <span>Scoped HOD & Faculty Command Portals</span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: GET STARTED CTA CARD -->
                <div class="lg:col-span-5">
                    <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/60 relative overflow-hidden">
                        <!-- Card Top Accent Bar -->
                        <div class="absolute top-0 left-0 right-0 h-1.5 bg-linear-to-r from-blue-700 via-blue-600 to-indigo-600"></div>

                        <div class="mb-6 space-y-2">
                            <div class="flex items-center gap-2">
                                <div class="w-9 h-9 rounded-xl bg-blue-600 bg-linear-to-tr from-blue-700 to-blue-500 flex items-center justify-center text-white shadow-sm" style="background: linear-gradient(to top right, #1d4ed8, #3b82f6);">
                                    <i class="fas fa-graduation-cap text-lg"></i>
                                </div>
                                <span class="font-display font-black text-slate-900 text-lg tracking-tight">EduInsight Portal</span>
                            </div>
                            <p class="text-xs text-slate-500 font-semibold leading-relaxed">
                                Access role-based workspaces for System Administration, Department HOD Intelligence, Faculty Grading, and Student Growth tracking.
                            </p>
                        </div>

                        <!-- CTA Actions -->
                        <div class="space-y-3">
                            <a href="{{ route('login') }}" class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs hover:shadow-md transition duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <i class="fas fa-sign-in-alt"></i> Sign In to Dashboard
                            </a>
                            <a href="{{ route('register') }}" class="w-full py-3 px-4 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold text-xs shadow-2xs transition duration-200 flex items-center justify-center gap-2">
                                <i class="fas fa-user-plus text-blue-600"></i> Register New Account
                            </a>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                            <span>Ready to test the platform?</span>
                            <a href="#demo-accounts" class="font-bold text-blue-600 hover:text-blue-700 transition">View Demo Logins &darr;</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==========================================================================
         SECTION 2: LIVE SYSTEM METRICS & INTERACTIVE PRODUCT PREVIEW MOCKUP
         ========================================================================== -->
    <section class="py-12 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <div class="text-3xl font-display font-extrabold text-blue-600">1,600+</div>
                    <div class="text-xs font-bold text-slate-700 mt-1">Attendance Sessions</div>
                    <div class="text-[10px] text-slate-400 font-medium">Recorded & Analyzed</div>
                </div>
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <div class="text-3xl font-display font-extrabold text-slate-900">200</div>
                    <div class="text-xs font-bold text-slate-700 mt-1">Enrolled Students</div>
                    <div class="text-[10px] text-slate-400 font-medium">B.Tech, MCA, MBA</div>
                </div>
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <div class="text-3xl font-display font-extrabold text-blue-600">1,600+</div>
                    <div class="text-xs font-bold text-slate-700 mt-1">Assessment Marks</div>
                    <div class="text-[10px] text-slate-400 font-medium">Internal & External</div>
                </div>
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <div class="text-3xl font-display font-extrabold text-emerald-600">99.4%</div>
                    <div class="text-xs font-bold text-slate-700 mt-1">Risk Model Precision</div>
                    <div class="text-[10px] text-slate-400 font-medium">Scikit-Learn Classifier</div>
                </div>
            </div>

            <!-- Dashboard Visual Interface Card Mockup -->
            <div class="bg-slate-50 text-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 mb-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold uppercase tracking-wider mb-2">
                            <i class="fas fa-desktop text-blue-600"></i> Live Platform Demonstration
                        </div>
                        <h3 class="text-2xl font-display font-extrabold text-slate-900">How EduInsight Displays Risk Intelligence</h3>
                        <p class="text-xs text-slate-500 font-medium mt-1">Real-time student risk cards, attendance progression tracking, and AI action recommendations.</p>
                    </div>
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition">
                        Experience Full Dashboard &rarr;
                    </a>
                </div>

                <!-- Mock Dashboard Interface Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Student Card 1 -->
                    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs">
                        <div class="flex items-center justify-between mb-3">
                            <div class="font-bold text-xs text-slate-900">Saiganesh (STU-001)</div>
                            <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold">Low Risk</span>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between text-slate-600 text-[11px]">
                                <span>Attendance Rate</span>
                                <span class="font-bold text-emerald-600">92.5%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 92.5%"></div>
                            </div>
                            <div class="flex justify-between text-slate-600 text-[11px] pt-1">
                                <span>Avg. Marks Score</span>
                                <span class="font-bold text-slate-900">88.4 / 100</span>
                            </div>
                        </div>
                    </div>

                    <!-- Student Card 2 -->
                    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs">
                        <div class="flex items-center justify-between mb-3">
                            <div class="font-bold text-xs text-slate-900">Rahul Verma (STU-014)</div>
                            <span class="px-2 py-0.5 rounded-md bg-red-50 text-red-700 border border-red-200 text-[10px] font-bold">High Risk</span>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between text-slate-600 text-[11px]">
                                <span>Attendance Rate</span>
                                <span class="font-bold text-red-600">62.0%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-red-500 h-1.5 rounded-full" style="width: 62%"></div>
                            </div>
                            <div class="flex justify-between text-slate-600 text-[11px] pt-1">
                                <span>Avg. Marks Score</span>
                                <span class="font-bold text-slate-900">45.0 / 100</span>
                            </div>
                        </div>
                    </div>

                    <!-- AI NLP Assistant Card -->
                    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs">
                        <div class="flex items-center gap-2 mb-2 text-xs font-bold text-blue-700">
                            <i class="fas fa-robot text-blue-600"></i> AI Assistant Query Response
                        </div>
                        <p class="text-[11px] text-slate-700 leading-relaxed font-mono bg-slate-50 p-2.5 rounded-xl border border-slate-200">
                            &gt; "Show CSE students with &lt;75% attendance"<br/>
                            <span class="text-emerald-700 font-sans block mt-1 font-semibold">Found 5 students requiring attendance warnings. Email notifications prepared.</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         SECTION 3: HOW THE SITE WORKS (4-STEP PIPELINE)
         ========================================================================== -->
    <section id="how-it-works" class="py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <span class="px-3 py-1 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold uppercase tracking-wider">
                    Architecture & Pipeline
                </span>
                <h2 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900">How EduInsight Works</h2>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium">
                    EduInsight bridges classroom data with artificial intelligence. Here is how our 4-step pipeline identifies academic risk and drives early intervention.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Step 1 -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 hover:border-blue-400 transition duration-300 space-y-3 relative group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-sm font-extrabold group-hover:scale-110 transition">
                        01
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Data Ingestion</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">
                        Faculty logs daily student attendance (present, absent, late) and records continuous internal assessment & semester examination scores.
                    </p>
                    <div class="pt-1 text-[11px] text-blue-600 font-bold flex items-center gap-1">
                        <span>Attendance + Marks Records</span> &rarr;
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 hover:border-blue-400 transition duration-300 space-y-3 relative group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-sm font-extrabold group-hover:scale-110 transition">
                        02
                    </div>
                    <h3 class="text-base font-bold text-slate-900">ML Risk Prediction</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">
                        The Python Flask API evaluates student metrics using a trained Random Forest model, calculating attendance % and score distributions to generate a numerical risk score.
                    </p>
                    <div class="pt-1 text-[11px] text-blue-600 font-bold flex items-center gap-1">
                        <span>Scikit-Learn Classifier</span> &rarr;
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 hover:border-blue-400 transition duration-300 space-y-3 relative group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-sm font-extrabold group-hover:scale-110 transition">
                        03
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Risk Categorization</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">
                        Students are categorized into Low Risk, Medium Risk, or High Risk status. Automated alerts notify faculty and HODs when risk thresholds are breached.
                    </p>
                    <div class="pt-1 text-[11px] text-blue-600 font-bold flex items-center gap-1">
                        <span>Low / Medium / High Risk</span> &rarr;
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 hover:border-blue-400 transition duration-300 space-y-3 relative group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-sm font-extrabold group-hover:scale-110 transition">
                        04
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Action & Email Outreach</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">
                        Administrators and HODs execute Natural Language Queries (NLP) for executive reporting while sending personalized progress emails to parents & students.
                    </p>
                    <div class="pt-1 text-[11px] text-emerald-600 font-bold flex items-center gap-1">
                        <span>Automated Interventions</span> &check;
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         SECTION 4: WHAT THE SITE DOES (CORE CAPABILITIES GRID)
         ========================================================================== -->
    <section id="features" class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <span class="px-3 py-1 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold uppercase tracking-wider">
                    Core Capabilities
                </span>
                <h2 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900">What EduInsight Does</h2>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium">
                    Built to solve attendance dropouts, exam failures, and communication gaps across academic departments.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-blue-400 transition duration-300 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Early Risk Prediction Engine</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">
                        Uses continuous attendance tracking and mark evaluations to compute risk scores before end-of-semester exams happen.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-blue-400 transition duration-300 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">NLP Natural Language Querying</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">
                        Allows HODs and Faculty to ask questions in plain English ("Show CSE students with attendance below 75%") and get instant chart visualizers.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-blue-400 transition duration-300 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Integrated Email Notification Hub</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">
                        Send automated or manual notifications to students and parents regarding low attendance or exam marks with real-time SMTP delivery tracking.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-blue-400 transition duration-300 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                        <i class="fas fa-building-user"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Department HOD Analytics</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">
                        Dedicated dashboards for Department HODs (CSE, IT, MCA, MBA) to monitor faculty workloads, course pass percentages, and department alerts.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-blue-400 transition duration-300 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                        <i class="fas fa-clipboard-user"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Faculty Attendance & Evaluation</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">
                        Empowers faculty members to record batch attendance, submit internal assessment marks, and manage course materials effortlessly.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-blue-400 transition duration-300 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Student Growth Portal</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">
                        Provides students with full visibility into their current attendance %, GPA predictions, risk recommendations, and achievement milestones.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         SECTION 5: ROLE-BASED PORTAL OVERVIEW
         ========================================================================== -->
    <section id="portals" class="py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <span class="px-3 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold uppercase tracking-wider">
                    Role Access
                </span>
                <h2 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900">Tailored Portals for Every Role</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Admin Portal Card -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 flex flex-col justify-between space-y-5 shadow-2xs">
                    <div class="space-y-2.5">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-blue-100 text-blue-800 text-xs font-bold">
                            <i class="fas fa-user-shield"></i> System Administrator
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Admin Command Center</h3>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Full institution-wide overview, student directories, course catalog management, faculty approval queue, and global email analytics.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-mono text-[11px]">admin@eduinsight.com</span>
                        <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700">Login as Admin &rarr;</a>
                    </div>
                </div>

                <!-- HOD Portal Card -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 flex flex-col justify-between space-y-5 shadow-2xs">
                    <div class="space-y-2.5">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-slate-200 text-slate-800 text-xs font-bold">
                            <i class="fas fa-building"></i> Department HOD
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Department HOD Intelligence</h3>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Scoped views for CSE, IT, MCA, and MBA departments. Monitor faculty student loads, average pass rates, and perform NLP queries.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-mono text-[11px]">csehod@eduinsight.com</span>
                        <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700">Login as HOD &rarr;</a>
                    </div>
                </div>

                <!-- Faculty Portal Card -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 flex flex-col justify-between space-y-5 shadow-2xs">
                    <div class="space-y-2.5">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-800 text-xs font-bold">
                            <i class="fas fa-chalkboard-teacher"></i> Faculty Member
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Faculty Academic Dashboard</h3>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Batch attendance recording, grade entry (internal & external marks), class attendance analytics, and student risk recommendations.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-mono text-[11px]">drbalamuralikrishna@gmail.com</span>
                        <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-700">Login as Faculty &rarr;</a>
                    </div>
                </div>

                <!-- Student Portal Card -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 flex flex-col justify-between space-y-5 shadow-2xs">
                    <div class="space-y-2.5">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-blue-100 text-blue-800 text-xs font-bold">
                            <i class="fas fa-user-graduate"></i> Enrolled Student
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Student Personal Portal</h3>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Personal attendance status, mark statements, academic risk status, course resources, and individual AI assistant queries.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-mono text-[11px]">sowmikamca@gmail.com</span>
                        <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700">Login as Student &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         SECTION 6: LIVE DEMO ACCOUNTS REFERENCE LIST
         ========================================================================== -->
    <section id="demo-accounts" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="p-7 sm:p-10 rounded-2xl bg-slate-50 text-slate-900 border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="max-w-3xl space-y-3 mb-7">
                    <span class="px-3 py-1 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold uppercase tracking-wider">
                        Demo Account Credentials
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900">Try EduInsight Instantly</h2>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium">
                        All demo accounts use password <code class="px-2 py-0.5 rounded bg-slate-200 text-slate-800 font-mono font-bold">password</code>. Select any account below and proceed to login page.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <a href="{{ route('login') }}" class="p-3.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-left transition group shadow-2xs block">
                        <div class="text-xs font-bold text-slate-900 group-hover:text-blue-700 flex items-center justify-between">
                            <span>Admin Portal</span>
                            <i class="fas fa-arrow-right text-[10px] text-blue-600 opacity-0 group-hover:opacity-100 transition"></i>
                        </div>
                        <div class="text-xs text-blue-600 font-mono font-semibold mt-1.5">admin@eduinsight.com</div>
                    </a>

                    <a href="{{ route('login') }}" class="p-3.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-left transition group shadow-2xs block">
                        <div class="text-xs font-bold text-slate-900 group-hover:text-blue-700 flex items-center justify-between">
                            <span>CSE HOD (Dr. Prasad)</span>
                            <i class="fas fa-arrow-right text-[10px] text-blue-600 opacity-0 group-hover:opacity-100 transition"></i>
                        </div>
                        <div class="text-xs text-blue-600 font-mono font-semibold mt-1.5">csehod@eduinsight.com</div>
                    </a>

                    <a href="{{ route('login') }}" class="p-3.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-left transition group shadow-2xs block">
                        <div class="text-xs font-bold text-slate-900 group-hover:text-blue-700 flex items-center justify-between">
                            <span>IT HOD (Dr. Anuradha)</span>
                            <i class="fas fa-arrow-right text-[10px] text-blue-600 opacity-0 group-hover:opacity-100 transition"></i>
                        </div>
                        <div class="text-xs text-blue-600 font-mono font-semibold mt-1.5">ithod@eduinsight.com</div>
                    </a>

                    <a href="{{ route('login') }}" class="p-3.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-left transition group shadow-2xs block">
                        <div class="text-xs font-bold text-slate-900 group-hover:text-blue-700 flex items-center justify-between">
                            <span>MCA HOD (Dr. Anuradha)</span>
                            <i class="fas fa-arrow-right text-[10px] text-blue-600 opacity-0 group-hover:opacity-100 transition"></i>
                        </div>
                        <div class="text-xs text-blue-600 font-mono font-semibold mt-1.5">mcahod@eduinsight.com</div>
                    </a>

                    <a href="{{ route('login') }}" class="p-3.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-left transition group shadow-2xs block">
                        <div class="text-xs font-bold text-slate-900 group-hover:text-blue-700 flex items-center justify-between">
                            <span>MBA HOD (Dr. Anuradha)</span>
                            <i class="fas fa-arrow-right text-[10px] text-blue-600 opacity-0 group-hover:opacity-100 transition"></i>
                        </div>
                        <div class="text-xs text-blue-600 font-mono font-semibold mt-1.5">mbahod@eduinsight.com</div>
                    </a>

                    <a href="{{ route('login') }}" class="p-3.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-left transition group shadow-2xs block">
                        <div class="text-xs font-bold text-slate-900 group-hover:text-blue-700 flex items-center justify-between">
                            <span>Faculty (Dr. Bala Murali Krishna)</span>
                            <i class="fas fa-arrow-right text-[10px] text-blue-600 opacity-0 group-hover:opacity-100 transition"></i>
                        </div>
                        <div class="text-xs text-emerald-600 font-mono font-semibold mt-1.5">drbalamuralikrishna@gmail.com</div>
                    </a>

                    <a href="{{ route('login') }}" class="p-3.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-left transition group shadow-2xs block">
                        <div class="text-xs font-bold text-slate-900 group-hover:text-blue-700 flex items-center justify-between">
                            <span>Student (Sowmika CSE)</span>
                            <i class="fas fa-arrow-right text-[10px] text-blue-600 opacity-0 group-hover:opacity-100 transition"></i>
                        </div>
                        <div class="text-xs text-blue-600 font-mono font-semibold mt-1.5">sowmikacse@gmail.com</div>
                    </a>

                    <a href="{{ route('login') }}" class="p-3.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-left transition group shadow-2xs block">
                        <div class="text-xs font-bold text-slate-900 group-hover:text-blue-700 flex items-center justify-between">
                            <span>Student (Sowmika IT)</span>
                            <i class="fas fa-arrow-right text-[10px] text-blue-600 opacity-0 group-hover:opacity-100 transition"></i>
                        </div>
                        <div class="text-xs text-blue-600 font-mono font-semibold mt-1.5">sowmikait@gmail.com</div>
                    </a>

                    <a href="{{ route('login') }}" class="p-3.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-left transition group shadow-2xs block">
                        <div class="text-xs font-bold text-slate-900 group-hover:text-blue-700 flex items-center justify-between">
                            <span>Student (Sowmika MCA)</span>
                            <i class="fas fa-arrow-right text-[10px] text-blue-600 opacity-0 group-hover:opacity-100 transition"></i>
                        </div>
                        <div class="text-xs text-blue-600 font-mono font-semibold mt-1.5">sowmikamca@gmail.com</div>
                    </a>

                    <a href="{{ route('login') }}" class="p-3.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-left transition group shadow-2xs block">
                        <div class="text-xs font-bold text-slate-900 group-hover:text-blue-700 flex items-center justify-between">
                            <span>Student (Sowmika MBA)</span>
                            <i class="fas fa-arrow-right text-[10px] text-blue-600 opacity-0 group-hover:opacity-100 transition"></i>
                        </div>
                        <div class="text-xs text-blue-600 font-mono font-semibold mt-1.5">sowmikamba@gmail.com</div>
                    </a>

                    <a href="{{ route('register') }}" class="p-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-left transition flex flex-col justify-between group shadow-xs">
                        <div class="text-xs font-bold flex items-center justify-between">
                            <span>Create Account</span>
                            <i class="fas fa-user-plus text-[10px]"></i>
                        </div>
                        <div class="text-[11px] text-blue-100 font-medium mt-1.5">Register Student / Faculty &rarr;</div>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
