<?php

namespace Tests\Feature\Admin\Projects;

use App\Enums\ProjectStatus;
use App\Livewire\Admin\Projects\Edit;
use App\Models\Project;
use App\Models\ProjectUpdate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_away_from_the_edit_page(): void
    {
        $project = Project::factory()->create();

        $response = $this->get("/admin/projects/{$project->slug}/edit");

        $response->assertRedirect('/login');
    }

    public function test_unverified_users_are_redirected_away_from_the_edit_page(): void
    {
        $user = User::factory()->unverified()->create();
        $project = Project::factory()->create();

        $response = $this->actingAs($user)->get("/admin/projects/{$project->slug}/edit");

        $response->assertRedirect('/verify-email');
    }

    public function test_mount_hydrates_properties_from_the_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'title' => 'Original Title',
            'summary' => 'Original Summary',
            'body' => 'Original Body',
            'url' => 'https://example.com',
            'status' => ProjectStatus::Paused->value,
        ]);

        Livewire::actingAs($user)
            ->test(Edit::class, ['project' => $project])
            ->assertSet('title', 'Original Title')
            ->assertSet('slug', $project->slug)
            ->assertSet('summary', 'Original Summary')
            ->assertSet('body', 'Original Body')
            ->assertSet('url', 'https://example.com')
            ->assertSet('status', ProjectStatus::Paused->value);
    }

    public function test_save_updates_the_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['title' => 'Old Title']);

        Livewire::actingAs($user)
            ->test(Edit::class, ['project' => $project])
            ->set('title', 'New Title')
            ->set('status', ProjectStatus::Shipped->value)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('New Title', $project->fresh()->title);
        $this->assertSame(ProjectStatus::Shipped, $project->fresh()->status);
    }

    public function test_add_update_creates_project_update_and_resets_inputs(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        Livewire::actingAs($user)
            ->test(Edit::class, ['project' => $project])
            ->set('updateTitle', 'Progress')
            ->set('updateBody', 'Shipped the thing')
            ->call('addUpdate')
            ->assertHasNoErrors()
            ->assertSet('updateTitle', '')
            ->assertSet('updateBody', '');

        $update = ProjectUpdate::sole();

        $this->assertSame($project->id, $update->project_id);
        $this->assertSame('Progress', $update->title);
        $this->assertSame('Shipped the thing', $update->body);
    }

    public function test_delete_update_aborts_when_update_belongs_to_a_different_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $otherProject = Project::factory()->create();
        $otherUpdate = ProjectUpdate::factory()->for($otherProject)->create();

        Livewire::actingAs($user)
            ->test(Edit::class, ['project' => $project])
            ->call('deleteUpdate', $otherUpdate)
            ->assertStatus(403);

        $this->assertDatabaseHas('project_updates', ['id' => $otherUpdate->id]);
    }

    public function test_delete_update_removes_it_and_reloads_updates(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $update = ProjectUpdate::factory()->for($project)->create();

        Livewire::actingAs($user)
            ->test(Edit::class, ['project' => $project])
            ->call('deleteUpdate', $update)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('project_updates', ['id' => $update->id]);
    }
}
