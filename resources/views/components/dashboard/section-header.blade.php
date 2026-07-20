@props([
    'title' => 'Dashboard Section',
    'subtitle' => null,
    'badge' => null
])

<div {{ $attributes->merge(['class' => 'flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 pb-4 border-b border-slate-200/80']) }}>
    <div>
        <div class="flex items-center gap-2.5">
            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight leading-none">{{ $title }}</h3>
            @if($badge)
                <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-md bg-blue-50 text-blue-700 border border-blue-100 uppercase tracking-wider">
                    {{ $badge }}
                </span>
            @endif
        </div>
        @if($subtitle)
            <p class="text-xs text-slate-500 font-medium mt-1">{{ $subtitle }}</p>
        @endif
    </div>

    @if(isset($actions) || $slot->isNotEmpty())
        <div class="flex items-center gap-2 shrink-0">
            {{ $actions ?? $slot }}
        </div>
    @endif
</div>
