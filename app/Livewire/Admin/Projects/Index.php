<?php

namespace App\Livewire\Admin\Projects;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public function delete(Project $project): void
    {
        $project->delete();
    }

    public function render(): View
    {
        return view('livewire.admin.projects.index', [
            'projects' => Project::latest('updated_at')->get(),
        ]);
    }
}
