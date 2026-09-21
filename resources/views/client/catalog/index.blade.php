@extends('client.layouts.app')

@php
    $locale = app()->getLocale();
    $site = app(\App\Services\SiteContentService::class);
    $catalogBanner = $site->image('catalog.hero.banner', '');
    $canEdit = (bool) (auth()->user()?->canEditClientContent() && auth()->user()->can('media.view'));
@endphp

@section('title', ($locale === 'vi' ? 'Tất Cả Sản Phẩm Cà Phê S54 — Cà Phê Hạt Rang Mộc & Hòa Tan' : 'All S54 Coffee Products — Artisan Roasted Beans & Instant'))
@section('meta_description', ($locale === 'vi' ? 'Khám phá bộ sưu tập cà phê S54 COFFEE: cà phê hòa tan 3in1, cà phê hạt rang Robusta nguyên chất, combo dùng thử, và máy xay cà phê cầm tay cao cấp.' : 'Explore S54 COFFEE collection: 3-in-1 instant coffee, roasted Robusta beans, trial combos, and premium manual coffee grinders.'))

@section('content')
<section class="s54-catalog-hero" style="background: {{ $catalogBanner ? "radial-gradient(circle at center, rgba(47,34,26,0.82) 0%, rgba(26,18,14,0.95) 100%), url('{$catalogBanner}') center/cover no-repeat" : '#2F221A' }}; color: #FAF6F1; padding: 70px 20px 50px; text-align: center; position: relative;">
    @if($canEdit)
        <div style="position: absolute; top: 16px; right: 20px; z-index: 10;">
            <button type="button" class="s54-edit-banner-trigger" data-block-key="catalog.hero.banner" data-block-type="image" src="{{ $catalogBanner }}" title="{{ $locale === 'vi' ? 'Click để thay đổi ảnh nền banner Cửa hàng' : 'Click to change Catalog banner' }}" style="background: rgba(31,41,55,0.9); color: #fff; border: 1px solid rgba(255,255,255,0.3); border-radius: 20px; padding: 6px 14px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; backdrop-filter: blur(4px); box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                <span>📷 {{ $locale === 'vi' ? 'Đổi ảnh banner' : 'Change banner' }}</span>
            </button>
        </div>
    @endif
    <div class="o-wrapper" style="max-width: 960px; margin: 0 auto; position: relative; z-index: 1;">
        <x-client::editable key="catalog.hero.title" tag="h1" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: clamp(30px, 4vw, 42px); font-weight: 700; margin-bottom: 12px; color: #FAF6F1 !important;">
            {{ $locale === 'vi' ? 'Bộ Sưu Tập Cà Phê S54' : 'S54 Coffee Collection' }}
        </x-client::editable>
        <x-client::editable key="catalog.hero.subtitle" tag="p" style="color: #D6C7BC !important; font-size: clamp(14px, 1.8vw, 15px); max-width: 600px; margin: 0 auto; line-height: 1.6;">
            {{ $locale === 'vi' ? '100% Cà phê nguyên chất tuyển chọn từ Đắk Lắk & Cầu Đất, rang mộc công nghệ cao.' : '100% pure artisan coffee beans from Dak Lak & Cau Dat.' }}
        </x-client::editable>
    </div>
</section>

<section style="background-color: #FAF8F5; padding: 50px 20px 80px;">
    <div class="o-wrapper" style="max-width: 1440px; margin: 0 auto; padding: 0 clamp(20px, 4vw, 48px);">
        
        {{-- Category Pills --}}
        <div style="display: flex; justify-content: center; gap: 10px; margin-bottom: 40px; flex-wrap: wrap;">
            <a href="{{ route('client.catalog.index', ['locale' => $locale]) }}" 
               style="padding: 8px 20px; border-radius: 30px; font-size: 12px; font-weight: 700; text-transform: uppercase; text-decoration: none; background-color: {{ !request('category') ? '#2F221A' : '#EBE7E1' }}; color: {{ !request('category') ? '#FAF6F1' : '#2F221A' }};">
                {{ $locale === 'vi' ? 'Tất Cả' : 'All' }}
            </a>
            @foreach($categories ?? [] as $cat)
                @php
                    $catName = is_array($cat->name) ? ($cat->name[$locale] ?? $cat->name['vi'] ?? '') : ($cat->getTranslation('name', $locale, false) ?: $cat->name);
                @endphp
                <a href="{{ route('client.catalog.index', ['locale' => $locale, 'category' => $cat->slug]) }}" 
                   style="padding: 8px 20px; border-radius: 30px; font-size: 12px; font-weight: 700; text-transform: uppercase; text-decoration: none; background-color: {{ request('category') === $cat->slug ? '#2F221A' : '#EBE7E1' }}; color: {{ request('category') === $cat->slug ? '#FAF6F1' : '#2F221A' }};">
                    {{ $catName }}
                </a>
            @endforeach
        </div>

        {{-- Product Grid --}}
        <div class="o-products-list__products">
            @forelse($products as $prod)
                <x-client::product-card :product="$prod" />
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #8A7B70;">
                    <p style="font-size: 32px;">☕</p>
                    <p style="font-size: 16px; font-weight: 600;">{{ $locale === 'vi' ? 'Không tìm thấy sản phẩm phù hợp.' : 'No products found.' }}</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if(method_exists($products, 'links'))
            <div style="margin-top: 50px; display: flex; justify-content: center;">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
