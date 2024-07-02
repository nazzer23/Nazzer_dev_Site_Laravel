<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.main')] class extends Component {
}; ?>

<main>
    <x-partials.intro-section/>
    <x-partials.about-me-section/>
    <x-partials.projects-section/>
</main>
