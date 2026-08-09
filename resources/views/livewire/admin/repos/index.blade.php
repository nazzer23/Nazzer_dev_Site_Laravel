<div class="w-full px-6 py-6">
    <div class="repo-table-panel glass">
        <div class="panel-heading">
            <h3 class="panel-title">
                GitHub repository categories
                <span class="count-badge">{{ $repos->count() }}</span>
            </h3>
            <a class="small-link" href="{{ route('admin.categories.index') }}" wire:navigate>
                Manage categories &rarr;
            </a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Repository</th>
                        <th>Categories</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($repos as $repo)
                        <tr wire:key="repo-{{ $repo->id }}">
                            <td>{{ $repo->name }}</td>
                            <td>
                                @if($categories->isEmpty())
                                    <span class="text-primary-200/70 text-sm">No categories yet.</span>
                                @else
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($categories as $category)
                                            <label class="inline-flex items-center gap-1.5 text-sm text-primary-100">
                                                <input
                                                    type="checkbox"
                                                    wire:model="categoryIds.{{ $repo->id }}"
                                                    value="{{ $category->id }}"
                                                    class="rounded border-primary-800/60 bg-slate-800/20 text-primary-500 focus:ring-primary-500"
                                                />
                                                {{ $category->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-secondary" wire:click="save({{ $repo->id }})">Save</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No repositories are available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
