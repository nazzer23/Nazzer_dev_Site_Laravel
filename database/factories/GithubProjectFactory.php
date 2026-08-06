<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GithubProject>
 */
class GithubProjectFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->slug(2);

        return [
            'github_id' => fake()->unique()->numberBetween(1000, 999999),
            'name' => $name,
            'full_name' => "nazzer/{$name}",
            'language' => fake()->randomElement(['PHP', 'JavaScript', 'Go']),
            'html_url' => "https://github.com/nazzer/{$name}",
            'description' => fake()->sentence(),
            'repo_pushed_at' => now(),
            'repo_created_at' => now(),
            'flag_fork' => false,
            'stargazers_count' => 0,
            'forks_count' => 0,
            'topics' => [],
        ];
    }
}
