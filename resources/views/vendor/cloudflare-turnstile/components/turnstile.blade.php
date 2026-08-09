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
    id="{{ $id }}"
    @if ($model)
        wire:ignore
        {{ $attributes->filter(fn($value, $key) => ! in_array($key, ['wire:model', 'id']))->class([]) }}
    @else
        data-sitekey="{{ config('services.turnstile.key') }}"
        {{ $attributes->class(['cf-turnstile']) }}
    @endif
></div>

@if ($model)
    <script @if($nonce) nonce="{{ $nonce }}" @endif>
        (function () {
            let widgetId = null;

            function render() {
                if (widgetId !== null) {
                    window.turnstile.remove(widgetId);
                }

                widgetId = window.turnstile.render("#{{ $id }}", {
                    sitekey: @js(config('services.turnstile.key')),
                    callback: (token) => @this.set("{{ $model }}", token),
                    'expired-callback': () => window.turnstile.reset(widgetId),
                    'timeout-callback': () => window.turnstile.reset(widgetId),
                });
            }

            function renderWhenReady() {
                if (window.turnstile) {
                    render();
                } else {
                    (window.__turnstileQueue ??= []).push(render);
                }
            }

            document.addEventListener('livewire:navigated', () => {
                renderWhenReady();

                @this.watch("{{ $model }}", (value, old) => {
                    // If there was a value, and now there isn't, reset the Turnstile.
                    if (!!old && !value && widgetId !== null) {
                        window.turnstile.reset(widgetId);
                    }
                });
            });
        })();
    </script>
@endif
