<!doctype html>
<html class="js-unavailable" lang="{{ app()->getLocale() }}" data-country="Vietnam">
<head>
    @include('client.partials.head')
</head>
<body class="@yield('body_class', 'c-page c-page--index c-page--')">
    <a class="u-visually-hidden" href="#MainContent">Skip to content.</a>
    <div class="c-page__wrapper">
        @include('client.partials.header')

        <main role="main" class="o-main" id="MainContent">
            <div class="o-main__wrapper">
                @yield('content')
            </div>
        </main>

        @include('client.partials.footer')
        @include('client.partials.cart-drawer')
    </div>

    {{-- Admin Toolbar & Inline Editing Hooks --}}
    @include('client.partials.admin-bar')
    @include('client.partials.inline-blocks')
    @include('client.partials.inline-outline')

    {{-- S54 Luxury Back-To-Top Floating Button --}}
    <button type="button" class="s54-back-to-top" id="s54-back-to-top" aria-label="{{ app()->getLocale() === 'vi' ? 'Cuộn về đầu trang' : 'Back to top' }}">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 15l-6-6-6 6"/>
        </svg>
    </button>

    <script src="{{ asset('assets/js/vendor.js') }}"></script>
    <script src="{{ asset('assets/js/layouts.theme.js') }}"></script>
    <script src="{{ asset('assets/js/sections.product-carousel.js') }}"></script>
    <script src="{{ asset('assets/js/sections.article-feed.js') }}"></script>
    <script src="{{ asset('assets/js/sections.featured-video.js') }}"></script>
    <script src="{{ asset('assets/js/sections.featured-collections.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/client-cart.js') }}"></script>
    <script>
    (function() {
        var btn = document.getElementById('s54-back-to-top');
        if (!btn) return;
        function toggleBackToTop() {
            var st = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
            if (st > 250) {
                btn.classList.add('is-visible');
            } else {
                btn.classList.remove('is-visible');
            }
        }
        window.addEventListener('scroll', toggleBackToTop, { passive: true });
        document.addEventListener('scroll', toggleBackToTop, { passive: true });
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            document.documentElement.scrollTo({ top: 0, behavior: 'smooth' });
            document.body.scrollTo({ top: 0, behavior: 'smooth' });
        });
        toggleBackToTop();
    })();
    </script>
    @stack('scripts')
</body>
</html>

