@extends('client.layouts.app')

@php
    $locale = app()->getLocale();
@endphp

@section('title', ($locale === 'vi' ? 'Thanh Toán Đơn Hàng' : 'Checkout') . ' — S54 COFFEE')

@section('content')
<style>
/* Scoped Checkout Styles - Refined, Proportional Typography (Zero Huge Headings) */
.s54-checkout-wrapper {
    background-color: #FAF8F5;
    padding: clamp(20px, 3vw, 36px) 16px clamp(48px, 5vw, 72px);
    min-height: 75vh;
}
.s54-checkout-container {
    max-width: 1080px;
    margin: 0 auto;
}
.s54-checkout-breadcrumb {
    font-size: 12.5px;
    color: #8A7B70;
    margin-bottom: 18px;
}
.s54-checkout-breadcrumb a {
    color: #8A7B70;
    text-decoration: none;
}
.s54-checkout-breadcrumb a:hover {
    color: #D68E1D;
}
.s54-checkout-header {
    margin-bottom: 22px;
}
h1.s54-checkout-page-title {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
    font-size: 20px !important;
    font-weight: 700 !important;
    color: #2F221A !important;
    margin: 0 0 4px 0 !important;
    letter-spacing: -0.01em !important;
    line-height: 1.3 !important;
}
.s54-checkout-page-desc {
    font-size: 13px !important;
    color: #7A6F66 !important;
    margin: 0 !important;
    line-height: 1.4 !important;
}

/* Two-column layout */
.s54-checkout-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 24px;
    align-items: start;
}
@media (max-width: 880px) {
    .s54-checkout-grid {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
    }
}

/* Form Card */
.s54-checkout-card {
    background: #FFFFFF;
    border: 1px solid #EBE7E1;
    border-radius: 10px;
    padding: clamp(16px, 2.5vw, 24px);
    box-shadow: 0 2px 12px rgba(47, 34, 26, 0.03);
}

/* Step Header */
.s54-step-header {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    margin: 0 0 16px 0 !important;
    padding-bottom: 10px !important;
    border-bottom: 1px solid #F0EBE5 !important;
}
.s54-step-num {
    width: 22px !important;
    height: 22px !important;
    min-width: 22px !important;
    border-radius: 50% !important;
    background: #2F221A !important;
    color: #FAF6F1 !important;
    font-size: 11.5px !important;
    font-weight: 700 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
}
h2.s54-step-title {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
    font-size: 13.5px !important;
    font-weight: 700 !important;
    color: #2F221A !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    line-height: 1.3 !important;
    margin: 0 !important;
    padding: 0 !important;
}

/* Form Fields */
.s54-form-row {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 14px !important;
    margin-bottom: 13px !important;
    align-items: start !important;
}
@media (max-width: 600px) {
    .s54-form-row {
        grid-template-columns: 1fr !important;
        gap: 13px !important;
    }
}
.s54-form-group {
    display: flex !important;
    flex-direction: column !important;
    margin-bottom: 13px !important;
}
.s54-field-cell {
    display: flex !important;
    flex-direction: column !important;
}
.s54-field-label {
    font-size: 12.5px !important;
    font-weight: 600 !important;
    color: #3F332A !important;
    margin-bottom: 5px !important;
    display: flex !important;
    align-items: center !important;
    gap: 3px !important;
    line-height: 1.25 !important;
}
.s54-field-label .req {
    color: #C2410C !important;
    font-weight: 700 !important;
}
.s54-input,
.s54-textarea {
    width: 100% !important;
    background: #FFFFFF !important;
    border: 1px solid #D5CDC4 !important;
    border-radius: 6px !important;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    font-size: 13px !important;
    color: #2F221A !important;
    box-sizing: border-box !important;
    transition: border-color 0.2s, box-shadow 0.2s !important;
}
.s54-input {
    height: 40px !important;
    padding: 0 12px !important;
}
.s54-textarea {
    padding: 9px 12px !important;
    min-height: 64px !important;
    resize: vertical !important;
}
.s54-input:focus,
.s54-textarea:focus {
    border-color: #2F221A !important;
    box-shadow: 0 0 0 2.5px rgba(47, 34, 26, 0.08) !important;
    outline: none !important;
}

/* Payment Methods */
.s54-pay-options {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}
.s54-pay-option {
    border: 1px solid #E2DBD2;
    background: #FFFFFF;
    border-radius: 8px;
    padding: 12px 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.s54-pay-option:hover {
    border-color: #C0B4A6;
}
.s54-pay-option.is-selected {
    border-color: #2F221A;
    background: #FAF6F1;
    box-shadow: 0 1px 6px rgba(47, 34, 26, 0.04);
}
.s54-pay-option-top {
    display: flex;
    align-items: flex-start;
    gap: 10px;
}
.s54-pay-option input[type="radio"] {
    accent-color: #2F221A;
    margin-top: 2px;
    width: 16px;
    height: 16px;
    cursor: pointer;
}
.s54-pay-option-title {
    font-size: 13.5px;
    font-weight: 600;
    color: #2F221A;
    margin-bottom: 2px;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}
.s54-pay-badge {
    background: #EFE6D8;
    color: #8C5B14;
    font-size: 10.5px;
    font-weight: 700;
    padding: 1px 7px;
    border-radius: 10px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}
.s54-pay-option-desc {
    font-size: 12px;
    color: #6E6259;
    line-height: 1.35;
}

/* Inline VietQR */
.s54-inline-qr-card {
    display: none;
    margin-top: 8px;
    padding: 12px 14px;
    background: #FFFFFF;
    border: 1px dashed #CBBBAA;
    border-radius: 6px;
}
.s54-inline-qr-content {
    display: flex;
    gap: 14px;
    align-items: center;
    flex-wrap: wrap;
}
.s54-inline-qr-img {
    width: 110px;
    height: 110px;
    object-fit: contain;
    background: #FFFFFF;
    border: 1px solid #EBE7E1;
    border-radius: 6px;
    padding: 3px;
    flex-shrink: 0;
}
.s54-inline-qr-info {
    flex: 1;
    min-width: 160px;
    font-size: 12.5px;
    color: #3F332A;
    line-height: 1.55;
}
.s54-copy-btn {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    padding: 1px 7px;
    font-size: 11px;
    font-weight: 600;
    color: #2F221A;
    background: #EFE9E2;
    border: 1px solid #D8CFC5;
    border-radius: 3px;
    cursor: pointer;
    margin-left: 5px;
    transition: background 0.15s;
}
.s54-copy-btn:hover {
    background: #E2D7CC;
}

/* Submit Button */
.s54-btn-submit {
    width: 100% !important;
    background-color: #2F221A !important;
    color: #FAF6F1 !important;
    border: none !important;
    padding: 13px 20px !important;
    border-radius: 6px !important;
    font-family: 'Inter', sans-serif !important;
    font-size: 13.5px !important;
    font-weight: 700 !important;
    letter-spacing: 0.6px !important;
    text-transform: uppercase !important;
    cursor: pointer !important;
    transition: background 0.2s ease !important;
    box-shadow: 0 2px 10px rgba(47, 34, 26, 0.12) !important;
}
.s54-btn-submit:hover {
    background-color: #453327 !important;
}
.s54-btn-submit:disabled {
    background-color: #8C827A !important;
    cursor: not-allowed !important;
}

/* Order Summary Sticky Card */
.s54-summary-card {
    background: #FFFFFF;
    border: 1px solid #EBE7E1;
    border-radius: 10px;
    padding: clamp(16px, 2.5vw, 22px);
    box-shadow: 0 2px 12px rgba(47, 34, 26, 0.03);
    position: sticky;
    top: 90px;
}
.s54-summary-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 10px;
    border-bottom: 1px solid #F0EBE5;
    margin-bottom: 12px;
}
h3.s54-summary-title {
    font-family: 'Inter', sans-serif !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    color: #2F221A !important;
    text-transform: uppercase !important;
    letter-spacing: 0.4px !important;
    margin: 0 !important;
}
.s54-summary-count {
    font-size: 12px;
    color: #8A7B70;
    font-weight: 500;
}
.s54-summary-items {
    max-height: 280px;
    overflow-y: auto;
    margin-bottom: 14px;
    padding-right: 4px;
}
.s54-summary-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 9px 0;
    border-bottom: 1px solid #F5F0EA;
}
.s54-summary-item:last-child {
    border-bottom: none;
}
.s54-summary-item-img {
    width: 44px;
    height: 44px;
    object-fit: contain;
    border-radius: 5px;
    border: 1px solid #EBE7E1;
    background: #FAF8F5;
    flex-shrink: 0;
}
.s54-summary-item-info {
    flex: 1;
    min-width: 0;
}
.s54-summary-item-name {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    font-size: 12.5px !important;
    font-weight: 600 !important;
    color: #2F221A !important;
    line-height: 1.35 !important;
    margin: 0 0 2px 0 !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    word-break: break-word !important;
}
.s54-summary-item-sub {
    font-size: 11.5px;
    color: #8A7B70;
}
.s54-summary-item-total {
    font-size: 13px;
    font-weight: 600;
    color: #2F221A;
    white-space: nowrap;
}

/* Totals */
.s54-summary-totals {
    border-top: 1px solid #F0EBE5;
    padding-top: 12px;
    margin-bottom: 14px;
}
.s54-total-row {
    display: flex;
    justify-content: space-between;
    font-size: 12.5px;
    color: #6E6259;
    margin-bottom: 8px;
}
.s54-total-row strong {
    color: #2F221A;
    font-weight: 600;
}
.s54-grand-total-row {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    font-size: 14.5px;
    font-weight: 700;
    color: #2F221A;
    padding-top: 10px;
    border-top: 1.5px solid #EBE7E1;
    margin-top: 6px;
}
.s54-grand-total-amount {
    color: #D68E1D;
    font-size: 17px;
    font-weight: 800;
}
.s54-trust-box {
    background: #FAF8F5;
    border-radius: 6px;
    padding: 10px 12px;
    font-size: 11.5px;
    color: #5C4A3E;
    line-height: 1.5;
}

/* Toast */
.s54-copy-toast {
    display: none;
    position: fixed;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
    background: #2F221A;
    color: #FFFFFF;
    font-size: 12.5px;
    font-weight: 600;
    padding: 9px 18px;
    border-radius: 20px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.2);
    z-index: 999999;
}
</style>

<section class="s54-checkout-wrapper">
    <div class="s54-checkout-container">
        
        {{-- Breadcrumb --}}
        <div class="s54-checkout-breadcrumb">
            <a href="{{ route('client.home', ['locale' => $locale]) }}">{{ $locale === 'vi' ? 'Trang Chủ' : 'Home' }}</a> / 
            <a href="{{ route('client.cart', ['locale' => $locale]) }}">{{ $locale === 'vi' ? 'Giỏ Hàng' : 'Cart' }}</a> / 
            <span style="color: #2F221A; font-weight: 600;">{{ $locale === 'vi' ? 'Thanh Toán' : 'Checkout' }}</span>
        </div>

        {{-- Page Header --}}
        <div class="s54-checkout-header">
            <h1 class="s54-checkout-page-title">
                {{ $locale === 'vi' ? 'Thanh Toán Đơn Hàng' : 'Secure Checkout' }}
            </h1>
            <p class="s54-checkout-page-desc">
                {{ $locale === 'vi' ? 'Quý khách vui lòng điền thông tin nhận hàng bên dưới để S54 Coffee chuẩn bị và giao hàng sớm nhất.' : 'Please enter your shipping and contact details below to complete your order.' }}
            </p>
        </div>

        <div class="s54-checkout-grid">
            
            {{-- Left Column: Form --}}
            <form id="s54-checkout-form" class="s54-checkout-card">
                
                {{-- Step 1: Shipping Info --}}
                <div style="margin-bottom: 24px;">
                    <div class="s54-step-header">
                        <span class="s54-step-num">1</span>
                        <h2 class="s54-step-title">{{ $locale === 'vi' ? 'Thông Tin Giao Hàng' : 'Shipping Information' }}</h2>
                    </div>

                    {{-- Row 1: Full Name & Phone --}}
                    <div class="s54-form-row">
                        <div class="s54-field-cell">
                            <label class="s54-field-label" for="cust-name">
                                <span>{{ $locale === 'vi' ? 'Họ và tên' : 'Full Name' }}</span>
                                <span class="req">*</span>
                            </label>
                            <input type="text" id="cust-name" class="s54-input" required placeholder="{{ $locale === 'vi' ? 'Nguyễn Văn A' : 'John Doe' }}">
                        </div>
                        <div class="s54-field-cell">
                            <label class="s54-field-label" for="cust-phone">
                                <span>{{ $locale === 'vi' ? 'Số điện thoại' : 'Phone Number' }}</span>
                                <span class="req">*</span>
                            </label>
                            <input type="tel" id="cust-phone" class="s54-input" required placeholder="{{ $locale === 'vi' ? '0901 234 567' : '+84 901 234 567' }}">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="s54-form-group">
                        <label class="s54-field-label" for="cust-email">
                            <span>{{ $locale === 'vi' ? 'Email nhận thông báo' : 'Email Address' }}</span>
                            <span class="req">*</span>
                        </label>
                        <input type="email" id="cust-email" class="s54-input" required placeholder="name@example.com">
                    </div>

                    {{-- Row 2: City & District --}}
                    <div class="s54-form-row">
                        <div class="s54-field-cell">
                            <label class="s54-field-label" for="cust-city">
                                <span>{{ $locale === 'vi' ? 'Tỉnh / Thành phố' : 'City / Province' }}</span>
                                <span class="req">*</span>
                            </label>
                            <input type="text" id="cust-city" class="s54-input" required placeholder="{{ $locale === 'vi' ? 'TP. Hồ Chí Minh' : 'Ho Chi Minh City' }}">
                        </div>
                        <div class="s54-field-cell">
                            <label class="s54-field-label" for="cust-district">
                                <span>{{ $locale === 'vi' ? 'Quận / Huyện' : 'District' }}</span>
                                <span class="req">*</span>
                            </label>
                            <input type="text" id="cust-district" class="s54-input" required placeholder="{{ $locale === 'vi' ? 'Quận 1, TP. Thủ Đức...' : 'District 1...' }}">
                        </div>
                    </div>

                    {{-- Detailed Street Address --}}
                    <div class="s54-form-group">
                        <label class="s54-field-label" for="cust-address">
                            <span>{{ $locale === 'vi' ? 'Địa chỉ nhận hàng cụ thể' : 'Street Address' }}</span>
                            <span class="req">*</span>
                        </label>
                        <input type="text" id="cust-address" class="s54-input" required placeholder="{{ $locale === 'vi' ? 'Số nhà, tên đường, phường / xã...' : 'House number, street, ward...' }}">
                    </div>

                    {{-- Notes --}}
                    <div class="s54-form-group" style="margin-bottom: 0;">
                        <label class="s54-field-label" for="cust-notes">
                            <span>{{ $locale === 'vi' ? 'Ghi chú đơn hàng (tuỳ chọn)' : 'Order Notes (Optional)' }}</span>
                        </label>
                        <textarea id="cust-notes" class="s54-textarea" rows="2" placeholder="{{ $locale === 'vi' ? 'Ghi chú về giờ giao hàng hoặc yêu cầu xay cà phê thô/mịn...' : 'Notes about delivery time or grind preference...' }}"></textarea>
                    </div>
                </div>

                {{-- Step 2: Payment Method --}}
                <div style="margin-bottom: 22px;">
                    <div class="s54-step-header">
                        <span class="s54-step-num">2</span>
                        <h2 class="s54-step-title">{{ $locale === 'vi' ? 'Phương Thức Thanh Toán' : 'Payment Method' }}</h2>
                    </div>

                    <div class="s54-pay-options">
                        {{-- Method 1: COD --}}
                        <label class="s54-pay-option is-selected" id="opt-pay-cod">
                            <div class="s54-pay-option-top">
                                <input type="radio" name="payment_method" value="cod" checked>
                                <div>
                                    <div class="s54-pay-option-title">
                                        <span>💵 {{ $locale === 'vi' ? 'Thanh toán khi nhận hàng (COD)' : 'Cash On Delivery (COD)' }}</span>
                                    </div>
                                    <div class="s54-pay-option-desc">
                                        {{ $locale === 'vi' ? 'Quý khách kiểm tra hàng trước khi thanh toán tiền mặt cho nhân viên giao hàng.' : 'Inspect the package before paying cash directly to the courier.' }}
                                    </div>
                                </div>
                            </div>
                        </label>

                        {{-- Method 2: VietQR --}}
                        <label class="s54-pay-option" id="opt-pay-vietqr">
                            <div class="s54-pay-option-top">
                                <input type="radio" name="payment_method" value="bank_transfer">
                                <div style="flex: 1;">
                                    <div class="s54-pay-option-title">
                                        <span>📲 {{ $locale === 'vi' ? 'Chuyển khoản Ngân Hàng quét mã VietQR' : 'Direct Bank Transfer (VietQR)' }}</span>
                                        <span class="s54-pay-badge">{{ $locale === 'vi' ? 'Khuyên Dùng' : 'Recommended' }}</span>
                                    </div>
                                    <div class="s54-pay-option-desc">
                                        {{ $locale === 'vi' ? 'Quét mã VietQR bằng bất kỳ app ngân hàng nào (MB, VCB, BIDV, Techcombank, Momo, VNPay,...). Nhận diện tự động 24/7.' : 'Scan VietQR code with any mobile banking app for instant 24/7 payment.' }}
                                    </div>
                                </div>
                            </div>

                            {{-- Inline VietQR Details Box --}}
                            <div id="s54-inline-vietqr" class="s54-inline-qr-card">
                                <div class="s54-inline-qr-content">
                                    <img id="inline-qr-image" class="s54-inline-qr-img" src="https://img.vietqr.io/image/MB-0974933907-compact2.png?amount=0&addInfo=S54%20COFFEE&accountName=CONG%20TY%20TNHH%20GIAI%20PHAP%20TOT" alt="{{ $locale === 'vi' ? 'Mã VietQR S54 Coffee' : 'VietQR S54 Coffee Code' }}">
                                    <div class="s54-inline-qr-info">
                                        <div style="font-weight: 700; color: #2F221A; margin-bottom: 4px; font-size: 13px;">
                                            {{ $locale === 'vi' ? 'Thông tin tài khoản chính thức:' : 'Official Bank Details:' }}
                                        </div>
                                        <div>• {{ $locale === 'vi' ? 'Ngân hàng:' : 'Bank:' }} <strong>MBBank (Ngân hàng Quân Đội)</strong></div>
                                        <div>• {{ $locale === 'vi' ? 'Số tài khoản:' : 'Account Number:' }} <strong id="stk-val" style="color: #2F221A; font-size: 13.5px;">0974933907</strong>
                                            <button type="button" class="s54-copy-btn" id="btn-copy-stk">📋 {{ $locale === 'vi' ? 'Sao chép' : 'Copy' }}</button>
                                        </div>
                                        <div>• {{ $locale === 'vi' ? 'Chủ tài khoản:' : 'Account Holder:' }} <strong>CÔNG TY TNHH GIẢI PHÁP TỐT</strong></div>
                                        <div>• {{ $locale === 'vi' ? 'Số tiền thanh toán:' : 'Payment Amount:' }} <strong id="inline-qr-amount" style="color: #D68E1D; font-size: 13.5px;">0₫</strong></div>
                                        <div style="margin-top: 5px; font-size: 11.5px; color: #8A7B70; font-style: italic;">
                                            {{ $locale === 'vi' ? '* Bạn có thể quét mã QR ngay bây giờ hoặc sau khi bấm Xác nhận đặt hàng. Đơn hàng sẽ được xử lý ngay sau khi chuyển khoản.' : '* You can scan now or after clicking Place Order. Your order is processed immediately.' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" id="btn-submit-order" class="s54-btn-submit">
                    {{ $locale === 'vi' ? 'XÁC NHẬN ĐẶT HÀNG' : 'PLACE ORDER NOW' }}
                </button>
            </form>

            {{-- Right Column: Order Summary --}}
            <div class="s54-summary-card">
                <div class="s54-summary-header">
                    <h3 class="s54-summary-title">
                        {{ $locale === 'vi' ? 'Đơn Hàng Của Bạn' : 'Your Order Summary' }}
                    </h3>
                    <span id="checkout-summary-count" class="s54-summary-count">(0 {{ $locale === 'vi' ? 'sản phẩm' : 'items' }})</span>
                </div>

                {{-- Items Container --}}
                <div id="checkout-items-list" class="s54-summary-items">
                    {{-- Injected dynamically --}}
                </div>

                {{-- Cost Breakdown --}}
                <div class="s54-summary-totals">
                    <div class="s54-total-row">
                        <span>{{ $locale === 'vi' ? 'Tạm tính giỏ hàng:' : 'Subtotal:' }}</span>
                        <strong id="checkout-calc-subtotal">0₫</strong>
                    </div>
                    <div class="s54-total-row">
                        <span>{{ $locale === 'vi' ? 'Phí vận chuyển toàn quốc:' : 'Shipping Fee:' }}</span>
                        <span id="checkout-calc-shipping" style="font-weight: 600; color: #2E7D32;">{{ $locale === 'vi' ? 'Miễn phí' : 'Free' }}</span>
                    </div>
                    <div class="s54-grand-total-row">
                        <span>{{ $locale === 'vi' ? 'Tổng thanh toán:' : 'Grand Total:' }}</span>
                        <span id="checkout-calc-total" class="s54-grand-total-amount">0₫</span>
                    </div>
                </div>

                {{-- Trust Badges --}}
                <div class="s54-trust-box">
                    <div style="margin-bottom: 4px;">✓ <strong>{{ $locale === 'vi' ? '100% Cà phê nguyên chất:' : '100% Pure Coffee:' }}</strong> {{ $locale === 'vi' ? 'Không phụ gia, không tẩm ướp.' : 'No additives, 100% natural.' }}</div>
                    <div style="margin-bottom: 4px;">✓ <strong>{{ $locale === 'vi' ? 'Đổi trả miễn phí:' : 'Free Returns:' }}</strong> {{ $locale === 'vi' ? 'Trong vòng 7 ngày nếu lỗi sản xuất.' : 'Within 7 days for manufacturing defects.' }}</div>
                    <div>📞 <strong>{{ $locale === 'vi' ? 'Hotline hỗ trợ:' : 'Support Hotline:' }}</strong> <a href="tel:0974933907" style="color: #2F221A; font-weight: 700; text-decoration: none;">0974.933.907</a></div>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- Order Success Modal --}}
<div id="s54-order-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(36,26,20,0.7); z-index: 99999; align-items: center; justify-content: center; backdrop-filter: blur(3px); padding: 16px; box-sizing: border-box;">
    <div style="background: #FFFFFF; border-radius: 14px; max-width: 500px; width: 100%; padding: 28px 22px; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.25); max-height: 90vh; overflow-y: auto;">
        <div style="width: 52px; height: 52px; background: #EBF7EE; color: #2E7D32; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 14px;">✓</div>
        <h2 style="font-size: 18px !important; font-weight: 800 !important; color: #2F221A !important; margin: 0 0 6px 0 !important; text-transform: none !important;">
            {{ $locale === 'vi' ? 'Đặt Hàng Thành Công!' : 'Order Placed Successfully!' }}
        </h2>
        <p style="font-size: 13px; color: #6E6259; line-height: 1.5; margin: 0 0 16px 0;">
            {{ $locale === 'vi' ? 'Cảm ơn Quý khách đã tin tưởng S54 Coffee. Mã đơn hàng của Quý khách là:' : 'Thank you for choosing S54 Coffee. Your Order ID is:' }}<br>
            <strong id="modal-order-code" style="font-size: 18px; color: #D68E1D; display: inline-block; margin-top: 4px; letter-spacing: 0.5px;">S54-000000</strong>
        </p>

        {{-- Bank Transfer Instructions inside Modal --}}
        <div id="modal-payment-instructions" style="background: #FAF8F5; border: 1px solid #EBE7E1; border-radius: 8px; padding: 14px; font-size: 12.5px; color: #4A3E36; text-align: left; margin-bottom: 18px; line-height: 1.55; display: none;">
            {{-- Injected dynamically --}}
        </div>

        <p style="font-size: 12px; color: #8A7B70; margin: 0 0 18px 0;">
            {{ $locale === 'vi' ? 'Chuyên viên S54 sẽ liên hệ qua số điện thoại để xác nhận đơn và gửi hàng trong thời gian sớm nhất.' : 'Our customer support team will contact you shortly to confirm delivery.' }}
        </p>
        <a href="{{ route('client.home', ['locale' => $locale]) }}" style="display: inline-block; width: 100%; background: #2F221A; color: #FFFFFF; padding: 12px 20px; border-radius: 6px; font-size: 12.5px; font-weight: 700; letter-spacing: 0.6px; text-transform: uppercase; text-decoration: none; box-sizing: border-box;">
            {{ $locale === 'vi' ? 'Về Trang Chủ S54' : 'Return to Home' }}
        </a>
    </div>
</div>

<div id="s54-copy-toast" class="s54-copy-toast">{{ $locale === 'vi' ? '✓ Đã sao chép số tài khoản' : '✓ Account number copied' }}</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isVi = '{{ $locale }}' === 'vi';
    const FREE_SHIP_THRESHOLD = 500000;
    const SHIPPING_FEE = {{ (float) ($shippingFee ?? 0) }};

    function formatVND(n) {
        return new Intl.NumberFormat('vi-VN').format(Math.round(n)) + '₫';
    }

    let currentGrandTotal = 0;

    function updateVietQrDisplay() {
        const qrImg = document.getElementById('inline-qr-image');
        const amountEl = document.getElementById('inline-qr-amount');
        if (amountEl) amountEl.textContent = formatVND(currentGrandTotal);
        if (qrImg && currentGrandTotal > 0) {
            qrImg.src = `https://img.vietqr.io/image/MB-0974933907-compact2.png?amount=${currentGrandTotal}&addInfo=S54%20COFFEE&accountName=CONG%20TY%20TNHH%20GIAI%20PHAP%20TOT`;
        }
    }

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
                <div style="text-align: center; padding: 22px 10px; color: #8A7B70;">
                    <p style="margin-bottom: 10px; font-size: 13px;">${isVi ? 'Giỏ hàng của bạn đang trống.' : 'Your cart is empty.'}</p>
                    <a href="{{ route('client.catalog.index', ['locale' => $locale]) }}" style="color: #D68E1D; font-weight: 700; text-decoration: underline; font-size: 13px;">${isVi ? 'Chọn sản phẩm ngay' : 'Browse products'}</a>
                </div>
            `;
            subtotalEl.textContent = '0₫';
            shippingEl.textContent = '0₫';
            totalEl.textContent = '0₫';
            currentGrandTotal = 0;
            updateVietQrDisplay();
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
                <div class="s54-summary-item">
                    <img src="${itemImg}" alt="${itemTitle}" class="s54-summary-item-img">
                    <div class="s54-summary-item-info">
                        <div class="s54-summary-item-name">${itemTitle}</div>
                        <div class="s54-summary-item-sub">${formatVND(price)} &times; ${qty}</div>
                    </div>
                    <div class="s54-summary-item-total">${formatVND(line)}</div>
                </div>
            `;
        });

        container.innerHTML = html;
        const shipping = subtotal >= FREE_SHIP_THRESHOLD ? 0 : SHIPPING_FEE;
        currentGrandTotal = subtotal + shipping;

        subtotalEl.textContent = formatVND(subtotal);
        shippingEl.textContent = shipping === 0 ? (isVi ? 'Miễn phí' : 'Free') : formatVND(shipping);
        totalEl.textContent = formatVND(currentGrandTotal);
        updateVietQrDisplay();
    }

    // Payment method selection & VietQR toggle
    const payOptions = document.querySelectorAll('.s54-pay-option');
    const inlineQrCard = document.getElementById('s54-inline-vietqr');

    payOptions.forEach(function(opt) {
        opt.addEventListener('click', function(e) {
            if (e.target && e.target.closest('.s54-copy-btn')) return;

            payOptions.forEach(function(o) {
                o.classList.remove('is-selected');
                const rad = o.querySelector('input[type="radio"]');
                if (rad) rad.checked = false;
            });
            this.classList.add('is-selected');
            const radio = this.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;

            if (radio && radio.value === 'bank_transfer') {
                if (inlineQrCard) {
                    inlineQrCard.style.display = 'block';
                    updateVietQrDisplay();
                }
            } else {
                if (inlineQrCard) inlineQrCard.style.display = 'none';
            }
        });
    });

    // Copy Account Number button
    const btnCopyStk = document.getElementById('btn-copy-stk');
    const copyToast = document.getElementById('s54-copy-toast');
    if (btnCopyStk) {
        btnCopyStk.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const stk = '0974933907';
            if (navigator.clipboard) {
                navigator.clipboard.writeText(stk).then(showToast);
            } else {
                showToast();
            }
        });
    }

    function showToast() {
        if (!copyToast) return;
        copyToast.style.display = 'block';
        setTimeout(function() {
            copyToast.style.display = 'none';
        }, 2200);
    }

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
            btnSubmit.textContent = '{{ $locale === "vi" ? "Đang xử lý đặt hàng..." : "Processing..." }}';

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
                let pid = parseInt(it.id || it.product_id, 10) || 22;
                const legacyMap = {
                    200001: 23, 200002: 23, 200003: 22, 200004: 10,
                    200005: 10, 200006: 12, 200007: 13, 200008: 14,
                    200009: 15, 200010: 16, 200011: 17, 200012: 18,
                    100001: 23, 100002: 22, 100003: 10, 100004: 12,
                    100005: 13, 100006: 14, 100007: 15, 100008: 16,
                    100009: 17, 100010: 18
                };
                if (legacyMap[pid]) {
                    pid = legacyMap[pid];
                } else if (pid > 1000) {
                    const t = (it.title || it.name || '').toLowerCase();
                    if (t.includes('12 gói') || t.includes('dùng thử') || t.includes('5 gói') || t.includes('trial') || t.includes('12 sachets')) pid = 23;
                    else if (t.includes('456g') || t.includes('túi') || t.includes('bag') || t.includes('24 sachets')) pid = 22;
                    else if (t.includes('combo 2')) pid = 10;
                    else if (t.includes('250g')) pid = 12;
                    else if (t.includes('500g')) pid = 13;
                    else if (t.includes('vbz01')) pid = 14;
                    else if (t.includes('vbz08')) pid = 15;
                    else if (t.includes('vbz03')) pid = 16;
                    else if (t.includes('vbs02')) pid = 17;
                    else if (t.includes('kmdj')) pid = 18;
                    else pid = 22;
                }
                const itemObj = {
                    product_id: pid,
                    quantity: parseInt(it.quantity, 10) || 1
                };
                if (it.variant_id && parseInt(it.variant_id, 10) && parseInt(it.variant_id, 10) !== itemObj.product_id && parseInt(it.variant_id, 10) < 1000) {
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
                    let errMsg = data.message || '{{ $locale === "vi" ? "Không thể hoàn tất đơn hàng. Vui lòng thử lại." : "Could not complete order. Please try again." }}';
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
                apiError = '{{ $locale === "vi" ? "Lỗi kết nối máy chủ khi tạo đơn. Vui lòng thử lại." : "Server connection error. Please try again." }}';
            }

            if (apiError) {
                alert(apiError);
                btnSubmit.disabled = false;
                btnSubmit.textContent = '{{ $locale === "vi" ? "XÁC NHẬN ĐẶT HÀNG" : "PLACE ORDER NOW" }}';
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
                    <div style="display: flex; gap: 14px; align-items: center; flex-wrap: wrap;">
                        <img src="${vietQrUrl}" alt="VietQR S54 Coffee" style="width: 120px; height: 120px; border-radius: 6px; border: 1px solid #EBE7E1; background: #FFFFFF; object-fit: contain; flex-shrink: 0;">
                        <div style="flex: 1; min-width: 170px; font-size: 12.5px; line-height: 1.55;">
                            <strong style="color: #2F221A; font-size: 13px;">${isVi ? 'Quét mã VietQR chuyển khoản nhanh:' : 'Scan VietQR to pay via bank transfer:'}</strong><br>
                            • ${isVi ? 'Ngân hàng:' : 'Bank:'} <strong>MB Bank (Ngân hàng Quân Đội)</strong><br>
                            • ${isVi ? 'Số tài khoản:' : 'Account Number:'} <strong>0974933907</strong><br>
                            • ${isVi ? 'Chủ tài khoản:' : 'Account Holder:'} <strong>CÔNG TY TNHH GIẢI PHÁP TỐT</strong><br>
                            • ${isVi ? 'Số tiền:' : 'Amount:'} <strong style="color: #D68E1D;">${formatVND(currentGrandTotal)}</strong><br>
                            • ${isVi ? 'Nội dung CK:' : 'Transfer Reference:'} <strong style="color: #2F221A; background: #FFF3D6; padding: 2px 6px; border-radius: 4px; border: 1px solid #EAD8B0;">${orderCode}</strong>
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
