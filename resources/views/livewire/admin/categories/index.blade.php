<div class="w-full px-6 py-6">
    <div class="repo-table-panel glass">
        <div class="panel-heading">
            <h3 class="panel-title">
                Categories
                <span class="count-badge">{{ $categories->count() }}</span>
            </h3>
        </div>

        <form wire:submit="addCategory" class="flex items-end gap-3 p-4 border-b border-primary-800/40">
            <div class="flex-1">
                <x-input-label for="name" value="New category" />
                <x-text-input wire:model="name" id="name" class="block w-full mt-1" type="text" placeholder="e.g. Frontend" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Repositories</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr wire:key="category-{{ $category->id }}">
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->github_projects_count }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    wire:click="deleteCategory({{ $category->id }})"
                                    wire:confirm="Remove this category from all repositories it's tagged on?"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No categories yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
