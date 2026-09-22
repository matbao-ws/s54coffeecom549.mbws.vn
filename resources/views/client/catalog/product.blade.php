@extends('client.layouts.app')

@php
    $locale = app()->getLocale();
    $title = is_array($product->name) ? ($product->name[$locale] ?? $product->name['vi'] ?? '') : ($product->getTranslation('name', $locale, false) ?: $product->name);
    $shortDesc = is_array($product->short_description) ? ($product->short_description[$locale] ?? $product->short_description['vi'] ?? '') : ($product->getTranslation('short_description', $locale, false) ?: $product->short_description);
    $desc = is_array($product->description) ? ($product->description[$locale] ?? $product->description['vi'] ?? '') : ($product->getTranslation('description', $locale, false) ?: $product->description);
    
    $minPrice = $product->variants->where('is_active', true)->min('price') ?? $product->price ?? 145000;
    $defaultVariant = $product->variants->where('is_active', true)->first();
    
    $images = $product->images;
    if ($images->isEmpty()) {
        $imgUrl = $product->image_url ?: 'client-assets/images/s54/robusta_1.jpg';
        $images = collect([(object)['image_url' => $imgUrl]]);
    }
    
    $galleryUrls = [];
    foreach ($images as $img) {
        $u = $img->image_url;
        if (!str_starts_with($u, 'http') && !str_starts_with($u, 'client-assets') && !str_starts_with($u, 'assets') && !str_starts_with($u, 'storage') && !str_starts_with($u, '/storage')) {
            $u = asset('client-assets/' . ltrim($u, '/'));
        } elseif (!str_starts_with($u, 'http')) {
            $u = asset(ltrim($u, '/'));
        }
        $galleryUrls[] = $u;
    }
    if (count($galleryUrls) === 1) {
        $titleLower = mb_strtolower($title);
        if (str_contains($titleLower, 'hòa tan') || str_contains($titleLower, 'instant') || str_contains($titleLower, 'combo')) {
            $galleryUrls[] = asset('client-assets/images/s54/instant_3in1_1.jpg');
            $galleryUrls[] = asset('client-assets/images/s54/instant_3in1_2.jpg');
            $galleryUrls[] = asset('client-assets/images/s54/instant_3in1_3.jpg');
            $galleryUrls[] = asset('client-assets/images/s54/instant_3in1_4.jpg');
        } elseif (str_contains($titleLower, 'máy xay') || str_contains($titleLower, 'grinder')) {
            $galleryUrls[] = asset('client-assets/images/s54/products/may_xay_vbz01_5.jpg');
            $galleryUrls[] = asset('client-assets/images/s54/products/may_xay_vbz08_5.jpg');
            $galleryUrls[] = asset('client-assets/images/s54/products/may_xay_vbz03_5.jpg');
        } else {
            $galleryUrls[] = asset('client-assets/images/s54/robusta_1.jpg');
            $galleryUrls[] = asset('client-assets/images/s54/robusta_2.jpg');
            $galleryUrls[] = asset('client-assets/images/s54/robusta_3.jpg');
        }
    }
    $firstImg = $galleryUrls[0];

    // ── Intelligent Short Description & Dynamic Highlights Engine ──
    $customHighlights = [];
    $cleanShortDescLines = [];
    if (!empty($shortDesc)) {
        $lines = preg_split('/(\r\n|\r|\n)/', (string) $shortDesc);
        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (empty($trimmed)) continue;
            if (preg_match('/^[✓•\-\*]\s*(.+)$/u', $trimmed, $m)) {
                $customHighlights[] = $m[1];
            } else {
                $cleanShortDescLines[] = $trimmed;
            }
        }
    }
    $displayShortDesc = !empty($cleanShortDescLines) ? implode("\n", $cleanShortDescLines) : (!empty($customHighlights) ? '' : (string) $shortDesc);
    if (empty($displayShortDesc) && empty($customHighlights) && !empty($desc)) {
        $displayShortDesc = Str::limit(strip_tags($desc), 250);
    }

    $catName = mb_strtolower($product->category ? ($product->category->getTranslation('name', $locale, false) ?: $product->category->name) : '');
    $catSlug = mb_strtolower($product->category?->slug ?? '');
    $titleLower = mb_strtolower($title);
    $descLower = mb_strtolower(strip_tags($desc . ' ' . $shortDesc));

    $isGrinder = str_contains($catSlug, 'may-xay') || str_contains($catSlug, 'grinder') || str_contains($catName, 'máy xay') || str_contains($titleLower, 'máy xay') || str_contains($titleLower, 'grinder') || str_contains($titleLower, 'kmdj') || str_contains($titleLower, 'vbz') || str_contains($titleLower, 'vbs');
    $isInstant = str_contains($catSlug, 'hoa-tan') || str_contains($catSlug, 'instant') || str_contains($catName, 'hòa tan') || str_contains($titleLower, 'hòa tan') || str_contains($titleLower, 'instant') || str_contains($titleLower, '3in1');
    $isCoffeeBeans = !$isGrinder && !$isInstant;

    if (count($customHighlights) >= 2) {
        $highlights = $customHighlights;
    } elseif ($isGrinder) {
        $burr = str_contains($descLower, 'gốm') || str_contains($descLower, 'ceramic') || str_contains($titleLower, 'kmdj')
            ? ($locale === 'vi' ? 'Lõi xay gốm Ceramic cao cấp không sinh nhiệt' : 'Premium Ceramic burr preventing heat buildup')
            : ($locale === 'vi' ? 'Cối thép SUS420 CNC 5 trục độ chính xác cao' : 'High-precision SUS420 Stainless Steel CNC 5-Axis Burr');

        $adj = str_contains($descLower, '40 mức') || str_contains($descLower, '40 nấc') || str_contains($descLower, '40 cấp') || str_contains($titleLower, 'kmdj')
            ? ($locale === 'vi' ? '40 mức điều chỉnh độ mịn linh hoạt cho mọi kiểu pha' : '40 precise grind settings for versatile brewing')
            : (str_contains($descLower, 'bên ngoài') || str_contains($titleLower, 'vbz03')
                ? ($locale === 'vi' ? 'Vòng xoay chỉnh độ mịn bên ngoài thân máy tiện lợi' : 'Convenient external grind adjustment ring')
                : ($locale === 'vi' ? 'Đa cấp độ mịn linh hoạt: Espresso, Pour Over, Phin' : 'Versatile grind levels: Espresso, Pour Over, Phin'));

        $material = str_contains($descLower, 'thủy tinh') || str_contains($titleLower, 'kmdj')
            ? ($locale === 'vi' ? 'Hộp bột thủy tinh trong suốt sang trọng, chống tĩnh điện' : 'Clear anti-static glass ground container')
            : ($locale === 'vi' ? 'Thân nhôm kim loại cao cấp, hệ thống trục kép ổn định' : 'Premium solid aluminum alloy body with dual bearing');

        $warranty = $locale === 'vi' 
            ? '100% Chính hãng S54, bảo hành 12 tháng (1 đổi 1 trong 7 ngày)' 
            : '100% Authentic S54, 12-month warranty (7-day replacement)';

        $highlights = [
            ($locale === 'vi' ? '<strong>Cối xay:</strong> ' : '<strong>Burr:</strong> ') . $burr,
            ($locale === 'vi' ? '<strong>Điều chỉnh:</strong> ' : '<strong>Adjustment:</strong> ') . $adj,
            ($locale === 'vi' ? '<strong>Chất liệu:</strong> ' : '<strong>Material:</strong> ') . $material,
            ($locale === 'vi' ? '<strong>Bảo hành:</strong> ' : '<strong>Warranty:</strong> ') . $warranty,
        ];
    } elseif ($isInstant) {
        $highlights = [
            ($locale === 'vi' ? '<strong>Quy cách:</strong> Gói tiện lợi 19g chuẩn vị cà phê Việt thơm ngon' : '<strong>Packaging:</strong> Convenient 19g sachet with rich Vietnamese coffee taste'),
            ($locale === 'vi' ? '<strong>Công nghệ:</strong> Chiết xuất & sấy lạnh giữ trọn tinh túy hạt cà phê' : '<strong>Technology:</strong> Advanced extraction preserving true coffee essence'),
            ($locale === 'vi' ? '<strong>Tiêu chuẩn:</strong> Đạt chuẩn an toàn thực phẩm quốc tế HACCP & ISO' : '<strong>Standard:</strong> Certified food safety standard HACCP & ISO'),
            ($locale === 'vi' ? '<strong>Giao hàng:</strong> Miễn phí toàn quốc cho đơn từ 500.000₫' : '<strong>Shipping:</strong> Free nationwide shipping for orders over 500,000₫'),
        ];
    } else {
        $highlights = [
            ($locale === 'vi' ? '<strong>Xuất xứ:</strong> Tuyển chọn 100% từ Đắk Lắk & Cầu Đất (Lâm Đồng)' : '<strong>Origin:</strong> 100% selected from Dak Lak & Cau Dat (Lam Dong)'),
            ($locale === 'vi' ? '<strong>Công nghệ:</strong> Rang Hot-Air hồi khí của Đức chuẩn mộc cao cấp' : '<strong>Technology:</strong> German Convective Hot-Air artisan roasting technology'),
            ($locale === 'vi' ? '<strong>Cam kết:</strong> 100% Cà phê nguyên chất không tẩm ướp phụ gia hay bơ bắp' : '<strong>Guarantee:</strong> 100% pure artisan coffee without additives'),
            ($locale === 'vi' ? '<strong>Giao hàng:</strong> Miễn phí toàn quốc cho đơn từ 500.000₫' : '<strong>Shipping:</strong> Free nationwide shipping for orders over 500,000₫'),
        ];
    }
@endphp

@section('title', $title . ' — S54 COFFEE')
@section('meta_description', Str::limit(strip_tags($shortDesc ?: $desc), 160))
@section('og_title', $title . ' — S54 COFFEE')
@section('og_description', Str::limit(strip_tags($shortDesc ?: $desc), 200))
@section('og_image', $firstImg)
@section('og_type', 'product')

@push('jsonld')
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $title,
    'description' => Str::limit(strip_tags($shortDesc ?: $desc), 500),
    'image' => $galleryUrls,
    'brand' => [
        '@type' => 'Brand',
        'name' => 'S54 COFFEE',
    ],
    'offers' => [
        '@type' => 'Offer',
        'url' => url()->current(),
        'priceCurrency' => 'VND',
        'price' => (string) $minPrice,
        'availability' => 'https://schema.org/InStock',
        'seller' => [
            '@type' => 'Organization',
            'name' => 'S54 COFFEE',
        ],
    ],
    'sku' => $product->sku ?? '',
    'category' => $product->category ? ($product->category->getTranslation('name', $locale, false) ?: $product->category->name) : ($locale === 'vi' ? 'Cà Phê' : 'Coffee'),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => $locale === 'vi' ? 'Trang Chủ' : 'Home',
            'item' => route('client.home', ['locale' => $locale]),
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => $locale === 'vi' ? 'Sản Phẩm' : 'Products',
            'item' => route('client.catalog.index', ['locale' => $locale]),
        ],
        [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $title,
            'item' => url()->current(),
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@push('styles')
<style>
.s54-rich-description p { margin-bottom: 16px; line-height: 1.85; }
.s54-rich-description ul, .s54-rich-description ol { margin-bottom: 20px; padding-left: 24px; }
.s54-rich-description li { margin-bottom: 8px; line-height: 1.7; }
.s54-rich-description img { max-width: 100%; height: auto; border-radius: 8px; margin: 16px 0; }
.s54-rich-description strong { color: #2F221A; font-weight: 700; }
.s54-tab-toggle:hover { color: #2F221A !important; }
@media (max-width: 767px) {
    .s54-tabs-nav { gap: 4px !important; }
    .s54-tab-toggle { padding: 10px 14px !important; font-size: 13.5px !important; }
}
</style>
@endpush

@section('content')
<section style="background-color: #FAF8F5; padding: 50px 20px 80px;">
    <div class="o-wrapper" style="max-width: 1200px; margin: 0 auto;">
        
        {{-- Breadcrumb --}}
        <div style="font-size: 13px; color: #8A7B70; margin-bottom: 30px;">
            <a href="{{ route('client.home', ['locale' => $locale]) }}" style="color: #8A7B70; text-decoration: none;">{{ $locale === 'vi' ? 'Trang Chủ' : 'Home' }}</a> / 
            <a href="{{ route('client.catalog.index', ['locale' => $locale]) }}" style="color: #8A7B70; text-decoration: none;">{{ $locale === 'vi' ? 'Sản Phẩm' : 'Products' }}</a> / 
            <span style="color: #2F221A; font-weight: 600;">{{ $title }}</span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 48px; align-items: start;">
            
            {{-- Product Gallery --}}
            <div class="s54-product-gallery" style="display: flex; flex-direction: column; gap: 16px;">
                <div class="s54-gallery-hero" style="position: relative; width: 100%; height: 480px; background: #FAF6F1; border-radius: 16px; border: 1px solid rgba(47, 34, 26, 0.08); box-shadow: 0 4px 24px rgba(47, 34, 26, 0.05); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    <div class="s54-gallery-tag" style="position: absolute; top: 18px; left: 18px; z-index: 5; background: #2F221A; color: #FAF6F1; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; padding: 6px 14px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                        <span>{{ $locale === 'vi' ? '100% CHÍNH HÃNG • S54 COFFEE' : '100% AUTHENTIC • S54 COFFEE' }}</span>
                    </div>

                    <div class="s54-gallery-hero-inner" id="s54-blade-hero" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; padding: 24px; cursor: pointer;">
                        <img id="s54-main-image" src="{{ $firstImg }}" alt="{{ $title }}" style="max-width: 90%; max-height: 420px; object-fit: contain; transition: opacity 0.22s ease;">
                    </div>

                    @if(count($galleryUrls) > 1)
                        <button type="button" class="s54-gallery-nav-btn prev" id="s54-blade-prev" style="position: absolute; top: 50%; transform: translateY(-50%); left: 14px; z-index: 6; width: 42px; height: 42px; border-radius: 50%; background: rgba(255,255,255,0.95); border: 1px solid rgba(47,34,26,0.1); display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 14px rgba(47,34,26,0.12);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button type="button" class="s54-gallery-nav-btn next" id="s54-blade-next" style="position: absolute; top: 50%; transform: translateY(-50%); right: 14px; z-index: 6; width: 42px; height: 42px; border-radius: 50%; background: rgba(255,255,255,0.95); border: 1px solid rgba(47,34,26,0.1); display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 14px rgba(47,34,26,0.12);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                        <div class="s54-gallery-counter" id="s54-blade-counter" style="position: absolute; bottom: 16px; right: 16px; z-index: 5; background: rgba(47,34,26,0.82); color: #FAF6F1; font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: 600; padding: 4px 12px; border-radius: 12px;">1 / {{ count($galleryUrls) }}</div>
                    @endif
                </div>

                @if(count($galleryUrls) > 1)
                    <div class="s54-gallery-thumbs" id="s54-blade-thumbs" style="display: flex; gap: 12px; justify-content: center; align-items: center; flex-wrap: wrap;">
                        @foreach($galleryUrls as $idx => $gUrl)
                            <button type="button" class="s54-gallery-thumb {{ $loop->first ? 'is-active' : '' }}" data-idx="{{ $idx }}" data-src="{{ $gUrl }}" style="width: 76px; height: 76px; border-radius: 12px; background: #FAF6F1; border: 2px solid {{ $loop->first ? '#2F221A' : 'transparent' }}; padding: 4px; cursor: pointer; overflow: hidden; box-sizing: border-box;">
                                <img src="{{ $gUrl }}" alt="{{ $title }} - {{ $idx + 1 }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px; display: block;">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Product Info & Purchase Form --}}
            <div>
                <span style="display: inline-block; background: #D68E1D; color: #FFFFFF; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; padding: 4px 14px; border-radius: 20px; margin-bottom: 12px;">
                    {{ $locale === 'vi' ? 'ĐỘC QUYỀN ONLINE' : 'ONLINE EXCLUSIVE' }}
                </span>
                
                <h1 class="c-product-main__title" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: clamp(22px, 2.2vw, 28px); font-weight: 700; color: #2F221A; margin-bottom: 12px; line-height: 1.28;">
                    {{ $title }}
                </h1>

                <div class="c-product-main__star-reviews s54-product-reviews-bar" style="margin-bottom: 16px; display: inline-flex !important; flex-direction: row !important; align-items: center !important;">
                    <a class="s54-rating-anchor" href="#okereviews-section" title="{{ $locale === 'vi' ? 'Xem đánh giá của khách hàng' : 'View customer reviews' }}" onclick="event.preventDefault(); (document.getElementById('okereviews-section') || document.getElementById('s54-reviews-section'))?.scrollIntoView({behavior:'smooth'});" style="display: inline-flex !important; flex-direction: row !important; align-items: center !important; gap: 6px !important; text-decoration: none !important;">
                        <div class="s54-rating-stars" aria-label="{{ $locale === 'vi' ? '4.8 trên 5 sao' : '4.8 out of 5 stars' }}" style="display: inline-flex !important; flex-direction: row !important; align-items: center !important; gap: 3px !important; flex-shrink: 0 !important; white-space: nowrap !important;">
                            <svg class="s54-star-icon" viewBox="0 0 24 24" width="16" height="16" style="width: 16px !important; height: 16px !important; min-width: 16px !important; max-width: 16px !important; display: inline-block !important; vertical-align: middle !important; fill: #D68E1D !important; flex-shrink: 0 !important;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <svg class="s54-star-icon" viewBox="0 0 24 24" width="16" height="16" style="width: 16px !important; height: 16px !important; min-width: 16px !important; max-width: 16px !important; display: inline-block !important; vertical-align: middle !important; fill: #D68E1D !important; flex-shrink: 0 !important;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <svg class="s54-star-icon" viewBox="0 0 24 24" width="16" height="16" style="width: 16px !important; height: 16px !important; min-width: 16px !important; max-width: 16px !important; display: inline-block !important; vertical-align: middle !important; fill: #D68E1D !important; flex-shrink: 0 !important;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <svg class="s54-star-icon" viewBox="0 0 24 24" width="16" height="16" style="width: 16px !important; height: 16px !important; min-width: 16px !important; max-width: 16px !important; display: inline-block !important; vertical-align: middle !important; fill: #D68E1D !important; flex-shrink: 0 !important;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <svg class="s54-star-icon" viewBox="0 0 24 24" width="16" height="16" style="width: 16px !important; height: 16px !important; min-width: 16px !important; max-width: 16px !important; display: inline-block !important; vertical-align: middle !important; fill: #D68E1D !important; flex-shrink: 0 !important;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </div>
                        <span class="s54-rating-score" style="font-family: 'Inter', sans-serif !important; font-size: 14.5px !important; font-weight: 700 !important; color: #2F221A !important; line-height: 1 !important; margin-left: 2px !important;">4.8</span>
                        <span class="s54-rating-sep" style="color: #A3968C !important; font-size: 13px !important; line-height: 1 !important;">•</span>
                        <span class="s54-rating-count" style="font-family: 'Inter', sans-serif !important; font-size: 13.5px !important; font-weight: 500 !important; color: #7B685B !important; line-height: 1 !important;">527 {{ $locale === 'vi' ? 'đánh giá' : 'reviews' }}</span>
                    </a>
                </div>

                <div style="font-size: 26px; font-weight: 800; color: #D68E1D; margin-bottom: 24px;">
                    <span id="s54-product-price-display">{{ number_format($minPrice, 0, ',', '.') }}₫</span>
                </div>

                @if(!empty($displayShortDesc))
                    <div style="color: #5C4A3E; line-height: 1.6; margin-bottom: 24px; font-size: 14.5px;">
                        {!! nl2br(e($displayShortDesc)) !!}
                    </div>
                @endif

                {{-- Variant Selector --}}
                @if($product->variants->where('is_active', true)->isNotEmpty())
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; text-transform: uppercase; color: #2F221A; margin-bottom: 10px;">
                            {{ $locale === 'vi' ? 'Chọn Quy Cách (Khối lượng):' : 'Select Size / Variant:' }}
                        </label>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            @foreach($product->variants->where('is_active', true) as $v)
                                @php
                                    $vName = is_array($v->name) ? ($v->name[$locale] ?? $v->name['vi'] ?? '') : ($v->getTranslation('name', $locale, false) ?: $v->name);
                                @endphp
                                <button type="button" class="s54-variant-btn {{ $loop->first ? 'is-selected' : '' }}" 
                                        data-variant-id="{{ $v->id }}"
                                        data-variant-price="{{ $v->price }}"
                                        data-variant-price-formatted="{{ number_format($v->price, 0, ',', '.') }}₫"
                                        style="padding: 10px 20px; border: 1.5px solid {{ $loop->first ? '#2F221A' : '#D0C8C0' }}; background: {{ $loop->first ? '#2F221A' : '#FFFFFF' }}; color: {{ $loop->first ? '#FAF6F1' : '#2F221A' }}; border-radius: 6px; font-size: 13px; font-weight: 700; cursor: pointer;">
                                    {{ $vName }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Quantity and Add to Cart --}}
                <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 26px;">
                    <div style="display: flex; align-items: center; border: 1px solid #D0C8C0; border-radius: 4px; background: #FFFFFF;">
                        <button type="button" id="s54-qty-minus" style="background: none; border: none; padding: 12px 16px; font-size: 16px; cursor: pointer; color: #2F221A;">-</button>
                        <input type="number" id="s54-qty-input" value="1" min="1" style="width: 45px; text-align: center; border: none; font-weight: 700; font-size: 14px; -moz-appearance: textfield;">
                        <button type="button" id="s54-qty-plus" style="background: none; border: none; padding: 12px 16px; font-size: 16px; cursor: pointer; color: #2F221A;">+</button>
                    </div>

                    <button type="button" id="s54-detail-add-btn" 
                            data-product-id="{{ $product->id }}" 
                            data-variant-id="{{ $defaultVariant?->id ?? '' }}"
                            data-product-name="{{ $title }}"
                            data-product-price="{{ $minPrice }}"
                            data-product-image="{{ $firstImg }}"
                            style="flex: 1; background-color: #2F221A; color: #FAF6F1; border: none; padding: 14px 28px; border-radius: 4px; font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: background 0.2s;">
                        {{ $locale === 'vi' ? 'Thêm Vào Giỏ Hàng' : 'Add to Cart' }}
                    </button>
                </div>

                {{-- Highlights Box: Dynamically Tailored to Admin Data & Product Type --}}
                <div class="s54-highlights-box" style="background: #F3EEE8; border-radius: 8px; padding: 18px 20px; font-size: 13.5px; color: #5C4A3E; line-height: 1.8; border: 1px solid rgba(47, 34, 26, 0.06);">
                    @foreach($highlights as $hl)
                        <div style="margin-bottom: 4px; display: flex; align-items: baseline; gap: 8px;">
                            <span style="color: #D68E1D; font-weight: 700; flex-shrink: 0;">✓</span>
                            <span>{!! $hl !!}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- PRODUCT DETAILS & SPECIFICATIONS TABS --}}
<section class="s54-product-tabs-section" id="s54-details-section" style="background: #FFFFFF; padding: 60px 20px 70px; border-top: 1px solid #EBE7E1;">
    <div class="o-wrapper" style="max-width: 1100px; margin: 0 auto;">
        
        {{-- Tabs Navigation --}}
        <div class="s54-tabs-nav" style="display: flex; gap: 8px; border-bottom: 2px solid #EBE7E1; margin-bottom: 36px; overflow-x: auto; -webkit-overflow-scrolling: touch; padding-bottom: 2px;">
            <button type="button" class="s54-tab-toggle is-active" data-target="tab-desc" style="padding: 12px 22px; font-size: 15px; font-weight: 700; color: #2F221A; border: none; background: transparent; border-bottom: 3px solid #2F221A; cursor: pointer; white-space: nowrap; transition: all 0.2s ease;">
                {{ $locale === 'vi' ? 'Mô Tả Chi Tiết' : 'Detailed Description' }}
            </button>
            <button type="button" class="s54-tab-toggle" data-target="tab-specs" style="padding: 12px 22px; font-size: 15px; font-weight: 600; color: #7A6D65; border: none; background: transparent; border-bottom: 3px solid transparent; cursor: pointer; white-space: nowrap; transition: all 0.2s ease;">
                {{ $locale === 'vi' ? 'Thông Số Kỹ Thuật' : 'Specifications' }}
            </button>
            <button type="button" class="s54-tab-toggle" data-target="tab-guide" style="padding: 12px 22px; font-size: 15px; font-weight: 600; color: #7A6D65; border: none; background: transparent; border-bottom: 3px solid transparent; cursor: pointer; white-space: nowrap; transition: all 0.2s ease;">
                {{ $locale === 'vi' ? 'Hướng Dẫn Sử Dụng & Bảo Quản' : 'Usage & Care Guide' }}
            </button>
            <button type="button" class="s54-tab-toggle" data-target="tab-policy" style="padding: 12px 22px; font-size: 15px; font-weight: 600; color: #7A6D65; border: none; background: transparent; border-bottom: 3px solid transparent; cursor: pointer; white-space: nowrap; transition: all 0.2s ease;">
                {{ $locale === 'vi' ? 'Chính Sách Giao Hàng & Đổi Trả' : 'Shipping & Returns' }}
            </button>
        </div>

        {{-- Tab Panes --}}
        <div class="s54-tab-content-wrapper">
            
            {{-- Tab 1: Mô Tả Chi Tiết (Full description from Admin Quill editor) --}}
            <div id="tab-desc" class="s54-tab-pane is-active">
                <div class="s54-rich-description" style="color: #4A3B32; line-height: 1.85; font-size: 15px;">
                    @if(!empty(trim(strip_tags($desc))))
                        <div class="s54-rendered-html">
                            {!! $desc !!}
                        </div>
                    @elseif(!empty($displayShortDesc))
                        <p>{!! nl2br(e($displayShortDesc)) !!}</p>
                    @else
                        <p>{{ $locale === 'vi' ? 'Thông tin mô tả sản phẩm đang được cập nhật.' : 'Product description is being updated.' }}</p>
                    @endif
                </div>
            </div>

            {{-- Tab 2: Thông Số Kỹ Thuật --}}
            <div id="tab-specs" class="s54-tab-pane" style="display: none;">
                <div style="max-width: 860px; margin: 0 auto; background: #FAF8F5; border-radius: 12px; overflow: hidden; border: 1px solid #EBE7E1; box-shadow: 0 4px 16px rgba(0,0,0,0.02);">
                    <table style="width: 100%; border-collapse: collapse; font-size: 14.5px;">
                        <tbody>
                            <tr style="border-bottom: 1px solid #EBE7E1;">
                                <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; width: 35%; background: #F3EEE8;">{{ $locale === 'vi' ? 'Tên sản phẩm' : 'Product Name' }}</td>
                                <td style="padding: 14px 20px; color: #5C4A3E;">{{ $title }}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #EBE7E1;">
                                <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Mã sản phẩm / SKU' : 'SKU' }}</td>
                                <td style="padding: 14px 20px; color: #5C4A3E;">{{ $product->sku ?: 'S54-' . $product->id }}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #EBE7E1;">
                                <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Thương hiệu' : 'Brand' }}</td>
                                <td style="padding: 14px 20px; color: #5C4A3E;">S54 COFFEE VIETNAM</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #EBE7E1;">
                                <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Danh mục' : 'Category' }}</td>
                                <td style="padding: 14px 20px; color: #5C4A3E;">{{ $product->category ? ($product->category->getTranslation('name', $locale, false) ?: $product->category->name) : ($isGrinder ? ($locale === 'vi' ? 'Máy Xay Cà Phê' : 'Coffee Grinder') : ($locale === 'vi' ? 'Cà Phê' : 'Coffee')) }}</td>
                            </tr>
                            @if($isGrinder)
                                <tr style="border-bottom: 1px solid #EBE7E1;">
                                    <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Loại cối xay' : 'Burr Type' }}</td>
                                    <td style="padding: 14px 20px; color: #5C4A3E;">{{ str_contains($descLower, 'gốm') || str_contains($descLower, 'ceramic') || str_contains($titleLower, 'kmdj') ? ($locale === 'vi' ? 'Lõi gốm Ceramic cao cấp không sinh nhiệt' : 'Premium Ceramic Conical Burr') : ($locale === 'vi' ? 'Lõi thép SUS420 CNC 5 trục độ chính xác cao' : 'SUS420 Stainless Steel CNC 5-Axis Burr') }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #EBE7E1;">
                                    <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Cấp độ chỉnh độ mịn' : 'Grind Settings' }}</td>
                                    <td style="padding: 14px 20px; color: #5C4A3E;">{{ str_contains($descLower, '40 mức') || str_contains($titleLower, 'kmdj') ? ($locale === 'vi' ? '40 cấp độ vi chỉnh (Espresso, Moka, Pour Over, Phin)' : '40 precise micro-adjustment levels') : ($locale === 'vi' ? 'Đa cấp độ vi chỉnh linh hoạt cho mọi kiểu pha' : 'Multi-level micro adjustment') }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #EBE7E1;">
                                    <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Dung tích chứa' : 'Capacity' }}</td>
                                    <td style="padding: 14px 20px; color: #5C4A3E;">{{ $locale === 'vi' ? 'Khoảng 25g - 30g hạt cà phê / mẻ xay' : 'Approx. 25g - 30g coffee beans per batch' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #EBE7E1;">
                                    <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Chế độ bảo hành' : 'Warranty' }}</td>
                                    <td style="padding: 14px 20px; color: #5C4A3E;">{{ $locale === 'vi' ? '12 tháng chính hãng (1 đổi 1 trong 7 ngày nếu lỗi từ NSX)' : '12 months official warranty (7-day replacement for defect)' }}</td>
                                </tr>
                            @elseif($isInstant)
                                <tr style="border-bottom: 1px solid #EBE7E1;">
                                    <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Thành phần' : 'Ingredients' }}</td>
                                    <td style="padding: 14px 20px; color: #5C4A3E;">{{ $locale === 'vi' ? 'Cà phê hòa tan (14%), bột kem không sữa (NDC), đường, maltodextrine, muối' : 'Instant coffee (14%), non-dairy creamer, sugar, maltodextrine, salt' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #EBE7E1;">
                                    <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Quy cách đóng gói' : 'Packaging' }}</td>
                                    <td style="padding: 14px 20px; color: #5C4A3E;">{{ $locale === 'vi' ? 'Túi 24 gói x 19g (Tổng trọng lượng tịnh 456g)' : 'Bag of 24 sachets x 19g (Net weight 456g)' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #EBE7E1;">
                                    <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Hạn sử dụng' : 'Shelf Life' }}</td>
                                    <td style="padding: 14px 20px; color: #5C4A3E;">{{ $locale === 'vi' ? '18 tháng kể từ ngày sản xuất' : '18 months from manufacturing date' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #EBE7E1;">
                                    <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Tiêu chuẩn chất lượng' : 'Quality Standard' }}</td>
                                    <td style="padding: 14px 20px; color: #5C4A3E;">HACCP & ISO 22000:2018</td>
                                </tr>
                            @else
                                <tr style="border-bottom: 1px solid #EBE7E1;">
                                    <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Vùng nguyên liệu' : 'Origin Region' }}</td>
                                    <td style="padding: 14px 20px; color: #5C4A3E;">{{ $locale === 'vi' ? 'Đắk Lắk & Cầu Đất (Lâm Đồng) - Độ cao 800m - 1500m' : 'Dak Lak & Cau Dat (Lam Dong) - 800m - 1500m altitude' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #EBE7E1;">
                                    <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Mức độ rang' : 'Roast Level' }}</td>
                                    <td style="padding: 14px 20px; color: #5C4A3E;">{{ $locale === 'vi' ? 'Medium - Dark Roast (Rang vừa đậm chuẩn mộc cao cấp)' : 'Medium - Dark Roast (Artisan pure)' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #EBE7E1;">
                                    <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Công nghệ rang' : 'Roasting Method' }}</td>
                                    <td style="padding: 14px 20px; color: #5C4A3E;">{{ $locale === 'vi' ? 'Hot-Air hồi khí công nghệ Đức, hạt chín đều từ tâm' : 'German Convective Hot-Air circulation technology' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #EBE7E1;">
                                    <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Hạn sử dụng' : 'Shelf Life' }}</td>
                                    <td style="padding: 14px 20px; color: #5C4A3E;">{{ $locale === 'vi' ? '12 tháng kể từ ngày sản xuất (Ngon nhất trong 3 tháng đầu mở túi)' : '12 months from manufacturing date' }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td style="padding: 14px 20px; font-weight: 700; color: #2F221A; background: #F3EEE8;">{{ $locale === 'vi' ? 'Xuất xứ' : 'Origin' }}</td>
                                <td style="padding: 14px 20px; color: #5C4A3E;">{{ $isGrinder ? ($locale === 'vi' ? 'Chính hãng S54 Coffee' : 'Official S54 Coffee') : ($locale === 'vi' ? 'Việt Nam' : 'Vietnam') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tab 3: Hướng Dẫn Sử Dụng & Bảo Quản --}}
            <div id="tab-guide" class="s54-tab-pane" style="display: none;">
                <div style="max-width: 860px; margin: 0 auto; color: #4A3B32; line-height: 1.85; font-size: 15px;">
                    @if($isGrinder)
                        <h4 style="font-size: 17px; font-weight: 700; color: #2F221A; margin-bottom: 12px;">{{ $locale === 'vi' ? 'Các Bước Sử Dụng Máy Xay Cầm Tay:' : 'How to Use Manual Coffee Grinder:' }}</h4>
                        <ol style="padding-left: 20px; margin-bottom: 24px;">
                            <li style="margin-bottom: 10px;"><strong>{{ $locale === 'vi' ? 'Bước 1: Điều chỉnh độ mịn' : 'Step 1: Adjust grind size' }}</strong> — {{ $locale === 'vi' ? 'Xoay núm điều chỉnh đến mức mong muốn (Ví dụ: Nấc mịn cho Espresso/Moka Pot, Nấc vừa cho Phin/Pour Over, Nấc thô cho French Press/Cold Brew).' : 'Turn adjustment knob to desired setting (Fine for Espresso, Medium for Pour Over/Phin, Coarse for French Press).' }}</li>
                            <li style="margin-bottom: 10px;"><strong>{{ $locale === 'vi' ? 'Bước 2: Cho hạt cà phê' : 'Step 2: Add coffee beans' }}</strong> — {{ $locale === 'vi' ? 'Mở nắp, cho khoảng 15g - 25g hạt cà phê vào khoang chứa rồi đậy nắp và lắp tay quay.' : 'Open lid, put 15g - 25g beans into hopper, attach handle.' }}</li>
                            <li style="margin-bottom: 10px;"><strong>{{ $locale === 'vi' ? 'Bước 3: Tiến hành xay' : 'Step 3: Grind' }}</strong> — {{ $locale === 'vi' ? 'Giữ chắc thân máy theo phương thẳng đứng, quay đều tay theo chiều kim đồng hồ cho đến khi hết hạt.' : 'Hold body vertically, rotate handle clockwise smoothly.' }}</li>
                            <li style="margin-bottom: 10px;"><strong>{{ $locale === 'vi' ? 'Bước 4: Lấy bột cà phê' : 'Step 4: Collect grounds' }}</strong> — {{ $locale === 'vi' ? 'Tháo cối/hộp chứa bột phía dưới và đổ bột cà phê vào phin hoặc tay pha để chiết xuất.' : 'Detach lower container and pour grounds into your brewing tool.' }}</li>
                        </ol>
                        <h4 style="font-size: 17px; font-weight: 700; color: #2F221A; margin-bottom: 12px;">{{ $locale === 'vi' ? 'Hướng Dẫn Vệ Sinh & Bảo Quản:' : 'Cleaning & Maintenance:' }}</h4>
                        <ul style="padding-left: 20px; margin-bottom: 16px;">
                            <li style="margin-bottom: 8px;">{{ $locale === 'vi' ? 'Sử dụng chổi/bàn chải vệ sinh khô đi kèm để quét sạch bột cà phê đọng trong cối sau mỗi lần xay.' : 'Use dry cleaning brush to remove residual coffee grounds after each use.' }}</li>
                            <li style="margin-bottom: 8px;">{{ $locale === 'vi' ? 'KHÔNG ngâm rửa toàn bộ cối kim loại/trục máy vào nước để tránh gỉ sét ổ bi. Đối với hộp thủy tinh có thể rửa sạch và lau khô hoàn toàn trước khi lắp lại.' : 'DO NOT submerge the entire grinder body in water. Wipe clean with dry cloth.' }}</li>
                            <li style="margin-bottom: 8px;">{{ $locale === 'vi' ? 'Bảo quản nơi khô ráo, thoáng mát, tránh va đập mạnh hoặc làm rơi.' : 'Store in a cool, dry place and avoid dropping.' }}</li>
                        </ul>
                    @elseif($isInstant)
                        <h4 style="font-size: 17px; font-weight: 700; color: #2F221A; margin-bottom: 14px;">{{ $locale === 'vi' ? 'Cách Pha Cà Phê Hòa Tan Chuẩn Vị:' : 'How to Brew S54 Instant Coffee:' }}</h4>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px;">
                            <div style="background: #FAF8F5; padding: 22px; border-radius: 10px; border: 1px solid #EBE7E1;">
                                <h5 style="font-size: 15px; font-weight: 700; color: #D68E1D; margin-bottom: 8px;">🔥 {{ $locale === 'vi' ? 'Uống Nóng (Hot Coffee)' : 'Hot Coffee' }}</h5>
                                <p style="margin: 0; font-size: 14px; color: #5C4A3E;">{{ $locale === 'vi' ? 'Hòa tan 1 gói cà phê 19g với khoảng 70ml - 80ml nước sôi (khoảng 85°C - 90°C). Khuấy đều và thưởng thức ngay hương vị thơm béo đậm đà.' : 'Dissolve 1 sachet (19g) in 70ml - 80ml hot water (85°C - 90°C). Stir well and enjoy.' }}</p>
                            </div>
                            <div style="background: #FAF8F5; padding: 22px; border-radius: 10px; border: 1px solid #EBE7E1;">
                                <h5 style="font-size: 15px; font-weight: 700; color: #D68E1D; margin-bottom: 8px;">🧊 {{ $locale === 'vi' ? 'Uống Lạnh / Đá (Iced Coffee)' : 'Iced Coffee' }}</h5>
                                <p style="margin: 0; font-size: 14px; color: #5C4A3E;">{{ $locale === 'vi' ? 'Hòa tan 2 gói cà phê với 60ml - 70ml nước nóng. Khuấy thật đều cho tan hoàn toàn, sau đó thêm đá viên vào đầy ly và thưởng thức sảng khoái.' : 'Dissolve 2 sachets in 60ml - 70ml hot water, stir well, then add ice cubes for a refreshing cup.' }}</p>
                            </div>
                        </div>
                        <h4 style="font-size: 17px; font-weight: 700; color: #2F221A; margin-bottom: 12px;">{{ $locale === 'vi' ? 'Hướng Dẫn Bảo Quản:' : 'Storage Instructions:' }}</h4>
                        <p style="font-size: 14px; color: #5C4A3E; margin: 0;">{{ $locale === 'vi' ? 'Bảo quản nơi khô ráo, thoáng mát, tránh ánh nắng trực tiếp và nhiệt độ cao. Khóa chặt miệng túi zip sau khi sử dụng.' : 'Store in a cool, dry place away from direct sunlight. Seal zipper tightly after opening.' }}</p>
                    @else
                        <h4 style="font-size: 17px; font-weight: 700; color: #2F221A; margin-bottom: 14px;">{{ $locale === 'vi' ? 'Phương Pháp Pha Chế Chuẩn S54:' : 'Brewing Instructions:' }}</h4>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px;">
                            <div style="background: #FAF8F5; padding: 22px; border-radius: 10px; border: 1px solid #EBE7E1;">
                                <h5 style="font-size: 15px; font-weight: 700; color: #D68E1D; margin-bottom: 8px;">☕ {{ $locale === 'vi' ? 'Pha Phin Truyền Thống' : 'Traditional Vietnamese Phin' }}</h5>
                                <p style="margin: 0; font-size: 14px; color: #5C4A3E;">{{ $locale === 'vi' ? 'Dùng 25g cà phê xay vừa, nén nhẹ tấm gài. Rót 25ml nước sôi ủ 1-2 phút, sau đó rót tiếp 50ml nước sôi chiết xuất. Thêm sữa đặc hoặc đá theo khẩu vị.' : 'Use 25g medium ground coffee. Pre-infuse with 25ml hot water for 1-2 mins, then add 50ml hot water for full extraction.' }}</p>
                            </div>
                            <div style="background: #FAF8F5; padding: 22px; border-radius: 10px; border: 1px solid #EBE7E1;">
                                <h5 style="font-size: 15px; font-weight: 700; color: #D68E1D; margin-bottom: 8px;">⚡ {{ $locale === 'vi' ? 'Pha Máy Espresso / Moka Pot' : 'Espresso & Moka Pot' }}</h5>
                                <p style="margin: 0; font-size: 14px; color: #5C4A3E;">{{ $locale === 'vi' ? 'Xay mịn chuẩn Espresso, dùng 18g - 20g bột cà phê nén phẳng với lực tamping 15kg. Chiết xuất trong 25-30 giây để thu về 36ml - 40ml espresso lớp crema vàng óng sánh mịn.' : 'Grind fine, dose 18-20g, tamp firmly. Extract 36-40ml liquid in 25-30 seconds with thick golden crema.' }}</p>
                            </div>
                        </div>
                        <h4 style="font-size: 17px; font-weight: 700; color: #2F221A; margin-bottom: 12px;">{{ $locale === 'vi' ? 'Bảo Quản Hạt Cà Phê:' : 'Coffee Bean Storage:' }}</h4>
                        <p style="font-size: 14px; color: #5C4A3E; margin: 0;">{{ $locale === 'vi' ? 'Túi cà phê S54 được trang bị van 1 chiều cao cấp giúp thoát khí CO2 tự nhiên mà không để không khí lọt vào. Đóng kín nẹp/zip sau khi lấy hạt, bảo quản nơi thoáng mát.' : 'S54 bags feature high-grade one-way degassing valves. Reseal tightly after each use and keep in a cool place.' }}</p>
                    @endif
                </div>
            </div>

            {{-- Tab 4: Chính Sách Giao Hàng & Đổi Trả --}}
            <div id="tab-policy" class="s54-tab-pane" style="display: none;">
                <div style="max-width: 860px; margin: 0 auto; color: #4A3B32; line-height: 1.85; font-size: 15px;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px;">
                        <div style="background: #FAF8F5; padding: 22px; border-radius: 10px; border: 1px solid #EBE7E1;">
                            <h5 style="font-size: 15px; font-weight: 700; color: #2F221A; margin-bottom: 10px;">🚚 {{ $locale === 'vi' ? 'Chính Sách Vận Chuyển' : 'Shipping Policy' }}</h5>
                            <ul style="padding-left: 20px; margin: 0; font-size: 14px; color: #5C4A3E;">
                                <li style="margin-bottom: 6px;">{{ $locale === 'vi' ? 'Miễn phí giao hàng toàn quốc cho đơn hàng từ 500.000₫.' : 'Free nationwide shipping on orders from 500,000₫.' }}</li>
                                <li style="margin-bottom: 6px;">{{ $locale === 'vi' ? 'Thời gian giao hàng: Nội thành 1 - 2 ngày; các tỉnh thành khác 2 - 4 ngày.' : 'Delivery: 1-2 days within major cities, 2-4 days nationwide.' }}</li>
                                <li>{{ $locale === 'vi' ? 'Được đồng kiểm, mở hộp kiểm tra đúng sản phẩm trước khi thanh toán.' : 'Inspect package upon delivery before making payment.' }}</li>
                            </ul>
                        </div>
                        <div style="background: #FAF8F5; padding: 22px; border-radius: 10px; border: 1px solid #EBE7E1;">
                            <h5 style="font-size: 15px; font-weight: 700; color: #2F221A; margin-bottom: 10px;">🔄 {{ $locale === 'vi' ? 'Chính Sách Đổi Trả' : 'Returns & Warranty' }}</h5>
                            <ul style="padding-left: 20px; margin: 0; font-size: 14px; color: #5C4A3E;">
                                <li style="margin-bottom: 6px;">{{ $locale === 'vi' ? 'Đổi mới 1 - 1 trong 7 ngày nếu có lỗi từ nhà sản xuất hoặc hư hại do vận chuyển.' : '7-day replacement if manufacturer defect or transit damage occurs.' }}</li>
                                <li style="margin-bottom: 6px;">{{ $locale === 'vi' ? 'Sản phẩm đổi trả cần giữ nguyên tem mác, hộp và đầy đủ phụ kiện.' : 'Returned items must keep packaging, tags and accessories.' }}</li>
                                <li>{{ $locale === 'vi' ? 'Hotline hỗ trợ CSKH: 0981 797 849 (8:00 - 21:00 hàng ngày).' : 'Customer hotline: 0981 797 849 (8:00 - 21:00 daily).' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- S54 AUTHENTIC CUSTOMER REVIEWS SECTION --}}
<section id="okereviews-section" class="s54-reviews-section" style="background-color: #FAF8F5; padding: 70px 20px 80px; border-top: 1px solid #EBE7E1;">
    <div class="o-wrapper" style="max-width: 1100px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 36px;">
            <span style="color: #D68E1D; font-size: 12px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 8px;">
                {{ $locale === 'vi' ? 'TRẢI NGHIỆM THỰC TẾ' : 'VERIFIED EXPERIENCES' }}
            </span>
            <h2 style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; font-size: clamp(26px, 3.5vw, 36px); font-weight: 700; color: #2F221A; margin: 0 0 14px 0;">
                {{ $locale === 'vi' ? 'Đánh Giá Từ Khách Hàng' : 'Customer Reviews' }}
            </h2>
            <div style="display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 20px; color: #D68E1D;">
                <span style="letter-spacing: 2px;">★★★★★</span>
                <strong style="color: #2F221A; font-size: 18px; margin-left: 6px;">4.8 / 5.0</strong>
                <span style="color: #7A6D65; font-size: 14px;">({{ $locale === 'vi' ? 'Dựa trên 527 lượt đánh giá xác thực' : 'Based on 527 verified reviews' }})</span>
            </div>
        </div>

        {{-- Rating Breakdown Metrics --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; margin-bottom: 36px; background: #FFFFFF; padding: 24px 28px; border-radius: 12px; border: 1px solid #EBE7E1; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
            <div>
                <div style="display: flex; justify-content: space-between; font-size: 13.5px; font-weight: 600; color: #2F221A; margin-bottom: 8px;">
                    <span>{{ $isGrinder ? ($locale === 'vi' ? 'Độ sắc bén & độ mịn đều' : 'Sharpness & Consistency') : ($locale === 'vi' ? 'Chất lượng & hương vị' : 'Quality & Flavor') }}</span>
                    <span style="color: #D68E1D; font-weight: 700;">4.9 / 5.0</span>
                </div>
                <div style="height: 6px; background: #EBE7E1; border-radius: 3px; overflow: hidden;">
                    <div style="width: 98%; height: 100%; background: #D68E1D; border-radius: 3px;"></div>
                </div>
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; font-size: 13.5px; font-weight: 600; color: #2F221A; margin-bottom: 8px;">
                    <span>{{ $isGrinder ? ($locale === 'vi' ? 'Độ chắc chắn & hoàn thiện' : 'Build Quality & Finish') : ($locale === 'vi' ? 'Độ đậm đà & hậu vị' : 'Richness & Aftertaste') }}</span>
                    <span style="color: #D68E1D; font-weight: 700;">4.8 / 5.0</span>
                </div>
                <div style="height: 6px; background: #EBE7E1; border-radius: 3px; overflow: hidden;">
                    <div style="width: 96%; height: 100%; background: #D68E1D; border-radius: 3px;"></div>
                </div>
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; font-size: 13.5px; font-weight: 600; color: #2F221A; margin-bottom: 8px;">
                    <span>{{ $locale === 'vi' ? 'Đóng gói & giao hàng nhanh' : 'Packaging & Fast Delivery' }}</span>
                    <span style="color: #D68E1D; font-weight: 700;">4.8 / 5.0</span>
                </div>
                <div style="height: 6px; background: #EBE7E1; border-radius: 3px; overflow: hidden;">
                    <div style="width: 95%; height: 100%; background: #D68E1D; border-radius: 3px;"></div>
                </div>
            </div>
        </div>

        {{-- Verified Reviews Grid --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
            @if($isGrinder)
                <div style="background: #FFFFFF; padding: 24px; border-radius: 12px; border: 1px solid #EBE7E1; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div>
                            <strong style="color: #2F221A; font-size: 15px; display: block;">Nguyễn Tiến Đạt</strong>
                            <span style="display: inline-block; background: #E8F5E9; color: #2E7D32; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 10px; margin-top: 4px;">✓ {{ $locale === 'vi' ? 'Đã mua hàng' : 'Verified Buyer' }}</span>
                        </div>
                        <span style="color: #D68E1D; font-size: 14px;">★★★★★</span>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: #2F221A; margin: 0 0 8px 0;">{{ $locale === 'vi' ? 'Cối xay rất đầm tay, bột ra đều tăm tắp' : 'Very solid grinder, smooth and consistent' }}</h4>
                    <p style="color: #5C4A3E; font-size: 13.5px; line-height: 1.6; margin: 0 0 12px 0;">{{ $locale === 'vi' ? 'Mình dùng pha phin và pour over, điều chỉnh nấc rất nhạy và dễ. Hộp thủy tinh nhìn sạch sẽ sang trọng, xay không bị nóng bột hay khét mùi cà phê. Đóng gói rất kỹ.' : 'Adjusting grind settings is very intuitive. The glass container is clean and elegant. Excellent quality!' }}</p>
                    <span style="font-size: 12px; color: #8A7B70;">{{ $locale === 'vi' ? 'Đánh giá ngày 05/09/2026' : 'Reviewed on Sep 05, 2026' }}</span>
                </div>

                <div style="background: #FFFFFF; padding: 24px; border-radius: 12px; border: 1px solid #EBE7E1; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div>
                            <strong style="color: #2F221A; font-size: 15px; display: block;">Trần Quốc Bảo</strong>
                            <span style="display: inline-block; background: #E8F5E9; color: #2E7D32; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 10px; margin-top: 4px;">✓ {{ $locale === 'vi' ? 'Đã mua hàng' : 'Verified Buyer' }}</span>
                        </div>
                        <span style="color: #D68E1D; font-size: 14px;">★★★★★</span>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: #2F221A; margin: 0 0 8px 0;">{{ $locale === 'vi' ? 'Sản phẩm vượt mong đợi trong tầm giá' : 'Exceeded expectations for the price' }}</h4>
                    <p style="color: #5C4A3E; font-size: 13.5px; line-height: 1.6; margin: 0 0 12px 0;">{{ $locale === 'vi' ? 'Tay quay trợ lực tốt, xay 20g hạt chỉ mất tầm 40 giây nhẹ nhàng. Cối tháo rời vệ sinh dễ dàng bằng chổi đi kèm. Rất ưng ý với phụ kiện của S54.' : 'Smooth grinding motion, effortless to grind 20g of beans. Detaches easily for quick cleaning.' }}</p>
                    <span style="font-size: 12px; color: #8A7B70;">{{ $locale === 'vi' ? 'Đánh giá ngày 12/09/2026' : 'Reviewed on Sep 12, 2026' }}</span>
                </div>

                <div style="background: #FFFFFF; padding: 24px; border-radius: 12px; border: 1px solid #EBE7E1; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div>
                            <strong style="color: #2F221A; font-size: 15px; display: block;">Lê Phương Thảo</strong>
                            <span style="display: inline-block; background: #E8F5E9; color: #2E7D32; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 10px; margin-top: 4px;">✓ {{ $locale === 'vi' ? 'Đã mua hàng' : 'Verified Buyer' }}</span>
                        </div>
                        <span style="color: #D68E1D; font-size: 14px;">★★★★★</span>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: #2F221A; margin: 0 0 8px 0;">{{ $locale === 'vi' ? 'Nhỏ gọn mang đi du lịch cực tiện' : 'Compact and great for traveling' }}</h4>
                    <p style="color: #5C4A3E; font-size: 13.5px; line-height: 1.6; margin: 0 0 12px 0;">{{ $locale === 'vi' ? 'Máy nhỏ gọn, mang đi cắm trại hay văn phòng đều rất tiện. Xay hạt mộc thơm nức mũi, không có tiếng ồn lớn. Shop tư vấn nhiệt tình, giao hàng nhanh.' : 'Portable and stylish. Coffee smells amazing right after grinding. Fast delivery and friendly support.' }}</p>
                    <span style="font-size: 12px; color: #8A7B70;">{{ $locale === 'vi' ? 'Đánh giá ngày 18/09/2026' : 'Reviewed on Sep 18, 2026' }}</span>
                </div>
            @elseif($isInstant)
                <div style="background: #FFFFFF; padding: 24px; border-radius: 12px; border: 1px solid #EBE7E1; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div>
                            <strong style="color: #2F221A; font-size: 15px; display: block;">Trần Thu Hương</strong>
                            <span style="display: inline-block; background: #E8F5E9; color: #2E7D32; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 10px; margin-top: 4px;">✓ {{ $locale === 'vi' ? 'Đã mua hàng' : 'Verified Buyer' }}</span>
                        </div>
                        <span style="color: #D68E1D; font-size: 14px;">★★★★★</span>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: #2F221A; margin: 0 0 8px 0;">{{ $locale === 'vi' ? 'Cà phê hòa tan 3in1 tiện lợi, vị đậm đà' : 'Convenient 3in1 instant coffee, rich taste' }}</h4>
                    <p style="color: #5C4A3E; font-size: 13.5px; line-height: 1.6; margin: 0 0 12px 0;">{{ $locale === 'vi' ? 'Gói tiện mang lên văn phòng. Vị ngọt vừa phải béo bùi, uống tỉnh táo suốt cả ngày làm việc. Cả phòng mình đều ghiền loại này của S54.' : 'Perfect for the office. Balanced sweetness and richness, keeps me focused all workday.' }}</p>
                    <span style="font-size: 12px; color: #8A7B70;">{{ $locale === 'vi' ? 'Đánh giá ngày 24/08/2026' : 'Reviewed on Aug 24, 2026' }}</span>
                </div>

                <div style="background: #FFFFFF; padding: 24px; border-radius: 12px; border: 1px solid #EBE7E1; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div>
                            <strong style="color: #2F221A; font-size: 15px; display: block;">Phạm Văn Đức</strong>
                            <span style="display: inline-block; background: #E8F5E9; color: #2E7D32; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 10px; margin-top: 4px;">✓ {{ $locale === 'vi' ? 'Đã mua hàng' : 'Verified Buyer' }}</span>
                        </div>
                        <span style="color: #D68E1D; font-size: 14px;">★★★★★</span>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: #2F221A; margin: 0 0 8px 0;">{{ $locale === 'vi' ? 'Pha đá cực ngon, thơm chuẩn gu Việt' : 'Super delicious with ice, authentic Vietnamese flavor' }}</h4>
                    <p style="color: #5C4A3E; font-size: 13.5px; line-height: 1.6; margin: 0 0 12px 0;">{{ $locale === 'vi' ? 'Mình hay pha 2 gói với ít nước nóng rồi thêm đá đầy ly. Vị cà phê đậm rõ nét chứ không bị lờ lợ như các loại hòa tan thông thường trên thị trường.' : 'Dissolve 2 sachets in a bit of hot water then add ice. True coffee body without artificial aftertaste.' }}</p>
                    <span style="font-size: 12px; color: #8A7B70;">{{ $locale === 'vi' ? 'Đánh giá ngày 02/09/2026' : 'Reviewed on Sep 02, 2026' }}</span>
                </div>

                <div style="background: #FFFFFF; padding: 24px; border-radius: 12px; border: 1px solid #EBE7E1; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div>
                            <strong style="color: #2F221A; font-size: 15px; display: block;">Hoàng Minh Anh</strong>
                            <span style="display: inline-block; background: #E8F5E9; color: #2E7D32; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 10px; margin-top: 4px;">✓ {{ $locale === 'vi' ? 'Đã mua hàng' : 'Verified Buyer' }}</span>
                        </div>
                        <span style="color: #D68E1D; font-size: 14px;">★★★★★</span>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: #2F221A; margin: 0 0 8px 0;">{{ $locale === 'vi' ? 'Giao hàng nhanh, đóng gói chỉn chu' : 'Fast delivery, thoughtful packaging' }}</h4>
                    <p style="color: #5C4A3E; font-size: 13.5px; line-height: 1.6; margin: 0 0 12px 0;">{{ $locale === 'vi' ? 'Túi 456g nhiều gói dùng được cả tháng. Hạn sử dụng mới nguyên, bao bì sang trọng làm quà tặng cũng rất thích hợp.' : 'Generous 456g pack lasts the whole month. Fresh batch with great packaging.' }}</p>
                    <span style="font-size: 12px; color: #8A7B70;">{{ $locale === 'vi' ? 'Đánh giá ngày 14/09/2026' : 'Reviewed on Sep 14, 2026' }}</span>
                </div>
            @else
                <div style="background: #FFFFFF; padding: 24px; border-radius: 12px; border: 1px solid #EBE7E1; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div>
                            <strong style="color: #2F221A; font-size: 15px; display: block;">Nguyễn Hoàng Minh</strong>
                            <span style="display: inline-block; background: #E8F5E9; color: #2E7D32; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 10px; margin-top: 4px;">✓ {{ $locale === 'vi' ? 'Đã mua hàng' : 'Verified Buyer' }}</span>
                        </div>
                        <span style="color: #D68E1D; font-size: 14px;">★★★★★</span>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: #2F221A; margin: 0 0 8px 0;">{{ $locale === 'vi' ? 'Hương vị cà phê nguyên bản rất thơm ngon' : 'Authentic and fragrant coffee beans' }}</h4>
                    <p style="color: #5C4A3E; font-size: 13.5px; line-height: 1.6; margin: 0 0 12px 0;">{{ $locale === 'vi' ? 'Hạt rang chuẩn mộc, mở túi ra mùi thơm lan tỏa khắp phòng. Vị đậm đà êm dịu, không bị khét hay chua gắt, pha phin hay pha máy đều tuyệt vời.' : 'Pure artisan roast, incredible aroma upon opening the bag. Rich body, smooth finish with zero harshness.' }}</p>
                    <span style="font-size: 12px; color: #8A7B70;">{{ $locale === 'vi' ? 'Đánh giá ngày 18/08/2026' : 'Reviewed on Aug 18, 2026' }}</span>
                </div>

                <div style="background: #FFFFFF; padding: 24px; border-radius: 12px; border: 1px solid #EBE7E1; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div>
                            <strong style="color: #2F221A; font-size: 15px; display: block;">Đặng Hải Nam</strong>
                            <span style="display: inline-block; background: #E8F5E9; color: #2E7D32; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 10px; margin-top: 4px;">✓ {{ $locale === 'vi' ? 'Đã mua hàng' : 'Verified Buyer' }}</span>
                        </div>
                        <span style="color: #D68E1D; font-size: 14px;">★★★★★</span>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: #2F221A; margin: 0 0 8px 0;">{{ $locale === 'vi' ? 'Robusta rang mộc chuẩn gu người sành' : 'Perfect artisan Robusta for coffee lovers' }}</h4>
                    <p style="color: #5C4A3E; font-size: 13.5px; line-height: 1.6; margin: 0 0 12px 0;">{{ $locale === 'vi' ? 'Hạt đều màu, không dầu bóng mỡ, lớp crema khi pha espresso dày dặn và giữ lâu. Hậu vị ngọt sâu rất dễ chịu.' : 'Consistent roast with no oily coating. Thick, persistent crema on espresso with sweet lingering finish.' }}</p>
                    <span style="font-size: 12px; color: #8A7B70;">{{ $locale === 'vi' ? 'Đánh giá ngày 29/08/2026' : 'Reviewed on Aug 29, 2026' }}</span>
                </div>

                <div style="background: #FFFFFF; padding: 24px; border-radius: 12px; border: 1px solid #EBE7E1; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div>
                            <strong style="color: #2F221A; font-size: 15px; display: block;">Vũ Thị Mai</strong>
                            <span style="display: inline-block; background: #E8F5E9; color: #2E7D32; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 10px; margin-top: 4px;">✓ {{ $locale === 'vi' ? 'Đã mua hàng' : 'Verified Buyer' }}</span>
                        </div>
                        <span style="color: #D68E1D; font-size: 14px;">★★★★★</span>
                    </div>
                    <h4 style="font-size: 15px; font-weight: 700; color: #2F221A; margin: 0 0 8px 0;">{{ $locale === 'vi' ? 'Túi có van 1 chiều bảo quản cà phê rất tốt' : 'High quality one-way valve keeps beans fresh' }}</h4>
                    <p style="color: #5C4A3E; font-size: 13.5px; line-height: 1.6; margin: 0 0 12px 0;">{{ $locale === 'vi' ? 'Mình mua dùng cho gia đình uống hàng ngày. Cà phê giữ hương thơm rất lâu sau cả tháng mở túi. Đặt hàng hôm trước hôm sau đã nhận được.' : 'We use it daily at home. Fragrance remains fresh even weeks after opening. Fast shipping!' }}</p>
                    <span style="font-size: 12px; color: #8A7B70;">{{ $locale === 'vi' ? 'Đánh giá ngày 10/09/2026' : 'Reviewed on Sep 10, 2026' }}</span>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- RELATED PRODUCTS SECTION --}}
@php
    $relItems = $relatedProducts ?? \App\Models\Product::where('is_active', true)->where('id', '!=', $product->id)->take(4)->get();
@endphp
@if($relItems->isNotEmpty())
<section class="s54-related-section" style="background-color: #FAF6F1; padding: 70px 20px 80px; border-top: 1px solid #EBE7E1;">
    <div class="o-wrapper" style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 36px;">
            <span style="color: #D68E1D; font-size: 12px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 8px;">
                {{ $locale === 'vi' ? 'KHÁM PHÁ THÊM' : 'DISCOVER MORE' }}
            </span>
            <h2 style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; font-size: clamp(24px, 3vw, 32px); font-weight: 700; color: #2F221A; margin: 0;">
                {{ $locale === 'vi' ? 'Sản Phẩm Tương Tự' : 'Related Products' }}
            </h2>
        </div>
        <div class="s54-related-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 24px;">
            @foreach($relItems as $relProduct)
                <x-client::product-card :product="$relProduct" />
            @endforeach
        </div>
    </div>
</section>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── Gallery Thumbnail Switching ──
    const thumbs = document.querySelectorAll('#s54-blade-thumbs .s54-gallery-thumb');
    const mainImg = document.getElementById('s54-main-image');
    const counter = document.getElementById('s54-blade-counter');
    const prevBtn = document.getElementById('s54-blade-prev');
    const nextBtn = document.getElementById('s54-blade-next');
    let curIdx = 0;

    if (thumbs.length && mainImg) {
        function setIdx(idx) {
            if (idx < 0) idx = thumbs.length - 1;
            if (idx >= thumbs.length) idx = 0;
            curIdx = idx;

            const targetSrc = thumbs[curIdx].getAttribute('data-src');
            mainImg.style.opacity = '0.35';
            setTimeout(function() {
                mainImg.src = targetSrc;
                mainImg.style.opacity = '1';
            }, 120);

            thumbs.forEach(function(th, i) {
                if (i === curIdx) {
                    th.classList.add('is-active');
                    th.style.borderColor = '#2F221A';
                } else {
                    th.classList.remove('is-active');
                    th.style.borderColor = 'transparent';
                }
            });

            if (counter) {
                counter.textContent = (curIdx + 1) + ' / ' + thumbs.length;
            }
        }

        thumbs.forEach(function(th, i) {
            th.addEventListener('click', function() { setIdx(i); });
            th.addEventListener('mouseenter', function() { setIdx(i); });
        });

        if (prevBtn) prevBtn.addEventListener('click', function() { setIdx(curIdx - 1); });
        if (nextBtn) nextBtn.addEventListener('click', function() { setIdx(curIdx + 1); });
    }

    // ── Variant Selection ──
    const variantBtns = document.querySelectorAll('.s54-variant-btn');
    const detailAddBtn = document.getElementById('s54-detail-add-btn');
    const priceDisplay = document.querySelector('#s54-product-price-display');

    variantBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            variantBtns.forEach(function(b) {
                b.classList.remove('is-selected');
                b.style.borderColor = '#D0C8C0';
                b.style.background = '#FFFFFF';
                b.style.color = '#2F221A';
            });
            this.classList.add('is-selected');
            this.style.borderColor = '#2F221A';
            this.style.background = '#2F221A';
            this.style.color = '#FAF6F1';

            const varId = this.dataset.variantId;
            const varPrice = this.dataset.variantPrice;
            const varPriceFormatted = this.dataset.variantPriceFormatted;

            if (detailAddBtn) {
                detailAddBtn.dataset.variantId = varId || '';
                detailAddBtn.dataset.productPrice = varPrice || '';
            }
            if (priceDisplay && varPriceFormatted) {
                priceDisplay.textContent = varPriceFormatted;
            }
        });
    });

    // ── Interactive Tabs Switching ──
    const tabToggles = document.querySelectorAll('.s54-tab-toggle');
    const tabPanes = document.querySelectorAll('.s54-tab-pane');

    tabToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const targetId = this.dataset.target;

            tabToggles.forEach(function(t) {
                t.classList.remove('is-active');
                t.style.color = '#7A6D65';
                t.style.borderBottomColor = 'transparent';
                t.style.fontWeight = '600';
            });

            this.classList.add('is-active');
            this.style.color = '#2F221A';
            this.style.borderBottomColor = '#2F221A';
            this.style.fontWeight = '700';

            tabPanes.forEach(function(pane) {
                if (pane.id === targetId) {
                    pane.style.display = 'block';
                    pane.classList.add('is-active');
                } else {
                    pane.style.display = 'none';
                    pane.classList.remove('is-active');
                }
            });
        });
    });
});
</script>
@endpush
@endsection

