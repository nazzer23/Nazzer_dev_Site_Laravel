<?php

namespace Tests\Feature\Admin\Repos;

use App\Livewire\Admin\Repos\Index;
use App\Models\Category;
use App\Models\GithubProject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_away_from_the_index_page(): void
    {
        $response = $this->get('/admin/repos');

        $response->assertRedirect('/login');
    }

    public function test_unverified_users_are_redirected_away_from_the_index_page(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/admin/repos');

        $response->assertRedirect('/verify-email');
    }

    public function test_mount_hydrates_category_ids_keyed_by_repo_id(): void
    {
        $user = User::factory()->create();
        $repo = GithubProject::factory()->create();
        $category = Category::create(['name' => 'Backend']);
        $repo->categories()->attach($category);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->assertSet('categoryIds.'.$repo->id, [$category->id]);
    }

    public function test_save_syncs_selected_categories_to_the_repo(): void
    {
        $user = User::factory()->create();
        $repo = GithubProject::factory()->create();
        $frontend = Category::create(['name' => 'Frontend']);
        $backend = Category::create(['name' => 'Backend']);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->set("categoryIds.{$repo->id}", [$frontend->id, $backend->id])
            ->call('save', $repo->id);

        $this->assertEqualsCanonicalizing(
            [$frontend->id, $backend->id],
            $repo->fresh()->categories->pluck('id')->all(),
        );
    }

    public function test_save_removes_deselected_categories_from_the_repo(): void
    {
        $user = User::factory()->create();
        $repo = GithubProject::factory()->create();
        $category = Category::create(['name' => 'Cloud']);
        $repo->categories()->attach($category);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->set("categoryIds.{$repo->id}", [])
            ->call('save', $repo->id);

        $this->assertSame([], $repo->fresh()->categories->pluck('id')->all());
    }
}
