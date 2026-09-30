<!doctype html>
<html class="js-unavailable" lang="{{ app()->getLocale() }}" data-country="Vietnam">
<head>
    @if(!empty($siteBranding['embed_header']))
        {!! $siteBranding['embed_header'] !!}
    @else
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-W6K85LZR');</script>
        <!-- End Google Tag Manager -->
    @endif
    @include('client.partials.head')
</head>
<body class="@yield('body_class', 'c-page c-page--index c-page--')">
    @if(!empty($siteBranding['embed_body']))
        {!! $siteBranding['embed_body'] !!}
    @else
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W6K85LZR"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif
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

    @php
        $jsVer = @filemtime(base_path('assets/js/layouts.theme.js')) 
            ?: (@filemtime(public_path('assets/js/layouts.theme.js')) ?: 1789299999);
    @endphp
    <script>
        window.S54_LOCALE = '{{ app()->getLocale() }}';
    </script>
    <script src="{{ asset('assets/js/vendor.js') }}?v={{ $jsVer }}"></script>
    <script src="{{ asset('assets/js/layouts.theme.js') }}?v={{ $jsVer }}"></script>
    <script src="{{ asset('assets/js/sections.product-carousel.js') }}?v={{ $jsVer }}"></script>
    <script src="{{ asset('assets/js/sections.article-feed.js') }}?v={{ $jsVer }}"></script>
    <script src="{{ asset('assets/js/sections.featured-video.js') }}?v={{ $jsVer }}"></script>
    <script src="{{ asset('assets/js/sections.featured-collections.js') }}?v={{ $jsVer }}"></script>
    <script src="{{ asset('assets/js/client-cart.js') }}?v={{ $jsVer }}"></script>
    <script src="{{ asset('assets/js/main.js') }}?v={{ $jsVer }}"></script>
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
    @if(!empty($siteBranding['embed_footer']))
        {!! $siteBranding['embed_footer'] !!}
    @endif
</body>
</html>

