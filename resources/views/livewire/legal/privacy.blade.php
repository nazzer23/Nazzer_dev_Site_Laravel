<main>
    <section class="section">
        <div class="lower-card glass">
            <div class="section-heading">
                <h1 class="section-title">Privacy Policy</h1>
            </div>

            <div class="legal-content">
                <p>Last updated: {{ now()->format('j F Y') }}</p>

                <p>
                    {{ config('legal.entity_name') }} (company number
                    {{ config('legal.company_number') }}, "we", "us") is committed to
                    protecting your privacy. This policy explains what data we collect
                    through this site and how it's used.
                </p>

                <h2>What we collect</h2>
                <ul>
                    <li><strong>Contact form submissions</strong> — name, email address, and message content you submit voluntarily.</li>
                    <li><strong>Usage data</strong> — anonymised analytics (pages visited, approximate location, device/browser type) via Google Analytics.</li>
                    <li><strong>Security data</strong> — data processed by Cloudflare Turnstile to verify you're not a bot when submitting forms.</li>
                </ul>

                <h2>How we use it</h2>
                <ul>
                    <li>To respond to messages sent via the contact form.</li>
                    <li>To understand site usage and improve content.</li>
                    <li>To protect the site against spam and abuse.</li>
                </ul>

                <h2>Legal basis</h2>
                <p>
                    We process contact form data on the basis of consent (you choosing to
                    submit it) and analytics/security data on the basis of our legitimate
                    interest in operating and protecting the site.
                </p>

                <h2>Sharing your data</h2>
                <p>
                    We don't sell your data. It may be shared with the service providers
                    that support the site — Google (Analytics) and Cloudflare (Turnstile) —
                    each acting under their own privacy policies.
                </p>

                <h2>Data retention</h2>
                <p>
                    Contact form submissions are retained only as long as needed to handle
                    the enquiry. Analytics data is retained per Google Analytics' standard
                    retention settings.
                </p>

                <h2>Your rights</h2>
                <p>
                    You may request access to, correction of, or deletion of your personal
                    data by contacting us via the
                    <a href="{{ route('contact') }}" wire:navigate>contact page</a>.
                </p>

                <h2>Cookies</h2>
                <p>
                    See our <a href="{{ route('legal.cookies') }}" wire:navigate>Cookie Policy</a>
                    for details on the cookies this site uses.
                </p>

                <h2>Changes to this policy</h2>
                <p>
                    This policy may be updated from time to time. Material changes will be
                    reflected by the "last updated" date above.
                </p>
            </div>
        </div>
    </section>
</main>
