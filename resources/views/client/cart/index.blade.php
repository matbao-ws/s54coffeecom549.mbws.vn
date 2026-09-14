@extends('client.layouts.app')

@php
    $locale = app()->getLocale();
@endphp

@section('title', ($locale === 'vi' ? 'Giỏ Hàng Của Bạn' : 'Your Shopping Cart') . ' — S54 COFFEE')

@section('content')
<section style="background-color: #FAF8F5; padding: clamp(28px, 4vw, 44px) 20px clamp(60px, 7vw, 90px); min-height: 70vh;">
    <div style="max-width: 1120px; margin: 0 auto;">
        
        {{-- Breadcrumb --}}
        <div style="font-size: 13px; color: #8A7B70; margin-bottom: 24px;">
            <a href="{{ route('client.home', ['locale' => $locale]) }}" style="color: #8A7B70; text-decoration: none;">{{ $locale === 'vi' ? 'Trang Chủ' : 'Home' }}</a> / 
            <span style="color: #2F221A; font-weight: 600;">{{ $locale === 'vi' ? 'Giỏ Hàng' : 'Shopping Cart' }}</span>
        </div>

        {{-- Page Header --}}
        <div style="margin-bottom: 28px;">
            <h1 style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: clamp(24px, 2.8vw, 32px); font-weight: 800; color: #2F221A; margin: 0 0 8px 0; letter-spacing: -0.5px;">
                {{ $locale === 'vi' ? 'Giỏ Hàng Của Bạn' : 'Your Shopping Cart' }} (<span id="cart-page-count">0</span>)
            </h1>
            <p style="font-size: 14px; color: #6E6259; margin: 0;">
                {{ $locale === 'vi' ? 'Kiểm tra lại các dòng cà phê nguyên chất S54 bạn đã chọn trước khi thanh toán.' : 'Review your selected S54 artisan coffees before proceeding to checkout.' }}
            </p>
        </div>

        {{-- Free Shipping Banner --}}
        <div id="cart-freeship-box" style="background: #FFFFFF; border: 1px solid #EBE7E1; border-radius: 12px; padding: 18px 22px; margin-bottom: 28px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
            <div id="cart-freeship-text" style="font-size: 13.5px; font-weight: 600; color: #2F221A; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                <span>🚚</span>
                <span id="cart-freeship-msg">{{ $locale === 'vi' ? 'Thêm sản phẩm để nhận ưu đãi MIỄN PHÍ VẬN CHUYỂN toàn quốc' : 'Add items to qualify for FREE nationwide shipping' }}</span>
            </div>
            <div style="width: 100%; height: 7px; background: #EFE9E2; border-radius: 4px; overflow: hidden;">
                <div id="cart-freeship-bar" style="width: 0%; height: 100%; background: linear-gradient(90deg, #D68E1D, #EAA83B); border-radius: 4px; transition: width 0.35s ease;"></div>
            </div>
        </div>

        {{-- Cart Content Wrapper --}}
        <div id="cart-empty-container" style="display: none; background: #FFFFFF; border: 1px solid #EBE7E1; border-radius: 12px; padding: 60px 24px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
            <div style="font-size: 48px; margin-bottom: 16px;">☕</div>
            <h2 style="font-size: 18px; font-weight: 700; color: #2F221A; margin: 0 0 10px 0;">{{ $locale === 'vi' ? 'Giỏ hàng của bạn đang trống' : 'Your cart is currently empty' }}</h2>
            <p style="font-size: 14px; color: #6E6259; margin: 0 0 24px 0;">{{ $locale === 'vi' ? 'Hãy khám phá bộ sưu tập cà phê rang xay mộc và hòa tan thượng hạng của S54.' : 'Discover our collection of premium roasted artisan coffees.' }}</p>
            <a href="{{ route('client.catalog.index', ['locale' => $locale]) }}" style="display: inline-block; padding: 14px 32px; background-color: #2F221A; color: #FFFFFF; text-decoration: none; border-radius: 6px; font-weight: 700; font-size: 13px; letter-spacing: 1px; text-transform: uppercase;">
                {{ $locale === 'vi' ? 'Khám Phá Sản Phẩm Ngay' : 'Shop Now' }}
            </a>
        </div>

        <div id="cart-filled-container" style="display: none;">
            <div style="background: #FFFFFF; border: 1px solid #EBE7E1; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.03); margin-bottom: 24px;">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                        <thead>
                            <tr style="background: #FAF8F5; border-bottom: 1px solid #EBE7E1;">
                                <th style="padding: 16px 20px; font-size: 13px; font-weight: 700; color: #554940; text-align: left; text-transform: uppercase; letter-spacing: 0.5px;">{{ $locale === 'vi' ? 'Sản Phẩm' : 'Product' }}</th>
                                <th style="padding: 16px 20px; font-size: 13px; font-weight: 700; color: #554940; text-align: left; text-transform: uppercase; letter-spacing: 0.5px;">{{ $locale === 'vi' ? 'Đơn Giá' : 'Price' }}</th>
                                <th style="padding: 16px 20px; font-size: 13px; font-weight: 700; color: #554940; text-align: center; text-transform: uppercase; letter-spacing: 0.5px;">{{ $locale === 'vi' ? 'Số Lượng' : 'Quantity' }}</th>
                                <th style="padding: 16px 20px; font-size: 13px; font-weight: 700; color: #554940; text-align: right; text-transform: uppercase; letter-spacing: 0.5px;">{{ $locale === 'vi' ? 'Tạm Tính' : 'Total' }}</th>
                                <th style="padding: 16px 20px; width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="cart-table-body">
                            {{-- Injected dynamically --}}
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Summary & Actions --}}
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 24px;">
                <a href="{{ route('client.catalog.index', ['locale' => $locale]) }}" style="color: #6E6259; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; padding: 12px 0;">
                    <span>←</span>
                    <span>{{ $locale === 'vi' ? 'Tiếp tục mua sắm' : 'Continue shopping' }}</span>
                </a>

                <div style="background: #FFFFFF; border: 1px solid #EBE7E1; border-radius: 12px; padding: 24px 28px; width: 100%; max-width: 420px; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 14.5px;">
                        <span style="color: #6E6259;">{{ $locale === 'vi' ? 'Tạm tính giỏ hàng:' : 'Subtotal:' }}</span>
                        <strong id="cart-summary-subtotal" style="color: #2F221A; font-size: 18px;">0₫</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; font-size: 13.5px;">
                        <span style="color: #6E6259;">{{ $locale === 'vi' ? 'Phí vận chuyển:' : 'Shipping:' }}</span>
                        <span id="cart-summary-shipping" style="color: #2E7D32; font-weight: 600;">{{ $locale === 'vi' ? 'Tính ở bước thanh toán' : 'Calculated at checkout' }}</span>
                    </div>
                    <div style="border-top: 1px solid #F0EBE5; padding-top: 16px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: baseline;">
                        <span style="font-size: 15px; font-weight: 700; color: #2F221A;">{{ $locale === 'vi' ? 'Tổng thanh toán ước tính:' : 'Estimated Total:' }}</span>
                        <strong id="cart-summary-total" style="font-size: 22px; font-weight: 800; color: #D68E1D;">0₫</strong>
                    </div>

                    <a href="{{ route('client.checkout', ['locale' => $locale]) }}" id="cart-btn-checkout" style="display: block; width: 100%; text-align: center; background-color: #2F221A; color: #FFFFFF; padding: 15px 24px; border-radius: 6px; font-size: 13.5px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; box-sizing: border-box; transition: background 0.2s;">
                        {{ $locale === 'vi' ? 'TIẾN HÀNH THANH TOÁN' : 'PROCEED TO CHECKOUT' }}
                    </a>

                    <div style="margin-top: 16px; text-align: center; font-size: 12px; color: #8A7B70;">
                        🔒 {{ $locale === 'vi' ? 'Bảo mật thông tin & Thanh toán an toàn 100%' : '100% Secure & Encrypted Checkout' }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const FREE_SHIP_THRESHOLD = 500000;
    const isVi = '{{ $locale }}' === 'vi';

    function formatVND(n) {
        return new Intl.NumberFormat('vi-VN').format(Math.round(n)) + '₫';
    }

    function renderPageCart() {
        const cart = window.S54Cart ? window.S54Cart.getCart() : { items: [], total_price: 0, item_count: 0 };
        const items = cart.items || [];
        const emptyBox = document.getElementById('cart-empty-container');
        const filledBox = document.getElementById('cart-filled-container');
        const countEl = document.getElementById('cart-page-count');
        const tbody = document.getElementById('cart-table-body');
        const subtotalEl = document.getElementById('cart-summary-subtotal');
        const totalEl = document.getElementById('cart-summary-total');
        const freeshipMsg = document.getElementById('cart-freeship-msg');
        const freeshipBar = document.getElementById('cart-freeship-bar');

        if (countEl) countEl.textContent = cart.item_count || items.reduce((s, i) => s + (i.quantity || 1), 0);

        if (items.length === 0) {
            if (emptyBox) emptyBox.style.display = 'block';
            if (filledBox) filledBox.style.display = 'none';
            if (freeshipBar) freeshipBar.style.width = '0%';
            if (freeshipMsg) freeshipMsg.textContent = isVi ? 'Thêm sản phẩm để nhận ưu đãi MIỄN PHÍ VẬN CHUYỂN toàn quốc' : 'Add items for free shipping';
            return;
        }

        if (emptyBox) emptyBox.style.display = 'none';
        if (filledBox) filledBox.style.display = 'block';

        let subtotal = 0;
        let html = '';

        items.forEach(function(it, idx) {
            const qty = it.quantity || 1;
            const price = it.price || 0;
            const line = price * qty;
            subtotal += line;
            const itemKey = it.key || it.id || idx;

            html += `
                <tr style="border-bottom: 1px solid #F0EBE5;">
                    <td style="padding: 18px 20px; vertical-align: middle;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <img src="${it.image || '{{ asset('assets/images/s54/products/tui_3in1_456g.jpg') }}'}" alt="${it.title}" style="width: 64px; height: 64px; object-fit: contain; border-radius: 8px; border: 1px solid #EBE7E1; background: #FAF8F5; flex-shrink: 0;">
                            <div>
                                <h4 style="margin: 0 0 4px 0; font-size: 14px; font-weight: 700; color: #2F221A;">${it.title}</h4>
                                ${it.variant_title ? `<span style="font-size: 12px; color: #8A7B70;">${it.variant_title}</span>` : ''}
                            </div>
                        </div>
                    </td>
                    <td style="padding: 18px 20px; vertical-align: middle; font-size: 14px; font-weight: 600; color: #2F221A;">
                        ${formatVND(price)}
                    </td>
                    <td style="padding: 18px 20px; vertical-align: middle; text-align: center;">
                        <div style="display: inline-flex; align-items: center; border: 1px solid #D0C8C0; border-radius: 6px; background: #FFFFFF; overflow: hidden;">
                            <button type="button" class="btn-qty-mod" data-key="${itemKey}" data-qty="${qty - 1}" style="border: none; background: #FAF8F5; padding: 8px 12px; font-size: 15px; cursor: pointer; color: #2F221A;">−</button>
                            <span style="min-width: 34px; text-align: center; font-size: 13.5px; font-weight: 700; color: #2F221A;">${qty}</span>
                            <button type="button" class="btn-qty-mod" data-key="${itemKey}" data-qty="${qty + 1}" style="border: none; background: #FAF8F5; padding: 8px 12px; font-size: 15px; cursor: pointer; color: #2F221A;">+</button>
                        </div>
                    </td>
                    <td style="padding: 18px 20px; vertical-align: middle; text-align: right; font-size: 15px; font-weight: 700; color: #D68E1D;">
                        ${formatVND(line)}
                    </td>
                    <td style="padding: 18px 20px; vertical-align: middle; text-align: right;">
                        <button type="button" class="btn-qty-mod" data-key="${itemKey}" data-qty="0" aria-label="Xóa" style="background: none; border: none; font-size: 18px; color: #A3968C; cursor: pointer; padding: 4px 8px; line-height: 1;">&times;</button>
                    </td>
                </tr>
            `;
        });

        if (tbody) tbody.innerHTML = html;
        if (subtotalEl) subtotalEl.textContent = formatVND(subtotal);
        if (totalEl) totalEl.textContent = formatVND(subtotal);

        // Free shipping progress calculation
        if (freeshipMsg && freeshipBar) {
            if (subtotal >= FREE_SHIP_THRESHOLD) {
                freeshipMsg.innerHTML = isVi ? '🎉 <strong>Chúc mừng! Bạn đã được MIỄN PHÍ VẬN CHUYỂN toàn quốc!</strong>' : '🎉 <strong>Congratulations! You qualify for FREE Delivery!</strong>';
                freeshipBar.style.width = '100%';
            } else {
                const diff = FREE_SHIP_THRESHOLD - subtotal;
                freeshipMsg.innerHTML = isVi ? `Thêm <strong>${formatVND(diff)}</strong> nữa để được <strong>MIỄN PHÍ VẬN CHUYỂN</strong> toàn quốc!` : `Add <strong>${formatVND(diff)}</strong> more for <strong>FREE Shipping</strong>!`;
                freeshipBar.style.width = Math.min(100, Math.max(8, (subtotal / FREE_SHIP_THRESHOLD) * 100)) + '%';
            }
        }
    }

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-qty-mod');
        if (btn && window.S54Cart) {
            e.preventDefault();
            const key = btn.dataset.key;
            const qty = parseInt(btn.dataset.qty, 10);
            window.S54Cart.updateQuantity(key, qty);
            renderPageCart();
        }
    });

    window.addEventListener('cart:updated', renderPageCart);
    renderPageCart();
});
</script>
@endpush
