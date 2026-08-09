<?php

namespace App\Livewire\Admin\Projects;

use App\Enums\ProjectStatus;
use App\Models\GithubProject;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Create extends Component
{
    public string $title = '';

    public string $slug = '';

    public string $summary = '';

    public string $body = '';

    public string $url = '';

    public string $status = ProjectStatus::Active->value;

    /** @var array<int, int> */
    public array $githubProjectIds = [];

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug'],
            'summary' => ['required', 'string', 'max:1000'],
            'body' => ['nullable', 'string'],
            'url' => ['nullable', 'url', 'max:255'],
            'status' => ['required', Rule::enum(ProjectStatus::class)],
            'githubProjectIds' => ['array'],
            'githubProjectIds.*' => ['integer', 'exists:github_projects,id'],
        ]);

        $validated['slug'] = blank($validated['slug']) ? null : $validated['slug'];
        $githubProjectIds = $validated['githubProjectIds'];
        unset($validated['githubProjectIds']);

        $project = Project::create($validated);
        $project->githubProjects()->sync($githubProjectIds);

        $this->redirectRoute('admin.projects.edit', $project, navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin.projects.create', [
            'statuses' => ProjectStatus::cases(),
            'repos' => GithubProject::orderBy('name')->get(),
        ]);
    }
}
