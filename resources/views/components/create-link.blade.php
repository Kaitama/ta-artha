@props(['disabled' => false])

@php
    $classes = 'font-medium text-green-600 dark:text-green-500 hover:underline flex items-center gap-2 justify-end';

    $classes = ($disabled ?? false)
        ? 'font-medium text-green-300 dark:text-green-500 hover:underline flex items-center gap-2 justify-end'
        : 'font-medium text-green-600 dark:text-green-500 hover:underline flex items-center gap-2 justify-end';
@endphp

<a {{ $attributes->merge(['class' => $classes, 'style' => $disabled ? 'pointer-events: none' : '']) }}>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    {{ $slot }}
</a>
