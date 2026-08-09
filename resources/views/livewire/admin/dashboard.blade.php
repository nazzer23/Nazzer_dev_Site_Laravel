<div class="w-full px-6 py-6 flex flex-col gap-6">
    <div class="grid grid-cols-4 tablet:grid-cols-2 mobile:grid-cols-1 gap-4">
        <a href="{{ route('admin.projects.index') }}" class="glass rounded-2xl p-5 flex flex-col gap-1 transition hover:border-primary-500/60" wire:navigate>
            <span class="text-3xl font-secondary font-bold text-white">{{ $projectCount }}</span>
            <span class="text-sm text-primary-200">Projects</span>
        </a>
        <a href="{{ route('admin.repos.index') }}" class="glass rounded-2xl p-5 flex flex-col gap-1 transition hover:border-primary-500/60" wire:navigate>
            <span class="text-3xl font-secondary font-bold text-white">{{ $repoCount }}</span>
            <span class="text-sm text-primary-200">GitHub repos</span>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="glass rounded-2xl p-5 flex flex-col gap-1 transition hover:border-primary-500/60" wire:navigate>
            <span class="text-3xl font-secondary font-bold text-white">{{ $categoryCount }}</span>
            <span class="text-sm text-primary-200">Categories</span>
        </a>
        <a href="{{ route('admin.skills.index') }}" class="glass rounded-2xl p-5 flex flex-col gap-1 transition hover:border-primary-500/60" wire:navigate>
            <span class="text-3xl font-secondary font-bold text-white">{{ $skillCount }}</span>
            <span class="text-sm text-primary-200">Skills</span>
        </a>
    </div>

    <div class="repo-table-panel glass">
        <div class="panel-heading">
            <h3 class="panel-title">Recent activity</h3>
            <a class="small-link" href="{{ route('admin.audit-log.index') }}" wire:navigate>
                View full audit log &rarr;
            </a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>When</th>
                        <th>Who</th>
                        <th>Action</th>
                        <th>Record</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentActivity as $log)
                        <tr wire:key="activity-{{ $log->id }}">
                            <td>{{ $log->created_at->diffForHumans() }}</td>
                            <td>{{ $log->user?->name ?? 'System' }}</td>
                            <td>{{ $log->action->label() }}</td>
                            <td>{{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No activity yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
