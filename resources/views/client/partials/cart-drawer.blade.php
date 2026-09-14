<div class="s54-cart-drawer-overlay" id="s54-cart-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(36,26,20,0.6); z-index: 99998; backdrop-filter: blur(2px);"></div>
<div class="s54-cart-drawer" id="s54-cart-drawer" style="position: fixed; top: 0; right: -450px; width: 100%; max-width: 420px; height: 100vh; background: #FAF8F5; z-index: 99999; box-shadow: -8px 0 24px rgba(0,0,0,0.15); transition: right 0.35s cubic-bezier(0.16, 1, 0.3, 1); display: flex; flex-direction: column;">
    <div style="padding: 20px 24px; border-bottom: 1px solid #EBE7E1; display: flex; justify-content: space-between; align-items: center; background: #FFFFFF;">
        <h3 style="margin: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700; color: #2F221A; text-transform: uppercase; letter-spacing: 0.5px;">
            🛒 {{ app()->getLocale() === 'vi' ? 'Giỏ Hàng Của Bạn' : 'Your Cart' }} (<span id="s54-drawer-count">0</span>)
        </h3>
        <button type="button" id="s54-cart-close" style="background: none; border: none; font-size: 22px; cursor: pointer; color: #2F221A; line-height: 1;" aria-label="Đóng">&times;</button>
    </div>

    {{-- Free Shipping Bar --}}
    <div style="padding: 12px 24px; background: #FAF6F1; border-bottom: 1px solid #EBE7E1;">
        <div id="s54-drawer-freeship-text" style="font-size: 12px; font-weight: 600; color: #2F221A; margin-bottom: 6px;">
            {{ app()->getLocale() === 'vi' ? 'Thêm 500.000₫ nữa để được MIỄN PHÍ VẬN CHUYỂN' : 'Add 500,000₫ more for FREE Shipping' }}
        </div>
        <div style="width: 100%; height: 5px; background: #EFE9E2; border-radius: 3px; overflow: hidden;">
            <div id="s54-drawer-freeship-bar" style="width: 0%; height: 100%; background: #D68E1D; border-radius: 3px; transition: width 0.3s ease;"></div>
        </div>
    </div>

    <div id="s54-cart-items-container" style="flex: 1; overflow-y: auto; padding: 20px 24px;">
        <div id="s54-cart-empty-state" style="text-align: center; padding: 60px 20px; color: #8A7B70;">
            <p style="font-size: 40px; margin-bottom: 16px;">☕</p>
            <p style="font-weight: 600; font-size: 15px; color: #2F221A; margin-bottom: 8px;">{{ app()->getLocale() === 'vi' ? 'Giỏ hàng của bạn đang trống' : 'Your cart is empty' }}</p>
            <p style="font-size: 13px; margin-bottom: 24px;">{{ app()->getLocale() === 'vi' ? 'Hãy khám phá các dòng cà phê rang xay & hòa tan thượng hạng của S54.' : 'Discover artisan coffee beans & instant coffee by S54.' }}</p>
            <a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" style="display: inline-block; background: #2F221A; color: #FAF6F1; padding: 10px 24px; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: uppercase; text-decoration: none;">
                {{ app()->getLocale() === 'vi' ? 'Mua Sắm Ngay' : 'Shop Now' }}
            </a>
        </div>
        <div id="s54-cart-items-list" style="display: none;"></div>
    </div>

    <div id="s54-cart-footer" style="padding: 20px 24px; border-top: 1px solid #EBE7E1; background: #FFFFFF;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
            <span style="font-size: 14px; font-weight: 600; color: #5C4A3E;">{{ app()->getLocale() === 'vi' ? 'Tạm tính:' : 'Subtotal:' }}</span>
            <span id="s54-drawer-subtotal" style="font-size: 18px; font-weight: 700; color: #D68E1D;">0₫</span>
        </div>
        <p style="font-size: 12px; color: #8A7B70; margin-bottom: 16px;">{{ app()->getLocale() === 'vi' ? 'Phí vận chuyển và mã giảm giá sẽ được tính ở bước thanh toán.' : 'Shipping and vouchers are calculated at checkout.' }}</p>
        <button type="button" id="s54-checkout-btn" style="width: 100%; background: #2F221A; color: #FAF6F1; border: none; padding: 14px 20px; border-radius: 4px; font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: background 0.2s;">
            {{ app()->getLocale() === 'vi' ? 'Tiến Hành Thanh Toán' : 'Proceed to Checkout' }}
        </button>
        <a href="{{ route('client.cart', ['locale' => app()->getLocale()]) }}" id="s54-view-cart-link" class="s54-direct-cart-link c-cart-drawer__view-cart" onclick="window.location.href='{{ route('client.cart', ['locale' => app()->getLocale()]) }}';" style="display: block; text-align: center; margin-top: 12px; font-size: 13px; font-weight: 600; color: #6E6259; text-decoration: underline; cursor: pointer;">
            {{ app()->getLocale() === 'vi' ? 'Xem Giỏ Hàng Chi Tiết' : 'View Cart Details' }}
        </a>
    </div>
</div>
