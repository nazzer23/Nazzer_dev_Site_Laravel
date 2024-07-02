<?php

namespace App\Console\Commands;

use App\Models\GithubProject;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateGithubProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-github-projects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Triggers a request to GitHub to retrieve projects';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $request = Http::get('https://api.github.com/users/' . env('GITHUB_USER', 'nazzer23') . '/repos');
        $response = $request->json();

        $repoIDs = (collect($response)->map(function ($item) {
            return $item['id'];
        }));

        GithubProject::query()->whereNotIn('github_id', $repoIDs)->delete();

        foreach ($response as $project) {
            // Check to see if repo exists in database.
            $githubProject = GithubProject::where('github_id', $project['id'])->first();
            if (!$githubProject) {
                $githubProject = new GithubProject();
            }
            $githubProject->github_id = $project['id'];
            $githubProject->name = $project['name'];
            $githubProject->full_name = $project['full_name'];
            $githubProject->language = $project['language'];
            $githubProject->html_url = $project['html_url'];
            $githubProject->description = $project['description'];
            $githubProject->repo_pushed_at = $project['pushed_at'];
            $githubProject->repo_created_at = $project['created_at'];

            $githubProject->save();
        }
    }
}
