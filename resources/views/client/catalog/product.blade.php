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
    
    $firstImg = $images->first()->image_url;
    if (!str_starts_with($firstImg, 'http') && !str_starts_with($firstImg, 'client-assets') && !str_starts_with($firstImg, 'assets')) {
        $firstImg = asset('client-assets/' . ltrim($firstImg, '/'));
    } elseif (!str_starts_with($firstImg, 'http')) {
        $firstImg = asset($firstImg);
    }
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
            <div>
                <div style="background: #FFFFFF; border-radius: 12px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); text-align: center; margin-bottom: 16px;">
                    <img id="s54-main-image" src="{{ $firstImg }}" alt="{{ $title }}" style="max-width: 100%; max-height: 400px; object-fit: contain;">
                </div>
            </div>

            {{-- Product Info & Purchase Form --}}
            <div>
                <span style="display: inline-block; background: #D68E1D; color: #FFFFFF; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; padding: 4px 14px; border-radius: 20px; margin-bottom: 12px;">
                    {{ $locale === 'vi' ? 'ĐỘC QUYỀN ONLINE' : 'ONLINE EXCLUSIVE' }}
                </span>
                
                <h1 class="c-product-main__title" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: clamp(22px, 2.2vw, 28px); font-weight: 700; color: #2F221A; margin-bottom: 12px; line-height: 1.28;">
                    {{ $title }}
                </h1>

                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                    <span style="color: #D68E1D; font-size: 15px;">★★★★★</span>
                    <span style="font-size: 13px; font-weight: 600; color: #2F221A;">4.8 (765 {{ $locale === 'vi' ? 'Đánh giá' : 'Reviews' }})</span>
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
                            data-variant-id="{{ $defaultVariant?->id ?? $product->id }}"
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
@endsection
