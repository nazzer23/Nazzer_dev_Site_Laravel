<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'CreativeWork',
    'name' => $project->title,
    'description' => $project->summary,
    'url' => $project->url ?: route('projects.show', $project),
], JSON_UNESCAPED_SLASHES) !!}
</script>

<main>
    <section class="section">
        <div class="lower-card glass">
            <div class="section-heading">
                <h1 class="section-title">{{ $project->title }}</h1>
                <span class="repo-badge">{{ $project->status->label() }}</span>
            </div>

            <p class="repo-description">{{ $project->summary }}</p>

            @if($project->url || $project->githubProjects->isNotEmpty())
                <div class="hero-actions">
                    @if($project->url)
                        <x-partials.button href="{{ $project->url }}" variant="secondary">
                            Visit project &rarr;
                        </x-partials.button>
                    @endif
                    @foreach($project->githubProjects as $repo)
                        <x-partials.button href="{{ $repo->html_url }}" variant="secondary">
                            {{ $repo->name }} on GitHub &rarr;
                        </x-partials.button>
                    @endforeach
                </div>
            @endif

            @if($project->body)
                <div class="repo-description whitespace-pre-line">{{ $project->body }}</div>
            @endif
        </div>

        @if($project->updates->isNotEmpty())
            <div class="repo-table-panel glass">
                <div class="panel-heading">
                    <h3 class="panel-title">Dev log</h3>
                    <span class="count-badge">{{ $project->updates->count() }}</span>
                </div>

                <div class="flex flex-col gap-4 p-4">
                    @foreach($project->updates as $update)
                        <x-partials.dev-log-entry :update="$update"/>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</main>
