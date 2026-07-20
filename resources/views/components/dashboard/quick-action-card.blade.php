@props([
    'title' => 'Action Title',
    'description' => 'Quick action description text.',
    'icon' => 'fas fa-bolt',
    'url' => '#',
    'badge' => null,
    'color' => 'blue' // blue, purple, emerald, amber
])

@php
$iconStyles = [
    'blue'    => 'bg-blue-50 text-blue-600 border-blue-100 group-hover:bg-blue-600 group-hover:text-white',
    'purple'  => 'bg-purple-50 text-purple-600 border-purple-100 group-hover:bg-purple-600 group-hover:text-white',
    'emerald' => 'bg-emerald-50 text-emerald-600 border-emerald-100 group-hover:bg-emerald-600 group-hover:text-white',
    'amber'   => 'bg-amber-50 text-amber-600 border-amber-100 group-hover:bg-amber-600 group-hover:text-white',
][$color] ?? 'bg-blue-50 text-blue-600 border-blue-100 group-hover:bg-blue-600 group-hover:text-white';
@endphp

<a href="{{ $url }}" {{ $attributes->merge(['class' => 'group bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-xs hover:shadow-md hover:border-blue-300 transition duration-200 flex items-start gap-4']) }}>
    <div class="w-11 h-11 rounded-xl border flex items-center justify-center text-base shrink-0 transition duration-200 {{ $iconStyles }}">
        <i class="{{ $icon }}"></i>
    </div>

    <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between gap-2">
            <h4 class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition tracking-tight truncate">{{ $title }}</h4>
            @if($badge)
                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-slate-100 text-slate-600 shrink-0">
                    {{ $badge }}
                </span>
            @endif
        </div>
        <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $description }}</p>
    </div>

    <div class="text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1 transition self-center">
        <i class="fas fa-chevron-right text-xs"></i>
    </div>
</a>
