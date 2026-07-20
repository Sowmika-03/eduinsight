@props([
    'title' => 'Recommended Intervention Plan',
    'description' => 'Suggested academic support actions based on risk analytics.',
    'riskLevel' => 'High Risk',
    'actionText' => 'Implement Recommendation',
    'actionUrl' => null
])

@php
$riskPill = [
    'High Risk'   => 'bg-red-100 text-red-800 border-red-300',
    'Medium Risk' => 'bg-amber-100 text-amber-800 border-amber-300',
    'Low Risk'    => 'bg-emerald-100 text-emerald-800 border-emerald-300',
][$riskLevel] ?? 'bg-blue-100 text-blue-800 border-blue-300';
@endphp

<div {{ $attributes->merge(['class' => 'bg-white border border-slate-200 rounded-xl p-5 shadow-xs hover:shadow-md transition duration-200 flex flex-col justify-between']) }}>
    <div>
        <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-3 mb-3">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-md bg-purple-50 text-purple-600 border border-purple-100 flex items-center justify-center text-xs">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500">{{ $title }}</h4>
            </div>
            <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full border {{ $riskPill }}">
                {{ $riskLevel }}
            </span>
        </div>

        <p class="text-xs font-medium text-slate-700 leading-relaxed">
            {{ $description }}
        </p>

        @if($slot->isNotEmpty())
            <div class="mt-2.5 text-xs text-slate-600 bg-slate-50 p-3 rounded-lg border border-slate-200/80">
                {{ $slot }}
            </div>
        @endif
    </div>

    @if($actionUrl)
        <div class="mt-4 pt-3 border-t border-slate-100 flex justify-end">
            <a href="{{ $actionUrl }}" class="px-3.5 py-1.5 text-xs font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition shadow-2xs inline-flex items-center gap-1.5">
                <span>{{ $actionText }}</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    @endif
</div>
