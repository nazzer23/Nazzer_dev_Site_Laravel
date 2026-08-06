<?php

namespace Tests\Feature\Models;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\ProjectUpdate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_slug_is_generated_from_title_when_blank(): void
    {
        $project = Project::factory()->create(['title' => 'My Great Project']);

        $this->assertSame('my-great-project', $project->slug);
    }

    public function test_slug_is_suffixed_on_collision(): void
    {
        Project::factory()->create(['title' => 'My Great Project']);
        $second = Project::factory()->create(['title' => 'My Great Project']);
        $third = Project::factory()->create(['title' => 'My Great Project']);

        $this->assertSame('my-great-project-2', $second->slug);
        $this->assertSame('my-great-project-3', $third->slug);
    }

    public function test_explicit_slug_is_not_overwritten(): void
    {
        $project = Project::factory()->create(['title' => 'My Great Project', 'slug' => 'custom-slug']);

        $this->assertSame('custom-slug', $project->slug);
    }

    public function test_route_key_name_is_slug(): void
    {
        $project = Project::factory()->create();

        $this->assertSame('slug', $project->getRouteKeyName());
    }

    public function test_status_casts_to_enum(): void
    {
        $project = Project::factory()->create(['status' => ProjectStatus::Shipped->value]);

        $this->assertInstanceOf(ProjectStatus::class, $project->status);
        $this->assertSame(ProjectStatus::Shipped, $project->status);
    }

    public function test_updates_relation_orders_latest_first(): void
    {
        $project = Project::factory()->create();

        $older = ProjectUpdate::factory()->for($project)->create(['created_at' => now()->subDay()]);
        $newer = ProjectUpdate::factory()->for($project)->create(['created_at' => now()]);

        $updates = $project->updates;

        $this->assertSame($newer->id, $updates->first()->id);
        $this->assertSame($older->id, $updates->last()->id);
    }

    public function test_soft_deletes_are_used(): void
    {
        $project = Project::factory()->create();

        $project->delete();

        $this->assertSoftDeleted($project);
        $this->assertNotNull($project->fresh()->deleted_at);
    }
}
