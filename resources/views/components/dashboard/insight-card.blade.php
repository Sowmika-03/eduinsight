@props([
    'title' => 'Academic Intelligence Summary',
    'message' => 'System intelligence detected performance anomalies requiring review.',
    'type' => 'info', // 'info', 'warning', 'danger', 'success'
    'actionText' => null,
    'actionUrl' => null,
    'badge' => 'AI Insight'
])

@php
$typeStyles = [
    'info'    => ['bg' => 'bg-blue-50/70',    'border' => 'border-blue-200',    'text' => 'text-blue-900',    'iconBg' => 'bg-blue-600 text-white',    'icon' => 'fas fa-brain'],
    'warning' => ['bg' => 'bg-amber-50/70',   'border' => 'border-amber-200',   'text' => 'text-amber-900',   'iconBg' => 'bg-amber-500 text-white',   'icon' => 'fas fa-exclamation-triangle'],
    'danger'  => ['bg' => 'bg-red-50/70',     'border' => 'border-red-200',     'text' => 'text-red-900',     'iconBg' => 'bg-red-600 text-white',     'icon' => 'fas fa-radiation'],
    'success' => ['bg' => 'bg-emerald-50/70', 'border' => 'border-emerald-200', 'text' => 'text-emerald-900', 'iconBg' => 'bg-emerald-600 text-white', 'icon' => 'fas fa-check-circle'],
][$type] ?? ['bg' => 'bg-blue-50/70', 'border' => 'border-blue-200', 'text' => 'text-blue-900', 'iconBg' => 'bg-blue-600 text-white', 'icon' => 'fas fa-brain'];
@endphp

<div {{ $attributes->merge(['class' => 'border rounded-xl p-4 sm:p-5 transition duration-200 shadow-xs ' . $typeStyles['bg'] . ' ' . $typeStyles['border']]) }}>
    <div class="flex items-start gap-3.5">
        <div class="w-9 h-9 rounded-lg flex items-center justify-center text-xs shrink-0 shadow-xs {{ $typeStyles['iconBg'] }}">
            <i class="{{ $typeStyles['icon'] }}"></i>
        </div>
        
        <div class="flex-1">
            <div class="flex items-center justify-between gap-2">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500">{{ $title }}</h4>
                @if($badge)
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-white border border-slate-200 text-slate-700 shadow-2xs">
                        {{ $badge }}
                    </span>
                @endif
            </div>
            
            <p class="text-sm font-semibold mt-1 {{ $typeStyles['text'] }} leading-snug">
                {{ $message }}
            </p>

            @if($slot->isNotEmpty())
                <div class="mt-2 text-xs text-slate-600">
                    {{ $slot }}
                </div>
            @endif

            @if($actionText && $actionUrl)
                <div class="mt-3">
                    <a href="{{ $actionUrl }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-700 hover:text-blue-900 transition">
                        <span>{{ $actionText }}</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
