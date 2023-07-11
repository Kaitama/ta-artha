@props(['color' => 'secondary'])

@php
    match ($color) {
        'primary' => $classes = 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5',
        'success' => $classes = 'focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5',
        'warning' => $classes = 'focus:outline-none text-white bg-amber-400 hover:bg-amber-500 focus:ring-4 focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5',
        'danger' => $classes = 'focus:outline-none text-white bg-rose-700 hover:bg-rose-800 focus:ring-4 focus:ring-rose-300 font-medium rounded-lg text-sm px-5 py-2.5',
        'dark' => $classes = 'text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5',
        default => $classes = 'text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-700 focus:z-10 focus:ring-4 focus:ring-gray-200 py-2.5 px-5 '
    }
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
