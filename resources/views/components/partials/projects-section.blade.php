<section id="projects">
    <div class="flex flex-col gap-6 justify-center items-center w-full">
        <h1>my projects</h1>

        <div>
            <div class="github_projects">
                @if(\App\Models\GithubProject::get()->count() <= 0)
                    <h2>The user has no public repositories</h2>
                @else
                    @each('components.partials.github-project', \App\Models\GithubProject::all()->sortByDesc('repo_pushed_at'), 'project')
                @endif
            </div>
        </div>

    </div>
</section>
