@props(['active' => false])

@php
    $classes = ($active ?? false)
        ? 'flex items-center p-2 text-blue-700 bg-blue-100 rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-gray-700'
        : 'flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-gray-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $icon }}
    <span class="ml-3">{{ $slot }}</span>
</a>
