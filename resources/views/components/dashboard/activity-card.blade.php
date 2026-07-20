@props([
    'title' => 'Recent Activity',
    'subtitle' => 'Latest system events and updates',
    'viewAllUrl' => null
])

<div {{ $attributes->merge(['class' => 'bg-white border border-slate-200 rounded-xl p-5 shadow-xs flex flex-col justify-between']) }}>
    <!-- Header -->
    <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-3">
        <div>
            <h4 class="text-sm font-bold text-slate-900 tracking-tight">{{ $title }}</h4>
            @if($subtitle)
                <p class="text-[11px] text-slate-500 mt-0.5">{{ $subtitle }}</p>
            @endif
        </div>
        @if($viewAllUrl)
            <a href="{{ $viewAllUrl }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition">
                View All &rarr;
            </a>
        @endif
    </div>

    <!-- Activity Feed List Slot -->
    <div class="divide-y divide-slate-100">
        {{ $slot }}
    </div>
</div>
