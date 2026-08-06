@props(['statuses', 'repos', 'githubProjectIds', 'submit'])

<form wire:submit="{{ $submit }}" class="flex flex-col gap-4">
    <div>
        <x-input-label for="title" value="Title" />
        <x-text-input wire:model="title" id="title" class="block mt-1 w-full" type="text" required />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="slug" value="Slug" />
        <x-text-input wire:model="slug" id="slug" class="block mt-1 w-full" type="text" />
        <p class="text-xs text-primary-200/70 mt-1">Leave blank to auto-generate.</p>
        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="summary" value="Summary" />
        <x-text-input wire:model="summary" id="summary" class="block mt-1 w-full" type="text" required />
        <x-input-error :messages="$errors->get('summary')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="body" value="Body" />
        <textarea wire:model="body" id="body" rows="8" class="block mt-1 w-full bg-slate-800/20 border-primary-800/60 text-white placeholder-primary-200/40 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"></textarea>
        <x-input-error :messages="$errors->get('body')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="url" value="URL" />
        <x-text-input wire:model="url" id="url" class="block mt-1 w-full" type="url" />
        <x-input-error :messages="$errors->get('url')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="status" value="Status" />
        <select wire:model="status" id="status" class="block mt-1 w-full bg-slate-800/20 border-primary-800/60 text-white rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500">
            @foreach($statuses as $case)
                <option value="{{ $case->value }}">{{ $case->label() }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    <div>
        <x-input-label value="Linked GitHub repos" />

        @if($repos->isEmpty())
            <p class="text-xs text-primary-200/70 mt-1">No repos synced yet.</p>
        @else
            <div class="flex flex-wrap gap-1.5 mt-1">
                @forelse($repos->whereIn('id', $githubProjectIds) as $repo)
                    <span class="repo-tag-demo">{{ $repo->name }}</span>
                @empty
                    <span class="text-xs text-primary-200/70">None selected.</span>
                @endforelse
            </div>

            <button type="button" class="btn btn-secondary mt-2" x-data x-on:click="$dispatch('open-modal', 'select-repos')">
                Select repos
            </button>

            <x-modal name="select-repos" maxWidth="lg">
                <div class="p-6 flex flex-col gap-4" x-data="{ search: '' }">
                    <h2 class="font-secondary font-bold text-lg text-white">Select GitHub repos</h2>

                    <x-text-input type="text" x-model="search" class="w-full" placeholder="Search repos..." />

                    <div class="max-h-80 overflow-y-auto flex flex-col gap-1 -mx-2">
                        @foreach($repos as $repo)
                            <label
                                x-show="'{{ strtolower($repo->name) }}'.includes(search.toLowerCase())"
                                class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-primary-900 text-sm text-primary-100 cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    wire:model="githubProjectIds"
                                    value="{{ $repo->id }}"
                                    class="rounded border-primary-800/60 bg-slate-800/20 text-primary-500 focus:ring-primary-500"
                                />
                                {{ $repo->name }}
                            </label>
                        @endforeach
                    </div>

                    <div class="flex justify-end">
                        <button type="button" class="btn btn-primary" x-on:click="$dispatch('close-modal', 'select-repos')">
                            Done
                        </button>
                    </div>
                </div>
            </x-modal>
        @endif

        <x-input-error :messages="$errors->get('githubProjectIds')" class="mt-2" />
    </div>

    <div class="flex justify-end">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
