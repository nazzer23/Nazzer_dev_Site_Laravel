<div class="w-full px-6 py-6 flex flex-col gap-6">
    <div class="lower-card glass">
        <h1 class="section-title mb-2">Edit project</h1>

        <x-partials.admin.project-form :statuses="$statuses" :repos="$repos" :github-project-ids="$githubProjectIds" submit="save" />
    </div>

    <div class="repo-table-panel glass">
        <div class="panel-heading">
            <h3 class="panel-title">
                Dev log
                <span class="count-badge">{{ $project->updates->count() }}</span>
            </h3>
        </div>

        <div class="flex flex-col gap-4 p-4">
            @forelse($project->updates as $update)
                <div wire:key="update-{{ $update->id }}" class="flex items-start justify-between gap-3">
                    <div class="flex-1">
                        <x-partials.dev-log-entry :update="$update" :deletable="true" />
                    </div>
                    <button
                        class="small-link cursor-pointer shrink-0"
                        wire:click="deleteUpdate({{ $update->id }})"
                        wire:confirm="Are you sure you want to delete this dev log entry?"
                    >
                        Delete
                    </button>
                </div>
            @empty
                <p class="repo-description">No dev log entries yet.</p>
            @endforelse

            <form wire:submit="addUpdate" class="flex flex-col gap-3 border-t border-primary-800/40 pt-4">
                <div>
                    <x-input-label for="updateTitle" value="Title (optional)" />
                    <x-text-input wire:model="updateTitle" id="updateTitle" class="block mt-1 w-full" type="text" />
                    <x-input-error :messages="$errors->get('updateTitle')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="updateBody" value="Update" />
                    <textarea wire:model="updateBody" id="updateBody" rows="3" class="block mt-1 w-full bg-slate-800/20 border-primary-800/60 text-white placeholder-primary-200/40 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"></textarea>
                    <x-input-error :messages="$errors->get('updateBody')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="newUpdateImages" value="Images (optional, up to 10)" />
                    <input
                        wire:model="newUpdateImages"
                        id="newUpdateImages"
                        type="file"
                        multiple
                        accept="image/*"
                        class="block mt-1 w-full text-sm text-primary-200 file:mr-3 file:btn file:btn-secondary file:border-0"
                    />
                    <div wire:loading wire:target="newUpdateImages" class="text-xs text-primary-200/70 mt-1">
                        Uploading&hellip;
                    </div>
                    <x-input-error :messages="$errors->get('newUpdateImages')" class="mt-2" />
                    <x-input-error :messages="$errors->get('newUpdateImages.*')" class="mt-2" />

                    @if(!empty($newUpdateImages))
                        <div class="dev-log-images">
                            @foreach($newUpdateImages as $image)
                                <img src="{{ $image->temporaryUrl() }}" alt="" class="!aspect-video">
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn btn-secondary">Add entry</button>
                </div>
            </form>
        </div>
    </div>
</div>
