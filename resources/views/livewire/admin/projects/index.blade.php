<div class="w-full px-6 py-6">
    <div class="repo-table-panel glass">
        <div class="panel-heading">
            <h3 class="panel-title">
                Projects
                <span class="count-badge">{{ $projects->count() }}</span>
            </h3>
            <a class="btn btn-primary" href="{{ route('admin.projects.create') }}" wire:navigate>New project</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr wire:key="project-{{ $project->id }}">
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->status->label() }}</td>
                            <td>{{ $project->updated_at?->diffForHumans() }}</td>
                            <td class="flex items-center gap-3">
                                <a class="small-link" href="{{ route('admin.projects.edit', $project) }}" wire:navigate>Edit</a>
                                <button
                                    class="small-link cursor-pointer"
                                    wire:click="delete({{ $project->id }})"
                                    wire:confirm="Are you sure you want to delete this project?"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No projects yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
