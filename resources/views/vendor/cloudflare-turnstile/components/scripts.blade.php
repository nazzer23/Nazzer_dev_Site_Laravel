<script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=__turnstileOnLoad" async defer {{ $attributes }}></script>
<script>
    window.__turnstileOnLoad = function () {
        (window.__turnstileQueue || []).forEach((fn) => fn());
        window.__turnstileQueue = [];
    };
</script>
