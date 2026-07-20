@props([
    'id' => 'chartCanvas',
    'title' => 'Chart Analytics',
    'description' => null,
    'height' => 'h-64',
    'actions' => true
])

<div {{ $attributes->merge(['class' => 'bg-white border border-slate-200 rounded-xl p-5 sm:p-6 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col justify-between']) }}>
    
    <!-- Card Header -->
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
        <div>
            <h4 class="text-sm sm:text-base font-bold text-slate-900 tracking-tight">{{ $title }}</h4>
            @if($description)
                <p class="text-xs text-slate-500 mt-0.5 font-normal">{{ $description }}</p>
            @endif
        </div>

        @if($actions)
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition focus:outline-none">
                    <i class="fas fa-ellipsis-v text-xs"></i>
                </button>

                <div x-show="open" @click.outside="open = false" x-cloak class="absolute right-0 mt-1 w-40 bg-white border border-slate-200 rounded-lg shadow-md py-1 z-20 text-xs">
                    <button type="button" onclick="alert('Export functionality ready')" class="w-full text-left px-3 py-1.5 hover:bg-slate-50 text-slate-700 flex items-center gap-2">
                        <i class="fas fa-download text-slate-400 text-[10px]"></i> Export Data
                    </button>
                    <button type="button" onclick="location.reload()" class="w-full text-left px-3 py-1.5 hover:bg-slate-50 text-slate-700 flex items-center gap-2">
                        <i class="fas fa-sync-alt text-slate-400 text-[10px]"></i> Refresh Chart
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Chart Container / Canvas Placeholder -->
    <div class="relative w-full {{ $height }} flex items-center justify-center">
        <canvas id="{{ $id }}"></canvas>
        {{ $slot }}
    </div>
</div>
