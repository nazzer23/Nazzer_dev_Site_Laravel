<div x-data="{ open: false }">
    <!-- Mobile top bar -->
    <div class="hidden tablet:flex items-center justify-between h-14 px-4 border-b border-primary-800/40 bg-primary-950 sticky top-0 z-30">
        <a href="{{ route('home') }}" class="font-secondary font-bold text-white" wire:navigate>Ben Vernazza</a>
        <button
            type="button"
            class="mobile-toggle"
            x-on:click="open = true"
            aria-label="Open admin navigation"
        >
            <svg class="icon-sm" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </button>
    </div>

    <!-- Desktop sidebar -->
    <aside class="tablet:hidden w-64 shrink-0 sticky top-0 h-screen border-r border-primary-800/40 bg-primary-900 flex flex-col">
        <x-partials.admin-sidebar-content/>
    </aside>

    <!-- Mobile drawer -->
    <div
        class="fixed inset-0 z-40 bg-black/50"
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-on:click.self="open = false"
    >
        <div
            class="w-72 max-w-[85%] h-full bg-primary-900 border-r border-primary-800/40 flex flex-col"
            x-on:click="open = false"
        >
            <div class="flex items-center justify-between px-4 h-14 border-b border-primary-800/40">
                <span class="font-secondary font-bold text-white text-lg">Admin</span>
                <button type="button" class="mobile-toggle" x-on:click.stop="open = false" aria-label="Close admin navigation">
                    <svg class="icon-sm" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
            <x-partials.admin-sidebar-content/>
        </div>
    </div>
</div>
