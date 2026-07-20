@props([
    'severity' => 'medium', // 'high', 'medium', 'low'
    'student' => null,
    'course' => null,
    'message' => 'Academic Alert Triggered',
    'date' => null,
    'actionText' => 'Take Action',
    'actionUrl' => null
])

@php
$severityConfig = [
    'high'   => ['bg' => 'bg-red-50/80',    'border' => 'border-red-200',    'badgeBg' => 'bg-red-100 text-red-800 border-red-300',       'icon' => 'fas fa-exclamation-circle text-red-600',    'label' => 'HIGH SEVERITY'],
    'medium' => ['bg' => 'bg-amber-50/80',  'border' => 'border-amber-200',  'badgeBg' => 'bg-amber-100 text-amber-800 border-amber-300', 'icon' => 'fas fa-exclamation-triangle text-amber-600', 'label' => 'MEDIUM SEVERITY'],
    'low'    => ['bg' => 'bg-emerald-50/80','border' => 'border-emerald-200','badgeBg' => 'bg-emerald-100 text-emerald-800 border-emerald-300','icon' => 'fas fa-info-circle text-emerald-600',   'label' => 'LOW RISK'],
][$severity] ?? ['bg' => 'bg-slate-50', 'border' => 'border-slate-200', 'badgeBg' => 'bg-slate-100 text-slate-700 border-slate-300', 'icon' => 'fas fa-bell text-slate-500', 'label' => 'NOTIFICATION'];
@endphp

<div {{ $attributes->merge(['class' => 'border rounded-xl p-4 transition duration-200 shadow-2xs ' . $severityConfig['bg'] . ' ' . $severityConfig['border']]) }}>
    <div class="flex items-start justify-between gap-3">
        <div class="flex items-start gap-3">
            <div class="mt-0.5 text-base">
                <i class="{{ $severityConfig['icon'] }}"></i>
            </div>
            <div>
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-md border uppercase tracking-wider {{ $severityConfig['badgeBg'] }}">
                        {{ $severityConfig['label'] }}
                    </span>
                    @if($course)
                        <span class="text-xs font-bold text-slate-800 bg-white px-2 py-0.5 rounded border border-slate-200">
                            {{ $course }}
                        </span>
                    @endif
                </div>

                <p class="text-xs font-semibold text-slate-900 mt-1.5 leading-snug">
                    {{ $message }}
                </p>

                @if($student)
                    <p class="text-xs text-slate-600 mt-1 font-medium">
                        Student: <span class="font-semibold text-slate-800">{{ $student }}</span>
                    </p>
                @endif
            </div>
        </div>

        @if($date)
            <span class="text-[10px] font-medium text-slate-400 shrink-0">
                {{ $date }}
            </span>
        @endif
    </div>

    @if($actionUrl)
        <div class="mt-3 pt-2.5 border-t border-slate-200/60 flex justify-end">
            <a href="{{ $actionUrl }}" class="px-3 py-1 text-xs font-semibold rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition shadow-2xs">
                {{ $actionText }} &rarr;
            </a>
        </div>
    @endif
</div>
