<?php

namespace App\Livewire\Admin\AuditLog;

use App\Models\AuditLog;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.admin.audit-log.index', [
            'logs' => AuditLog::with('user')->latest('created_at')->paginate(25),
        ]);
    }
}
