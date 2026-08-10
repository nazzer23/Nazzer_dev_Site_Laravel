<?php

namespace App\Livewire\Legal;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.main')]
class Privacy extends Component
{
    public function render(): View
    {
        return view('livewire.legal.privacy');
    }
}
