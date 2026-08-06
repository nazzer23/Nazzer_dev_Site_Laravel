<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = [
            ['loc' => route('home'), 'lastmod' => now()],
            ['loc' => route('contact'), 'lastmod' => now()],
        ];

        foreach (Project::all() as $project) {
            $urls[] = [
                'loc' => route('projects.show', $project),
                'lastmod' => $project->updated_at,
            ];
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }
}
