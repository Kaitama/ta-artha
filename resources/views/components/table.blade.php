<table {{ $attributes->merge(['class' => 'w-full text-sm text-left text-gray-500 dark:text-gray-400']) }}>
    <thead class="text-xs text-gray-100 uppercase bg-gray-800 dark:bg-gray-100 dark:text-gray-900">
        <tr>
            {{ $th }}
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>
