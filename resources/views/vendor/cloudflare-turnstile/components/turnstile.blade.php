@props([
    'id' => 'captcha',
    'nonce' => null,
])

@php
if (! preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $id)) {
    throw new InvalidArgumentException("The Turnstile ID [{$id}] must start with a letter or underscore, and can only contain alphanumeric or underscore characters.");
}

$model = $attributes->has('wire:model') ? $attributes->get('wire:model') : null;
@endphp

<div
    data-sitekey="{{ config('services.turnstile.key') }}"
    @if ($model)
        wire:ignore
        data-callback="{{ $id }}Callback"
        data-expired-callback="{{ $id }}ExpiredCallback"
        data-timeout-callback="{{ $id }}ExpiredCallback"
        {{ $attributes->filter(fn($value, $key) => ! in_array($key, ['data-callback', 'data-expired-callback', 'data-timeout-callback', 'wire:model', 'id']))->class(['cf-turnstile']) }}
    @else
        {{ $attributes->class(['cf-turnstile']) }}
    @endif
></div>

@if ($model)
    <script @if($nonce) nonce="{{ $nonce }}" @endif>
        document.addEventListener('livewire:navigated', () => {
            console.log('[turnstile] listener registered for {{ $model }}');

            window.{{ $id }}Callback = function (token) {
                console.log('[turnstile] token received', token);
                @this.set("{{ $model }}", token);
                setTimeout(() => console.log('[turnstile] value 500ms after set:', @this["{{ $model }}"]), 500);
            }

            window.{{ $id }}ExpiredCallback = function () {
                window.turnstile.reset();
            }

            @this.watch("{{ $model }}", (value, old) => {
                // If there was a value, and now there isn't, reset the Turnstile.
                if (!!old && !value) {
                    window.turnstile.reset();
                }
            })
        });
    </script>
@endif
