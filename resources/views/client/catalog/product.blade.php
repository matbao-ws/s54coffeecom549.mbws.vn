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
@endphp

@section('title', $title . ' — S54 COFFEE')

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
                        <span>100% CHÍNH HÃNG • S54 COFFEE</span>
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
                        <div class="s54-rating-stars" aria-label="4.8 trên 5 sao" style="display: inline-flex !important; flex-direction: row !important; align-items: center !important; gap: 3px !important; flex-shrink: 0 !important; white-space: nowrap !important;">
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

                <p style="color: #5C4A3E; line-height: 1.6; margin-bottom: 24px; font-size: 14.5px;">
                    {{ $shortDesc ?: $desc }}
                </p>

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
                <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 30px;">
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

                {{-- Highlights Box --}}
                <div style="background: #F3EEE8; border-radius: 8px; padding: 20px; font-size: 13px; color: #5C4A3E; line-height: 1.8;">
                    <div>✓ <strong>{{ $locale === 'vi' ? 'Xuất xứ:' : 'Origin:' }}</strong> Đắk Lắk & Cầu Đất (Lâm Đồng)</div>
                    <div>✓ <strong>{{ $locale === 'vi' ? 'Công nghệ:' : 'Technology:' }}</strong> {{ $locale === 'vi' ? 'Rang Hot-Air hồi khí của Đức' : 'German Convective Hot-Air Roasting' }}</div>
                    <div>✓ <strong>{{ $locale === 'vi' ? 'Cam kết:' : 'Guarantee:' }}</strong> {{ $locale === 'vi' ? '100% Cà phê nguyên chất không tẩm ướp phụ gia' : '100% pure artisan coffee without additives' }}</div>
                    <div>✓ <strong>{{ $locale === 'vi' ? 'Giao hàng:' : 'Shipping:' }}</strong> {{ $locale === 'vi' ? 'Miễn phí toàn quốc cho đơn từ 500.000₫' : 'Free nationwide shipping for orders over 500,000₫' }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const thumbs = document.querySelectorAll('#s54-blade-thumbs .s54-gallery-thumb');
    const mainImg = document.getElementById('s54-main-image');
    const counter = document.getElementById('s54-blade-counter');
    const prevBtn = document.getElementById('s54-blade-prev');
    const nextBtn = document.getElementById('s54-blade-next');
    let curIdx = 0;

    if (!thumbs.length || !mainImg) return;

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

    // Variant selection
    const variantBtns = document.querySelectorAll('.s54-variant-btn');
    const detailAddBtn = document.getElementById('s54-detail-add-btn');
    const priceDisplay = document.querySelector('.s54-product-price-main') || document.querySelector('.o-product-thumbnail__price');

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
});
</script>
@endpush
@endsection

