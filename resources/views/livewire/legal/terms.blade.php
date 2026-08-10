<main>
    <section class="section">
        <div class="lower-card glass">
            <div class="section-heading">
                <h1 class="section-title">Terms &amp; Conditions</h1>
            </div>

            <div class="legal-content">
                <p>Last updated: {{ now()->format('j F Y') }}</p>

                <p>
                    This website is operated by {{ config('legal.entity_name') }}
                    (company number {{ config('legal.company_number') }}), registered in
                    {{ config('legal.jurisdiction') }}. By accessing or using this site, you
                    agree to be bound by these Terms &amp; Conditions.
                </p>

                <h2>Use of this site</h2>
                <p>
                    This site is a personal development portfolio. Its content — including
                    project write-ups, dev-log entries, and repository listings — is provided
                    for informational purposes and may be updated or removed at any time
                    without notice.
                </p>

                <h2>Intellectual property</h2>
                <p>
                    Unless otherwise stated, all content on this site is the property of
                    {{ config('legal.entity_name') }}. Linked open-source repositories remain
                    subject to their own individual licences.
                </p>

                <h2>Acceptable use</h2>
                <ul>
                    <li>Don't attempt to disrupt, overload, or gain unauthorised access to this site or its systems.</li>
                    <li>Don't submit unlawful, abusive, or fraudulent content through the contact form.</li>
                </ul>

                <h2>Third-party links</h2>
                <p>
                    This site links to third-party services (including GitHub, LinkedIn, and
                    individual project sites). We aren't responsible for the content or
                    practices of those external sites.
                </p>

                <h2>Liability</h2>
                <p>
                    This site is provided "as is" without warranties of any kind. To the
                    fullest extent permitted by law, {{ config('legal.entity_name') }} accepts
                    no liability for any loss or damage arising from use of this site.
                </p>

                <h2>Changes to these terms</h2>
                <p>
                    These terms may be updated from time to time. Continued use of the site
                    after changes are published constitutes acceptance of the revised terms.
                </p>

                <h2>Contact</h2>
                <p>
                    Questions about these terms can be sent via the
                    <a href="{{ route('contact') }}" wire:navigate>contact page</a>.
                </p>
            </div>
        </div>
    </section>
</main>
