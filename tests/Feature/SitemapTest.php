<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_is_returned_as_xml(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml');
    }

    public function test_sitemap_always_includes_home_and_contact_urls(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertSee(route('home'), false);
        $response->assertSee(route('contact'), false);
    }

    public function test_sitemap_includes_a_url_per_project(): void
    {
        $projectOne = Project::factory()->create();
        $projectTwo = Project::factory()->create();

        $response = $this->get('/sitemap.xml');

        $response->assertSee(route('projects.show', $projectOne), false);
        $response->assertSee(route('projects.show', $projectTwo), false);
    }
}
