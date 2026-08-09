<?php

namespace App\Livewire\Admin\Projects;

use App\Enums\ProjectStatus;
use App\Models\GithubProject;
use App\Models\Project;
use App\Models\ProjectUpdate;
use App\Models\ProjectUpdateImage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class Edit extends Component
{
    use WithFileUploads;

    public Project $project;

    public string $title = '';

    public string $slug = '';

    public string $summary = '';

    public string $body = '';

    public string $url = '';

    public string $status = '';

    /** @var array<int, int> */
    public array $githubProjectIds = [];

    public string $updateTitle = '';

    public string $updateBody = '';

    /** @var array<int, \Livewire\Features\SupportFileUploads\TemporaryUploadedFile> */
    public array $newUpdateImages = [];

    public function mount(Project $project): void
    {
        $project->load('updates.images', 'githubProjects');

        $this->project = $project;
        $this->title = $project->title;
        $this->slug = $project->slug;
        $this->summary = $project->summary;
        $this->body = (string) $project->body;
        $this->url = (string) $project->url;
        $this->status = $project->status->value;
        $this->githubProjectIds = $project->githubProjects->pluck('id')->all();
    }

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($this->project->id)],
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

        $this->project->update($validated);
        $this->project->githubProjects()->sync($githubProjectIds);
    }

    public function addUpdate(): void
    {
        $validated = $this->validate([
            'updateTitle' => ['nullable', 'string', 'max:255'],
            'updateBody' => ['required', 'string'],
            'newUpdateImages' => ['nullable', 'array', 'max:10'],
            'newUpdateImages.*' => ['image', 'max:5120'],
        ]);

        $update = $this->project->updates()->create([
            'title' => blank($validated['updateTitle']) ? null : $validated['updateTitle'],
            'body' => $validated['updateBody'],
        ]);

        foreach ($this->newUpdateImages as $index => $image) {
            $update->images()->create([
                'path' => $image->store('project-updates', 'public'),
                'sort_order' => $index,
            ]);
        }

        $this->reset(['updateTitle', 'updateBody', 'newUpdateImages']);
        $this->project->load('updates.images');
    }

    public function deleteUpdate(ProjectUpdate $update): void
    {
        abort_if($update->project_id !== $this->project->id, 403);

        foreach ($update->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $update->delete();
        $this->project->load('updates.images');
    }

    public function deleteUpdateImage(ProjectUpdateImage $image): void
    {
        abort_if($image->projectUpdate?->project_id !== $this->project->id, 403);

        Storage::disk('public')->delete($image->path);
        $image->delete();

        $this->project->load('updates.images');
    }

    public function render(): View
    {
        return view('livewire.admin.projects.edit', [
            'statuses' => ProjectStatus::cases(),
            'repos' => GithubProject::orderBy('name')->get(),
        ]);
    }
}
