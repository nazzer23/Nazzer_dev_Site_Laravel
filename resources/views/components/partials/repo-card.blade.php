@props(['project'])

@php($tag = $project->html_url ? 'a' : 'div')

<{{ $tag }}
    @if($project->html_url) href="{{ $project->html_url }}" target="_blank" rel="noreferrer" @endif
    class="repo-card"
>
    <div class="repo-card-top">
        <div class="repo-title-wrap">
            <div class="repo-title-line">
                <span class="repo-title">{{ $project->name }}</span>
                @if($project->flag_fork)
                    <span class="repo-badge">Fork</span>
                @endif
            </div>
        </div>
        <div class="repo-mark" aria-hidden="true">
            @if($project->flag_fork)
                <x-partials.icons.git.fork/>
            @else
                <x-partials.icons.git.repo/>
            @endif
        </div>
    </div>

    @if($project->description)
        <p class="repo-description">{{ $project->description }}</p>
    @endif

    @if($project->language || !empty($project->topics) || $project->categories->isNotEmpty())
        <div class="repo-tags">
            @if($project->language)
                <span class="repo-tag">{{ $project->language }}</span>
            @endif
            @foreach(array_slice($project->topics ?? [], 0, 3) as $topic)
                <span class="repo-tag">{{ $topic }}</span>
            @endforeach
            @foreach($project->categories as $category)
                <span class="repo-tag-demo">{{ $category->name }}</span>
            @endforeach
        </div>
    @endif

    <div class="repo-footer">
        <div class="repo-stats">
            <span class="repo-stat"><x-partials.icons.git.star/> {{ $project->stargazers_count }}</span>
            <span class="repo-stat"><x-partials.icons.git.fork/> {{ $project->forks_count }}</span>
        </div>
        @if($project->repo_pushed_at)
            <span>Updated {{ $project->repo_pushed_at->diffForHumans() }}</span>
        @endif
    </div>
</{{ $tag }}>
