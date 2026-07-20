@props([
    'variant' => 'primary', // primary, secondary, outline, danger
    'size' => 'md', // sm, md, lg
    'icon' => null,
    'type' => 'button'
])

@php
$variantClasses = [
    'primary'   => 'bg-blue-600 hover:bg-blue-700 text-white shadow-xs focus:ring-blue-500',
    'secondary' => 'bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 focus:ring-slate-400',
    'outline'   => 'bg-transparent hover:bg-slate-50 text-slate-700 border border-slate-300 focus:ring-blue-500',
    'danger'    => 'bg-red-600 hover:bg-red-700 text-white shadow-xs focus:ring-red-500',
][$variant] ?? 'bg-blue-600 hover:bg-blue-700 text-white';

$sizeClasses = [
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-4 py-2 text-xs',
    'lg' => 'px-5 py-2.5 text-sm',
][$size] ?? 'px-4 py-2 text-xs';
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "inline-flex items-center justify-center gap-2 font-medium rounded-lg transition duration-150 focus:outline-none focus:ring-2 focus:ring-offset-1 cursor-pointer {$variantClasses} {$sizeClasses}"]) }}>
    @if($icon)
        <i class="{{ $icon }}"></i>
    @endif
    <span>{{ $slot }}</span>
</button>
