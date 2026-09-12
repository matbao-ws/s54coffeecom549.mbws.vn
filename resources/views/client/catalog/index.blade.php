@extends('client.layouts.app')

@php
    $locale = app()->getLocale();
@endphp

@section('title', ($locale === 'vi' ? 'Tất Cả Sản Phẩm Cà Phê S54 — Cà Phê Hạt Rang Mộc & Hòa Tan' : 'All S54 Coffee Products — Artisan Roasted Beans & Instant'))

@section('content')
<section style="background-color: #2F221A; color: #FAF6F1; padding: 60px 20px 40px; text-align: center;">
    <h1 style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 42px; font-weight: 700; margin-bottom: 12px; color: #FAF6F1 !important;">
        {{ $locale === 'vi' ? 'Bộ Sưu Tập Cà Phê S54' : 'S54 Coffee Collection' }}
    </h1>
    <p style="color: #D6C7BC !important; font-size: 15px; max-width: 600px; margin: 0 auto;">
        {{ $locale === 'vi' ? '100% Cà phê nguyên chất tuyển chọn từ Đắk Lắk & Cầu Đất, rang mộc công nghệ cao.' : '100% pure artisan coffee beans from Dak Lak & Cau Dat.' }}
    </p>
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
