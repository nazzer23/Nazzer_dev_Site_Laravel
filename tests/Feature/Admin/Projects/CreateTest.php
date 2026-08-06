<?php

namespace Tests\Feature\Admin\Projects;

use App\Enums\ProjectStatus;
use App\Livewire\Admin\Projects\Create;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_away_from_the_create_page(): void
    {
        $response = $this->get('/admin/projects/create');

        $response->assertRedirect('/login');
    }

    public function test_unverified_users_are_redirected_away_from_the_create_page(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/admin/projects/create');

        $response->assertRedirect('/verify-email');
    }

    public function test_title_summary_and_status_are_required(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Create::class)
            ->set('title', '')
            ->set('summary', '')
            ->set('status', '')
            ->call('save')
            ->assertHasErrors(['title' => 'required', 'summary' => 'required', 'status' => 'required']);
    }

    public function test_status_must_be_a_valid_enum_value(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Create::class)
            ->set('title', 'Project X')
            ->set('summary', 'Summary')
            ->set('status', 'not-a-real-status')
            ->call('save')
            ->assertHasErrors(['status']);
    }

    public function test_url_must_be_a_valid_url(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Create::class)
            ->set('title', 'Project X')
            ->set('summary', 'Summary')
            ->set('status', ProjectStatus::Active->value)
            ->set('url', 'not-a-url')
            ->call('save')
            ->assertHasErrors(['url']);
    }

    public function test_slug_must_be_unique(): void
    {
        $user = User::factory()->create();
        Project::factory()->create(['slug' => 'taken-slug']);

        Livewire::actingAs($user)
            ->test(Create::class)
            ->set('title', 'Project X')
            ->set('summary', 'Summary')
            ->set('status', ProjectStatus::Active->value)
            ->set('slug', 'taken-slug')
            ->call('save')
            ->assertHasErrors(['slug']);
    }

    public function test_successful_save_creates_project_and_redirects_to_edit(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(Create::class)
            ->set('title', 'Project X')
            ->set('summary', 'Summary')
            ->set('status', ProjectStatus::Active->value)
            ->call('save');

        $component->assertHasNoErrors();

        $project = Project::sole();

        $this->assertSame('Project X', $project->title);
        $component->assertRedirect(route('admin.projects.edit', $project, absolute: false));
    }

    public function test_blank_slug_is_auto_generated_on_save(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Create::class)
            ->set('title', 'My New Project')
            ->set('summary', 'Summary')
            ->set('status', ProjectStatus::Active->value)
            ->set('slug', '')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('my-new-project', Project::sole()->slug);
    }
}
