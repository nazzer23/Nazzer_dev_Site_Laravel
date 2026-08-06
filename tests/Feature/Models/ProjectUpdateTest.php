<?php

namespace Tests\Feature\Models;

use App\Models\Project;
use App\Models\ProjectUpdate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_project(): void
    {
        $project = Project::factory()->create();
        $update = ProjectUpdate::factory()->for($project)->create();

        $this->assertTrue($update->project->is($project));
    }
}
