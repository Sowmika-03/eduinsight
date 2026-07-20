<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Authentication') - EduInsight Platform</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS Asset -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles')
</head>
<body class="h-full bg-slate-100 text-slate-900 font-sans antialiased flex flex-col justify-center py-12 sm:px-6 lg:px-8">

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Logo Branding Header -->
        <div class="flex flex-col items-center text-center">
            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-md mb-3">
                <i class="fas fa-graduation-cap text-2xl"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">EduInsight Platform</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Predictive Academic Analytics & Performance System</p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 shadow-xl border border-slate-200 sm:rounded-2xl sm:px-10">
            
            @if(isset($errors) && $errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 flex flex-col gap-1.5 text-xs shadow-xs">
                    <div class="flex items-center gap-2 font-semibold text-sm">
                        <i class="fas fa-exclamation-circle text-red-600"></i>
                        <span>Authentication Error</span>
                    </div>
                    <ul class="list-disc list-inside text-red-700 space-y-0.5 ml-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2 shadow-xs">
                    <i class="fas fa-check-circle text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
        
        <p class="mt-6 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} EduInsight Platform. Secure Light Theme Portal.
        </p>
    </div>

    @yield('scripts')
</body>
</html>
