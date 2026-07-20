@props([
    'title' => '',
    'value' => '0',
    'icon' => 'fas fa-chart-bar',
    'color' => 'blue',
    'trend' => null,
    'trendUp' => true
])

@php
$colorClasses = [
    'blue'    => 'bg-blue-50 text-blue-600 border-blue-100',
    'emerald' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
    'amber'   => 'bg-amber-50 text-amber-600 border-amber-100',
    'red'     => 'bg-red-50 text-red-600 border-red-100',
    'purple'  => 'bg-purple-50 text-purple-600 border-purple-100',
][$color] ?? 'bg-blue-50 text-blue-600 border-blue-100';
@endphp

<div {{ $attributes->merge(['class' => 'bg-white border border-slate-200 rounded-xl p-5 shadow-xs hover:shadow-md transition duration-200 flex items-center justify-between']) }}>
    <div>
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ $title }}</p>
        <h3 class="text-2xl font-extrabold text-slate-900 mt-1 tracking-tight">{{ $value }}</h3>
        @if($trend)
            <div class="flex items-center gap-1 mt-1 text-xs font-medium {{ $trendUp ? 'text-emerald-600' : 'text-red-600' }}">
                <i class="fas {{ $trendUp ? 'fa-arrow-up' : 'fa-arrow-down' }} text-[10px]"></i>
                <span>{{ $trend }}</span>
            </div>
        @endif
    </div>
    
    <div class="w-12 h-12 rounded-xl border flex items-center justify-center text-xl shadow-xs {{ $colorClasses }}">
        <i class="{{ $icon }}"></i>
    </div>
</div>
