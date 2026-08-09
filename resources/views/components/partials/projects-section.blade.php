@props(['projects', 'categories', 'activeCategory'])

<section id="projects" class="section">
    <div class="section-heading">
        <h2 class="section-title">Recently Updated</h2>
    </div>

    @if($categories->isNotEmpty())
        <div class="chips">
            <button
                type="button"
                wire:click="setCategory(null)"
                class="chip cursor-pointer @if(!$activeCategory) chip-active @endif"
            >
                All
            </button>
            @foreach($categories as $category)
                <button
                    type="button"
                    wire:click="setCategory('{{ $category->slug }}')"
                    class="chip cursor-pointer @if($activeCategory === $category->slug) chip-active @endif"
                >
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    @endif

    @if($projects->isEmpty())
        <p>{{ $activeCategory ? 'No repositories in this category yet.' : 'No public repositories yet.' }}</p>
    @else
        <div class="repo-grid">
            @foreach($projects->take(3) as $project)
                <x-partials.repo-card :project="$project"/>
            @endforeach
        </div>

        <x-partials.repo-table :projects="$projects"/>
    @endif
</section>
