@props(['color' => 'secondary'])

@php
    match ($color) {
        'primary' => $classes = 'bg-blue-100 text-blue-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded mr-2 border border-blue-500',
        'success' => $classes = 'bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded mr-2 border border-green-500',
        'warning' => $classes = 'bg-amber-100 text-amber-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded mr-2 border border-amber-500',
        'danger' => $classes = 'bg-rose-100 text-rose-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded mr-2 border border-rose-500',
        default => $classes = 'bg-gray-100 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded mr-2 border border-gray-500'
    }
@endphp

<span {{ $attributes->merge(['class' => 'flex items-center gap-2 rounded-full ' . $classes]) }}>
  {{ $icon }}
  {{ $slot }}
</span>
