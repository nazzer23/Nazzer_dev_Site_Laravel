<?php

namespace App\Support;

use RyanChandler\LaravelCloudflareTurnstile\Rules\Turnstile as TurnstileRule;

class Turnstile
{
    /**
     * Turnstile is only enforced when both keys are configured, and never
     * in local/testing so developers and the test suite are not challenged.
     */
    public static function enabled(): bool
    {
        if (app()->environment(['local', 'testing'])) {
            return false;
        }

        return !empty(config('services.turnstile.key'))
            && !empty(config('services.turnstile.secret'));
    }

    /**
     * Validation rules for the token field — empty when Turnstile is disabled.
     *
     * @return array<int, mixed>
     */
    public static function rules(): array
    {
        return self::enabled() ? ['required', app(TurnstileRule::class)] : [];
    }
}
