@props(['href', 'variant' => 'primary'])

<a href="{{ $href }}" {{ $attributes->class(['btn', "btn-{$variant}"]) }}>
    {{ $slot }}
</a>
