<main>
    <x-partials.intro-section/>
    <x-partials.about-me-section/>
    <x-partials.current-projects-section :projects="$currentProjects"/>
    <x-partials.projects-section :projects="$projects" :categories="$categories" :active-category="$activeCategory"/>
</main>
