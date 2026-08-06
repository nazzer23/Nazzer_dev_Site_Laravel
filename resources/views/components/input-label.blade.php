@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-primary-100']) }}>
    {{ $value ?? $slot }}
</label>
