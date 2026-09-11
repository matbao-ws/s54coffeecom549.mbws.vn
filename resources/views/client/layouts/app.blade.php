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

    <script src="{{ asset('assets/js/vendor.js') }}"></script>
    <script src="{{ asset('assets/js/layouts.theme.js') }}"></script>
    <script src="{{ asset('assets/js/sections.product-carousel.js') }}"></script>
    <script src="{{ asset('assets/js/sections.article-feed.js') }}"></script>
    <script src="{{ asset('assets/js/sections.featured-video.js') }}"></script>
    <script src="{{ asset('assets/js/sections.featured-collections.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/client-cart.js') }}"></script>
    @stack('scripts')
</body>
</html>

