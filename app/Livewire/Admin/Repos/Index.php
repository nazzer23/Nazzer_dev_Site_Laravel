<?php

namespace App\Livewire\Admin\Repos;

use App\Enums\AuditAction;
use App\Models\AuditLog;
use App\Models\Category;
use App\Models\GithubProject;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    /** @var array<int, array<int, int>> */
    public array $categoryIds = [];

    public function mount(): void
    {
        $this->categoryIds = GithubProject::with('categories')
            ->get()
            ->mapWithKeys(fn (GithubProject $repo) => [$repo->id => $repo->categories->pluck('id')->all()])
            ->all();
    }

    public function save(int $repoId): void
    {
        $repo = GithubProject::findOrFail($repoId);

        $sync = $repo->categories()->sync($this->categoryIds[$repoId] ?? []);

        if (empty($sync['attached']) && empty($sync['detached'])) {
            return;
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => AuditAction::Updated,
            'auditable_type' => GithubProject::class,
            'auditable_id' => $repo->id,
            'changes' => ['categories' => $sync],
        ]);
    }

    public function render(): View
    {
        return view('livewire.admin.repos.index', [
            'repos' => GithubProject::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
