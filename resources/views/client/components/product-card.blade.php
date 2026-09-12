@props(['product'])

@php
    $locale = app()->getLocale();
    $minPrice = $product->variants->where('is_active', true)->min('price') ?? $product->price ?? 145000;
    $defaultVariant = $product->variants->first();
    $thumbnail = $product->image_url ?? $product->images->first()?->image_url ?? 'client-assets/images/s54/robusta_1.jpg';
    if (!str_starts_with($thumbnail, 'http') && !str_starts_with($thumbnail, 'client-assets') && !str_starts_with($thumbnail, 'assets')) {
        $thumbnail = asset('client-assets/' . ltrim($thumbnail, '/'));
    } elseif (!str_starts_with($thumbnail, 'http')) {
        $thumbnail = asset($thumbnail);
    }
    
    $title = is_array($product->name) ? ($product->name[$locale] ?? $product->name['vi'] ?? '') : ($product->getTranslation('name', $locale, false) ?: $product->name);
    $excerpt = is_array($product->short_description) ? ($product->short_description[$locale] ?? $product->short_description['vi'] ?? '') : ($product->getTranslation('short_description', $locale, false) ?: $product->short_description ?: 'Cà phê rang mộc thượng hạng S54');
    $badge = $locale === 'vi' ? 'ĐỘC QUYỀN ONLINE' : 'ONLINE EXCLUSIVE';
@endphp

<div class="o-product-thumbnail o-products-list__product c-featured-collections__product" data-product-id="{{ $product->id }}">
    <div class="o-product-thumbnail__inner">
        <a href="{{ route('client.products.show', ['locale' => $locale, 'slug' => $product->slug]) }}" class="o-product-thumbnail__link">
            <div class="o-product-thumbnail__image-container">
                <img src="{{ $thumbnail }}" alt="{{ $title }}" loading="lazy" class="o-product-thumbnail__image">
            </div>
            
            <div class="o-product-thumbnail__badge">{{ $badge }}</div>
            
            <h3 class="o-product-thumbnail__title">{{ $title }}</h3>
            
            <div class="s54-thumb-reviews-bar" aria-label="Đánh giá 4.8 trên 5 sao (765 đánh giá)">
              <div class="s54-thumb-stars">
                <svg class="s54-thumb-star" viewBox="0 0 20 20" fill="#D68E1D" width="13" height="13" aria-hidden="true"><path d="M10 1.5l2.6 5.3 5.9.8-4.2 4.1 1 5.8-5.3-2.8-5.3 2.8 1-5.8-4.2-4.1 5.9-.8 2.6-5.3z"/></svg>
                <svg class="s54-thumb-star" viewBox="0 0 20 20" fill="#D68E1D" width="13" height="13" aria-hidden="true"><path d="M10 1.5l2.6 5.3 5.9.8-4.2 4.1 1 5.8-5.3-2.8-5.3 2.8 1-5.8-4.2-4.1 5.9-.8 2.6-5.3z"/></svg>
                <svg class="s54-thumb-star" viewBox="0 0 20 20" fill="#D68E1D" width="13" height="13" aria-hidden="true"><path d="M10 1.5l2.6 5.3 5.9.8-4.2 4.1 1 5.8-5.3-2.8-5.3 2.8 1-5.8-4.2-4.1 5.9-.8 2.6-5.3z"/></svg>
                <svg class="s54-thumb-star" viewBox="0 0 20 20" fill="#D68E1D" width="13" height="13" aria-hidden="true"><path d="M10 1.5l2.6 5.3 5.9.8-4.2 4.1 1 5.8-5.3-2.8-5.3 2.8 1-5.8-4.2-4.1 5.9-.8 2.6-5.3z"/></svg>
                <svg class="s54-thumb-star" viewBox="0 0 20 20" fill="#D68E1D" width="13" height="13" aria-hidden="true"><path d="M10 1.5l2.6 5.3 5.9.8-4.2 4.1 1 5.8-5.3-2.8-5.3 2.8 1-5.8-4.2-4.1 5.9-.8 2.6-5.3z"/></svg>
              </div>
              <span class="s54-thumb-rating-score">4.8</span>
              <span class="s54-thumb-rating-sep">•</span>
              <span class="s54-thumb-rating-count">(765)</span>
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
