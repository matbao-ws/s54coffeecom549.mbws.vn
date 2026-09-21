@extends('client.layouts.app')

@php
    $locale = app()->getLocale();
@endphp

@section('title', $locale === 'vi' ? 'S54 COFFEE — Tinh Hoa Cà Phê Việt | New Coffee, New Income' : 'S54 COFFEE — Essence of Vietnamese Coffee | New Coffee, New Income')

@section('content')
<div id="shopify-section-template--15747875471535__hero_banner_d3Tacb" class="shopify-section c-section c-section__hero-banner">

<link href="{{ asset('assets/css/sections.hero-banner.css') }}" rel="stylesheet" type="text/css" media="all" />
<style id="s54-hero-banner-exact-ratio">
  /* S54 Homepage Hero Banner - Rendered Exact 1651 x 600 Ratio (36.3416%) - Zero Cropping */
  .c-section.c-section__hero-banner {
    margin-bottom: 0 !important;
  }
  .c-hero-banner.is-homepage {
    margin: 0 0 2rem 0 !important;
    width: 100% !important;
    position: relative !important;
    display: block !important;
  }
  .c-hero-banner.is-homepage .c-hero-banner__media-container {
    width: 100% !important;
    max-width: 100% !important;
    padding-bottom: calc(600 / 1651 * 100%) !important; /* 36.34161% - exact 1651x600 ratio */
    height: 0 !important;
    min-height: 0 !important;
    max-height: none !important;
    position: relative !important;
    overflow: hidden !important;
  }
  .c-hero-banner.is-homepage .c-hero-banner__media,
  .c-hero-banner.is-homepage img.c-hero-banner__media {
    display: block !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    max-width: 100% !important;
    max-height: 100% !important;
    object-fit: cover !important;
    object-position: center center !important;
  }
  .c-hero-banner.is-homepage .c-hero-banner__container {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    pointer-events: none !important;
  }
</style>
<section class="c-hero-banner is-large is-homepage">
  <div class="c-hero-banner__media-container o-media-container" style="position: relative;">
    @php
      $heroBannerVer = @filemtime(public_path('client-assets/images/s54/hero_banner_s54.png')) 
        ?: (@filemtime(base_path('assets/images/s54/hero_banner_s54.png')) ?: 1789212000);
      $canEditHomeBanner = (bool) (auth()->user()?->canEditClientContent() && auth()->user()->can('media.view'));
    @endphp
    @if($canEditHomeBanner)
        <div style="position: absolute; top: 16px; right: 20px; z-index: 10;">
            <button type="button" class="s54-edit-banner-trigger" data-block-key="home.hero.banner" data-block-type="image" src="{{ asset('assets/images/s54/hero_banner_s54.png') }}" title="{{ $locale === 'vi' ? 'Click để thay đổi ảnh banner Trang Chủ' : 'Click to change Home banner' }}" style="background: rgba(31,41,55,0.9); color: #fff; border: 1px solid rgba(255,255,255,0.3); border-radius: 20px; padding: 6px 14px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; backdrop-filter: blur(4px); box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                <span>📷 {{ $locale === 'vi' ? 'Đổi ảnh banner' : 'Change banner' }}</span>
            </button>
        </div>
    @endif
    <x-client::editable-image key="home.hero.banner" src="{{ asset('assets/images/s54/hero_banner_s54.png') }}?v={{ $heroBannerVer }}" alt="S54 Coffee – Vietnamese Coffee. Made for the World." class="c-hero-banner__media o-media" style="width: 100%; height: 100%; object-fit: cover; object-position: center center;" />

    <div class="c-hero-banner__container">
      <div class="c-hero-banner__overlay" style="opacity: 0; pointer-events: none;">
        <x-client::editable key="home.hero.title" tag="h1" class="c-hero-banner__title o-heading--1">
        {{ $locale === 'vi' ? 'S54 COFFEE – ĐẬM VỊ ĐAM MÊ' : 'Vietnamese Coffee. Made for the World.' }}
      </x-client::editable>
        <x-client::editable key="home.hero.subtitle" tag="p" class="c-hero-banner__subtitle is-size--large">
        {{ $locale === 'vi' ? 'Khám phá hương vị cà phê mộc đậm đà, chuẩn mực quốc tế từ S54 Coffee.' : 'Discover bold Vietnamese coffee, crafted for modern coffee lovers.' }}
      </x-client::editable>
        <a href="{{ route('client.catalog.index', ['locale' => $locale]) }}" class="c-hero-banner__button has-margin-top-small o-btn is-primary is-dark has-arrow">
          {{ $locale === 'vi' ? 'MUA SẮM NGAY' : 'SHOP NOW' }}
          <svg fill="none" class="o-btn__arrow" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd"><path d="m.146118 12c0-.2761.223858-.5.5-.5h22.054082c.2761 0 .5.2239.5.5s-.2239.5-.5.5h-22.054082c-.276142 0-.5-.2239-.5-.5z"/><path d="m17.3776 6.1973c.198-.19257.5145-.18823.7071.00969l5.2973 5.44441c.1888.1941.1888.5033 0 .6974l-5.2973 5.4444c-.1926.1979-.5091.2023-.7071.0097-.1979-.1926-.2022-.5091-.0096-.707l4.958-5.0958-4.958-5.09576c-.1926-.19792-.1883-.51447.0096-.70704z"/></g></svg>
        </a>
      </div>
    </div>
  </div>
</section></div><div id="shopify-section-template--15747875471535__cbd04918-7743-4ff7-926e-4a123fe46195" class="shopify-section c-section c-section__product-carousel">
<link href="assets/css/sections.product-carousel.css" rel="stylesheet" type="text/css" media="all" /><script src="assets/js/sections.product-carousel.js" type="text/javascript" defer="defer"></script><section class="c-product-carousel" data-product-carousel>
  <div class="c-product-carousel__inner">
    <div class="c-product-carousel__header"><x-client::editable key="home.carousel.title" tag="h2" class="c-product-carousel__title o-heading--2">
      <span>{{ $locale === 'vi' ? 'Khám Phá' : 'Discover' }} <em><br/></em>{{ $locale === 'vi' ? 'Dòng Sản Phẩm S54' : 'S54 Coffee Collection' }}</span>
    </x-client::editable><x-client::editable key="home.carousel.desc" tag="div" class="c-product-carousel__description">
      <p>{{ $locale === 'vi' ? '“S54 Coffee – Đổi mới trong từng tách cà phê Việt. Tuyển chọn khắt khe hạt Robusta và Arabica hảo hạng từ Tây Nguyên.”' : '“S54 Coffee – Innovation in every Vietnamese cup. Rigorously selected premium Robusta and Arabica from the Central Highlands.”' }}<br/><strong><br/>Mr. Paul Hieu (CEO) & Tony Hoan (Founder)</strong></p>
    </x-client::editable><a href="{{ route('client.catalog.index', ['locale' => $locale]) }}" 
          class="c-product-carousel__button o-btn is-primary is-dark has-arrow">{{ $locale === 'vi' ? 'Tất Cả Sản Phẩm' : 'All Products' }}<svg fill="none" class="o-btn__arrow c-product-carousel__control-arrow" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd"><path d="m.146118 12c0-.2761.223858-.5.5-.5h22.054082c.2761 0 .5.2239.5.5s-.2239.5-.5.5h-22.054082c-.276142 0-.5-.2239-.5-.5z"/><path d="m17.3776 6.1973c.198-.19257.5145-.18823.7071.00969l5.2973 5.44441c.1888.1941.1888.5033 0 .6974l-5.2973 5.4444c-.1926.1979-.5091.2023-.7071.0097-.1979-.1926-.2022-.5091-.0096-.707l4.958-5.0958-4.958-5.09576c-.1926-.19792-.1883-.51447.0096-.70704z"/></g></svg>
</a></div>
    <div class="c-product-carousel__products" data-carousel>
      {{-- 1. Túi Cà Phê Hòa Tan 456gr --}}
      <a href="{{ route('client.products.show', ['locale' => $locale, 'slug' => 'tui-ca-phe-hoa-tan-3in1-s54-coffee-456g']) }}" class="c-product-carousel__product" data-carousel-tile>
        <div class="c-product-carousel__product-image-container o-media-container">
          <picture>
            <source srcset="{{ asset('assets/images/s54/products/tui_3in1_456g.png') }}, {{ asset('assets/images/s54/products/tui_3in1_456g.png') }} 2x" />
            <img loading="lazy" src="{{ asset('assets/images/s54/products/tui_3in1_456g.png') }}" width="500" alt="{{ $locale === 'vi' ? 'Túi Cà Phê Hòa Tan 456gr' : 'S54 Instant Coffee Bag 456g' }}" class="c-product-carousel__product-image o-media" />
          </picture>
        </div>
        <h6 class="c-product-carousel__product-title o-heading--6">{{ $locale === 'vi' ? 'Túi Cà Phê Hòa Tan 456gr' : 'S54 Instant Coffee Bag 456g' }}</h6>
      </a>

      {{-- 2. Cà Phê Hạt Rang --}}
      <a href="{{ route('client.products.show', ['locale' => $locale, 'slug' => 'ca-phe-hat-rang-robusta-s54-500gr']) }}" class="c-product-carousel__product" data-carousel-tile>
        <div class="c-product-carousel__product-image-container o-media-container">
          <picture>
            <source srcset="{{ asset('assets/images/s54/products/robusta_500g.png') }}, {{ asset('assets/images/s54/products/robusta_500g.png') }} 2x" />
            <img loading="lazy" src="{{ asset('assets/images/s54/products/robusta_500g.png') }}" width="500" alt="{{ $locale === 'vi' ? 'Cà Phê Hạt Rang' : 'Roasted Whole Beans' }}" class="c-product-carousel__product-image o-media" />
          </picture>
        </div>
        <h6 class="c-product-carousel__product-title o-heading--6">{{ $locale === 'vi' ? 'Cà Phê Hạt Rang' : 'Roasted Whole Beans' }}</h6>
      </a>

      {{-- 3. Combo 12 Gói Dùng Thử --}}
      <a href="{{ route('client.products.show', ['locale' => $locale, 'slug' => 'combo-12-goi-ca-phe-hoa-tan-s54-dung-thu']) }}" class="c-product-carousel__product" data-carousel-tile>
        <div class="c-product-carousel__product-image-container o-media-container">
          <picture>
            <source srcset="{{ asset('assets/images/s54/products/combo_12goi_dung_thu.png') }}, {{ asset('assets/images/s54/products/combo_12goi_dung_thu.png') }} 2x" />
            <img loading="lazy" src="{{ asset('assets/images/s54/products/combo_12goi_dung_thu.png') }}" width="500" alt="{{ $locale === 'vi' ? 'Combo 12 Gói Cà Phê Hòa Tan Dùng Thử' : '12-Sachet Trial Pack' }}" class="c-product-carousel__product-image o-media" />
          </picture>
        </div>
        <h6 class="c-product-carousel__product-title o-heading--6">{{ $locale === 'vi' ? 'Combo 12 Gói Cà Phê Hòa Tan Dùng Thử' : '12-Sachet Trial Pack' }}</h6>
      </a>

      {{-- 4. Máy Xay Cà Phê --}}
      <a href="{{ route('client.products.show', ['locale' => $locale, 'slug' => 'may-xay-ca-phe-cam-tay-vbz01-5']) }}" class="c-product-carousel__product" data-carousel-tile>
        <div class="c-product-carousel__product-image-container o-media-container">
          <picture>
            <source srcset="{{ asset('assets/images/s54/products/may_xay_vbz01_5.png') }}, {{ asset('assets/images/s54/products/may_xay_vbz01_5.png') }} 2x" />
            <img loading="lazy" src="{{ asset('assets/images/s54/products/may_xay_vbz01_5.png') }}" width="500" alt="{{ $locale === 'vi' ? 'Máy Xay Cà Phê' : 'Manual Coffee Grinder' }}" class="c-product-carousel__product-image o-media" />
          </picture>
        </div>
        <h6 class="c-product-carousel__product-title o-heading--6">{{ $locale === 'vi' ? 'Máy Xay Cà Phê' : 'Manual Coffee Grinder' }}</h6>
      </a>
    </div>
    <a class="c-product-carousel__control c-product-carousel__control--prev" data-carousel-prev>
      <svg fill="none" class="o-btn__arrow" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd"><path d="m.146118 12c0-.2761.223858-.5.5-.5h22.054082c.2761 0 .5.2239.5.5s-.2239.5-.5.5h-22.054082c-.276142 0-.5-.2239-.5-.5z"/><path d="m17.3776 6.1973c.198-.19257.5145-.18823.7071.00969l5.2973 5.44441c.1888.1941.1888.5033 0 .6974l-5.2973 5.4444c-.1926.1979-.5091.2023-.7071.0097-.1979-.1926-.2022-.5091-.0096-.707l4.958-5.0958-4.958-5.09576c-.1926-.19792-.1883-.51447.0096-.70704z"/></g></svg>
    </a>
    <a class="c-product-carousel__control c-product-carousel__control--next" data-carousel-next>
      <svg fill="none" class="o-btn__arrow" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd"><path d="m.146118 12c0-.2761.223858-.5.5-.5h22.054082c.2761 0 .5.2239.5.5s-.2239.5-.5.5h-22.054082c-.276142 0-.5-.2239-.5-.5z"/><path d="m17.3776 6.1973c.198-.19257.5145-.18823.7071.00969l5.2973 5.44441c.1888.1941.1888.5033 0 .6974l-5.2973 5.4444c-.1926.1979-.5091.2023-.7071.0097-.1979-.1926-.2022-.5091-.0096-.707l4.958-5.0958-4.958-5.09576c-.1926-.19792-.1883-.51447.0096-.70704z"/></g></svg>
    </a>
  </div>
</section><style> #shopify-section-template--15747875471535__cbd04918-7743-4ff7-926e-4a123fe46195 .c-product-carousel {margin-top: 4.5rem;} @media (min-width: 1100px) {#shopify-section-template--15747875471535__cbd04918-7743-4ff7-926e-4a123fe46195 .c-product-carousel {margin-top: 2.5rem; }} </style></div><div id="shopify-section-template--15747875471535__fabf30fe-4c77-4d83-bcc0-ba9c1677001f" class="shopify-section c-section c-section__text-and-image">
<link href="assets/css/sections.text-and-image.css" rel="stylesheet" type="text/css" media="all" />

<section class="c-text-and-image" id="text-and-image">
  <div class="c-text-and-image__media-container o-media-container
    is-rounded
    is-position--left is-mobile-position--left"
  >
    <x-client::editable-image key="home.story.image" src="{{ asset('assets/images/s54/s54_story_blend_intro.png') }}" alt="S54 Coffee – Đổi Mới Trong Từng Tách Cà Phê Việt" class="c-text-and-image__media o-media" style="width: 100%; height: 100%; object-fit: cover;" /></div>
  <div class="c-text-and-image__text-container">
    <div class="c-text-and-image__text-inner"><x-client::editable key="home.story.title" tag="h2" class="c-text-and-image__text-title o-heading--2">
      {{ $locale === 'vi' ? 'S54 Coffee – Đổi Mới Trong Từng Tách Cà Phê Việt' : 'S54 Coffee – Innovation in Every Vietnamese Cup' }}
    </x-client::editable><x-client::editable key="home.story.desc" tag="div" class="c-text-and-image__text-paragraph o-paragraph--1">
      <p>{{ $locale === 'vi' ? 'Tuyển chọn khắt khe những hạt Robusta và Arabica hảo hạng từ thủ phủ Tây Nguyên, S54 Coffee ứng dụng quy trình chế biến hiện đại để giữ trọn hương vị đậm đà, thơm ngon đặc trưng. Với tinh thần "New Coffee, New Income", chúng tôi không chỉ mang đến một tách cà phê tỉnh táo mỗi ngày mà còn truyền nguồn năng lượng tích cực và đồng hành cùng sự phát triển bền vững của cộng đồng.' : 'Rigorously selecting premium Robusta and Arabica beans from the Central Highlands, S54 Coffee applies modern processing techniques to preserve full-bodied, distinctive aroma and taste. Guided by our "New Coffee, New Income" vision, we bring not only an invigorating daily brew but also positive energy and sustainable community empowerment.' }}</p>
    </x-client::editable><div class="c-text-and-image__buttons"><a href="{{ route('client.pages.show', ['locale' => $locale, 'slug' => 'our-story']) }}" 
              class="c-text-and-image__text-button o-btn is-primary has-arrow is-dark">{{ $locale === 'vi' ? 'Về Chúng Tôi' : 'About Us' }}<svg fill="none" class="o-btn__arrow" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd"><path d="m.146118 12c0-.2761.223858-.5.5-.5h22.054082c.2761 0 .5.2239.5.5s-.2239.5-.5.5h-22.054082c-.276142 0-.5-.2239-.5-.5z"/><path d="m17.3776 6.1973c.198-.19257.5145-.18823.7071.00969l5.2973 5.44441c.1888.1941.1888.5033 0 .6974l-5.2973 5.4444c-.1926.1979-.5091.2023-.7071.0097-.1979-.1926-.2022-.5091-.0096-.707l4.958-5.0958-4.958-5.09576c-.1926-.19792-.1883-.51447.0096-.70704z"/></g></svg>
            </a></div></div>
  </div>
</section></div><div id="shopify-section-template--15747875471535__44232c0b-23d6-4254-84bb-0820ac045df1" class="shopify-section c-section c-section__article-feed"><link href="assets/css/sections.article-feed.css" rel="stylesheet" type="text/css" media="all" /><script src="assets/js/sections.article-feed.js" type="text/javascript" defer="defer"></script><section class="c-article-feed" data-article-carousel>
  <div class="c-article-feed__inner">

    <div class="c-article-feed__inner-text"><x-client::editable key="home.articles.title" tag="h2" class="c-article-feed__title o-heading--2">
      {{ $locale === 'vi' ? 'Tin Tức & Blog Mới Nhất' : 'Latest News & Stories' }}
    </x-client::editable><x-client::editable key="home.articles.desc" tag="div" class="c-article c-text-and-image__text-paragraph o-paragraph--1">
      <p>{{ $locale === 'vi' ? 'Cập nhật những tin tức, câu chuyện và kiến thức cà phê mới nhất từ S54 Coffee.' : 'Stay updated with the latest news, stories, and coffee insights from S54 Coffee.' }}</p>
    </x-client::editable><a href="{{ route('client.blog.index', ['locale' => $locale]) }}" 
        class="c-article-feed__button o-btn is-primary is-dark has-arrow is-desktop">{{ $locale === 'vi' ? 'Xem Tất Cả' : 'View All' }}<svg fill="none" class="o-btn__arrow" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd"><path d="m.146118 12c0-.2761.223858-.5.5-.5h22.054082c.2761 0 .5.2239.5.5s-.2239.5-.5.5h-22.054082c-.276142 0-.5-.2239-.5-.5z"/><path d="m17.3776 6.1973c.198-.19257.5145-.18823.7071.00969l5.2973 5.44441c.1888.1941.1888.5033 0 .6974l-5.2973 5.4444c-.1926.1979-.5091.2023-.7071.0097-.1979-.1926-.2022-.5091-.0096-.707l4.958-5.0958-4.958-5.09576c-.1926-.19792-.1883-.51447.0096-.70704z"/></g></svg>
</a></div>

    <div class="c-article-feed__inner-feed" data-carousel>
      {{-- Card 1: Vì Sao Việt Nam Là Cường Quốc Cà Phê? --}}
      <a href="{{ route('client.blog.show', ['locale' => $locale, 'slug' => 'vi-sao-viet-nam-la-cuong-quoc-ca-phe']) }}" class="o-article-tile" data-carousel-tile>
        <div class="o-article-tile__image-wrap">
          <picture>
            <source srcset="{{ asset('assets/images/s54/news/news_1_vi_sao_viet_nam_la_cuong_quoc_ca_phe.png') }}, {{ asset('assets/images/s54/news/news_1_vi_sao_viet_nam_la_cuong_quoc_ca_phe.png') }} 2x" />
            <img loading="lazy" src="{{ asset('assets/images/s54/news/news_1_vi_sao_viet_nam_la_cuong_quoc_ca_phe.png') }}" width="1024" alt="{{ $locale === 'vi' ? 'Vì Sao Việt Nam Là Cường Quốc Cà Phê Thế Giới?' : 'Why is Vietnam a Global Coffee Powerhouse?' }}" class="o-article-tile__image" />
          </picture>
        </div>
        <div class="o-article-tile__detail">
          <div class="o-article-tile__detail-inner">
            <span class="o-article-tile__detail-tag o-subtitle">{{ $locale === 'vi' ? 'Tin Tức' : 'News' }}</span>
            <span><svg fill="none" class="o-article-tile__circle-separator" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6"><circle cx="3" cy="3" r="3" fill="#AC8A62"/></svg></span>
          </div>
          <div class="o-article-tile__detail-separator"></div>
          <h6 class="o-article-tile__detail-title">{{ $locale === 'vi' ? 'Vì Sao Việt Nam Là Cường Quốc Cà Phê Thế Giới?' : 'Why is Vietnam a Global Coffee Powerhouse?' }}</h6>
          <div class="o-article-tile__detail-read-time o-type--1">{{ $locale === 'vi' ? '3 phút đọc' : '3 min read' }}</div>
        </div>
      </a>

      {{-- Card 2: Ý Nghĩa Của Tên Gọi S54 Là Gì? --}}
      <a href="{{ route('client.blog.show', ['locale' => $locale, 'slug' => 'y-nghia-cua-ten-goi-s54-la-gi']) }}" class="o-article-tile" data-carousel-tile>
        <div class="o-article-tile__image-wrap">
          <picture>
            <source srcset="{{ asset('assets/images/s54/news/news_12_y_nghia_cua_ten_goi_s54_la_gi.png') }}, {{ asset('assets/images/s54/news/news_12_y_nghia_cua_ten_goi_s54_la_gi.png') }} 2x" />
            <img loading="lazy" src="{{ asset('assets/images/s54/news/news_12_y_nghia_cua_ten_goi_s54_la_gi.png') }}" width="1024" alt="{{ $locale === 'vi' ? 'Ý Nghĩa Của Tên Gọi S54 Là Gì?' : 'What is the True Meaning Behind the Name S54?' }}" class="o-article-tile__image" />
          </picture>
        </div>
        <div class="o-article-tile__detail">
          <div class="o-article-tile__detail-inner">
            <span class="o-article-tile__detail-tag o-subtitle">{{ $locale === 'vi' ? 'Câu Chuyện S54' : 'S54 Story' }}</span>
            <span><svg fill="none" class="o-article-tile__circle-separator" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6"><circle cx="3" cy="3" r="3" fill="#AC8A62"/></svg></span>
          </div>
          <div class="o-article-tile__detail-separator"></div>
          <h6 class="o-article-tile__detail-title">{{ $locale === 'vi' ? 'Ý Nghĩa Của Tên Gọi S54 Là Gì?' : 'What is the True Meaning Behind the Name S54?' }}</h6>
          <div class="o-article-tile__detail-read-time o-type--1">{{ $locale === 'vi' ? '3 phút đọc' : '3 min read' }}</div>
        </div>
      </a>

      {{-- Card 3: Điều Gì Làm Nên Sự Khác Biệt Của Cà Phê Việt Nam? --}}
      <a href="{{ route('client.blog.show', ['locale' => $locale, 'slug' => 'dieu-gi-lam-nen-su-khac-biet-cua-ca-phe-viet-nam']) }}" class="o-article-tile" data-carousel-tile>
        <div class="o-article-tile__image-wrap">
          <picture>
            <source srcset="{{ asset('assets/images/s54/news/news_2_ieu_gi_lam_nen_su_khac_biet_cua_ca_phe_v.png') }}, {{ asset('assets/images/s54/news/news_2_ieu_gi_lam_nen_su_khac_biet_cua_ca_phe_v.png') }} 2x" />
            <img loading="lazy" src="{{ asset('assets/images/s54/news/news_2_ieu_gi_lam_nen_su_khac_biet_cua_ca_phe_v.png') }}" width="1024" alt="{{ $locale === 'vi' ? 'Điều Gì Làm Nên Sự Khác Biệt Của Cà Phê Việt Nam?' : 'What Makes Vietnamese Coffee Truly Unique?' }}" class="o-article-tile__image" />
          </picture>
        </div>
        <div class="o-article-tile__detail">
          <div class="o-article-tile__detail-inner">
            <span class="o-article-tile__detail-tag o-subtitle">{{ $locale === 'vi' ? 'Kiến Thức Cà Phê' : 'Coffee Knowledge' }}</span>
            <span><svg fill="none" class="o-article-tile__circle-separator" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6"><circle cx="3" cy="3" r="3" fill="#AC8A62"/></svg></span>
          </div>
          <div class="o-article-tile__detail-separator"></div>
          <h6 class="o-article-tile__detail-title">{{ $locale === 'vi' ? 'Điều Gì Làm Nên Sự Khác Biệt Của Cà Phê Việt Nam?' : 'What Makes Vietnamese Coffee Truly Unique?' }}</h6>
          <div class="o-article-tile__detail-read-time o-type--1">{{ $locale === 'vi' ? '3 phút đọc' : '3 min read' }}</div>
        </div>
      </a>

      {{-- Card 4: S54 Coffee Là Ai? --}}
      <a href="{{ route('client.blog.show', ['locale' => $locale, 'slug' => 's54-coffee-la-ai']) }}" class="o-article-tile" data-carousel-tile>
        <div class="o-article-tile__image-wrap">
          <picture>
            <source srcset="{{ asset('assets/images/s54/news/news_11_s54_coffee_la_ai.png') }}, {{ asset('assets/images/s54/news/news_11_s54_coffee_la_ai.png') }} 2x" />
            <img loading="lazy" src="{{ asset('assets/images/s54/news/news_11_s54_coffee_la_ai.png') }}" width="1024" alt="{{ $locale === 'vi' ? 'S54 Coffee Là Ai? Hành Trình Từ Những Hạt Cà Phê Việt' : 'Who is S54 Coffee? The Story of Community-Driven Coffee' }}" class="o-article-tile__image" />
          </picture>
        </div>
        <div class="o-article-tile__detail">
          <div class="o-article-tile__detail-inner">
            <span class="o-article-tile__detail-tag o-subtitle">{{ $locale === 'vi' ? 'Thương Hiệu' : 'Brand' }}</span>
            <span><svg fill="none" class="o-article-tile__circle-separator" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6"><circle cx="3" cy="3" r="3" fill="#AC8A62"/></svg></span>
          </div>
          <div class="o-article-tile__detail-separator"></div>
          <h6 class="o-article-tile__detail-title">{{ $locale === 'vi' ? 'S54 Coffee Là Ai? Hành Trình Hạt Cà Phê Việt' : 'Who is S54 Coffee? The Story of Community-Driven Coffee' }}</h6>
          <div class="o-article-tile__detail-read-time o-type--1">{{ $locale === 'vi' ? '3 phút đọc' : '3 min read' }}</div>
        </div>
      </a>
    </div>

    <div class="c-article-feed__control c-article-feed__control--prev" data-carousel-prev>
      <svg fill="none" class="o-btn__arrow c-article-feed__control-arrow" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd"><path d="m.146118 12c0-.2761.223858-.5.5-.5h22.054082c.2761 0 .5.2239.5.5s-.2239.5-.5.5h-22.054082c-.276142 0-.5-.2239-.5-.5z"/><path d="m17.3776 6.1973c.198-.19257.5145-.18823.7071.00969l5.2973 5.44441c.1888.1941.1888.5033 0 .6974l-5.2973 5.4444c-.1926.1979-.5091.2023-.7071.0097-.1979-.1926-.2022-.5091-.0096-.707l4.958-5.0958-4.958-5.09576c-.1926-.19792-.1883-.51447.0096-.70704z"/></g></svg>
    </div>
    <div class="c-article-feed__control c-article-feed__control--next" data-carousel-next>
      <svg fill="none" class="o-btn__arrow c-article-feed__control-arrow" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd"><path d="m.146118 12c0-.2761.223858-.5.5-.5h22.054082c.2761 0 .5.2239.5.5s-.2239.5-.5.5h-22.054082c-.276142 0-.5-.2239-.5-.5z"/><path d="m17.3776 6.1973c.198-.19257.5145-.18823.7071.00969l5.2973 5.44441c.1888.1941.1888.5033 0 .6974l-5.2973 5.4444c-.1926.1979-.5091.2023-.7071.0097-.1979-.1926-.2022-.5091-.0096-.707l4.958-5.0958-4.958-5.09576c-.1926-.19792-.1883-.51447.0096-.70704z"/></g></svg>
    </div><a href="{{ route('client.blog.index', ['locale' => $locale]) }}" 
      class="c-article-feed__button o-btn is-primary is-dark has-arrow is-mobile">{{ $locale === 'vi' ? 'Xem Tất Cả' : 'View All' }}<svg fill="none" class="o-btn__arrow" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd"><path d="m.146118 12c0-.2761.223858-.5.5-.5h22.054082c.2761 0 .5.2239.5.5s-.2239.5-.5.5h-22.054082c-.276142 0-.5-.2239-.5-.5z"/><path d="m17.3776 6.1973c.198-.19257.5145-.18823.7071.00969l5.2973 5.44441c.1888.1941.1888.5033 0 .6974l-5.2973 5.4444c-.1926.1979-.5091.2023-.7071.0097-.1979-.1926-.2022-.5091-.0096-.707l4.958-5.0958-4.958-5.09576c-.1926-.19792-.1883-.51447.0096-.70704z"/></g></svg>
</a></div>
</section>

</div><div id="shopify-section-template--15747875471535__69efaa66-8022-49b4-a52c-fb59d87d3c72" class="shopify-section c-section c-section__featured-video">
@php
    $homeVideo = app(\App\Services\SiteContentService::class)->video(
        'home.featured.video',
        'assets/media/espresso_brew_desktop.mp4',
        'assets/images/s54/espresso_brewtorial_desktop.jpg'
    );
    $canEdit = (bool) auth()->user()?->canEditClientContent();
@endphp
<link href="assets/css/sections.featured-video.css?v=1789150000" rel="stylesheet" type="text/css" media="all" /><script src="assets/js/sections.featured-video.js?v=1789150000" type="text/javascript" defer="defer"></script><section class="c-featured-video">
  <div class="c-featured-video__wrapper">
    <div
      class="c-featured-video__media-container o-media-container"
      @if($canEdit)
        data-block-key="home.featured.video"
        data-block-type="video"
        data-video-url="{{ $homeVideo['url'] }}"
        data-poster-url="{{ $homeVideo['custom_poster'] ?? '' }}"
        data-default-url="assets/media/espresso_brew_desktop.mp4"
        data-default-poster="assets/images/s54/espresso_brewtorial_desktop.jpg"
        data-video-title="{{ $locale === 'vi' ? 'Video Nghệ Thuật Cà Phê Espresso' : 'Espresso Artistry Video' }}"
        data-is-youtube="{{ $homeVideo['is_youtube'] ? 'true' : 'false' }}"
      @endif
    >
      @if($homeVideo['is_youtube'])
        <div class="c-featured-video__media o-media has-mobile" style="position: absolute; inset: 0; background: url('{{ $homeVideo['poster'] }}') center/cover no-repeat; z-index: 1;"></div>
        <div class="c-featured-video__media o-media is-mobile" style="position: absolute; inset: 0; background: url('{{ $homeVideo['poster'] }}') center/cover no-repeat; z-index: 1;"></div>
        <iframe
          id="home-youtube-iframe"
          data-src="{{ $homeVideo['embed_url'] }}?autoplay=1&rel=0"
          src=""
          title="{{ $locale === 'vi' ? 'Video Nghệ Thuật Cà Phê S54' : 'S54 Coffee Artistry Video' }}"
          style="display: none; position: absolute; inset: 0; width: 100%; height: 100%; border: 0; z-index: 3;"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          allowfullscreen
        ></iframe>
        <button class="o-btn--square is-play c-featured-video__button-play" aria-label="{{ $locale === 'vi' ? 'Phát video' : 'Play video' }}" onclick="var frame=this.parentElement.querySelector('#home-youtube-iframe'); if(frame){ frame.src=frame.dataset.src; frame.style.display='block'; this.parentElement.classList.add('is-playing'); }">
          <svg class="o-btn__play" viewBox="0 0 24 24" width="28" height="28" fill="currentColor" style="display:block!important;margin:0!important;padding:0!important;" xmlns="http://www.w3.org/2000/svg"><path d="M7 5.5a1 1 0 0 1 1.55-.83l10 6.5a1 1 0 0 1 0 1.66l-10 6.5A1 1 0 0 1 7 18.5v-13z"/></svg>
        </button>
      @else
        <video
          playsinline
          loop
          title="Play Video"
          class="c-featured-video__media o-media has-mobile"
          poster="{{ $homeVideo['poster'] }}"
          data-video
        >
          <source src="{{ $homeVideo['url'] }}" type="video/mp4">
        </video>
        <video
          playsinline
          loop
          title="Play Video"
          class="c-featured-video__media o-media is-mobile"
          poster="{{ $homeVideo['poster'] }}"
          data-video
        >
          <source src="{{ $homeVideo['url'] }}" type="video/mp4">
        </video>
        
        <button class="o-btn--square is-play c-featured-video__button-play" data-play aria-label="{{ $locale === 'vi' ? 'Phát video' : 'Play video' }}">
          <svg class="o-btn__play" viewBox="0 0 24 24" width="28" height="28" fill="currentColor" style="display:block!important;margin:0!important;padding:0!important;" xmlns="http://www.w3.org/2000/svg"><path d="M7 5.5a1 1 0 0 1 1.55-.83l10 6.5a1 1 0 0 1 0 1.66l-10 6.5A1 1 0 0 1 7 18.5v-13z"/></svg>
        </button>
      @endif

      <div class="c-featured-video__inner is-color--crema">
        <span class="c-featured-video__tag" style="display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #D68E1D; margin-bottom: 12px;">{{ $locale === 'vi' ? 'Nghệ Thuật Cà Phê S54' : 'Art of S54 Coffee' }}</span>
        <x-client::editable key="home.video.title" tag="h2" class="c-featured-video__title o-heading--2">
          {!! $locale === 'vi' ? 'Nghệ Thuật Chiết Xuất<br/>Tách Espresso Hoàn Hảo' : 'Art of Extraction<br/>The Perfect Espresso Cup' !!}
        </x-client::editable>
        <x-client::editable key="home.video.desc" tag="p" class="c-featured-video__desc">
          {{ $locale === 'vi' ? 'Khám phá phương pháp cân chỉnh nhiệt độ và áp suất để chiết xuất trọn vẹn lớp crema bồng bềnh cùng hương vị tinh tuý từ hạt cà phê S54.' : 'Discover the balance of temperature and pressure to extract a rich crema and refined flavors from S54 coffee beans.' }}
        </x-client::editable>
        <a href="{{ route('client.pages.show', ['locale' => $locale, 'slug' => 'our-story']) }}" class="c-featured-video__button o-btn is-primary is-dark has-arrow">{{ $locale === 'vi' ? 'Khám Phá Câu Chuyện S54' : 'Discover S54 Story' }}<svg fill="none" class="o-btn__arrow c-featured-video__button-arrow" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd"><path d="m.146118 12c0-.2761.223858-.5.5-.5h22.054082c.2761 0 .5.2239.5.5s-.2239.5-.5.5h-22.054082c-.276142 0-.5-.2239-.5-.5z"/><path d="m17.3776 6.1973c.198-.19257.5145-.18823.7071.00969l5.2973 5.44441c.1888.1941.1888.5033 0 .6974l-5.2973 5.4444c-.1926.1979-.5091.2023-.7071.0097-.1979-.1926-.2022-.5091-.0096-.707l4.958-5.0958-4.958-5.09576c-.1926-.19792-.1883-.51447.0096-.70704z"/></g></svg>
        </a>
      </div>
    </div>
  </div>
</section></div><div id="shopify-section-template--15747875471535__ec2a4e76-e99a-4ae6-8df1-9700dce446a2" class="shopify-section c-section c-section__featured-collections">
<link href="assets/css/sections.featured-collections.css" rel="stylesheet" type="text/css" media="all" /><script src="assets/js/sections.featured-collections.js" type="text/javascript" defer="defer"></script><section class="c-featured-collections s54-featured-section" style="background-color: #FAF8F5; padding: 80px 20px;">
  <div class="o-wrapper" style="max-width: 1280px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 40px;">
      <span style="color: #D68E1D; font-size: 12px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 10px;">{{ $locale === 'vi' ? 'DANH MỤC TUYỂN CHỌN' : 'CURATED COLLECTION' }}</span>
      <x-client::editable key="home.products.title" tag="h2" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: clamp(32px, 4.5vw, 48px); font-weight: 700; color: #2F221A; margin: 0 0 16px 0;">
        {{ $locale === 'vi' ? 'Sản Phẩm Bán Chạy Nhất' : 'Best-Selling Products' }}
      </x-client::editable>
      <x-client::editable key="home.products.subtitle" tag="p" style="font-size: 15px; color: #6E6259; max-width: 650px; margin: 0 auto 28px;">
        {{ $locale === 'vi' ? 'Khám phá các dòng cà phê hòa tan 3in1 tiện lợi, cà phê hạt rang Robusta nguyên chất và máy xay cà phê thủ công cao cấp của S54 Coffee.' : 'Discover convenient 3in1 instant coffee, pure roasted Robusta whole beans, and premium manual coffee grinders by S54 Coffee.' }}
      </x-client::editable>
      
      <!-- Filter Tabs -->
      <div class="s54-filter-tabs" style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
        <button type="button" class="s54-filter-btn is-active" onclick="filterS54Prods(this, 'all')" style="background: #2F221A; color: #FFFFFF; border: 1px solid #2F221A; padding: 8px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer;">{{ $locale === 'vi' ? 'Tất Cả Sản Phẩm' : 'All Products' }}</button>
        <button type="button" class="s54-filter-btn" onclick="filterS54Prods(this, 'ca-phe-hoa-tan')" style="background: #FFFFFF; color: #2F221A; border: 1px solid #D8CEBE; padding: 8px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer;">☕ {{ $locale === 'vi' ? 'Cà Phê Hòa Tan 3in1' : 'Instant Coffee 3in1' }}</button>
        <button type="button" class="s54-filter-btn" onclick="filterS54Prods(this, 'ca-phe-hat-rang')" style="background: #FFFFFF; color: #2F221A; border: 1px solid #D8CEBE; padding: 8px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer;">🌱 {{ $locale === 'vi' ? 'Cà Phê Hạt Rang Mộc' : 'Roasted Whole Beans' }}</button>
        <button type="button" class="s54-filter-btn" onclick="filterS54Prods(this, 'may-xay-ca-phe-cam-tay')" style="background: #FFFFFF; color: #2F221A; border: 1px solid #D8CEBE; padding: 8px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer;">⚙️ {{ $locale === 'vi' ? 'Máy Xay Cà Phê Cầm Tay' : 'Manual Coffee Grinders' }}</button>
      </div>
    </div>

    <!-- Product Grid: Unified dynamic cards synchronized with catalog -->
    <div id="s54-home-products-grid" class="o-products-list__products" style="margin-bottom: 48px;">
      @forelse($featuredProducts as $prod)
        <x-client::product-card :product="$prod" />
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #8A7B70;">
          <p style="font-size: 32px;">☕</p>
          <p style="font-size: 16px; font-weight: 600;">{{ $locale === 'vi' ? 'Không tìm thấy sản phẩm phù hợp.' : 'No products found.' }}</p>
        </div>
      @endforelse
    </div>

    <div style="text-align: center;">
      <a href="{{ route('client.catalog.index', ['locale' => $locale]) }}" style="display: inline-flex; align-items: center; gap: 8px; background: #2F221A; color: #FAF6F1; padding: 14px 36px; border-radius: 4px; font-size: 13px; font-weight: 700; text-transform: uppercase; text-decoration: none; letter-spacing: 1px; transition: background 0.2s ease;">
        {{ $locale === 'vi' ? 'XEM TẤT CẢ SẢN PHẨM →' : 'VIEW ALL PRODUCTS →' }}
      </a>
    </div>
  </div>
  
  <script>
  function filterS54Prods(btn, cat) {
    document.querySelectorAll('.s54-filter-btn').forEach(b => {
      b.style.background = '#FFFFFF';
      b.style.color = '#2F221A';
      b.style.borderColor = '#D8CEBE';
    });
    btn.style.background = '#2F221A';
    btn.style.color = '#FFFFFF';
    btn.style.borderColor = '#2F221A';

    const cards = document.querySelectorAll('.s54-product-card');
    cards.forEach(card => {
      const cardCat = card.getAttribute('data-category');
      if (cat === 'all' || cardCat === cat || (cat === 'ca-phe-hat-rang' && (cardCat === 'ca-phe-hat-rang' || cardCat === 'ca-phe-hat'))) {
        card.style.setProperty('display', 'flex', 'important');
      } else {
        card.style.setProperty('display', 'none', 'important');
      }
    });
  }
  </script>
</section><style> #shopify-section-template--15747875471535__ec2a4e76-e99a-4ae6-8df1-9700dce446a2 .o-product-thumbnail__price {font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;} #shopify-section-template--15747875471535__ec2a4e76-e99a-4ae6-8df1-9700dce446a2 .o-product-thumbnail__hover__pricing {font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;} #shopify-section-template--15747875471535__ec2a4e76-e99a-4ae6-8df1-9700dce446a2 .o-subtitle {font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; text-transform: capitalize;} #shopify-section-template--15747875471535__ec2a4e76-e99a-4ae6-8df1-9700dce446a2 .o-swatches__swatch {padding-left: 10px;} </style></div>
@endsection
