<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'S54 COFFEE — Cà Phê Rang Xay & Hòa Tan Thượng Hạng | Good Solutions')</title>
@hasSection('meta_description')
    <meta name="description" content="@yield('meta_description')">
@else
    <meta name="description" content="S54 COFFEE - Thương hiệu cà phê thượng hạng thuộc Good Solutions Co., Ltd. Cung cấp cà phê rang mộc nguyên chất, cà phê hòa tan 3in1 và giải pháp B2B toàn diện.">
@endif

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('assets/css/layouts.critical.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/layouts.theme.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custom.css?v=1789123000') }}">

<style id="s54-direct-typography-override">
/* S54 HARMONIOUS INTER TYPOGRAPHY SYSTEM */
:root {
    --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
}

html, body, *, *::before, *::after,
button, input, select, textarea,
h1, h2, h3, h4, h5, h6, p, span, a, li {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
}

body {
    -webkit-font-smoothing: antialiased !important;
    -moz-osx-font-smoothing: grayscale !important;
    letter-spacing: -0.011em;
}

/* Headings Scale: Balanced, Modern, Refined */
h1, .o-heading--1, .s54-hero-title, .c-hero-banner__title, .c-hero-banner__title span {
    font-size: clamp(32px, 4.5vw, 52px) !important;
    font-weight: 800 !important;
    line-height: 1.15 !important;
    letter-spacing: -0.03em !important;
}

h2, .o-heading--2,
.c-product-carousel__title, .c-product-carousel__title span, .c-product-carousel__title p,
.c-text-and-image__text-title, .c-text-and-image__text-title span, .c-text-and-image__title,
.c-featured-video__title, .c-featured-video__title span,
.c-featured-collections__header-title, .c-featured-collections__header-title span,
.c-featured-collections__title, .c-product-main__title,
.c-article-feed__title, .c-article-feed__title span,
.s54-featured-section h2 {
    font-size: clamp(24px, 3.2vw, 36px) !important;
    font-weight: 700 !important;
    line-height: 1.25 !important;
    letter-spacing: -0.02em !important;
}

/* Subtitles & Section Intros */
.c-hero-banner__subtitle,
.c-product-carousel__description p,
.c-text-and-image__text-paragraph p,
.c-article-feed__inner-text p,
.c-featured-video__desc,
.s54-featured-section p {
    font-size: 15px !important;
    font-weight: 400 !important;
    line-height: 1.6 !important;
    color: #6E6259 !important;
    letter-spacing: -0.005em !important;
}

/* ==========================================================================
   CRITICAL FIX: PRODUCT CARD TITLES (Harmonious 15px Semibold, No Clunky 32px)
   ========================================================================== */
.s54-product-card h3,
.s54-product-card h3 a,
.o-product-thumbnail h3,
.o-product-thumbnail h3 a,
.o-product-thumbnail__title,
.c-product-carousel__product-title,
.c-product-carousel__product-title span {
    font-size: 15px !important;
    font-weight: 600 !important;
    line-height: 1.4 !important;
    letter-spacing: -0.01em !important;
    color: #1A120B !important;
    margin: 0 0 8px 0 !important;
    min-height: 42px !important;
    max-height: 42px !important;
    height: 42px !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    text-decoration: none !important;
}

.s54-product-card h3 a:hover,
.o-product-thumbnail h3 a:hover {
    color: #D68E1D !important;
}

/* Product Card Description Clamping */
.s54-product-card p,
.o-product-thumbnail p {
    font-size: 12.5px !important;
    font-weight: 400 !important;
    line-height: 1.5 !important;
    color: #6E6259 !important;
    margin: 0 0 12px 0 !important;
    min-height: 38px !important;
    max-height: 38px !important;
    height: 38px !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
}

/* Price Alignment */
.o-product-thumbnail__price,
.s54-product-card .o-product-thumbnail__price {
    font-size: 16px !important;
    font-weight: 700 !important;
    color: #D68E1D !important;
    letter-spacing: -0.01em !important;
}

/* Filter Buttons */
.s54-filter-btn {
    font-size: 13px !important;
    font-weight: 600 !important;
    letter-spacing: 0 !important;
}

/* Call to Action Buttons */
.o-btn,
.c-hero-banner__button,
.c-text-and-image__text-button,
.c-product-carousel__button,
.c-article-feed__button,
.s54-product-card button,
.o-product-thumbnail button {
    font-size: 12.5px !important;
    font-weight: 600 !important;
    letter-spacing: 0.5px !important;
}

/* Topbar Announcement */
.c-header__topbar-message {
    font-size: 12px !important;
    font-weight: 500 !important;
    letter-spacing: 0.01em !important;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@stack('styles')
