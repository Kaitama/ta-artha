<div {{ $attributes->merge(['class' => 'block p-4 bg-white border border-gray-200 md:rounded-md shadow']) }}>
    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $title }}</h5>
    {{ $slot }}
</div>
