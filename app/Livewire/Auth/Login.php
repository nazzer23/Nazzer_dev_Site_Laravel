<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\LoginForm;
use App\Support\Turnstile;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class Login extends Component
{
    public LoginForm $form;

    public ?string $turnstileToken = null;

    public function login(): void
    {
        try {
            $this->validate(['turnstileToken' => Turnstile::rules()]);
            $this->validate();
        } catch (ValidationException $e) {
            $this->turnstileToken = null;
            throw $e;
        }

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.auth.login');
    }
}
