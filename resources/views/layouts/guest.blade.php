<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50 scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EduInsight') - AI Academic Intelligence & Early Risk Prediction Platform</title>
    
    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @yield('styles')
</head>
<body class="min-h-full bg-slate-50 text-slate-900 font-sans antialiased selection:bg-blue-600 selection:text-white flex flex-col">

    <!-- Top Navigation Header matching Dashboard Navbar -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/90 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand Logo matching Dashboard -->
            <a href="/" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-blue-600 bg-linear-to-tr from-blue-700 to-blue-500 flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition" style="background: linear-gradient(to top right, #1d4ed8, #3b82f6);">
                    <i class="fas fa-graduation-cap text-lg"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-display font-black text-slate-900 text-lg tracking-tight leading-none">EduInsight</span>
                    <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase leading-tight mt-0.5">Enterprise Platform</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-8 text-xs font-bold text-slate-600">
                <a href="#about" class="hover:text-blue-600 transition">About Platform</a>
                <a href="#how-it-works" class="hover:text-blue-600 transition">How It Works</a>
                <a href="#features" class="hover:text-blue-600 transition">Features</a>
                <a href="#portals" class="hover:text-blue-600 transition">Role Portals</a>
                <a href="#demo-accounts" class="hover:text-blue-600 transition text-blue-600 flex items-center gap-1.5 font-bold">
                    <i class="fas fa-key text-[10px]"></i> Demo Logins
                </a>
            </nav>

            <!-- CTA Actions -->
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-sm hover:shadow transition flex items-center gap-2">
                    <i class="fas fa-sign-in-alt"></i> Portal Login
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="grow">
        @yield('content')
    </main>

    <!-- Footer matching Dashboard Footer -->
    <footer class="bg-white border-t border-slate-200 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-blue-600 bg-linear-to-tr from-blue-700 to-blue-500 flex items-center justify-center text-white shadow-sm" style="background: linear-gradient(to top right, #1d4ed8, #3b82f6);">
                            <i class="fas fa-graduation-cap text-lg"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-display font-black text-slate-900 text-lg tracking-tight leading-none">EduInsight</span>
                            <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase leading-tight mt-0.5">Enterprise Platform</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed max-w-md font-medium">
                        EduInsight is an enterprise Decision Support System leveraging Machine Learning algorithms and Natural Language Processing to detect student academic risk early, assist department heads, and empower faculty with actionable intelligence.
                    </p>
                </div>
                <div>
                    <h5 class="text-xs font-extrabold uppercase tracking-wider text-slate-900 mb-4">Quick Navigation</h5>
                    <ul class="space-y-2 text-xs text-slate-600 font-semibold">
                        <li><a href="#about" class="hover:text-blue-600 transition">Platform Overview</a></li>
                        <li><a href="#how-it-works" class="hover:text-blue-600 transition">4-Step Workflow</a></li>
                        <li><a href="#features" class="hover:text-blue-600 transition">Key Features</a></li>
                        <li><a href="#portals" class="hover:text-blue-600 transition">Role-Based Access</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-xs font-extrabold uppercase tracking-wider text-slate-900 mb-4">System Stack</h5>
                    <ul class="space-y-2 text-xs text-slate-600 font-semibold">
                        <li class="flex items-center gap-2"><i class="fab fa-laravel text-red-500"></i> Laravel 12 Web Framework</li>
                        <li class="flex items-center gap-2"><i class="fab fa-python text-blue-600"></i> Python Flask ML Service</li>
                        <li class="flex items-center gap-2"><i class="fas fa-database text-blue-600"></i> MySQL Database Engine</li>
                        <li class="flex items-center gap-2"><i class="fas fa-brain text-blue-600"></i> Scikit-Learn Classifier</li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400 font-medium">
                <p>&copy; {{ date('Y') }} EduInsight Academic Intelligence Platform. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <span class="hover:text-slate-600 cursor-pointer">Privacy Policy</span>
                    <span class="hover:text-slate-600 cursor-pointer">Security Terms</span>
                    <span class="hover:text-slate-600 cursor-pointer">System Support</span>
                </div>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
