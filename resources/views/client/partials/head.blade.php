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
<link rel="stylesheet" href="{{ asset('assets/css/custom.css?v=' . (file_exists(public_path('assets/css/custom.css')) ? filemtime(public_path('assets/css/custom.css')) : '1789209999')) }}">

<style id="s54-thumb-reviews-critical">
  /* BULLETPROOF REVIEW STARS & PRODUCT CARD CRITICAL STYLES */
  .s54-thumb-reviews-bar {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 5px !important;
    margin: 6px auto 8px auto !important;
    width: 100% !important;
    line-height: 1 !important;
    text-decoration: none !important;
  }
  .s54-thumb-stars {
    display: inline-flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 2.5px !important;
    flex-shrink: 0 !important;
    white-space: nowrap !important;
  }
  .s54-thumb-star {
    width: 13px !important;
    height: 13px !important;
    min-width: 13px !important;
    min-height: 13px !important;
    max-width: 13px !important;
    max-height: 13px !important;
    display: inline-block !important;
    vertical-align: middle !important;
    fill: #D68E1D !important;
    flex-shrink: 0 !important;
  }
  .s54-thumb-rating-score {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    color: #2F221A !important;
    line-height: 1 !important;
    margin-left: 2px !important;
  }
  .s54-thumb-rating-sep {
    font-size: 11px !important;
    color: #A58A79 !important;
    line-height: 1 !important;
    opacity: 0.8 !important;
    margin: 0 1px !important;
  }
  .s54-thumb-rating-count {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    font-size: 12px !important;
    font-weight: 500 !important;
    color: #7B685B !important;
    line-height: 1 !important;
  }
  .s54-product-reviews-bar,
  .s54-rating-anchor {
    display: inline-flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 6px !important;
    text-decoration: none !important;
  }
  .s54-rating-stars {
    display: inline-flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 3px !important;
    flex-shrink: 0 !important;
    white-space: nowrap !important;
  }
  .s54-star-icon {
    width: 16px !important;
    height: 16px !important;
    min-width: 16px !important;
    max-width: 16px !important;
    display: inline-block !important;
    vertical-align: middle !important;
    fill: #D68E1D !important;
    flex-shrink: 0 !important;
  }
  .o-product-thumbnail__image-container {
    background-color: #FAF8F5 !important;
    position: relative !important;
    overflow: hidden !important;
  }
  .o-product-thumbnail__image {
    width: 100% !important;
    height: 100% !important;
    object-fit: contain !important;
    display: block !important;
  }

  /* BULLETPROOF FLAG ICONS & LANGUAGE PILL CRITICAL STYLES */
  .s54-flag-icon,
  .s54-header-lang-pill svg,
  .s54-topbar-lang svg,
  .s54-mobile-drawer__footer svg,
  .c-lang-switcher svg {
    width: 15px !important;
    height: 10px !important;
    min-width: 15px !important;
    max-width: 15px !important;
    min-height: 10px !important;
    max-height: 10px !important;
    display: inline-block !important;
    vertical-align: middle !important;
    flex-shrink: 0 !important;
    border-radius: 1.5px !important;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.25) !important;
  }
  .s54-header-lang-pill {
    display: inline-flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 2px !important;
    padding: 2px 4px !important;
    border-radius: 16px !important;
    background: rgba(255, 255, 255, 0.08) !important;
    border: 1px solid rgba(255, 255, 255, 0.14) !important;
    height: 30px !important;
    box-sizing: border-box !important;
    flex-shrink: 0 !important;
  }
  .s54-header-lang-pill .s54-lang-btn {
    display: inline-flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 4px !important;
    padding: 3px 8px !important;
    border-radius: 12px !important;
    font-size: 11.5px !important;
    font-weight: 700 !important;
    text-decoration: none !important;
    line-height: 1 !important;
    white-space: nowrap !important;
    flex-shrink: 0 !important;
    transition: all 0.2s ease !important;
  }
  .s54-header-lang-pill .s54-lang-btn.is-active {
    background: #D68E1D !important;
    color: #FFFFFF !important;
  }
  .s54-header-lang-pill .s54-lang-btn:not(.is-active) {
    background: transparent !important;
    color: rgba(250, 246, 241, 0.65) !important;
  }
  .s54-header-lang-pill .s54-lang-btn:not(.is-active):hover {
    color: #FFFFFF !important;
  }
</style>

<style id="s54-direct-typography-override">
/* S54 HARMONIOUS INTER TYPOGRAPHY SYSTEM */
@font-face {
    font-family: 'domaine';
    src: local('Inter');
}
:root {
    --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
}

html, body, *, *::before, *::after,
button, input, select, textarea,
h1, h2, h3, h4, h5, h6, p, span, a, li, div {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
}

body {
    -webkit-font-smoothing: antialiased !important;
    -moz-osx-font-smoothing: grayscale !important;
    letter-spacing: -0.011em;
}

/* 1. Global Headings Scale: Balanced & Elegant Sans-Serif Inter */
h1, .o-heading--1, .s54-hero-title, .c-hero-banner__title {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: clamp(30px, 3.8vw, 44px) !important;
    font-weight: 800 !important;
    line-height: 1.15 !important;
    letter-spacing: -0.025em !important;
}

h2, .o-heading--2,
.c-product-carousel__title,
.c-text-and-image__text-title, .c-text-and-image__title,
.c-featured-video__title,
.c-featured-collections__header-title,
.c-featured-collections__title,
.c-article-feed__title,
.s54-featured-section h2 {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: clamp(22px, 2.8vw, 32px) !important;
    font-weight: 700 !important;
    line-height: 1.25 !important;
    letter-spacing: -0.02em !important;
}

h3, .o-heading--3, .c-featured-collections__tab-title {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: clamp(18px, 2.2vw, 24px) !important;
    font-weight: 600 !important;
    line-height: 1.3 !important;
    letter-spacing: -0.01em !important;
}

/* 2. PRODUCT DETAIL PAGE TYPOGRAPHY (Standard Luxury Scale: 24px-28px, Never 56px, Never Serif) */
.c-product-main__title,
h1.c-product-main__title,
#dynamic-product-title,
.product-detail-title,
.c-page--product h1,
.c-product-main h1 {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: clamp(22px, 2.2vw, 28px) !important;
    line-height: 1.28 !important;
    font-weight: 700 !important;
    letter-spacing: -0.015em !important;
    color: #2F221A !important;
    margin-top: 0 !important;
    margin-bottom: 12px !important;
    text-transform: none !important;
}

/* Product Detail Eyebrow & Badges */
.c-product-main__badges,
.c-product-main__badges .o-badge,
#dynamic-product-badge,
.c-product-vendor {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: 11.5px !important;
    font-weight: 700 !important;
    letter-spacing: 1.2px !important;
    text-transform: uppercase !important;
    color: #8A7B70 !important;
    margin-bottom: 8px !important;
    display: inline-block !important;
}

/* Product Detail Breadcrumb (Clean relative flow, no overlapping image) */
.c-product-main .o-breadcrumbs {
    position: relative !important;
    top: auto !important;
    left: auto !important;
    margin: 0 auto 16px auto !important;
    padding: 16px 20px 0 !important;
    max-width: 1200px !important;
    width: 100% !important;
    box-sizing: border-box !important;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: 12px !important;
    font-weight: 500 !important;
    letter-spacing: 0.02em !important;
    color: #8A7B70 !important;
    z-index: 10 !important;
}

.c-product-main .o-breadcrumbs a {
    color: #8A7B70 !important;
    text-decoration: none !important;
    font-size: 12px !important;
}

.c-product-main .o-breadcrumbs a:hover {
    color: #D68E1D !important;
}

/* Product Detail Short Intro */
.c-product-main__description--intro,
.c-product-main__description p {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: 14px !important;
    line-height: 1.6 !important;
    color: #5A4E46 !important;
    margin-bottom: 16px !important;
}

/* Subtitles & Section Intros */
.c-hero-banner__subtitle,
.c-product-carousel__description p,
.c-text-and-image__text-paragraph p,
.c-article-feed__inner-text p,
.c-featured-video__desc,
.s54-featured-section p {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: 14.5px !important;
    font-weight: 400 !important;
    line-height: 1.6 !important;
    color: #6E6259 !important;
    letter-spacing: -0.005em !important;
}

/* 3. PRODUCT CARD TITLES (Harmonious 14.5px Semibold Inter) */
.s54-product-card h3,
.s54-product-card h3 a,
.o-product-thumbnail h2,
.o-product-thumbnail h2 a,
.o-product-thumbnail h3,
.o-product-thumbnail h3 a,
.o-product-thumbnail__title,
h2.o-product-thumbnail__title,
h3.o-product-thumbnail__title,
.c-product-carousel__product-title,
.c-product-carousel__product-title span {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: 14.5px !important;
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
.o-product-thumbnail h2 a:hover,
.o-product-thumbnail h3 a:hover {
    color: #D68E1D !important;
}

/* Product Card Description */
.s54-product-card p,
.o-product-thumbnail p {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
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
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: 15.5px !important;
    font-weight: 700 !important;
    color: #D68E1D !important;
    letter-spacing: -0.01em !important;
}

/* 4. OTHER STOREFRONT HERO & SECTION TITLES */
.s54-coll-hero__title,
h1.s54-coll-hero__title {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: clamp(28px, 3.2vw, 38px) !important;
    font-weight: 800 !important;
    line-height: 1.2 !important;
}

.s54-page-hero__title,
h1.s54-page-hero__title {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: clamp(28px, 3.5vw, 40px) !important;
    font-weight: 800 !important;
    line-height: 1.2 !important;
}

.s54-cart-main-title,
.s54-checkout-main-title {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: clamp(22px, 2.5vw, 28px) !important;
    font-weight: 700 !important;
}

.s54-checkout-title,
h2.s54-checkout-title {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: 16px !important;
    font-weight: 700 !important;
}

/* Buttons */
.o-btn,
.c-hero-banner__button,
.c-text-and-image__text-button,
.c-product-carousel__button,
.c-article-feed__button,
.s54-product-card button,
.o-product-thumbnail button {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: 12.5px !important;
    font-weight: 600 !important;
    letter-spacing: 0.5px !important;
}

/* Topbar Announcement */
.c-header__topbar-message {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
    font-size: 12px !important;
    font-weight: 500 !important;
    letter-spacing: 0.01em !important;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@stack('styles')
