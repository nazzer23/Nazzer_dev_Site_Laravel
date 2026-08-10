<footer class="footer">
    <div class="footer-top">
        <span>&copy; {{ now()->year }} <span class="highlight">Ben Vernazza</span></span>
        <x-partials.icons.social-icons/>
        <span>Website by <a href="https://elbah.group/" target="_blank" rel="noreferrer" class="small-link">Elbah Group</a></span>
    </div>

    <div class="footer-legal">
        <span>{{ config('legal.entity_name') }} &middot; Company No. {{ config('legal.company_number') }}</span>
        <a href="{{ route('legal.terms') }}" wire:navigate class="small-link">Terms &amp; Conditions</a>
        <a href="{{ route('legal.privacy') }}" wire:navigate class="small-link">Privacy Policy</a>
        <a href="{{ route('legal.cookies') }}" wire:navigate class="small-link">Cookie Policy</a>
    </div>
</footer>
