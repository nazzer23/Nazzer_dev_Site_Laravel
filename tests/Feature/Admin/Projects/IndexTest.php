<?php

namespace Tests\Feature\Admin\Projects;

use App\Livewire\Admin\Projects\Index;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_away_from_the_index_page(): void
    {
        $response = $this->get('/admin/projects');

        $response->assertRedirect('/login');
    }

    public function test_unverified_users_are_redirected_away_from_the_index_page(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/admin/projects');

        $response->assertRedirect('/verify-email');
    }

    public function test_projects_are_listed_ordered_by_updated_at_descending(): void
    {
        $user = User::factory()->create();

        $older = Project::factory()->create(['updated_at' => now()->subDay()]);
        $newer = Project::factory()->create(['updated_at' => now()]);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->assertViewHas('projects', function ($projects) use ($older, $newer) {
                return $projects->first()->is($newer) && $projects->last()->is($older);
            });
    }

    public function test_delete_soft_deletes_the_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        Livewire::actingAs($user)
            ->test(Index::class)
            ->call('delete', $project);

        $this->assertSoftDeleted($project);
    }
}
