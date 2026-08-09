<div class="w-full px-6 py-6">
    <div class="lower-card glass">
        <h1 class="section-title mb-2">New project</h1>

        <x-partials.admin.project-form :statuses="$statuses" :repos="$repos" :github-project-ids="$githubProjectIds" submit="save" />
    </div>
</div>
