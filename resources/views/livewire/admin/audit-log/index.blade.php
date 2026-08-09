<div class="w-full px-6 py-6">
    <div class="repo-table-panel glass">
        <div class="panel-heading">
            <h3 class="panel-title">
                Audit log
                <span class="count-badge">{{ $logs->total() }}</span>
            </h3>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>When</th>
                        <th>Who</th>
                        <th>Action</th>
                        <th>Record</th>
                        <th>Changes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr wire:key="audit-{{ $log->id }}">
                            <td>{{ $log->created_at->diffForHumans() }}</td>
                            <td>{{ $log->user?->name ?? 'System' }}</td>
                            <td>{{ $log->action->label() }}</td>
                            <td>{{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}</td>
                            <td>
                                <div class="repo-tags">
                                    @foreach($log->changes ?? [] as $field => $value)
                                        <span class="repo-tag-demo">{{ $field }}: {{ is_scalar($value) ? $value : json_encode($value) }}</span>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No audit activity yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
