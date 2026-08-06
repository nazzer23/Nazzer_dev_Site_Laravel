<?php

namespace App\Livewire;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.main')]
class ProjectShow extends Component
{
    public Project $project;

    public function mount(Project $project): void
    {
        $this->project = $project->load('updates.images', 'githubProjects');
    }

    public function render(): View
    {
        return view('livewire.project-show');
    }
}
