@php($skillGroups = \App\Models\Skill::orderBy('sort_order')->get()->groupBy('category'))

@if($skillGroups->isNotEmpty())
    <article class="lower-card glass">
        <h2 class="lower-title">Skills</h2>

        <div class="skills-grid">
            @foreach($skillGroups as $category => $skills)
                <div>
                    <h3 class="skill-heading">{{ $category }}</h3>
                    <ul class="skill-list">
                        @foreach($skills as $skill)
                            <li>{{ $skill->name }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </article>
@endif
