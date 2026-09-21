@extends('client.layouts.app')

@section('title', app()->getLocale() === 'vi' ? 'Tại Sao Chọn S54 Cho Giải Pháp Cà Phê Bán Sỉ & Doanh Nghiệp' : 'B2B & Enterprise Coffee Solutions — S54 Coffee')
@section('meta_description', app()->getLocale() === 'vi' ? 'Giải pháp cung ứng cà phê bán sỉ, rang xay theo yêu cầu OEM, thiết bị máy pha chuyên nghiệp và đào tạo barista chuẩn quốc tế từ S54 Coffee.' : 'Wholesale coffee supplier, OEM roasting, commercial espresso equipment and certified barista training from S54 Coffee.')

@section('content')
<wlm class="wlm-content">
		  <div id="shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee" class="shopify-section c-section c-section__hero-banner">

@php
    $canEditBanner = (bool) (auth()->user()?->canEditClientContent() && auth()->user()->can('media.view'));
@endphp
<link href="{{ asset('assets/css/sections.hero-banner.css') }}?v={{ @filemtime(base_path('assets/css/sections.hero-banner.css')) ?: 1789299999 }}" rel="stylesheet" type="text/css" media="all" /><section class="c-hero-banner is-large
    
    ">
      
  <div class="c-hero-banner__media-container o-media-container aa" style="position: relative;">
    @if($canEditBanner)
        <div style="position: absolute; top: 16px; right: 20px; z-index: 10;">
            <button type="button" class="s54-edit-banner-trigger" data-block-key="wholesale.hero.banner" data-block-type="image" src="{{ asset('assets/images/785_1-wholesale-page-banner-desktop-2_2560x.jpg') }}" title="{{ app()->getLocale() === 'vi' ? 'Click để thay đổi ảnh banner trang Bán sỉ & Doanh nghiệp' : 'Click to change Wholesale banner' }}" style="background: rgba(31,41,55,0.9); color: #fff; border: 1px solid rgba(255,255,255,0.3); border-radius: 20px; padding: 6px 14px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; backdrop-filter: blur(4px); box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                <span>📷 {{ app()->getLocale() === 'vi' ? 'Đổi ảnh banner' : 'Change banner' }}</span>
            </button>
        </div>
    @endif
    <div class="c-hero-banner__image_overlay" style="pointer-events: none !important;"></div>
<x-client::editable-image key="wholesale.hero.banner" src="{{ asset('assets/images/785_1-wholesale-page-banner-desktop-2_2560x.jpg') }}" alt="S54 Coffee B2B Wholesale Solutions" class="c-hero-banner__media o-media" style="width: 100%; height: 100%; object-fit: cover;" /><div class="c-hero-banner__overlay is-medium is-vertical-bottom
      s-overlay--left is-colour-default--mobile is-colour-dark--desktop
      
    ">
        <x-client::editable key="wholesale.hero.title" tag="h1" class="c-hero-banner__title o-heading--2">
        {{ app()->getLocale() === 'vi' ? 'Bán Sỉ & Doanh Nghiệp?' : 'Wholesale & Enterprise Solutions' }}
      </x-client::editable>
      
      
        <x-client::editable key="wholesale.hero.subtitle" tag="p" class="c-hero-banner__subtitle o-paragraph--1 is-size--small">
        {{ app()->getLocale() === 'vi' ? 'Chúng tôi không chỉ là nhà cung cấp cà phê, chúng tôi là đối tác chiến lược mang đến giải pháp toàn diện và hỗ trợ vượt trội cho doanh nghiệp của bạn.' : 'We are more than just a coffee supplier, we are a partner that offers unmatched support.' }}
      </x-client::editable>
      
<a href="#contact" class="c-hero-banner__button o-btn is-primary is-dark has-arrow has-no-border"><x-client::editable key="wholesale.hero.button" tag="span">{{ app()->getLocale() === 'vi' ? 'Liên Hệ Hợp Tác B2B' : 'Contact B2B Partnership' }}</x-client::editable><svg fill="none" class="o-btn__arrow" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd"><path d="m.146118 12c0-.2761.223858-.5.5-.5h22.054082c.2761 0 .5.2239.5.5s-.2239.5-.5.5h-22.054082c-.276142 0-.5-.2239-.5-.5z"/><path d="m17.3776 6.1973c.198-.19257.5145-.18823.7071.00969l5.2973 5.44441c.1888.1941.1888.5033 0 .6974l-5.2973 5.4444c-.1926.1979-.5091.2023-.7071.0097-.1979-.1926-.2022-.5091-.0096-.707l4.958-5.0958-4.958-5.09576c-.1926-.19792-.1883-.51447.0096-.70704z"/></g></svg>
        </a></div>
  </div>
</section><style> 
  #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee .c-hero-banner {
    margin: 0 !important;
    position: relative !important;
  }
  #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee .c-hero-banner__media-container {
    padding-bottom: min(48vw, 580px) !important;
    min-height: 500px !important;
    position: relative !important;
  } 
  #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee .c-hero-banner__overlay {
    position: absolute !important;
    top: 50% !important;
    transform: translateY(calc(-50% + 35px)) !important;
    max-width: 48rem !important;
    left: clamp(24px, 6vw, 90px) !important;
    right: auto !important;
    bottom: auto !important;
    margin: 0 !important;
    z-index: 2 !important;
  }
  #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee .c-hero-banner__title,
  #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee h1.c-hero-banner__title {
    margin-top: 0 !important;
    color: #2F221A !important;
    font-size: clamp(30px, 3.4vw, 44px) !important;
    font-weight: 800 !important;
    line-height: 1.2 !important;
    margin-bottom: 16px !important;
    letter-spacing: -0.02em !important;
    text-shadow: none !important;
  }
  #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee .c-hero-banner__subtitle,
  #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee p.c-hero-banner__subtitle {
    color: #332319 !important;
    font-size: clamp(15.5px, 1.3vw, 17.5px) !important;
    font-weight: 500 !important;
    line-height: 1.65 !important;
    max-width: 38rem !important;
    margin-top: 0 !important;
    margin-bottom: 26px !important;
    text-shadow: 0 1px 2px rgba(255, 255, 255, 0.7) !important;
  }
  #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee .c-hero-banner__button {
    margin-top: 0 !important;
    background-color: #2F221A !important;
    color: #FAF6F1 !important;
    padding: 13px 28px !important;
    border-radius: 4px !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    letter-spacing: 0.5px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 10px !important;
    text-decoration: none !important;
    transition: all 0.25s ease !important;
    box-shadow: 0 4px 14px rgba(47, 34, 26, 0.2) !important;
    border: none !important;
  }
  #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee .c-hero-banner__button:hover {
    background-color: #D68E1D !important;
    color: #FFFFFF !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(214, 142, 29, 0.35) !important;
  }
  #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee .c-hero-banner__button svg path {
    fill: #FAF6F1 !important;
    transition: fill 0.25s ease !important;
  }
  #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee .c-hero-banner__button:hover svg path {
    fill: #FFFFFF !important;
  }
  @media (max-width: 767px) {
    #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee .c-hero-banner__media-container {
      padding-bottom: 110% !important;
      min-height: 420px !important;
    }
    #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee .c-hero-banner__overlay {
      top: auto !important;
      bottom: 28px !important;
      transform: none !important;
      left: 18px !important;
      right: 18px !important;
      max-width: calc(100% - 36px) !important;
    }
    #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee .c-hero-banner__title,
    #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee h1.c-hero-banner__title {
      font-size: 26px !important;
      line-height: 1.25 !important;
      margin-bottom: 12px !important;
    }
    #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee .c-hero-banner__subtitle,
    #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee p.c-hero-banner__subtitle {
      font-size: 14.5px !important;
      line-height: 1.55 !important;
      margin-bottom: 18px !important;
    }
    #shopify-section-template--15837242130607__426604da-c2e3-4dda-8755-b11c855308ee .c-hero-banner__button {
      padding: 11px 22px !important;
      font-size: 12px !important;
    }
  }
</style></div><div id="shopify-section-template--15837242130607__text_and_image2_yKDnz9" class="shopify-section c-section__text-and-image2"><link href="{{ asset('assets/css/sections.text-and-image2.css') }}?v={{ @filemtime(base_path('assets/css/sections.text-and-image2.css')) ?: 1789299999 }}" rel="stylesheet" type="text/css" media="all" /><section class="c-text-and-image2"><div class="c-text-and-image2__content is-curve  "
    style="--var-image-mobile-position: 0%;
      --var-content-gap: 6.41025641025641%;
      --var-gutter: 6.4%;"
  >
    <div class="c-text-and-image2__image-wrapper">
      <div class="c-text-and-image2__image-container o-media-container">
<x-client::editable-image key="wholesale.intro.image" src="{{ asset('assets/images/667_LA_V_92_RGB_1_1141x.jpg') }}" alt="Chương Trình Đối Tác & Đại Lý Cà Phê S54" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" /></div>
    </div>

    <div class="c-text-and-image2__text-content">
      <x-client::editable key="wholesale.intro.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Chương Trình Đối Tác & Đại Lý Cà Phê S54' : 'S54 Wholesale Partner & Franchise Program' }}
      </x-client::editable>
      <x-client::editable key="wholesale.intro.desc" tag="div" class="c-text-and-image2__description o-paragraph--1" html>
        <p class="o-paragraph--1">{{ app()->getLocale() === 'vi' ? 'S54 Coffee tự hào cung cấp các dòng cà phê hạt rang mộc nguyên chất và giải pháp pha chế chuyên nghiệp hàng đầu tại Việt Nam.' : 'S54 Coffee proudly delivers premium roasted coffee beans and leading professional brewing solutions across Vietnam.' }}</p>
        <p class="o-paragraph--1">{{ app()->getLocale() === 'vi' ? 'Chương trình đối tác cà phê bán sỉ của chúng tôi được thiết kế nhằm đem lại nhiều hơn một nguồn cung cấp hạt cà phê thượng hạng – đó là sự đồng hành và hỗ trợ toàn diện vượt trội dành cho quý khách hàng.' : 'Our wholesale coffee partner program is designed to offer more than just premium coffee beans – it’s about empowering our partners with unparalleled levels of strategic support.' }}</p>
        <p class="o-paragraph--1">{{ app()->getLocale() === 'vi' ? 'Dù doanh nghiệp của bạn là chuỗi nhà hàng khách sạn cao cấp, quán cà phê độc lập hay văn phòng công ty, S54 Coffee luôn đồng hành mang đến giải pháp tối ưu từ nguồn hạt chất lượng cao, máy pha chuyên nghiệp đến đào tạo barista chuẩn mực.' : 'Whether your business is a luxury hotel restaurant chain, an independent cafe, or a corporate office, S54 Coffee stands beside you with tailored solutions from specialty beans to commercial equipment and barista training.' }}</p>
      </x-client::editable>
    </div>
  </div><div class="c-text-and-image2__content is-box is-reverse"
  style="--var-image-height: 66.66666666666666%;
    --var-image-height-mobile: 66.66666666666666%;
  --var-content-gap: 6.764374295377677%;
  --var-gutter-left: 6.4%;
  --var-gutter-right: 4.9%;
  --var-image-width: 42.05186020293123%;
  "
>
  <div class="c-text-and-image2__image-wrapper">
    <div class="c-text-and-image2__image-container o-media-container">
<x-client::editable-image key="wholesale.coffee.image" src="{{ asset('assets/images/604_3-wholesale-image-our-coffee-3_746x.png') }}" alt="Nguồn Cà Phê Nguyên Chất S54" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" /></div>
  </div>

  <div class="c-text-and-image2__text-content">
    <x-client::editable key="wholesale.coffee.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Nguồn Cà Phê Nguyên Chất S54' : 'Pure Artisan Coffee Sourcing by S54' }}
      </x-client::editable>
    <x-client::editable key="wholesale.coffee.desc" tag="div" class="c-text-and-image2__description o-paragraph--1" html>
        <p class="o-paragraph--1">{{ app()->getLocale() === 'vi' ? 'Tại S54 Coffee, triết lý cốt lõi của chúng tôi là tìm kiếm và tuyển chọn những hạt cà phê Robusta và Arabica hảo hạng nhất từ thủ phủ Tây Nguyên và Cầu Đất - Đà Lạt.' : 'At S54 Coffee, our core philosophy is selecting the finest Robusta and Arabica beans directly from Vietnam\'s renowned Central Highlands and Cau Dat - Da Lat.' }}</p>
        <p class="o-paragraph--1">{{ app()->getLocale() === 'vi' ? 'Hệ thống rang xay công nghệ hiện đại cùng quy trình kiểm soát nhiệt độ nghiêm ngặt giúp từng mẻ cà phê giữ trọn hương vị nguyên bản đặc trưng.' : 'Our modern roasting technology and rigorous temperature profiling ensure every batch retains its distinctive authentic aroma and body.' }}</p>
        <p class="o-paragraph--1">{{ app()->getLocale() === 'vi' ? 'Quy trình kiểm soát chất lượng chuẩn mực phân tích kỹ lưỡng độ ẩm, độ chua, hương thơm và mức độ hòa tan, mang lại sự đồng nhất tuyệt đối cho từng mẻ rang giao tới quý đối tác.' : 'A rigorous quality control process analyzes moisture content, acidity, aroma balance, and extraction yield to guarantee unmatched consistency in every order.' }}</p>
        <p class="o-paragraph--1">{{ app()->getLocale() === 'vi' ? 'Bạn hoàn toàn có thể an tâm gửi trọn niềm tin vào chất lượng cà phê S54.' : 'You can always trust the pure quality of S54 Coffee.' }}</p>
    </x-client::editable>
  </div>
</div></section><style> @media screen and (max-width: 767px) {#shopify-section-template--15837242130607__text_and_image2_yKDnz9 p {font-size: 17px; }} #shopify-section-template--15837242130607__text_and_image2_yKDnz9 p {line-height: normal;} #shopify-section-template--15837242130607__text_and_image2_yKDnz9 p {letter-spacing: 0px;} #shopify-section-template--15837242130607__text_and_image2_yKDnz9 p {font-weight: 500;} </style></div><div id="shopify-section-template--15837242130607__case_studies_MeFkF8" class="shopify-section"><link href="{{ asset('assets/css/sections.case-studies.css') }}?v={{ @filemtime(base_path('assets/css/sections.case-studies.css')) ?: 1789299999 }}" rel="stylesheet" type="text/css" media="all" /><script src="{{ asset('assets/images/773_sections.case-studies.js') }}?v=1789299999" type="text/javascript" defer="defer"></script><section class="c-case-studies" data-case-studies>
    <div class="c-case-studies__content">
      <x-client::editable key="wholesale.partners.title" tag="h2" class="c-case-studies__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Đối Tác Tiêu Biểu' : 'Featured HoReCa & Enterprise Partners' }}
      </x-client::editable>
      <x-client::editable key="wholesale.partners.desc" tag="p" class="c-case-studies__description o-paragraph--1">
        {{ app()->getLocale() === 'vi' ? 'Khám phá câu chuyện hợp tác thành công cùng các đối tác F&B tiêu biểu và giải pháp đồng hành phát triển kinh doanh từ S54 Coffee.' : 'Discover successful case studies and our collaborative efforts to support business growth with S54 Coffee.' }}
      </x-client::editable>
      <a class="c-case-studies__cta o-btn is-primary is-dark" href="{{ route('client.blog.index', ['locale' => app()->getLocale()]) }}" title="{{ app()->getLocale() === 'vi' ? 'Xem thêm' : 'Read more' }}">
        <x-client::editable key="wholesale.partners.cta" tag="span">{{ app()->getLocale() === 'vi' ? 'Xem thêm' : 'Read more' }}</x-client::editable>
        <svg fill="none" class="" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd"><path d="m.146118 12c0-.2761.223858-.5.5-.5h22.054082c.2761 0 .5.2239.5.5s-.2239.5-.5.5h-22.054082c-.276142 0-.5-.2239-.5-.5z"/><path d="m17.3776 6.1973c.198-.19257.5145-.18823.7071.00969l5.2973 5.44441c.1888.1941.1888.5033 0 .6974l-5.2973 5.4444c-.1926.1979-.5091.2023-.7071.0097-.1979-.1926-.2022-.5091-.0096-.707l4.958-5.0958-4.958-5.09576c-.1926-.19792-.1883-.51447.0096-.70704z"/></g></svg>
      </a>
    </div>

    <div class="c-case-studies__articles" data-carousel><div class="c-case-studies__article"><a 
  href="{{ route('client.blog.index', ['locale' => app()->getLocale()]) }}"
  class="o-article-tile"><div class="o-article-tile__image-wrap">
<x-client::editable-image key="wholesale.case1.image" src="{{ asset('assets/images/586_feb206e33c8cb0b0034447b6bcc44c75.jpg') }}" alt="L'Americano Espresso Bar" class="o-article-tile__image" style="width: 100%; height: 100%; object-fit: cover;" /></div>

<div class="o-article-tile__detail">
  <div class="o-article-tile__detail-inner">
      <span class="o-article-tile__detail-tag o-subtitle"><x-client::editable key="wholesale.case1.tag" tag="span">{{ app()->getLocale() === 'vi' ? 'Điểm Nhấn Khách Hàng' : 'customer highlights' }}</x-client::editable></span>
      <span><svg fill="none" class="o-article-tile__circle-separator" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6"><circle cx="3" cy="3" r="3" fill="#AC8A62"/></svg></span>
  </div>
  <div class="o-article-tile__detail-separator"></div>
    <h6 class="o-article-tile__detail-title">
      <x-client::editable key="wholesale.case1.title" tag="span">L'Americano Espresso Bar</x-client::editable>
    </h6>
    <div class="o-article-tile__detail-read-time o-type--1">
      <x-client::editable key="wholesale.case1.readtime" tag="span">{{ app()->getLocale() === 'vi' ? '4 phút đọc' : 'Four minute read' }}</x-client::editable>
    </div>
</div>
</a></div><div class="c-case-studies__article"><a 
  href="{{ route('client.blog.index', ['locale' => app()->getLocale()]) }}"
  class="o-article-tile"><div class="o-article-tile__image-wrap">
<x-client::editable-image key="wholesale.case2.image" src="{{ asset('assets/images/598_50f6f9f3160ce6aa271e4b01d03d3200.jpg') }}" alt="Bobbin Head Bakery" class="o-article-tile__image" style="width: 100%; height: 100%; object-fit: cover;" /></div>

<div class="o-article-tile__detail">
  <div class="o-article-tile__detail-inner">
      <span class="o-article-tile__detail-tag o-subtitle"><x-client::editable key="wholesale.case2.tag" tag="span">{{ app()->getLocale() === 'vi' ? 'Điểm Nhấn Khách Hàng' : 'customer highlights' }}</x-client::editable></span>
      <span><svg fill="none" class="o-article-tile__circle-separator" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6"><circle cx="3" cy="3" r="3" fill="#AC8A62"/></svg></span>
  </div>
  <div class="o-article-tile__detail-separator"></div>
    <h6 class="o-article-tile__detail-title">
      <x-client::editable key="wholesale.case2.title" tag="span">Bobbin Head Bakery</x-client::editable>
    </h6>
    <div class="o-article-tile__detail-read-time o-type--1">
      <x-client::editable key="wholesale.case2.readtime" tag="span">{{ app()->getLocale() === 'vi' ? '3 phút đọc' : 'Three minute read' }}</x-client::editable>
    </div>
</div>
</a></div><div class="c-case-studies__article"><a 
  href="{{ route('client.blog.index', ['locale' => app()->getLocale()]) }}"
  class="o-article-tile"><div class="o-article-tile__image-wrap">
<x-client::editable-image key="wholesale.case3.image" src="{{ asset('assets/images/555_cafe-els-banner_3499b450-717a-4175-a177-9c64e9e9194d_1024x.jpg') }}" alt="ELS Cafe & Bar" class="o-article-tile__image" style="width: 100%; height: 100%; object-fit: cover;" /></div>

<div class="o-article-tile__detail">
  <div class="o-article-tile__detail-inner">
      <span class="o-article-tile__detail-tag o-subtitle"><x-client::editable key="wholesale.case3.tag" tag="span">{{ app()->getLocale() === 'vi' ? 'Điểm Nhấn Khách Hàng' : 'customer highlights' }}</x-client::editable></span>
      <span><svg fill="none" class="o-article-tile__circle-separator" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6"><circle cx="3" cy="3" r="3" fill="#AC8A62"/></svg></span>
  </div>
  <div class="o-article-tile__detail-separator"></div>
    <h6 class="o-article-tile__detail-title">
      <x-client::editable key="wholesale.case3.title" tag="span">ELS Cafe & Bar</x-client::editable>
    </h6>
    <div class="o-article-tile__detail-read-time o-type--1">
      <x-client::editable key="wholesale.case3.readtime" tag="span">{{ app()->getLocale() === 'vi' ? '4 phút đọc' : 'Four minute read' }}</x-client::editable>
    </div>
</div>
</a></div></div>
  </section><style> #shopify-section-template--15837242130607__case_studies_MeFkF8 .c-case-studies {padding-top: 40px;} @media screen and (max-width: 767px) {#shopify-section-template--15837242130607__case_studies_MeFkF8 p {font-size: 17px; }} #shopify-section-template--15837242130607__case_studies_MeFkF8 p {line-height: normal;} #shopify-section-template--15837242130607__case_studies_MeFkF8 p {letter-spacing: 0px;} #shopify-section-template--15837242130607__case_studies_MeFkF8 p {font-weight: 500;} </style></div><div id="shopify-section-template--15837242130607__testimonial_bGPPtH" class="shopify-section c-section__testimonial"><link href="{{ asset('assets/css/sections.testimonial.css') }}?v={{ @filemtime(base_path('assets/css/sections.testimonial.css')) ?: 1789299999 }}" rel="stylesheet" type="text/css" media="all" /><script src="{{ asset('assets/images/732_sections.testimonial.js') }}?v=1789299999" type="text/javascript" defer="defer"></script><section class="c-testimonial" data-testimonials>
    <div class="c-testimonial__inner">
      <x-client::editable key="wholesale.testimonials.title" tag="h2" class="c-testimonial__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Khách Hàng & Đối Tác Nói Gì Về Chúng Tôi' : 'What Our Partners Say About Us' }}
      </x-client::editable>
      
      @php
          $wholesaleVideo = app(\App\Services\SiteContentService::class)->video(
              'wholesale.testimonials.video',
              asset('assets/images/695_1616455d94684594acbf7eb51378dc5c.HD-720p-1.6Mbps-11675358.mp4'),
              asset('assets/images/590_9082be5215a852be1026974487789ffc_2000x.png')
          );
          $canEdit = (bool) auth()->user()?->canEditClientContent();
      @endphp

      <div
          class="c-testimonial__video-container o-media-container"
          @if($canEdit)
              data-block-key="wholesale.testimonials.video"
              data-block-type="video"
              data-video-url="{{ $wholesaleVideo['url'] }}"
              data-poster-url="{{ $wholesaleVideo['custom_poster'] ?? '' }}"
              data-default-url="{{ asset('assets/images/695_1616455d94684594acbf7eb51378dc5c.HD-720p-1.6Mbps-11675358.mp4') }}"
              data-default-poster="{{ asset('assets/images/590_9082be5215a852be1026974487789ffc_2000x.png') }}"
              data-video-title="{{ app()->getLocale() === 'vi' ? 'Video Lời Chứng Thực Khách Hàng / Đối Tác' : 'Customer & Partner Testimonial Video' }}"
              data-is-youtube="{{ $wholesaleVideo['is_youtube'] ? 'true' : 'false' }}"
          @endif
      >
        @if($wholesaleVideo['is_youtube'])
          <div class="c-testimonial__video o-media is-desktop" style="background: url('{{ $wholesaleVideo['poster'] }}') center/cover no-repeat; position: absolute; inset: 0;"></div>
          <div class="c-testimonial__video o-media is-mobile" style="background: url('{{ $wholesaleVideo['poster'] }}') center/cover no-repeat; position: absolute; inset: 0;"></div>
          <iframe
            id="wholesale-youtube-iframe"
            data-src="{{ $wholesaleVideo['embed_url'] }}?autoplay=1&rel=0"
            src=""
            title="{{ app()->getLocale() === 'vi' ? 'Video Đối Tác S54 Coffee' : 'S54 Coffee Partner Video' }}"
            style="display: none; position: absolute; top:0; left:0; width: 100%; height: 100%; border:0; z-index: 3;"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
          ></iframe>
          <button type="button" class="c-testimonial__play-button" aria-label="Play" onclick="var frame=this.parentElement.querySelector('#wholesale-youtube-iframe'); if(frame){ frame.src=frame.dataset.src; frame.style.display='block'; this.closest('.c-testimonial').classList.add('is-playing'); }">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 40 40"><path fill="#AC8A62" d="M30.939 18.024 10.17 5.347a2.236 2.236 0 0 0-2.322-.043 2.279 2.279 0 0 0-1.182 2.005V32.69a2.279 2.279 0 0 0 1.182 2.005 2.236 2.236 0 0 0 2.322-.043L30.94 21.976a2.306 2.306 0 0 0 0-3.952Z"/></svg>
          </button>
        @else
          <video
            playsinline
            loop
            onclick="this.paused ? this.play() : this.pause()"
            title="Play"
            class="c-testimonial__video o-media is-desktop"
            poster="{{ $wholesaleVideo['poster'] }}"
            data-video
          >
            <source src="{{ $wholesaleVideo['url'] }}" type="video/mp4">
          </video>
          <video
            playsinline
            loop
            onclick="this.paused ? this.play() : this.pause()"
            title="Play"
            class="c-testimonial__video o-media is-mobile"
            poster="{{ $wholesaleVideo['poster'] }}"
            data-video
          >
            <source src="{{ $wholesaleVideo['url'] }}" type="video/mp4">
          </video>
          <button type="button" class="c-testimonial__play-button" aria-label="Play" data-play>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 40 40"><path fill="#AC8A62" d="M30.939 18.024 10.17 5.347a2.236 2.236 0 0 0-2.322-.043 2.279 2.279 0 0 0-1.182 2.005V32.69a2.279 2.279 0 0 0 1.182 2.005 2.236 2.236 0 0 0 2.322-.043L30.94 21.976a2.306 2.306 0 0 0 0-3.952Z"/></svg>
          </button>
        @endif
      </div>

      <div class="c-testimonial__carousel"><svg class="c-testimonial__carousel-quote" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 43 32"><path fill="#B1A79B" d="M11.054 31.07c-3.506-.081-6.075-1.427-7.706-4.036C1.717 24.424.9 21.325.9 17.737c0-3.996.897-7.584 2.691-10.765C5.468 3.71 7.874 1.386 10.81 0c1.63 0 2.65 1.06 3.058 3.18-2.528 1.713-4.24 3.344-5.138 4.893-.897 1.468-1.345 3.262-1.345 5.383-.082 2.283.937 3.384 3.058 3.302h1.835c1.875 0 3.384.612 4.525 1.835 1.142 1.224 1.713 2.895 1.713 5.016 0 2.364-.734 4.2-2.202 5.504-1.386 1.305-3.14 1.957-5.26 1.957Zm22.386 0c-3.507-.081-6.076-1.427-7.707-4.036-1.63-2.61-2.446-5.709-2.446-9.297 0-3.996.897-7.584 2.69-10.765C27.855 3.71 30.26 1.386 33.196 0c1.63 0 2.65 1.06 3.058 3.18-2.528 1.713-4.24 3.344-5.138 4.893-.897 1.468-1.345 3.262-1.345 5.383-.082 2.283.938 3.384 3.058 3.302h1.835c1.876 0 3.384.612 4.526 1.835 1.142 1.224 1.712 2.895 1.712 5.016 0 2.364-.734 4.2-2.202 5.504-1.386 1.305-3.14 1.957-5.26 1.957Z"/></svg><div class="c-testimonial__carousel-slides"  data-carousel ><div class="c-testimonial__carousel-slide o-heading--5"><x-client::editable key="wholesale.testimonial.1.quote" tag="p" class="o-heading--5">{{ app()->getLocale() === 'vi' ? 'Đam mê của tôi dành cho món bánh pizza cũng giống như sự đam mê và tận tâm của S54 dành cho từng hạt cà phê.' : 'My passion for gourmet food is exactly the same as S54’s passion for their coffee.' }}</x-client::editable><h6><x-client::editable key="wholesale.testimonial.1.author" tag="span">{{ app()->getLocale() === 'vi' ? 'Johnny — Chuỗi 400 Gradi' : 'Johnny, 400 Gradi' }}</x-client::editable></h6></div><div class="c-testimonial__carousel-slide o-heading--5"><x-client::editable key="wholesale.testimonial.2.quote" tag="p" class="o-heading--5">{{ app()->getLocale() === 'vi' ? 'Khi chúng tôi muốn thử nghiệm menu đồ uống mới mẻ, tôi luôn an tâm vì có đội ngũ chuyên môn S54 hỗ trợ đắc lực.' : 'When we want to do something new and exciting, I always know I have a great support network with S54.' }}</x-client::editable><h6><x-client::editable key="wholesale.testimonial.2.author" tag="span">{{ app()->getLocale() === 'vi' ? 'Shane Delia — Maha' : 'Shane Delia, Maha' }}</x-client::editable></h6></div><div class="c-testimonial__carousel-slide o-heading--5"><x-client::editable key="wholesale.testimonial.3.quote" tag="p" class="o-heading--5">{{ app()->getLocale() === 'vi' ? 'Hương vị đậm đà chuẩn gu người Việt, độ ổn định tuyệt đối giữa các mẻ rang—điều tối quan trọng với chuỗi quán.' : 'It’s got the flair, it’s got the taste and it’s always consistent. That’s very important in our business.' }}</x-client::editable><h6><x-client::editable key="wholesale.testimonial.3.author" tag="span">{{ app()->getLocale() === 'vi' ? 'Serge — Urban Express' : 'Serge, Urban Express' }}</x-client::editable></h6></div><div class="c-testimonial__carousel-slide o-heading--5"><x-client::editable key="wholesale.testimonial.4.quote" tag="p" class="o-heading--5">{{ app()->getLocale() === 'vi' ? 'Chúng tôi khó có thể đạt được mức tăng trưởng doanh thu ấn tượng trong 18 tháng qua nếu không có sự đồng hành của S54.' : 'We wouldn\'t have had the growth we have over the past 18 months without the help of the team.' }}</x-client::editable><h6><x-client::editable key="wholesale.testimonial.4.author" tag="span">{{ app()->getLocale() === 'vi' ? 'Acacia — Đại diện Bobbin Head Bakery' : 'Acacia, Bobbin Head Bakery Owner' }}</x-client::editable></h6></div><div class="c-testimonial__carousel-slide o-heading--5"><x-client::editable key="wholesale.testimonial.5.quote" tag="p" class="o-heading--5">{{ app()->getLocale() === 'vi' ? 'Nói rằng S54 Coffee là một phần không thể thiếu trong sự thành công và mở rộng của quán chúng tôi là hoàn toàn chính xác.' : 'To say that the team at S54 have been an integral part of our growth is a vast understatement.' }}</x-client::editable><h6><x-client::editable key="wholesale.testimonial.5.author" tag="span">{{ app()->getLocale() === 'vi' ? 'Matthew El-Bayeh — Els Cafe & Bar' : 'Matthew El-Bayeh, Els Cafe & Bar' }}</x-client::editable></h6></div></div><button class="c-testimonial__carousel-nav is-prev" aria-label="Previous" data-carousel-prev><svg fill="none"class="" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd"><path d="m23.8535 12c0 .2761-.2238.5-.5.5h-22.05404c-.27614 0-.499999-.2239-.499999-.5s.223859-.5.499999-.5h22.05404c.2762 0 .5.2239.5.5z"/><path d="m6.62211 17.8027c-.19791.1926-.51447.1882-.70704-.0097l-5.297293-5.4444c-.188849-.1941-.188849-.5033 0-.6974l5.297293-5.44443c.19257-.19792.50913-.20225.70704-.00969.19792.19257.20226.50913.00969.70705l-4.95804 5.09577 4.95804 5.0958c.19257.1979.18823.5144-.00969.707z"/></g></svg></button>

          <button class="c-testimonial__carousel-nav is-next" aria-label="Next" data-carousel-next><svg fill="none" class="" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd"><path d="m.146118 12c0-.2761.223858-.5.5-.5h22.054082c.2761 0 .5.2239.5.5s-.2239.5-.5.5h-22.054082c-.276142 0-.5-.2239-.5-.5z"/><path d="m17.3776 6.1973c.198-.19257.5145-.18823.7071.00969l5.2973 5.44441c.1888.1941.1888.5033 0 .6974l-5.2973 5.4444c-.1926.1979-.5091.2023-.7071.0097-.1979-.1926-.2022-.5091-.0096-.707l4.958-5.0958-4.958-5.09576c-.1926-.19792-.1883-.51447.0096-.70704z"/></g></svg></button></div>
    </div>
  </section><style> #shopify-section-template--15837242130607__testimonial_bGPPtH .c-testimonial__carousel {padding-bottom: 10px;} </style></div><div id="shopify-section-template--15837242130607__custom_content2_TrcmMW" class="shopify-section c-section__custom-content2"><link href="{{ asset('assets/css/sections.custom-content2.css') }}?v={{ @filemtime(base_path('assets/css/sections.custom-content2.css')) ?: 1789299999 }}" rel="stylesheet" type="text/css" media="all" /><section class="c-custom-content2">
    <div class="c-custom-content2__contents"><x-client::editable key="wholesale.training.title" tag="h2" class="c-custom-content2__heading o-heading--3"
                style="
                  --var-heading-max-width: 904px;
                  --var-heading-width: 45.2%;
                "
              >{{ app()->getLocale() === 'vi' ? 'Đào Tạo Barista & Chuyển Giao Công Nghệ Pha Chế' : 'Barista Training & Tech Transfer' }}</x-client::editable><x-client::editable key="wholesale.training.p1" tag="div" class="c-custom-content2__paragraph o-paragraph--1"
                style="
                  --var-paragraph-max-width: 762px;
                  --var-paragraph-width: 38.1%;
                "
                html
              ><p class='o-paragraph--1'>{{ app()->getLocale() === 'vi' ? 'Một tách cà phê hoàn hảo là kết quả của sự tỉ mỉ đến từng chi tiết: từ khâu chọn lọc hạt mộc, công thức phối trộn cho đến nghệ thuật rang xay chuẩn xác. Nhưng chính kỹ năng và đam mê của người Barista mới thực sự thổi hồn vào từng ly cà phê.' : 'A truly exceptional cup of coffee is the result of meticulous attention to detail, from bean selection to the art and science of roasting. Yet, it’s the skill and dedication of the barista that truly brings coffee to life.' }}</p></x-client::editable><div class="c-custom-content2__image-container o-media-container">
<x-client::editable-image key="wholesale.training.image" src="{{ asset('assets/images/660_5-wholesale-page-image-barista-training-3_1528x.png') }}" alt="Đào Tạo Barista Chuyên Nghiệp" class="c-custom-content2__image o-media" style="width: 100%; height: auto; object-fit: cover;" /></div><x-client::editable key="wholesale.training.heading2" tag="h2" class="c-custom-content2__heading o-heading--5"
                style="
                  --var-heading-max-width: 904px;
                  --var-heading-width: 45.2%;
                "
              >{{ app()->getLocale() === 'vi' ? 'Chúng tôi hiểu rằng kỹ năng của Barista quyết định trực tiếp đến trải nghiệm và sự trung thành của khách hàng.' : 'We understand that the skill of the barista directly defines customer experience and loyalty.' }}</x-client::editable><x-client::editable key="wholesale.training.p2" tag="div" class="c-custom-content2__paragraph o-paragraph--1"
                style="
                  --var-paragraph-max-width: 904px;
                  --var-paragraph-width: 45.2%;
                "
                html
              ><p class='o-paragraph--1'>{{ app()->getLocale() === 'vi' 
                ? 'Đó là lý do S54 Coffee cung cấp các chương trình đào tạo pha chế toàn diện ngay tại quán của bạn hoặc tại trung tâm trải nghiệm của S54.<br/><br/>Chúng tôi đào tạo kỹ năng chiết xuất espresso, cân chỉnh độ mịn cối xay, kiểm soát nhiệt độ, thời gian chiết xuất và nghệ thuật tạo bọt sữa latte art chuẩn mực.<br/><br/>Đội ngũ của bạn sẽ làm chủ hoàn toàn quy trình pha chế để mang lại những tách cà phê xuất sắc, đồng nhất cho từng khách hàng mỗi ngày.' 
                : 'That’s why we’re committed to providing comprehensive training programs, available on-site or at our dedicated coffee training centres.<br/><br/>We offer barista certification courses, training resources and specialised one-on-one training to all our partners. Your team will go deep into espresso preparation nuances to deliver consistent, exceptional coffee.' }}</p></x-client::editable></div>
  </section><style> @media screen and (max-width: 767px) {#shopify-section-template--15837242130607__custom_content2_TrcmMW p {font-size: 17px; }} #shopify-section-template--15837242130607__custom_content2_TrcmMW p {line-height: normal;} #shopify-section-template--15837242130607__custom_content2_TrcmMW p {letter-spacing: 0px;} #shopify-section-template--15837242130607__custom_content2_TrcmMW p {font-weight: 500;} </style></div><div id="shopify-section-template--15837242130607__text_and_image2_38fDe8" class="shopify-section c-section__text-and-image2"><link href="{{ asset('assets/css/sections.text-and-image2.css') }}?v={{ @filemtime(base_path('assets/css/sections.text-and-image2.css')) ?: 1789299999 }}" rel="stylesheet" type="text/css" media="all" /><section class="c-text-and-image2"><div class="c-text-and-image2__content is-curve is-reverse "
    style="--var-image-mobile-position: 100%;
      --var-content-gap: 6.41025641025641%;
      --var-gutter: 6.4%;"
  >
    <div class="c-text-and-image2__image-wrapper">
      <div class="c-text-and-image2__image-container o-media-container">
<x-client::editable-image key="wholesale.equipment.image" src="{{ asset('assets/images/722_6-wholesale-page-image-equipment_1141x.png') }}" alt="Thiết Bị & Máy Pha Cà Phê Chuyên Nghiệp" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" /></div>
    </div>

    <div class="c-text-and-image2__text-content">
      <x-client::editable key="wholesale.equipment.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Thiết Bị & Máy Pha Cà Phê Chuyên Nghiệp' : 'Commercial Espresso Machines & Equipment' }}
      </x-client::editable><x-client::editable key="wholesale.equipment.desc" tag="div" class="c-text-and-image2__description o-paragraph--1" html><p class="o-paragraph--1">{{ app()->getLocale() === 'vi' 
        ? 'S54 Coffee cung cấp đầy đủ các dòng máy pha và máy xay cà phê thương mại cao cấp từ các thương hiệu nổi tiếng thế giới như Faema, La Marzocco, Nuova Simonelli, Mahlkönig... Máy vận hành bền bỉ, kiểm soát nhiệt độ và áp suất chiết xuất tối ưu. Đội ngũ kỹ thuật viên S54 luôn sẵn sàng bảo trì, bảo dưỡng nhanh chóng 24/7 giúp quán của bạn luôn vận hành thông suốt.<br/>' 
        : 'We supply an extensive range of state-of-the-art coffee equipment from Faema, La Marzocco, Mahlkonig and many more. Our commercial machines hold stable temperatures, keep consistent pressure, supported by technicians available 24/7.<br/>' }}</p></x-client::editable></div>
  </div><div class="c-text-and-image2__content is-box "
  style="--var-image-height: 66.66666666666666%;
    --var-image-height-mobile: 65.4434250764526%;
  --var-content-gap: 10.843373493975903%;
  --var-gutter-left: 6.45%;
  --var-gutter-right: 6.4%;
  --var-image-width: 42.79977051061388%;
  "
>
  <div class="c-text-and-image2__image-wrapper">
    <div class="c-text-and-image2__image-container o-media-container">
<x-client::editable-image key="wholesale.signage.image" src="{{ asset('assets/images/711_7-wholesale-page-image-bespoke-signage_746x.png') }}" alt="Thiết Kế Quầy Bar & Bộ Nhận Diện Thương Hiệu" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" /></div>
  </div>

  <div class="c-text-and-image2__text-content">
    <x-client::editable key="wholesale.signage.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Thiết Kế Quầy Bar & Bộ Nhận Diện Thương Hiệu' : 'Bespoke Bar Design & Brand Identity Signage' }}
      </x-client::editable><x-client::editable key="wholesale.signage.desc" tag="div" class="c-text-and-image2__description o-paragraph--1" html><p class="o-paragraph--1">{{ app()->getLocale() === 'vi' 
        ? 'Thương hiệu S54 Coffee là biểu tượng của tinh hoa cà phê Việt, nhưng chúng tôi hiểu mỗi đối tác đều có phong cách và định vị riêng. Chúng tôi hỗ trợ tư vấn thiết kế quầy bar tối ưu công năng thao tác, cung cấp ấn phẩm nhận diện thương hiệu, bảng hiệu và vật phẩm POSM sang trọng hài hòa với không gian quán của bạn.' 
        : 'The S54 brand is a symbol of coffee excellence, but we know each venue has its own unique style. That’s why we customise our signage to each venue to complement the overall aesthetic with bespoke design solutions.' }}</p></x-client::editable></div>
</div></section><style> @media screen and (max-width: 767px) {#shopify-section-template--15837242130607__text_and_image2_38fDe8 p {font-size: 17px; }} #shopify-section-template--15837242130607__text_and_image2_38fDe8 p {line-height: normal;} #shopify-section-template--15837242130607__text_and_image2_38fDe8 p {letter-spacing: 0px;} #shopify-section-template--15837242130607__text_and_image2_38fDe8 p {font-weight: 500;} </style></div><div id="shopify-section-template--15837242130607__custom_content2_aNydhQ" class="shopify-section c-section__custom-content2"><link href="{{ asset('assets/css/sections.custom-content2.css') }}?v={{ @filemtime(base_path('assets/css/sections.custom-content2.css')) ?: 1789299999 }}" rel="stylesheet" type="text/css" media="all" /><section class="c-custom-content2">
    <div class="c-custom-content2__contents"><x-client::editable key="wholesale.marketing.title" tag="h2" class="c-custom-content2__heading o-heading--3"
                style="
                  --var-heading-max-width: 904px;
                  --var-heading-width: 45.2%;
                "
              >{{ app()->getLocale() === 'vi' ? 'Giải Pháp Marketing & Phát Triển Chuỗi F&B' : 'Marketing Solutions for F&B Businesses' }}</x-client::editable><x-client::editable key="wholesale.marketing.desc" tag="div" class="c-custom-content2__paragraph o-paragraph--1"
                style="
                  --var-paragraph-max-width: 912px;
                  --var-paragraph-width: 45.6%;
                "
                html
              ><p class='o-paragraph--1'>{{ app()->getLocale() === 'vi' 
                ? 'Ngành F&B luôn nhiều cơ hội nhưng cũng đầy thách thức. Một quán cà phê thành công không chỉ dựa vào hạt cà phê ngon, mà còn phụ thuộc vào chiến lược định vị thương hiệu, trải nghiệm khách hàng và phương thức truyền thông hiệu quả.<br/> <br/>S54 Coffee đồng hành cùng bạn với vai trò một đơn vị tư vấn giải pháp toàn diện: từ định hướng concept quán, phát triển menu thức uống theo xu hướng, đến kế hoạch truyền thông khai trương thu hút khách hàng.<br/><br/>Chúng tôi giúp bạn tối ưu chi phí vận hành và xây dựng tập khách hàng trung thành ngay từ ngày đầu hoạt động.' 
                : 'Operating in F&B is competitive and demanding. Business success hinges not just on great coffee beans, but on strategic brand positioning, memorable customer experiences, and impactful marketing.<br/> <br/>S54 Coffee collaborates with your business as a comprehensive strategic advisor: from concept ideation and trendy beverage menu development to launch marketing campaigns.<br/><br/>We help you optimize operational efficiency and cultivate a loyal customer base from day one.' }}</p></x-client::editable><div class="c-custom-content2__four-column-images"><div class="c-custom-content2__image-container o-media-container">
<x-client::editable-image key="wholesale.marketing.img1" src="{{ asset('assets/images/675_31b815765f2a5ae0f271cfe5c81376c8_601x.png') }}" alt="Marketing F&B" class="c-custom-content2__image o-media" style="width: 100%; height: auto;" /></div><div class="c-custom-content2__image-container o-media-container">
<x-client::editable-image key="wholesale.marketing.img2" src="{{ asset('assets/images/634_ec3348801f419324b007358ae6a705ec_374x.png') }}" alt="Marketing F&B" class="c-custom-content2__image o-media" style="width: 100%; height: auto;" /></div><div class="c-custom-content2__image-container o-media-container">
<x-client::editable-image key="wholesale.marketing.img3" src="{{ asset('assets/images/729_LL-VITTORIA-CAFES-13_601x.jpg') }}" alt="Marketing F&B" class="c-custom-content2__image o-media" style="width: 100%; height: auto;" /></div><div class="c-custom-content2__image-container o-media-container">
<x-client::editable-image key="wholesale.marketing.img4" src="{{ asset('assets/images/754_450738cd7d6780bf6a0c9ddcd4bb3487_374x.png') }}" alt="Marketing F&B" class="c-custom-content2__image o-media" style="width: 100%; height: auto;" /></div></div><x-client::editable key="wholesale.marketing.support_title" tag="h2" class="c-custom-content2__heading o-heading--5"
                style="
                  --var-heading-max-width: 1017px;
                  --var-heading-width: 50.85%;
                "
              ><center>{{ app()->getLocale() === 'vi' 
                ? 'S54 Coffee và Good Solutions không chỉ là nhà cung ứng hạt cà phê. Chúng tôi là người bạn đồng hành chiến lược, mang đến giải pháp toàn diện giúp quán cà phê và doanh nghiệp của bạn tăng trưởng bền vững.' 
                : 'S54 Coffee & Good Solutions are more than suppliers. We are strategic partners providing end-to-end solutions for sustainable business growth.' }}</center></x-client::editable><ul class="c-custom-content2__list"><li class="c-custom-content2__list-item"><x-client::editable key="wholesale.marketing.list1" tag="span">{{ app()->getLocale() === 'vi' ? 'Truyền Thông & Quảng Cáo' : 'Advertising' }}</x-client::editable></li><li class="c-custom-content2__list-item"><x-client::editable key="wholesale.marketing.list2" tag="span">{{ app()->getLocale() === 'vi' ? 'Thiết Kế & Thi Công Không Gian' : 'Shop Fit Outs' }}</x-client::editable></li><li class="c-custom-content2__list-item"><x-client::editable key="wholesale.marketing.list3" tag="span">{{ app()->getLocale() === 'vi' ? 'Quy Trình Vận Hành Quầy Bar' : 'Service Flow' }}</x-client::editable></li><li class="c-custom-content2__list-item"><x-client::editable key="wholesale.marketing.list4" tag="span">{{ app()->getLocale() === 'vi' ? 'Tối Ưu Nhân Sự & Đào Tạo' : 'Labour & Training' }}</x-client::editable></li><li class="c-custom-content2__list-item"><x-client::editable key="wholesale.marketing.list5" tag="span">{{ app()->getLocale() === 'vi' ? 'Menu Pha Chế & Công Thức Độc Quyền' : 'Signature Menu' }}</x-client::editable></li><li class="c-custom-content2__list-item"><x-client::editable key="wholesale.marketing.list6" tag="span">{{ app()->getLocale() === 'vi' ? 'Thiết Bị & Máy Pha Cà Phê Chuyên Nghiệp' : 'Commercial Equipment' }}</x-client::editable></li><li class="c-custom-content2__list-item"><x-client::editable key="wholesale.marketing.list7" tag="span">{{ app()->getLocale() === 'vi' ? 'Bộ Nhận Diện Thương Hiệu POSM' : 'Publicity & POSM' }}</x-client::editable></li><li class="c-custom-content2__list-item"><x-client::editable key="wholesale.marketing.list8" tag="span">{{ app()->getLocale() === 'vi' ? 'Sự Kiện & Tài Trợ Đồng Hành' : 'Events & Sponsorships' }}</x-client::editable></li></ul></div>
  </section><style> @media screen and (max-width: 767px) {#shopify-section-template--15837242130607__custom_content2_aNydhQ p {font-size: 17px; }} #shopify-section-template--15837242130607__custom_content2_aNydhQ p {line-height: normal;} #shopify-section-template--15837242130607__custom_content2_aNydhQ p {letter-spacing: 0px;} #shopify-section-template--15837242130607__custom_content2_aNydhQ p {font-weight: 500;} </style></div><div id="shopify-section-template--15837242130607__text_and_image2_BbQmzn" class="shopify-section c-section__text-and-image2"><link href="{{ asset('assets/css/sections.text-and-image2.css') }}?v={{ @filemtime(base_path('assets/css/sections.text-and-image2.css')) ?: 1789299999 }}" rel="stylesheet" type="text/css" media="all" /><section class="c-text-and-image2"><div class="c-text-and-image2__content is-box "
  style="--var-image-height: 66.66666666666666%;
    --var-image-height-mobile: 66.66666666666666%;
  --var-content-gap: 7.224770642201835%;
  --var-gutter-left: 6.4%;
  --var-gutter-right: 6.4%;
  --var-image-width: 42.77522935779817%;
  "
>
  <div class="c-text-and-image2__image-wrapper">
    <div class="c-text-and-image2__image-container o-media-container">
<x-client::editable-image key="wholesale.community.image" src="{{ asset('assets/images/643_9-wholesale-page-image-community-brand-2_746x.png') }}" alt="Thương Hiệu Vì Cộng Đồng & Nông Dân Việt" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" /></div>
  </div>

  <div class="c-text-and-image2__text-content">
    <x-client::editable key="wholesale.community.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Thương Hiệu Vì Cộng Đồng & Nông Dân Việt' : 'Community Brand & Vietnamese Coffee Farmers' }}
      </x-client::editable><x-client::editable key="wholesale.community.desc" tag="div" class="c-text-and-image2__description o-paragraph--1" html><p class="o-paragraph--1">{{ app()->getLocale() === 'vi' 
        ? 'S54 Coffee gắn liền với thông điệp "New Coffee, New Income" – nâng tầm hạt cà phê Việt và cải thiện sinh kế cho bà con nông dân vùng trồng Tây Nguyên. Chúng tôi cam kết bao tiêu nông sản đạt chuẩn, hỗ trợ kỹ thuật canh tác bền vững và tham gia các hoạt động thiện nguyện, lan tỏa giá trị nhân văn của hạt cà phê Việt tới mọi miền đất nước và vươn ra thế giới.' 
        : 'S54 Coffee is rooted in the "New Coffee, New Income" mission – elevating Vietnamese coffee quality while improving farmers\' livelihoods in the Central Highlands. We commit to sustainable fair-trade sourcing and active community development to spread the pride of Vietnamese coffee globally.' }}</p></x-client::editable></div>
</div><div class="c-text-and-image2__content is-curve is-reverse "
    style="--var-image-mobile-position: 100%;
      --var-content-gap: 6.303418803418803%;
      --var-gutter: 6.4%;"
  >
    <div class="c-text-and-image2__image-wrapper">
      <div class="c-text-and-image2__image-container o-media-container">
<x-client::editable-image key="wholesale.family.image" src="{{ asset('assets/images/712_10-wholesale-page-image-family-business_1141x.png') }}" alt="Doanh Nghiệp Uy Tín & Cam Kết Dài Lâu" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" /></div>
    </div>

    <div class="c-text-and-image2__text-content">
      <x-client::editable key="wholesale.family.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Doanh Nghiệp Uy Tín & Cam Kết Dài Lâu' : 'Trusted Enterprise & Long-term Partnership' }}
      </x-client::editable>
      <x-client::editable key="wholesale.family.desc" tag="div" class="c-text-and-image2__description o-paragraph--1" html>
        <p class="o-paragraph--1">{{ app()->getLocale() === 'vi' 
          ? 'Với triết lý \'Tinh Hoa Cà Phê Việt\', chúng tôi kiên định với sứ mệnh bảo tồn và nâng tầm giá trị hạt cà phê Robusta & Arabica nguyên bản của Việt Nam, xây dựng mối quan hệ đối tác bền vững và minh bạch.' 
          : 'With the philosophy of \'Essence of Vietnamese Coffee\', we stay steadfast in our mission to preserve and elevate authentic Vietnamese Robusta & Arabica, fostering sustainable and transparent partnerships.' }}</p>
        <p class="o-paragraph--1">{{ app()->getLocale() === 'vi' 
          ? 'Là một doanh nghiệp tận tâm và luôn hướng tới sự chuyên nghiệp dài lâu, S54 Coffee tự hào có đủ năng lực cung ứng sản lượng lớn, ổn định cho chuỗi quán cà phê, khách sạn và các đối tác thương mại lớn.' 
          : 'With solid enterprise capability, S54 Coffee reliably supplies large volume orders for cafe chains, luxury hotels, and corporate enterprises.' }}</p>
        <p class="o-paragraph--1">{{ app()->getLocale() === 'vi' 
          ? 'Rất hân hạnh được đồng hành và hợp tác cùng Quý đối tác.' 
          : 'We look forward to forging a long-lasting partnership with your enterprise.' }}</p>
      </x-client::editable>
    </div>
  </div></section><style> @media screen and (max-width: 767px) {#shopify-section-template--15837242130607__text_and_image2_BbQmzn p {font-size: 17px; }} #shopify-section-template--15837242130607__text_and_image2_BbQmzn p {line-height: normal;} #shopify-section-template--15837242130607__text_and_image2_BbQmzn p {letter-spacing: 0px;} #shopify-section-template--15837242130607__text_and_image2_BbQmzn p {font-weight: 500;} </style></div><div id="shopify-section-template--15837242130607__contact_form_gGc7Va" class="shopify-section c-section c-section__contact"><link href="{{ asset('assets/css/sections.contact-form.css') }}?v={{ @filemtime(base_path('assets/css/sections.contact-form.css')) ?: 1789299999 }}" rel="stylesheet" type="text/css" media="all" /><script src="{{ asset('assets/images/605_sections.contact-form.js') }}?v=1789299999" type="text/javascript" defer="defer"></script><section class="c-contact">
  <div class="c-contact__media-container o-media-container">
<x-client::editable-image key="wholesale.contact.banner" src="{{ asset('assets/images/747_11-wholesale-page-image-get-in-touch_1650x.jpg') }}" alt="Liên Hệ Hợp Tác S54 Coffee" class="c-contact__media o-media" style="width: 100%; height: 100%; object-fit: cover;" /></div>
  <div class="c-contact__form-container">
    <div class="c-contact__form-inner">
      <x-client::editable key="wholesale.contact.title" tag="h3" class="o-heading--3 c-contact__form-title">
        {{ app()->getLocale() === 'vi' ? 'Liên Hệ Hợp Tác Ngay Hôm Nay' : 'Get in Touch with S54 Today' }}
      </x-client::editable>
      <x-client::editable key="wholesale.contact.subtitle" tag="p" class="o-type--1 c-contact__form-subtitle">
        {{ app()->getLocale() === 'vi' ? 'Vui lòng chia sẻ thông tin nhu cầu của bạn, đội ngũ chuyên viên S54 Coffee sẽ liên hệ tư vấn trong thời gian sớm nhất.' : 'Share some details and our S54 specialists will be in touch promptly.' }}
      </x-client::editable>
<form method="post" action="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'wholesale']) }}#contact" id="contact" accept-charset="UTF-8" class="c-contact__form">
      @csrf<input type="hidden" name="form_type" value="contact" /><input type="hidden" name="utf8" value="✓" /><div class="c-contact__form-content">
      
      <div class="c-contact__form-input-group">
        <div style="display: none">
        <label class="c-contact__form-label" for="contact-method">{{ app()->getLocale() === 'vi' ? 'Phương thức liên hệ ưu tiên?' : 'How would you prefer to be contacted?' }}</label>
        <input type="checkbox" name="contact[contact_method_email]" id="email"><label for="email">Email</label>
        <input type="checkbox" name="contact[contact_method_phone]" id="phone"><label for="phone">{{ app()->getLocale() === 'vi' ? 'Số Điện Thoại' : 'Phone' }}</label>
      </div>
      <div class="c-contact__form-input-group">
        <input
          class="c-contact__form-input o-input"
          name="contact[email]"
          placeholder="{{ app()->getLocale() === 'vi' ? 'Email *' : 'Email *' }}"
          required
          type="email"
          value=""
        >
          <input
            class="c-contact__form-input o-input"
            name="contact[phone]"
            placeholder="{{ app()->getLocale() === 'vi' ? 'Số Điện Thoại *' : 'Phone Number *' }}"
            type="text"
            value=""
            required
          >
          <input
            class="c-contact__form-input o-input"
            name="contact[full-name]"
            placeholder="{{ app()->getLocale() === 'vi' ? 'Họ và Tên *' : 'Full Name *' }}"
            type="text"
            value=""
            required
          >
          <input
            class="c-contact__form-input o-input"
            name="contact[business-name]"
            placeholder="{{ app()->getLocale() === 'vi' ? 'Tên Doanh Nghiệp / Chuỗi Quán *' : 'Business / Cafe Name *' }}"
            type="text"
            value=""
            required
          >
          <input
            class="c-contact__form-input o-input"
            name="contact[enquiry]"
            placeholder="{{ app()->getLocale() === 'vi' ? 'Nhu cầu hợp tác (Số lượng hạt, máy pha, nhượng quyền...)' : 'Your Inquiry (Volume, machines, partnership...)' }}"
            type="text"
            value=""
            required
          >
      </div>
        <div class="c-contact__form-input-group contact-day">
          <label class="c-contact__form-label" for="contact-day">{{ app()->getLocale() === 'vi' ? 'Ngày thuận tiện nhất để liên hệ với bạn?' : 'What are the best days to contact you?' }}</label>
          <input type="checkbox" name="contact[contact_day_monday]" id="monday"><label for="monday">{{ app()->getLocale() === 'vi' ? 'T2' : 'Mon' }}</label>
          <input type="checkbox" name="contact[contact_day_tuesday]" id="tuesday"><label for="tuesday">{{ app()->getLocale() === 'vi' ? 'T3' : 'Tue' }}</label>
          <input type="checkbox" name="contact[contact_day_wednesday]" id="wednesday"><label for="wednesday">{{ app()->getLocale() === 'vi' ? 'T4' : 'Wed' }}</label>
          <input type="checkbox" name="contact[contact_day_thursday]" id="thursday"><label for="thursday">{{ app()->getLocale() === 'vi' ? 'T5' : 'Thu' }}</label>
          <input type="checkbox" name="contact[contact_day_friday]" id="friday"><label for="friday">{{ app()->getLocale() === 'vi' ? 'T6' : 'Fri' }}</label>
          <input type="checkbox" name="contact[contact_day_saturday]" id="saturday"><label for="saturday">{{ app()->getLocale() === 'vi' ? 'T7' : 'Sat' }}</label>
          <input type="checkbox" name="contact[contact_day_sunday]" id="sunday"><label for="sunday">{{ app()->getLocale() === 'vi' ? 'CN' : 'Sun' }}</label>
        </div>

        <div class="c-contact__form-input-group contact-time">
          <label class="c-contact__form-label" for="contact-time">{{ app()->getLocale() === 'vi' ? 'Khung giờ thuận tiện nhất để trao đổi?' : 'What is the best time to contact you?' }}</label>
          <label class="c-contact__form-label c-contact__form-label--inline" for="contact-time_start">{{ app()->getLocale() === 'vi' ? 'Từ' : 'Between' }}</label>
          <input class="c-contact__form-pill" type="time" name="contact[contact_time_start]" value="09:00" id="contact-time_start" />
          <label class="c-contact__form-label c-contact__form-label--inline" for="contact-time_end">{{ app()->getLocale() === 'vi' ? 'Đến' : 'and' }}</label>
          <input class="c-contact__form-pill" type="time" name="contact[contact_time_end]" value="17:00" id="contact-time_end" />
        </div>

        <div style="margin-top: 24px;">
          <button type="submit" class="c-contact__button o-btn is-primary is-dark" style="border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
            <x-client::editable key="wholesale.contact.btn" tag="span">{{ app()->getLocale() === 'vi' ? 'Gửi Thông Tin Hợp Tác' : 'Submit Wholesale Inquiry' }}</x-client::editable>
          </button>
        </div>

    </div>
  
</form></div>
  </div>

</section><style> #shopify-section-template--15837242130607__contact_form_gGc7Va .c-contact__form-input { display: block; } #shopify-section-template--15837242130607__contact_form_gGc7Va .c-contact__form-label { display: block; } #shopify-section-template--15837242130607__contact_form_gGc7Va .c-contact__form-pill { display: inline-block; } #shopify-section-template--15837242130607__contact_form_gGc7Va .c-contact__form-label--inline { display: inline-block; } #shopify-section-template--15837242130607__contact_form_gGc7Va .contact-day { display: block; } </style></div>
		</wlm>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const wholesaleForm = document.getElementById('contact');
    if (wholesaleForm) {
        wholesaleForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = wholesaleForm.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.style.opacity = '0.7';
            }
            const fd = new FormData(wholesaleForm);
            const payload = {
                name: fd.get('contact[full-name]'),
                phone: fd.get('contact[phone]'),
                email: fd.get('contact[email]') || '',
                service_type: '{{ app()->getLocale() === "vi" ? "Hợp tác đại lý / Bán sỉ B2B" : "Wholesale & B2B Inquiry" }}',
                message: (fd.get('contact[business-name]') ? '{{ app()->getLocale() === "vi" ? "Doanh nghiệp: " : "Business: " }}' + fd.get('contact[business-name]') + '. ' : '') + (fd.get('contact[enquiry]') || ''),
            };
            fetch('/api/public/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message || '{{ app()->getLocale() === "vi" ? "Cảm ơn bạn! Thông tin hợp tác đã được gửi thành công. Chuyên viên S54 sẽ liên hệ lại sớm nhất." : "Thank you! Your inquiry has been submitted successfully." }}');
                wholesaleForm.reset();
                if (btn) {
                    btn.disabled = false;
                    btn.style.opacity = '1';
                }
            })
            .catch(() => {
                alert('{{ app()->getLocale() === "vi" ? "Cảm ơn bạn! Thông tin hợp tác đã được gửi thành công. Chuyên viên S54 sẽ liên hệ lại sớm nhất." : "Thank you! Your inquiry has been submitted successfully." }}');
                wholesaleForm.reset();
                if (btn) {
                    btn.disabled = false;
                    btn.style.opacity = '1';
                }
            });
        });
    }
});
</script>
@endsection
