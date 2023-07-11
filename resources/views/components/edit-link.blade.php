@props(['disabled' => false])

@php
    $classes = 'font-medium text-blue-600 dark:text-blue-500 hover:underline flex items-center gap-2 justify-end';

    $classes = ($disabled ?? false)
        ? 'font-medium text-blue-300 dark:text-blue-500 hover:underline flex items-center gap-2 justify-end'
        : 'font-medium text-blue-600 dark:text-blue-500 hover:underline flex items-center gap-2 justify-end';
@endphp

<a {{ $attributes->merge(['class' => $classes, 'style' => $disabled ? 'pointer-events: none' : '']) }}>
    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 21 21">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279"/>
    </svg>
    {{ $slot }}
</a>
