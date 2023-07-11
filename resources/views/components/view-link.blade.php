@props(['disabled' => false])

@php
    $classes = 'font-medium text-indigo-600 dark:text-indigo-500 hover:underline flex items-center gap-2 justify-end';

    $classes = ($disabled ?? false)
        ? 'font-medium text-indigo-300 dark:text-indigo-500 hover:underline flex items-center gap-2 justify-end'
        : 'font-medium text-indigo-600 dark:text-indigo-500 hover:underline flex items-center gap-2 justify-end';
@endphp

<a {{ $attributes->merge(['class' => $classes, 'style' => $disabled ? 'pointer-events: none' : '']) }}>
    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 14">
        <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
            <path d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
            <path d="M10 13c4.97 0 9-2.686 9-6s-4.03-6-9-6-9 2.686-9 6 4.03 6 9 6Z"/>
        </g>
    </svg>
    {{ $slot }}
</a>
