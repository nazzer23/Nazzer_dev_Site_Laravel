<?php

namespace App\Livewire\Admin\Skills;

use App\Models\Skill;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public string $category = '';

    public string $name = '';

    public int $sortOrder = 0;

    /** @var array<int, array{category: string, name: string, sort_order: int}> */
    public array $rows = [];

    public function mount(): void
    {
        $this->refreshRows();
    }

    public function addSkill(): void
    {
        $validated = $this->validate([
            'category' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'sortOrder' => ['integer', 'min:0'],
        ]);

        Skill::create([
            'category' => $validated['category'],
            'name' => $validated['name'],
            'sort_order' => $validated['sortOrder'],
        ]);

        $this->reset(['category', 'name', 'sortOrder']);
        $this->refreshRows();
    }

    public function updateSkill(int $skillId): void
    {
        $validated = $this->validate([
            "rows.{$skillId}.category" => ['required', 'string', 'max:255'],
            "rows.{$skillId}.name" => ['required', 'string', 'max:255'],
            "rows.{$skillId}.sort_order" => ['integer', 'min:0'],
        ]);

        Skill::findOrFail($skillId)->update($validated['rows'][$skillId]);
    }

    public function deleteSkill(Skill $skill): void
    {
        $skill->delete();
        $this->refreshRows();
    }

    public function render(): View
    {
        return view('livewire.admin.skills.index');
    }

    private function refreshRows(): void
    {
        $this->rows = Skill::orderBy('sort_order')
            ->get()
            ->mapWithKeys(fn (Skill $skill) => [
                $skill->id => [
                    'category' => $skill->category,
                    'name' => $skill->name,
                    'sort_order' => $skill->sort_order,
                ],
            ])
            ->all();
    }
}
