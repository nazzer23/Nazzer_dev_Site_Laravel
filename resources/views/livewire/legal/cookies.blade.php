<main>
    <section class="section">
        <div class="lower-card glass">
            <div class="section-heading">
                <h1 class="section-title">Cookie Policy</h1>
            </div>

            <div class="legal-content">
                <p>Last updated: {{ now()->format('j F Y') }}</p>

                <p>
                    This site, operated by {{ config('legal.entity_name') }}
                    (company number {{ config('legal.company_number') }}), uses a small
                    number of cookies to keep the site working and to understand how it's
                    used.
                </p>

                <h2>Strictly necessary</h2>
                <p>
                    A session cookie keeps the site working correctly (e.g. remembering an
                    admin login session). These cookies can't be switched off, as the site
                    won't function without them.
                </p>

                <h2>Security</h2>
                <p>
                    Cloudflare Turnstile sets a cookie to verify form submissions aren't
                    coming from a bot, on the login, password reset, and contact forms.
                </p>

                <h2>Analytics</h2>
                <p>
                    Google Analytics sets cookies to measure site traffic and usage, so we
                    can understand which content is useful. This data is anonymised and
                    isn't used to identify you personally.
                </p>

                <h2>Managing cookies</h2>
                <p>
                    Most browsers let you block or delete cookies via their settings. Doing
                    so may affect the site's functionality, particularly for forms protected
                    by Turnstile.
                </p>

                <h2>Questions</h2>
                <p>
                    Questions about this policy can be sent via the
                    <a href="{{ route('contact') }}" wire:navigate>contact page</a>.
                </p>
            </div>
        </div>
    </section>
</main>
