<?php

namespace App\Livewire\Auth;

use App\Support\Turnstile;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class ForgotPassword extends Component
{
    public string $email = '';

    public ?string $turnstileToken = null;

    public function sendPasswordResetLink(): void
    {
        try {
            $this->validate([
                'email' => ['required', 'string', 'email'],
                'turnstileToken' => Turnstile::rules(),
            ]);
        } catch (ValidationException $e) {
            $this->turnstileToken = null;
            throw $e;
        }

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }

    public function render(): View
    {
        return view('livewire.auth.forgot-password');
    }
}
