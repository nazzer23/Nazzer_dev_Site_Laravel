@php($skillGroups = \App\Models\Skill::orderBy('sort_order')->get()->groupBy('category'))

@if($skillGroups->isNotEmpty())
    <article class="lower-card glass">
        <h2 class="lower-title">Technical Skills</h2>

        <div class="skills-grid">
            @foreach($skillGroups as $category => $skills)
                <div>
                    <h3 class="skill-heading">{{ $category }}</h3>
                    <div class="chips">
                        @foreach($skills as $skill)
                            <x-partials.chip>{{ $skill->name }}</x-partials.chip>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </article>
@endif
