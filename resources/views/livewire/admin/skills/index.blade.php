<div class="w-full px-6 py-6">
    <div class="repo-table-panel glass">
        <div class="panel-heading">
            <h3 class="panel-title">
                Skills
                <span class="count-badge">{{ count($rows) }}</span>
            </h3>
        </div>

        <form wire:submit="addSkill" class="flex items-end gap-3 flex-wrap p-4 border-b border-primary-800/40">
            <div>
                <x-input-label for="category" value="Category" />
                <x-text-input wire:model="category" id="category" class="block mt-1" type="text" placeholder="e.g. Backend" />
                <x-input-error :messages="$errors->get('category')" class="mt-1" />
            </div>
            <div>
                <x-input-label for="name" value="Skill" />
                <x-text-input wire:model="name" id="name" class="block mt-1" type="text" placeholder="e.g. Laravel" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>
            <div>
                <x-input-label for="sortOrder" value="Order" />
                <x-text-input wire:model="sortOrder" id="sortOrder" class="block mt-1 w-20" type="number" min="0" />
                <x-input-error :messages="$errors->get('sortOrder')" class="mt-1" />
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Skill</th>
                        <th>Order</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $skillId => $row)
                        <tr wire:key="skill-{{ $skillId }}">
                            <td>
                                <x-text-input wire:model="rows.{{ $skillId }}.category" class="block w-full" type="text" />
                                <x-input-error :messages="$errors->get('rows.'.$skillId.'.category')" class="mt-1" />
                            </td>
                            <td>
                                <x-text-input wire:model="rows.{{ $skillId }}.name" class="block w-full" type="text" />
                                <x-input-error :messages="$errors->get('rows.'.$skillId.'.name')" class="mt-1" />
                            </td>
                            <td>
                                <x-text-input wire:model="rows.{{ $skillId }}.sort_order" class="block w-20" type="number" min="0" />
                            </td>
                            <td class="flex items-center gap-3">
                                <button class="btn btn-secondary" wire:click="updateSkill({{ $skillId }})">Save</button>
                                <button
                                    class="small-link cursor-pointer"
                                    wire:click="deleteSkill({{ $skillId }})"
                                    wire:confirm="Are you sure you want to delete this skill?"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No skills yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
