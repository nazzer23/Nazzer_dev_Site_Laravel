@props(['projects'])

<div class="repo-table-panel glass">
    <div class="panel-heading">
        <h3 class="panel-title">
            All repositories
            <span class="count-badge">{{ $projects->count() }}</span>
        </h3>
        <a class="small-link" href="https://github.com/{{ config('github.user') }}?tab=repositories" target="_blank" rel="noreferrer">
            View all on GitHub &rarr;
        </a>
    </div>

    <div class="table-wrap">
        <table>
            <colgroup>
                <col style="width:24%">
                <col style="width:37%">
                <col style="width:14%">
                <col style="width:10%">
            </colgroup>
            <thead>
                <tr>
                    <th>Repository</th>
                    <th>Description</th>
                    <th>Language</th>
                    <th>Updated</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td>
                            <a class="repo-cell" href="{{ $project->html_url }}" target="_blank" rel="noreferrer">
                                @if($project->flag_fork)
                                    <x-partials.icons.git.fork/>
                                @else
                                    <x-partials.icons.git.repo/>
                                @endif
                                {{ $project->displayName() }}
                            </a>
                        </td>
                        <td class="description-cell">{{ $project->description ?: '—' }}</td>
                        <td>
                            {{ $project->language ?: '—' }}
                            @foreach($project->categories as $category)
                                <span class="repo-tag-demo">{{ $category->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $project->repo_pushed_at?->diffForHumans(null, true) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No repositories are available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
