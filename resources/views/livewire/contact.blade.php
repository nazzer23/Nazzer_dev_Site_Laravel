<main>
    <section class="section">
        <div class="lower-card glass max-w-2xl mx-auto w-full">
            <h1 class="section-title">Get in touch</h1>
            <p class="contact-copy">Send a message and I'll get back to you as soon as I can.</p>

            @if($sent)
                <div class="status-pill">
                    <span class="status-dot bg-primary-400"></span>
                    Thanks — your message has been sent.
                </div>
            @endif

            <form wire:submit="send" class="flex flex-col gap-4 mt-2">
                <div>
                    <x-input-label for="name" value="Name" />
                    <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" required autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" required autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="message" value="Message" />
                    <textarea wire:model="message" id="message" rows="6" required class="block mt-1 w-full bg-slate-800/20 border-primary-800/60 text-white placeholder-primary-200/40 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"></textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                </div>

                <div class="hidden" aria-hidden="true">
                    <label for="website">Website</label>
                    <input wire:model="website" id="website" type="text" tabindex="-1" autocomplete="off">
                </div>

                @if (\App\Support\Turnstile::enabled())
                    <div>
                        <x-turnstile wire:model="turnstileToken"/>
                        <x-input-error :messages="$errors->get('turnstileToken')" class="mt-2"/>
                    </div>
                @endif

                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">Send message</button>
                </div>
            </form>
        </div>
    </section>
</main>
