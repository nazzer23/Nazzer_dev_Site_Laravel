<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public string $name = '';

    public function addCategory(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        Category::create($validated);

        $this->reset('name');
    }

    public function deleteCategory(Category $category): void
    {
        $category->delete();
    }

    public function render(): View
    {
        return view('livewire.admin.categories.index', [
            'categories' => Category::withCount('githubProjects')->orderBy('name')->get(),
        ]);
    }
}
