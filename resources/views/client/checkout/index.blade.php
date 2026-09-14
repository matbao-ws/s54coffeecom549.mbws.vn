@extends('client.layouts.app')

@php
    $locale = app()->getLocale();
@endphp

@section('title', ($locale === 'vi' ? 'Thanh Toán Đơn Hàng' : 'Checkout') . ' — S54 COFFEE')

@section('content')
<section style="background-color: #FAF8F5; padding: clamp(28px, 4vw, 44px) 20px clamp(60px, 7vw, 90px); min-height: 75vh;">
    <div style="max-width: 1140px; margin: 0 auto;">
        
        {{-- Breadcrumb --}}
        <div style="font-size: 13px; color: #8A7B70; margin-bottom: 24px;">
            <a href="{{ route('client.home', ['locale' => $locale]) }}" style="color: #8A7B70; text-decoration: none;">{{ $locale === 'vi' ? 'Trang Chủ' : 'Home' }}</a> / 
            <a href="{{ route('client.cart', ['locale' => $locale]) }}" style="color: #8A7B70; text-decoration: none;">{{ $locale === 'vi' ? 'Giỏ Hàng' : 'Cart' }}</a> / 
            <span style="color: #2F221A; font-weight: 600;">{{ $locale === 'vi' ? 'Thanh Toán' : 'Checkout' }}</span>
        </div>

        {{-- Page Header --}}
        <div style="margin-bottom: 30px;">
            <h1 style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: clamp(24px, 2.8vw, 32px); font-weight: 800; color: #2F221A; margin: 0 0 6px 0; letter-spacing: -0.5px;">
                {{ $locale === 'vi' ? 'Thanh Toán Đơn Hàng' : 'Secure Checkout' }}
            </h1>
            <p style="font-size: 14px; color: #6E6259; margin: 0;">
                {{ $locale === 'vi' ? 'Quý khách vui lòng điền thông tin nhận hàng bên dưới để S54 Coffee chuẩn bị và giao hàng sớm nhất.' : 'Please enter your shipping and contact details below to complete your order.' }}
            </p>
        </div>

        <div style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 32px; align-items: flex-start;" class="s54-checkout-grid">
            
            {{-- Left Column: Form --}}
            <form id="s54-checkout-form" style="background: #FFFFFF; border: 1px solid #EBE7E1; border-radius: 12px; padding: clamp(20px, 3vw, 32px); box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                
                {{-- Step 1: Shipping Info --}}
                <div style="margin-bottom: 32px;">
                    <h2 style="font-size: 16px; font-weight: 700; color: #2F221A; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 18px 0; padding-bottom: 12px; border-bottom: 1px solid #F0EBE5; display: flex; align-items: center; gap: 8px;">
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; background: #2F221A; color: #FAF6F1; border-radius: 50%; font-size: 12px; font-weight: 700;">1</span>
                        <span>{{ $locale === 'vi' ? 'Thông Tin Giao Hàng' : 'Shipping Information' }}</span>
                    </h2>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;" class="s54-form-row">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #4A3E36; margin-bottom: 6px;">{{ $locale === 'vi' ? 'Họ và tên *' : 'Full Name *' }}</label>
                            <input type="text" id="cust-name" required placeholder="{{ $locale === 'vi' ? 'Nguyễn Văn A' : 'John Doe' }}" style="width: 100%; padding: 11px 14px; border: 1px solid #D0C8C0; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: #FAFAF8;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #4A3E36; margin-bottom: 6px;">{{ $locale === 'vi' ? 'Số điện thoại nhận hàng *' : 'Phone Number *' }}</label>
                            <input type="tel" id="cust-phone" required placeholder="{{ $locale === 'vi' ? '0901 234 567' : '+84 901 234 567' }}" style="width: 100%; padding: 11px 14px; border: 1px solid #D0C8C0; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: #FAFAF8;">
                        </div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #4A3E36; margin-bottom: 6px;">{{ $locale === 'vi' ? 'Địa chỉ email nhận thông báo đơn *' : 'Email Address *' }}</label>
                        <input type="email" id="cust-email" required placeholder="name@example.com" style="width: 100%; padding: 11px 14px; border: 1px solid #D0C8C0; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: #FAFAF8;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;" class="s54-form-row">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #4A3E36; margin-bottom: 6px;">{{ $locale === 'vi' ? 'Tỉnh / Thành phố *' : 'City / Province *' }}</label>
                            <input type="text" id="cust-city" required placeholder="{{ $locale === 'vi' ? 'TP. Hồ Chí Minh' : 'Ho Chi Minh City' }}" style="width: 100%; padding: 11px 14px; border: 1px solid #D0C8C0; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: #FAFAF8;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #4A3E36; margin-bottom: 6px;">{{ $locale === 'vi' ? 'Quận / Huyện *' : 'District *' }}</label>
                            <input type="text" id="cust-district" required placeholder="{{ $locale === 'vi' ? 'Quận 1, TP. Thủ Đức...' : 'District 1...' }}" style="width: 100%; padding: 11px 14px; border: 1px solid #D0C8C0; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: #FAFAF8;">
                        </div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #4A3E36; margin-bottom: 6px;">{{ $locale === 'vi' ? 'Địa chỉ nhận hàng chi tiết *' : 'Street Address *' }}</label>
                        <input type="text" id="cust-address" required placeholder="{{ $locale === 'vi' ? 'Số nhà, tên đường, phường/xã...' : 'Street, Ward, House No.' }}" style="width: 100%; padding: 11px 14px; border: 1px solid #D0C8C0; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: #FAFAF8;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #4A3E36; margin-bottom: 6px;">{{ $locale === 'vi' ? 'Ghi chú cho đơn hàng (tuỳ chọn)' : 'Order Notes (Optional)' }}</label>
                        <textarea id="cust-notes" rows="2" placeholder="{{ $locale === 'vi' ? 'Ghi chú về giờ giao hàng hoặc yêu cầu xay thô/mịn...' : 'Notes about delivery or coffee grind preference...' }}" style="width: 100%; padding: 11px 14px; border: 1px solid #D0C8C0; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: #FAFAF8;"></textarea>
                    </div>
                </div>

                {{-- Step 2: Payment Method --}}
                <div style="margin-bottom: 28px;">
                    <h2 style="font-size: 16px; font-weight: 700; color: #2F221A; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 18px 0; padding-bottom: 12px; border-bottom: 1px solid #F0EBE5; display: flex; align-items: center; gap: 8px;">
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; background: #2F221A; color: #FAF6F1; border-radius: 50%; font-size: 12px; font-weight: 700;">2</span>
                        <span>{{ $locale === 'vi' ? 'Phương Thức Thanh Toán' : 'Payment Method' }}</span>
                    </h2>

                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <label class="s54-pay-label is-selected" style="display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; border: 1.5px solid #AC8A62; background: #FAF6F1; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="payment_method" value="cod" checked style="accent-color: #AC8A62; margin-top: 3px;">
                            <div>
                                <strong style="display: block; font-size: 14px; color: #2F221A; margin-bottom: 2px;">{{ $locale === 'vi' ? 'Thanh toán khi nhận hàng (COD)' : 'Cash On Delivery (COD)' }}</strong>
                                <span style="font-size: 12.5px; color: #6E6259;">{{ $locale === 'vi' ? 'Quý khách kiểm tra hàng trước khi thanh toán tiền mặt cho bưu tá.' : 'Inspect package before paying cash to delivery courier.' }}</span>
                            </div>
                        </label>

                        <label class="s54-pay-label" style="display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; border: 1.5px solid #EBE7E1; background: #FFFFFF; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="payment_method" value="bank_transfer" style="accent-color: #AC8A62; margin-top: 3px;">
                            <div>
                                <strong style="display: block; font-size: 14px; color: #2F221A; margin-bottom: 2px;">{{ $locale === 'vi' ? 'Chuyển khoản Ngân Hàng (VietQR)' : 'Direct Bank Transfer (VietQR)' }}</strong>
                                <span style="font-size: 12.5px; color: #6E6259;">{{ $locale === 'vi' ? 'Quét mã VietQR chuyển khoản nhanh 24/7. Đơn hàng được xử lý ngay sau khi nhận.' : 'Scan QR code for instant transfer. Order processed immediately.' }}</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" id="btn-submit-order" style="width: 100%; background-color: #2F221A; color: #FAF6F1; border: none; padding: 16px 24px; border-radius: 6px; font-size: 14px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: background 0.2s;">
                    {{ $locale === 'vi' ? 'XÁC NHẬN ĐẶT HÀNG' : 'PLACE ORDER NOW' }}
                </button>
            </form>

            {{-- Right Column: Order Summary --}}
            <div style="background: #FFFFFF; border: 1px solid #EBE7E1; border-radius: 12px; padding: clamp(20px, 3vw, 28px); box-shadow: 0 4px 20px rgba(0,0,0,0.03); position: sticky; top: 90px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #F0EBE5;">
                    <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #2F221A; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ $locale === 'vi' ? 'Đơn Hàng Của Bạn' : 'Order Summary' }}
                    </h3>
                    <span id="checkout-summary-count" style="font-size: 13px; color: #8A7B70; font-weight: 600;">(0 {{ $locale === 'vi' ? 'sản phẩm' : 'items' }})</span>
                </div>

                {{-- Items Container --}}
                <div id="checkout-items-list" style="max-height: 280px; overflow-y: auto; margin-bottom: 20px; padding-right: 4px;">
                    {{-- Injected dynamically --}}
                </div>

                {{-- Cost Breakdown --}}
                <div style="border-top: 1px solid #F0EBE5; padding-top: 14px; margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; font-size: 14px; color: #6E6259; margin-bottom: 10px;">
                        <span>{{ $locale === 'vi' ? 'Tạm tính:' : 'Subtotal:' }}</span>
                        <span id="checkout-calc-subtotal" style="color: #2F221A; font-weight: 600;">0₫</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 14px; color: #6E6259; margin-bottom: 10px;">
                        <span>{{ $locale === 'vi' ? 'Phí vận chuyển toàn quốc:' : 'Shipping Fee:' }}</span>
                        <span id="checkout-calc-shipping" style="font-weight: 600; color: #2E7D32;">{{ $locale === 'vi' ? 'Miễn phí' : 'Free' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: 800; color: #2F221A; padding-top: 14px; border-top: 1.5px solid #EBE7E1; margin-top: 10px;">
                        <span>{{ $locale === 'vi' ? 'Tổng thanh toán:' : 'Grand Total:' }}</span>
                        <span id="checkout-calc-total" style="color: #D68E1D;">0₫</span>
                    </div>
                </div>

                {{-- Trust Badges --}}
                <div style="background: #FAF8F5; border-radius: 8px; padding: 14px 16px; font-size: 12.5px; color: #5C4A3E; line-height: 1.6;">
                    <div style="margin-bottom: 4px;">✓ <strong>{{ $locale === 'vi' ? 'Cam kết 100% nguyên chất:' : '100% Pure Coffee:' }}</strong> Không phụ gia, không tẩm ướp.</div>
                    <div style="margin-bottom: 4px;">✓ <strong>{{ $locale === 'vi' ? 'Đổi trả miễn phí:' : 'Free Return Guarantee:' }}</strong> Trong vòng 7 ngày nếu lỗi sản xuất.</div>
                    <div>📞 <strong>Hotline hỗ trợ:</strong> <a href="tel:0974933907" style="color: #2F221A; font-weight: 700; text-decoration: none;">0974.933.907</a></div>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- Order Success Modal --}}
<div id="s54-order-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(36,26,20,0.7); z-index: 99999; align-items: center; justify-content: center; backdrop-filter: blur(3px); padding: 20px; box-sizing: border-box;">
    <div style="background: #FFFFFF; border-radius: 16px; max-width: 500px; width: 100%; padding: 36px 30px; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.25);">
        <div style="width: 64px; height: 64px; background: #EBF7EE; color: #2E7D32; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 20px;">✓</div>
        <h2 style="font-size: 22px; font-weight: 800; color: #2F221A; margin: 0 0 10px 0;">{{ $locale === 'vi' ? 'Đặt Hàng Thành Công!' : 'Order Placed Successfully!' }}</h2>
        <p style="font-size: 14px; color: #6E6259; line-height: 1.6; margin: 0 0 20px 0;">
            {{ $locale === 'vi' ? 'Cảm ơn Quý khách đã tin tưởng S54 Coffee. Mã đơn hàng của Quý khách là:' : 'Thank you for choosing S54 Coffee. Your Order ID is:' }}<br>
            <strong id="modal-order-code" style="font-size: 20px; color: #D68E1D; display: inline-block; margin-top: 6px;">S54-000000</strong>
        </p>
        <div id="modal-payment-instructions" style="background: #FAF8F5; border-radius: 8px; padding: 14px; font-size: 13px; color: #5C4A3E; text-align: left; margin-bottom: 24px; line-height: 1.5; display: none;">
            {{-- Injected if bank transfer --}}
        </div>
        <p style="font-size: 13px; color: #8A7B70; margin: 0 0 24px 0;">
            {{ $locale === 'vi' ? 'Chuyên viên S54 sẽ liên hệ qua số điện thoại để xác nhận đơn và gửi hàng trong thời gian sớm nhất.' : 'Our customer support team will contact you shortly to confirm delivery.' }}
        </p>
        <a href="{{ route('client.home', ['locale' => $locale]) }}" style="display: inline-block; width: 100%; background: #2F221A; color: #FFFFFF; padding: 14px 24px; border-radius: 6px; font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; box-sizing: border-box;">
            {{ $locale === 'vi' ? 'Về Trang Chủ' : 'Return to Home' }}
        </a>
    </div>
</div>
@endsection

@push('scripts')
<style>
@media (max-width: 860px) {
    .s54-checkout-grid {
        grid-template-columns: 1fr !important;
    }
}
@media (max-width: 540px) {
    .s54-form-row {
        grid-template-columns: 1fr !important;
    }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isVi = '{{ $locale }}' === 'vi';
    const FREE_SHIP_THRESHOLD = 500000;
    const SHIPPING_FEE = {{ (float) ($shippingFee ?? 0) }};

    function formatVND(n) {
        return new Intl.NumberFormat('vi-VN').format(Math.round(n)) + '₫';
    }

    let currentGrandTotal = 0;

    function renderSummary() {
        const cart = window.S54Cart ? window.S54Cart.getCart() : { items: [], total_price: 0 };
        const items = cart.items || [];
        const container = document.getElementById('checkout-items-list');
        const countEl = document.getElementById('checkout-summary-count');
        const subtotalEl = document.getElementById('checkout-calc-subtotal');
        const shippingEl = document.getElementById('checkout-calc-shipping');
        const totalEl = document.getElementById('checkout-calc-total');

        if (countEl) countEl.textContent = `(${items.reduce((s, i) => s + (i.quantity || 1), 0)} ${isVi ? 'sản phẩm' : 'items'})`;

        if (items.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 28px 10px; color: #8A7B70;">
                    <p style="margin-bottom: 12px; font-size: 14px;">${isVi ? 'Giỏ hàng của bạn đang trống.' : 'Your cart is empty.'}</p>
                    <a href="{{ route('client.catalog.index', ['locale' => $locale]) }}" style="color: #D68E1D; font-weight: 700; text-decoration: underline;">${isVi ? 'Chọn sản phẩm ngay' : 'Browse products'}</a>
                </div>
            `;
            subtotalEl.textContent = '0₫';
            shippingEl.textContent = '0₫';
            totalEl.textContent = '0₫';
            currentGrandTotal = 0;
            return;
        }

        let subtotal = 0;
        let html = '';

        items.forEach(function(it) {
            const qty = it.quantity || 1;
            const price = it.price || 0;
            const line = price * qty;
            subtotal += line;
            const itemTitle = it.title || it.name || 'S54 Coffee';
            const itemImg = it.image || '{{ asset('client-assets/images/s54/products/tui_3in1_456g.jpg') }}';

            html += `
                <div style="display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid #F0EBE5;">
                    <img src="${itemImg}" alt="${itemTitle}" style="width: 48px; height: 48px; object-fit: contain; border-radius: 6px; border: 1px solid #EBE7E1; background: #FAF8F5; flex-shrink: 0;">
                    <div style="flex: 1; min-width: 0;">
                        <h4 style="margin: 0 0 2px 0; font-size: 13px; font-weight: 600; color: #2F221A; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${itemTitle}</h4>
                        <div style="font-size: 12px; color: #8A7B70;">${formatVND(price)} &times; ${qty}</div>
                    </div>
                    <div style="font-size: 13.5px; font-weight: 700; color: #2F221A; white-space: nowrap;">${formatVND(line)}</div>
                </div>
            `;
        });

        container.innerHTML = html;
        const shipping = subtotal >= FREE_SHIP_THRESHOLD ? 0 : SHIPPING_FEE;
        currentGrandTotal = subtotal + shipping;

        subtotalEl.textContent = formatVND(subtotal);
        shippingEl.textContent = shipping === 0 ? (isVi ? 'Miễn phí' : 'Free') : formatVND(shipping);
        totalEl.textContent = formatVND(currentGrandTotal);
    }

    // Payment method radio selection styling
    document.querySelectorAll('.s54-pay-label').forEach(function(lbl) {
        lbl.addEventListener('click', function() {
            document.querySelectorAll('.s54-pay-label').forEach(function(l) {
                l.classList.remove('is-selected');
                l.style.borderColor = '#EBE7E1';
                l.style.background = '#FFFFFF';
            });
            this.classList.add('is-selected');
            this.style.borderColor = '#AC8A62';
            this.style.background = '#FAF6F1';
            const radio = this.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
        });
    });

    // Form submission
    const form = document.getElementById('s54-checkout-form');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const cart = window.S54Cart ? window.S54Cart.getCart() : { items: [] };
            const items = cart.items || [];
            if (items.length === 0) {
                alert(isVi ? 'Giỏ hàng của bạn đang trống! Vui lòng chọn sản phẩm trước khi thanh toán.' : 'Your cart is empty! Please add products before checking out.');
                window.location.href = '{{ route('client.catalog.index', ['locale' => $locale]) }}';
                return;
            }

            const btnSubmit = document.getElementById('btn-submit-order');
            btnSubmit.disabled = true;
            btnSubmit.textContent = isVi ? 'Đang xử lý đặt hàng...' : 'Processing...';

            const name = document.getElementById('cust-name').value.trim();
            const phone = document.getElementById('cust-phone').value.trim();
            const email = document.getElementById('cust-email').value.trim();
            const city = document.getElementById('cust-city').value.trim();
            const district = document.getElementById('cust-district').value.trim();
            const address = document.getElementById('cust-address').value.trim();
            const notes = document.getElementById('cust-notes').value.trim();
            const fullAddress = `${address}, ${district}, ${city}`;
            const payMethodRadio = document.querySelector('input[name="payment_method"]:checked');
            const payMethod = payMethodRadio ? payMethodRadio.value : 'cod';

            const payloadItems = items.map(it => {
                const itemObj = {
                    product_id: parseInt(it.id || it.product_id, 10) || 1,
                    quantity: parseInt(it.quantity, 10) || 1
                };
                if (it.variant_id && parseInt(it.variant_id, 10) && parseInt(it.variant_id, 10) !== itemObj.product_id) {
                    itemObj.variant_id = parseInt(it.variant_id, 10);
                }
                if (Array.isArray(it.option_value_ids) && it.option_value_ids.length > 0) {
                    itemObj.option_value_ids = it.option_value_ids;
                }
                return itemObj;
            });

            let orderCode = '';
            let apiError = null;
            try {
                const payload = {
                    customer_name: name,
                    customer_email: email,
                    customer_phone: phone,
                    shipping_address: fullAddress,
                    payment_method: payMethod,
                    notes: notes,
                    items: payloadItems
                };

                const res = await fetch('/api/public/orders/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();
                if (res.ok && data.success && data.data) {
                    orderCode = data.data.order_number || data.data.code || data.data.order_code;
                } else {
                    let errMsg = data.message || (isVi ? 'Không thể hoàn tất đơn hàng. Vui lòng thử lại.' : 'Could not complete order. Please try again.');
                    if (data.errors && typeof data.errors === 'object') {
                        const firstKey = Object.keys(data.errors)[0];
                        if (firstKey && data.errors[firstKey] && data.errors[firstKey][0]) {
                            errMsg = data.errors[firstKey][0];
                        }
                    }
                    apiError = errMsg;
                }
            } catch (err) {
                console.error('[Checkout] API call exception', err);
                apiError = isVi ? 'Lỗi kết nối máy chủ khi tạo đơn. Vui lòng thử lại.' : 'Server connection error. Please try again.';
            }

            if (apiError) {
                alert(apiError);
                btnSubmit.disabled = false;
                btnSubmit.textContent = isVi ? 'XÁC NHẬN ĐẶT HÀNG' : 'PLACE ORDER NOW';
                return;
            }

            if (!orderCode) {
                orderCode = 'S54-' + Math.floor(100000 + Math.random() * 900000);
            }

            // Display success modal
            document.getElementById('modal-order-code').textContent = orderCode;
            const payInstructions = document.getElementById('modal-payment-instructions');
            if (payMethod === 'bank_transfer') {
                payInstructions.style.display = 'block';
                const vietQrUrl = `https://img.vietqr.io/image/MB-0974933907-compact2.png?amount=${currentGrandTotal}&addInfo=${encodeURIComponent(orderCode)}&accountName=CONG%20TY%20TNHH%20GIAI%20PHAP%20TOT`;
                payInstructions.innerHTML = `
                    <div style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
                        <img src="${vietQrUrl}" alt="VietQR" style="width: 130px; height: 130px; border-radius: 8px; border: 1px solid #EBE7E1; background: #FFFFFF; object-fit: contain; flex-shrink: 0;">
                        <div style="flex: 1; min-width: 180px; font-size: 13px; line-height: 1.6;">
                            <strong style="color: #2F221A; font-size: 13.5px;">Thông tin chuyển khoản VietQR:</strong><br>
                            • Ngân hàng: <strong>MB Bank (Ngân hàng Quân Đội)</strong><br>
                            • Số tài khoản: <strong>0974933907</strong><br>
                            • Chủ tài khoản: <strong>CÔNG TY TNHH GIẢI PHÁP TỐT</strong><br>
                            • Số tiền: <strong style="color: #D68E1D;">${formatVND(currentGrandTotal)}</strong><br>
                            • Nội dung CK: <strong style="color: #2F221A; background: #FFF3D6; padding: 1px 6px; border-radius: 3px;">${orderCode}</strong>
                        </div>
                    </div>
                `;
            } else {
                payInstructions.style.display = 'none';
            }

            const modal = document.getElementById('s54-order-modal');
            if (modal) modal.style.display = 'flex';

            if (window.S54Cart && typeof window.S54Cart.clear === 'function') {
                window.S54Cart.clear();
            }
        });
    }

    renderSummary();
    window.addEventListener('cart:updated', renderSummary);
});
</script>
@endpush
