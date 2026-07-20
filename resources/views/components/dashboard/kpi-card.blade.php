@props([
    'title' => '',
    'value' => '0',
    'icon' => 'fas fa-chart-line',
    'change' => null,
    'changeType' => 'up', // 'up', 'down', 'neutral'
    'color' => 'blue',    // 'blue', 'emerald', 'amber', 'red', 'purple', 'slate'
    'subtitle' => null,
    'badge' => null
])

@php
$colorStyles = [
    'blue'    => ['bg' => 'bg-blue-50',    'text' => 'text-blue-600',    'border' => 'border-blue-100',    'iconBg' => 'bg-blue-600 text-white'],
    'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-100', 'iconBg' => 'bg-emerald-600 text-white'],
    'amber'   => ['bg' => 'bg-amber-50',   'text' => 'text-amber-600',   'border' => 'border-amber-100',   'iconBg' => 'bg-amber-600 text-white'],
    'red'     => ['bg' => 'bg-red-50',     'text' => 'text-red-600',     'border' => 'border-red-100',     'iconBg' => 'bg-red-600 text-white'],
    'purple'  => ['bg' => 'bg-purple-50',  'text' => 'text-purple-600',  'border' => 'border-purple-100',  'iconBg' => 'bg-purple-600 text-white'],
    'slate'   => ['bg' => 'bg-slate-100',  'text' => 'text-slate-700',   'border' => 'border-slate-200',   'iconBg' => 'bg-slate-700 text-white'],
][$color] ?? ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'border-blue-100', 'iconBg' => 'bg-blue-600 text-white'];

$trendClasses = [
    'up'      => 'text-emerald-600 bg-emerald-50 border-emerald-200',
    'down'    => 'text-red-600 bg-red-50 border-red-200',
    'neutral' => 'text-slate-600 bg-slate-100 border-slate-200',
][$changeType] ?? 'text-emerald-600 bg-emerald-50 border-emerald-200';

$trendIcon = [
    'up'      => 'fas fa-arrow-up',
    'down'    => 'fas fa-arrow-down',
    'neutral' => 'fas fa-minus',
][$changeType] ?? 'fas fa-arrow-up';
@endphp

<div {{ $attributes->merge(['class' => 'bg-white border border-slate-200 rounded-xl p-5 shadow-xs hover:shadow-md transition-all duration-200 relative overflow-hidden flex flex-col justify-between']) }}>
    
    <!-- Top Row: Title, Badge & Icon -->
    <div class="flex items-start justify-between gap-3">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">{{ $title }}</span>
            @if($badge)
                <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-semibold rounded-md border {{ $colorStyles['bg'] }} {{ $colorStyles['text'] }} {{ $colorStyles['border'] }}">
                    {{ $badge }}
                </span>
            @endif
        </div>
        
        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-semibold shadow-xs shrink-0 {{ $colorStyles['iconBg'] }}">
            <i class="{{ $icon }}"></i>
        </div>
    </div>

    <!-- Middle Row: Value & Subtitle -->
    <div class="mt-3">
        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-none">{{ $value }}</h3>
        @if($subtitle)
            <p class="text-xs text-slate-500 mt-1 font-medium">{{ $subtitle }}</p>
        @endif
    </div>

    <!-- Bottom Row: Optional Trend Indicator -->
    @if($change)
        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md border font-semibold text-[11px] {{ $trendClasses }}">
                <i class="{{ $trendIcon }} text-[9px]"></i>
                {{ $change }}
            </span>
            <span class="text-[11px] text-slate-400 font-medium">vs last period</span>
        </div>
    @endif
</div>
