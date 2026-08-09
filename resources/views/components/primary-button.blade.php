<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary text-xs uppercase tracking-widest']) }}>
    {{ $slot }}
</button>
