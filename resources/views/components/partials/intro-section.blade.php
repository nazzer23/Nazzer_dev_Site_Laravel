<section id="intro" class="hero">
    <div class="hero-copy-col">
        <livewire:discord-status wire:lazy/>

        <h1 class="title">
            Turning ideas into <span class="accent">reliable</span> software.
        </h1>

        <p class="hero-copy">
            I'm Ben, a developer who's been writing code since 2009. I care about
            turning complex problems into simple, well-built systems &mdash; and I'm
            always exploring new technology to do that better.
        </p>

        <div class="hero-actions">
            <x-partials.button href="#projects" variant="primary" x-on:click.prevent="$scrollTo({offsetHeader: true})">
                Explore my work
            </x-partials.button>
            <x-partials.button href="mailto:ben@nazzer.dev" variant="secondary">
                Email me
            </x-partials.button>
        </div>

        <div class="chips">
            <x-partials.chip>PHP / Laravel</x-partials.chip>
            <x-partials.chip>Livewire</x-partials.chip>
            <x-partials.chip>Alpine.js</x-partials.chip>
            <x-partials.chip>Tailwind CSS</x-partials.chip>
        </div>
    </div>

    <div class="hero-visual" aria-hidden="true">
        <x-partials.code-window/>
    </div>
</section>
