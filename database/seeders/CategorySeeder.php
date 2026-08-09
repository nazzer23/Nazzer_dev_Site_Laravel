<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Starter taxonomy — add more from /admin/categories, no code changes needed.
     */
    private const CATEGORIES = [
        'Frontend',
        'Backend',
        'Cloud',
    ];

    public function run(): void
    {
        foreach (self::CATEGORIES as $name) {
            Category::updateOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)],
            );
        }
    }
}
