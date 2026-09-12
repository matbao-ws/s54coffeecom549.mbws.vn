@props(['product'])

@php
    $locale = app()->getLocale();
    $minPrice = $product->variants->where('is_active', true)->min('price') ?? $product->price ?? 145000;
    $defaultVariant = $product->variants->first();
    $thumbnail = $product->image_url ?? $product->images->first()?->image_url ?? 'assets/images/s54/products/tui_3in1_456g.jpg';
    if (!str_starts_with($thumbnail, 'http') && !str_starts_with($thumbnail, 'client-assets') && !str_starts_with($thumbnail, 'assets') && !str_starts_with($thumbnail, 'storage') && !str_starts_with($thumbnail, '/storage')) {
        $thumbnail = asset('client-assets/' . ltrim($thumbnail, '/'));
    } elseif (!str_starts_with($thumbnail, 'http')) {
        $thumbnail = asset(ltrim($thumbnail, '/'));
    }
    
    $title = is_array($product->name) ? ($product->name[$locale] ?? $product->name['vi'] ?? '') : ($product->getTranslation('name', $locale, false) ?: $product->name);
    $excerpt = is_array($product->short_description) ? ($product->short_description[$locale] ?? $product->short_description['vi'] ?? '') : ($product->getTranslation('short_description', $locale, false) ?: $product->short_description ?: 'Cà phê rang mộc thượng hạng S54');
    $badge = $locale === 'vi' ? 'ĐỘC QUYỀN ONLINE' : 'ONLINE EXCLUSIVE';
@endphp

<div class="o-product-thumbnail o-products-list__product c-featured-collections__product" data-product-id="{{ $product->id }}">
    <div class="o-product-thumbnail__inner">
        <a href="{{ route('client.products.show', ['locale' => $locale, 'slug' => $product->slug]) }}" class="o-product-thumbnail__link">
            <div class="o-product-thumbnail__image-container">
                <img src="{{ $thumbnail }}" alt="{{ $title }}" loading="lazy" class="o-product-thumbnail__image" onerror="this.onerror=null;this.src='{{ asset('assets/images/s54/products/tui_3in1_456g.jpg') }}';">
            </div>
            
            <div class="o-product-thumbnail__badge">{{ $badge }}</div>
            
            <h3 class="o-product-thumbnail__title">{{ $title }}</h3>
            
            <div class="s54-thumb-reviews-bar" aria-label="Đánh giá 4.8 trên 5 sao (765 đánh giá)" style="display: flex !important; flex-direction: row !important; align-items: center !important; justify-content: center !important; gap: 5px !important; margin: 6px auto 8px auto !important; width: 100% !important; line-height: 1 !important;">
              <div class="s54-thumb-stars" style="display: inline-flex !important; flex-direction: row !important; align-items: center !important; gap: 2.5px !important; flex-shrink: 0 !important; white-space: nowrap !important;">
                <svg class="s54-thumb-star" viewBox="0 0 20 20" fill="#D68E1D" width="13" height="13" style="width: 13px !important; height: 13px !important; min-width: 13px !important; max-width: 13px !important; min-height: 13px !important; max-height: 13px !important; display: inline-block !important; vertical-align: middle !important; fill: #D68E1D !important; flex-shrink: 0 !important;" aria-hidden="true"><path d="M10 1.5l2.6 5.3 5.9.8-4.2 4.1 1 5.8-5.3-2.8-5.3 2.8 1-5.8-4.2-4.1 5.9-.8 2.6-5.3z"/></svg>
                <svg class="s54-thumb-star" viewBox="0 0 20 20" fill="#D68E1D" width="13" height="13" style="width: 13px !important; height: 13px !important; min-width: 13px !important; max-width: 13px !important; min-height: 13px !important; max-height: 13px !important; display: inline-block !important; vertical-align: middle !important; fill: #D68E1D !important; flex-shrink: 0 !important;" aria-hidden="true"><path d="M10 1.5l2.6 5.3 5.9.8-4.2 4.1 1 5.8-5.3-2.8-5.3 2.8 1-5.8-4.2-4.1 5.9-.8 2.6-5.3z"/></svg>
                <svg class="s54-thumb-star" viewBox="0 0 20 20" fill="#D68E1D" width="13" height="13" style="width: 13px !important; height: 13px !important; min-width: 13px !important; max-width: 13px !important; min-height: 13px !important; max-height: 13px !important; display: inline-block !important; vertical-align: middle !important; fill: #D68E1D !important; flex-shrink: 0 !important;" aria-hidden="true"><path d="M10 1.5l2.6 5.3 5.9.8-4.2 4.1 1 5.8-5.3-2.8-5.3 2.8 1-5.8-4.2-4.1 5.9-.8 2.6-5.3z"/></svg>
                <svg class="s54-thumb-star" viewBox="0 0 20 20" fill="#D68E1D" width="13" height="13" style="width: 13px !important; height: 13px !important; min-width: 13px !important; max-width: 13px !important; min-height: 13px !important; max-height: 13px !important; display: inline-block !important; vertical-align: middle !important; fill: #D68E1D !important; flex-shrink: 0 !important;" aria-hidden="true"><path d="M10 1.5l2.6 5.3 5.9.8-4.2 4.1 1 5.8-5.3-2.8-5.3 2.8 1-5.8-4.2-4.1 5.9-.8 2.6-5.3z"/></svg>
                <svg class="s54-thumb-star" viewBox="0 0 20 20" fill="#D68E1D" width="13" height="13" style="width: 13px !important; height: 13px !important; min-width: 13px !important; max-width: 13px !important; min-height: 13px !important; max-height: 13px !important; display: inline-block !important; vertical-align: middle !important; fill: #D68E1D !important; flex-shrink: 0 !important;" aria-hidden="true"><path d="M10 1.5l2.6 5.3 5.9.8-4.2 4.1 1 5.8-5.3-2.8-5.3 2.8 1-5.8-4.2-4.1 5.9-.8 2.6-5.3z"/></svg>
              </div>
              <span class="s54-thumb-rating-score" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important; font-size: 13px !important; font-weight: 700 !important; color: #2F221A !important; line-height: 1 !important; margin-left: 2px !important;">4.8</span>
              <span class="s54-thumb-rating-sep" style="font-size: 11px !important; color: #A58A79 !important; line-height: 1 !important; opacity: 0.8 !important; margin: 0 1px !important;">•</span>
              <span class="s54-thumb-rating-count" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important; font-size: 12px !important; font-weight: 500 !important; color: #7B685B !important; line-height: 1 !important;">(765)</span>
            </div>
            
            <p class="o-product-thumbnail__excerpt">{{ $excerpt }}</p>
        </a>

        <div class="o-product-thumbnail__content">
            <div class="o-product-thumbnail__content-inner">
                <p class="o-product-thumbnail__price">{{ number_format($minPrice, 0, ',', '.') }}₫</p>
            </div>

            <div class="o-product-thumbnail__hover">
                <button type="button" class="o-product-thumbnail__add-btn s54-quick-add-btn" 
                        data-product-id="{{ $product->id }}" 
                        data-variant-id="{{ $defaultVariant?->id ?? $product->id }}"
                        data-product-name="{{ $title }}"
                        data-product-price="{{ $minPrice }}"
                        data-product-image="{{ $thumbnail }}">
                    {{ $locale === 'vi' ? 'Thêm Vào Giỏ' : 'Add to Cart' }}
                </button>
            </div>
        </div>
    </div>
</div>
