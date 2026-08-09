<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\GithubProject;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.main')]
class Homepage extends Component
{
    public ?string $activeCategory = null;

    public function setCategory(?string $slug): void
    {
        $this->activeCategory = $slug;
    }

    public function render(): View
    {
        $currentProjects = Project::latest('updated_at')->get();

        $projects = GithubProject::query()
            ->with('categories')
            ->when(
                $this->activeCategory,
                fn ($query) => $query->whereHas(
                    'categories',
                    fn ($query) => $query->where('slug', $this->activeCategory),
                ),
            )
            ->get()
            ->sortByDesc('repo_pushed_at');

        return view('livewire.homepage', [
            'currentProjects' => $currentProjects,
            'projects' => $projects,
            'categories' => Category::whereHas('githubProjects')->orderBy('name')->get(),
        ]);
    }
}
