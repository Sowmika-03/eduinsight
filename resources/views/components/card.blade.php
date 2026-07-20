@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'class' => ''
])

<div {{ $attributes->merge(['class' => 'bg-white border border-slate-200 rounded-xl p-5 sm:p-6 shadow-xs hover:shadow-md transition duration-200 ' . $class]) }}>
    @if($title || $icon)
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
            <div>
                @if($title)
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">{{ $title }}</h3>
                @endif
                @if($subtitle)
                    <p class="text-xs text-slate-500 mt-0.5">{{ $subtitle }}</p>
                @endif
            </div>
            @if($icon)
                <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-base">
                    <i class="{{ $icon }}"></i>
                </div>
            @endif
        </div>
    @endif
    
    <div>
        {{ $slot }}
    </div>
</div>
