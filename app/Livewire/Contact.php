<?php

namespace App\Livewire;

use App\Mail\ContactMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
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

    public bool $sent = false;

    public function send(): void
    {
        $this->sent = false;

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

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

        Mail::send(new ContactMessage(
            senderName: $validated['name'],
            senderEmail: $validated['email'],
            body: $validated['message'],
        ));

        $this->reset(['name', 'email', 'message', 'website']);
        $this->sent = true;
    }

    private function throttleKey(): string
    {
        return 'contact-form:'.request()->ip();
    }

    public function render(): View
    {
        return view('livewire.contact');
    }
}
