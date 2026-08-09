<?php

namespace App\Livewire;

use App\Helpers\ACore;
use App\Mail\ContactMessage;
use App\Support\Turnstile;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.main')]
class Contact extends Component
{
    private const int MAX_ATTEMPTS = 3;

    private const int DECAY_MINUTES = 10;

    public string $name = '';

    public string $email = '';

    public string $message = '';

    public string $website = '';

    public ?string $turnstileToken = null;

    public bool $sent = false;

    public function send(): void
    {
        $this->sent = false;

        try {
            $validated = $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'message' => ['required', 'string', 'min:10', 'max:5000'],
                'turnstileToken' => Turnstile::rules(),
            ]);
        } catch (ValidationException $e) {
            $this->turnstileToken = null;
            throw $e;
        }

        if (filled($this->website)) {
            $this->reset(['name', 'email', 'message', 'website']);
            $this->sent = true;

            return;
        }

        if (RateLimiter::tooManyAttempts($this->throttleKey(), self::MAX_ATTEMPTS)) {
            $this->addError('message', 'Too many messages sent. Please try again later.');

            return;
        }

        RateLimiter::hit($this->throttleKey(), self::DECAY_MINUTES * 60);

        try {
            Mail::send(new ContactMessage(
                senderName: $validated['name'],
                senderEmail: $validated['email'],
                body: $validated['message'],
            ));
        } catch (\Exception $ex) {
            ACore::handleException($ex);

            // If Unable to send contact via email - we should trigger a Discord Webhook instead.
            ACore::sendDiscordNotification(
                sLocation: "Contact Form",
                sMessage: $validated['message'],
                aFields: [
                    [
                        'name' => 'Name',
                        'value' => $validated['name']
                    ],
                    [
                        'name' => 'Email',
                        'value' => $validated['email']
                    ],
                ]
            );
        }

        $this->reset(['name', 'email', 'message', 'website', 'turnstileToken']);
        $this->sent = true;
    }

    private function throttleKey(): string
    {
        return 'contact-form:' . request()->ip();
    }

    public function render(): View
    {
        return view('livewire.contact');
    }
}
