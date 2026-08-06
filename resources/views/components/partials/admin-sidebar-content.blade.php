<nav class="flex flex-col justify-between flex-1 overflow-y-auto">
    <div class="p-4 flex flex-col gap-1">
        <a href="{{ route('home') }}" class="btn btn-secondary justify-start mb-4" wire:navigate>
            &larr; Back to site
        </a>

        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.projects.index')" :active="request()->routeIs('admin.projects.*')" wire:navigate>
            {{ __('Projects') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.repos.index')" :active="request()->routeIs('admin.repos.*')" wire:navigate>
            {{ __('GitHub tags') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')" wire:navigate>
            {{ __('Categories') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.skills.index')" :active="request()->routeIs('admin.skills.*')" wire:navigate>
            {{ __('Skills') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.audit-log.index')" :active="request()->routeIs('admin.audit-log.*')" wire:navigate>
            {{ __('Audit log') }}
        </x-responsive-nav-link>
    </div>

    <div class="p-4 border-t border-primary-800/40">
        <div class="px-3 py-2">
            <div
                class="font-medium text-sm text-white"
                x-data="{{ json_encode(['name' => auth()->user()->name]) }}"
                x-text="name"
                x-on:profile-updated.window="name = $event.detail.name"
            ></div>
            <div class="text-xs text-primary-200">{{ auth()->user()->email }}</div>
        </div>

        <x-responsive-nav-link :href="route('profile')" wire:navigate>
            {{ __('Profile') }}
        </x-responsive-nav-link>

        <button wire:click="logout" class="w-full text-start">
            <x-responsive-nav-link>
                {{ __('Log Out') }}
            </x-responsive-nav-link>
        </button>
    </div>
</nav>
