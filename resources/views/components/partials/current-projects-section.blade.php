@props(['projects'])

@if($projects->isNotEmpty())
    <section id="building" class="section">
        <div class="section-heading">
            <h2 class="section-title">Currently building</h2>
        </div>

        <div class="repo-grid">
            @foreach($projects as $project)
                <a href="{{ route('projects.show', $project) }}" class="repo-card" wire:navigate>
                    <div class="repo-card-top">
                        <div class="repo-title-wrap">
                            <div class="repo-title-line">
                                <span class="repo-title">{{ $project->title }}</span>
                            </div>
                        </div>
                        <span class="repo-badge">{{ $project->status->label() }}</span>
                    </div>

                    <p class="repo-description">{{ $project->summary }}</p>
                </a>
            @endforeach
        </div>
    </section>
@endif
