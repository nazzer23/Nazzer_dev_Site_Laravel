<?php

namespace App\Observers;

use App\Enums\AuditAction;
use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditObserver
{
    public function created(Model $model): void
    {
        $this->log($model, AuditAction::Created, $model->getAttributes());
    }

    public function updated(Model $model): void
    {
        $changes = $model->getChanges();

        if (empty($changes)) {
            return;
        }

        $this->log($model, AuditAction::Updated, $changes);
    }

    public function deleted(Model $model): void
    {
        $this->log($model, AuditAction::Deleted, $model->getAttributes());
    }

    /**
     * @param  array<string, mixed>  $changes
     */
    private function log(Model $model, AuditAction $action, array $changes): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'auditable_type' => $model::class,
            'auditable_id' => $model->getKey(),
            'changes' => $changes,
        ]);
    }
}
