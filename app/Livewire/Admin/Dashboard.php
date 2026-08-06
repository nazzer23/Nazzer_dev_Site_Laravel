<?php

namespace App\Livewire\Admin;

use App\Models\AuditLog;
use App\Models\Category;
use App\Models\GithubProject;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render(): View
    {
        return view('livewire.admin.dashboard', [
            'projectCount' => Project::count(),
            'repoCount' => GithubProject::count(),
            'categoryCount' => Category::count(),
            'skillCount' => Skill::count(),
            'recentActivity' => AuditLog::with('user')->latest('created_at')->limit(10)->get(),
        ]);
    }
}
