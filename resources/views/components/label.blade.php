@props(['value', 'required' => false])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 mb-1']) }}>
    {{ $value ?? $slot }}
    @if($required)
        <sup class="text-rose-800">*</sup>
    @endif
</label>
