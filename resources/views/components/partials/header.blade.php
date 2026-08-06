<header class="header" x-data="{ mobileOpen: false }" x-scroll-to-header>
    <div class="links" x-bind:class="{ 'mobile:hidden': mobileOpen }">
        <a class="brand" href="{{ route('home') }}" wire:navigate>Ben Vernazza</a>

        <nav class="nav-links mobile:hidden">
            @if(request()->routeIs('home'))
                <a href="#projects" x-on:click.prevent="$scrollTo({offsetHeader: true})">Work</a>
                <a href="#about" x-on:click.prevent="$scrollTo({offsetHeader: true})">About</a>
            @else
                <a href="{{ route('home') }}#projects" wire:navigate>Work</a>
                <a href="{{ route('home') }}#about" wire:navigate>About</a>
            @endif
            <a href="https://github.com/{{ config('github.user') }}" target="_blank" rel="noreferrer">GitHub &#8599;</a>
        </nav>

        <div class="mobile:hidden">
            @if(request()->routeIs('home'))
                <x-partials.button href="#contact" variant="primary" x-on:click.prevent="$scrollTo({offsetHeader: true})">
                    Contact
                </x-partials.button>
            @else
                <x-partials.button href="{{ route('contact') }}" variant="primary" wire:navigate>
                    Contact
                </x-partials.button>
            @endif
        </div>
    </div>

    <button
        type="button"
        class="mobile-toggle hidden mobile:flex"
        x-on:click="mobileOpen = !mobileOpen"
        :aria-expanded="mobileOpen"
        aria-label="Toggle navigation"
    >
        <svg class="icon-sm" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path x-show="!mobileOpen" d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path x-show="mobileOpen" x-cloak d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        </svg>
    </button>

    <nav
        class="mobile-nav"
        x-show="mobileOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
    >
        @if(request()->routeIs('home'))
            <a href="#projects" x-on:click.prevent="$scrollTo({offsetHeader: true}); mobileOpen = false">Work</a>
            <a href="#about" x-on:click.prevent="$scrollTo({offsetHeader: true}); mobileOpen = false">About</a>
        @else
            <a href="{{ route('home') }}#projects" wire:navigate x-on:click="mobileOpen = false">Work</a>
            <a href="{{ route('home') }}#about" wire:navigate x-on:click="mobileOpen = false">About</a>
        @endif
        <a href="https://github.com/{{ config('github.user') }}" target="_blank" rel="noreferrer">GitHub &#8599;</a>
        <a href="{{ route('contact') }}" wire:navigate x-on:click="mobileOpen = false">Contact</a>
    </nav>
</header>
