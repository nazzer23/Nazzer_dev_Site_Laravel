<section id="intro">
    <div class="flex flex-row tablet:flex-col gap-6 justify-center items-center w-[80%] tablet:w-full">
        <div class="w-[50%] tablet:w-full pl-20 flex flex-col gap-3">
            <div class="flex flex-col">
                <h1 class="title">Ben Vernazza</h1>
                <h2 class="tagline">Transforming Code into Innovation</h2>
            </div>
{{--            <SocialIcons/>--}}
            <a class="hover:bg-primary-800/20 border-l-4 border-secondary-400 bg-primary-900/30 hover:transition hover:shadow-lg hover:shadow-primary-900 rounded-md w-fit py-1 px-2" href="#projects" on:click={handleAnchorClick}>view my projects</a>
        </div>
        <div class="w-[50%] tablet:w-full ">
            <x-partials.icons.programmer-animate />
        </div>
    </div>
</section>
