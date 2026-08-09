<!--
    Hey there!
    Have an ascii dinosaur
               __
              / _)
     _.----._/ /
    /         /
 __/ (  | (  |
/__.-'|_|--|_|
-->
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="The development portfolio for Ben Vernazza aka Nazzer23."/>
    <meta name="robots" content="index, follow"/>

    <meta property="og:title" content="Ben Vernazza — Nazzer23"/>
    <meta property="og:description" content="The development portfolio for Ben Vernazza aka Nazzer23."/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ url()->current() }}"/>

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:title" content="Ben Vernazza — Nazzer23"/>
    <meta name="twitter:description" content="The development portfolio for Ben Vernazza aka Nazzer23."/>

    <title>{{config('app.name', 'Laravel')}}</title>

    @if (\App\Support\Turnstile::enabled())
        <x-turnstile.scripts/>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php($skillNames = \App\Models\Skill::pluck('name'))
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'ProfilePage',
        'mainEntity' => [
            '@type' => 'Person',
            'name' => 'Ben Vernazza',
            'alternateName' => 'nazzer23',
            'identifier' => '1',
            'jobTitle' => 'Software Engineer',
            'sameAs' => [
                'https://github.com/nazzer23/',
                'https://www.linkedin.com/in/nazzer23/',
            ],
            'knowsAbout' => $skillNames,
        ],
    ], JSON_UNESCAPED_SLASHES) !!}
    </script>


    <!-- Google tag (gtag.js) -->
    <script async src="//www.googletagmanager.com/gtag/js?id=G-2T05V72N01"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-2T05V72N01');
    </script>
</head>

<body x-data>

<x-partials.header/>

{{$slot}}

<x-partials.footer/>

@livewireScripts
@stack('scripts')
</body>

</html>
