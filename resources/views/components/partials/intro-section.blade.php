<section id="intro" class="hero">
    <div class="hero-copy-col">
        <livewire:discord-status wire:lazy/>

        <h1 class="title">
            Turning ideas into <span class="accent">reliable</span> software.
        </h1>

        <p class="hero-copy">
            I build reliable software across application development, infrastructure and DevOps, with a focus on simple, maintainable systems.
        </p>

        <div class="hero-actions">
            <x-partials.button href="#projects" variant="primary" x-on:click.prevent="$scrollTo({offsetHeader: true})">
                Explore my work
            </x-partials.button>
            <x-partials.button href="{{route('contact')}}" variant="secondary">
                Contact me
            </x-partials.button>
        </div>
    </div>

    <div class="hero-visual" aria-hidden="true">
        <x-partials.code-window/>
    </div>
</section>
