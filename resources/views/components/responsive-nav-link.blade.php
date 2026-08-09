@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-primary-400 text-start text-base font-medium text-white bg-slate-700/20 focus:outline-none focus:text-white focus:bg-slate-700/30 focus:border-primary-500 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-primary-200 hover:text-white hover:bg-slate-700/10 hover:border-primary-700 focus:outline-none focus:text-white focus:bg-slate-700/10 focus:border-primary-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
