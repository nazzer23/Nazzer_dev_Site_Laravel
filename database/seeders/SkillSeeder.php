<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Edit this list to change what shows in the "Skills" card — no view changes needed.
     */
    private const SKILLS = [
        'Backend' => ['PHP', 'Laravel', 'Livewire'],
        'Frontend' => ['Alpine.js', 'Tailwind CSS', 'Blade'],
        'Tooling' => ['Vite', 'Git', 'PHPStan / Larastan'],
    ];

    public function run(): void
    {
        foreach (self::SKILLS as $category => $names) {
            foreach ($names as $index => $name) {
                Skill::updateOrCreate(
                    ['name' => $name],
                    ['category' => $category, 'sort_order' => $index],
                );
            }
        }
    }
}
