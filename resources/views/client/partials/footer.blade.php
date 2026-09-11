<footer class="c-footer s54-footer" contenteditable="false" style="background-color: #1A120D !important; color: #FAF6F1 !important; padding: 64px 0 32px; font-size: 14px; border-top: 1px solid rgba(214,142,29,0.2);">
    <div class="o-wrapper" style="max-width: 1440px; margin: 0 auto; padding: 0 clamp(20px, 4vw, 48px);">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: clamp(32px, 4vw, 48px); margin-bottom: 48px;">
            {{-- Column 1: Company Info --}}
            <div>
                <h4 style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 26px; font-weight: 700; color: #FFFFFF !important; margin: 0 0 16px 0; letter-spacing: 1px;">
                    S54 COFFEE
                </h4>
                <div style="width: 44px; height: 2px; background-color: #D68E1D; margin-bottom: 18px;"></div>
                <p style="color: #E5DDD5 !important; line-height: 1.6; margin-bottom: 12px; font-weight: 600;">
                    CÔNG TY TNHH GIẢI PHÁP TỐT (Good Solutions Co., Ltd)
                </p>
                <p style="color: #BAADA1 !important; line-height: 1.6; margin-bottom: 8px;">
                    📍 <strong style="color: #FFFFFF;">Trụ sở:</strong> Số 35, Đường T8, Manhattan, Vinhomes Grand Park, Phường Long Bình, TP. Thủ Đức, TP.HCM
                </p>
                <p style="color: #BAADA1 !important; line-height: 1.6; margin-bottom: 8px;">
                    📞 <strong style="color: #FFFFFF;">Hotline tư vấn:</strong> <a href="tel:0974933907" style="color: #D68E1D !important; text-decoration: none; font-weight: 700;">0974.933.907</a>
                </p>
                <p style="color: #BAADA1 !important; line-height: 1.6; margin-bottom: 16px;">
                    ✉️ <strong style="color: #FFFFFF;">Email:</strong> <a href="mailto:infor@S54Coffee.com" style="color: #FAF6F1 !important; text-decoration: none;">infor@S54Coffee.com</a>
                </p>
                <div style="display: flex; gap: 12px; align-items: center; margin-top: 14px;">
                    <a href="https://facebook.com" target="_blank" rel="noopener" aria-label="Facebook" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.08); color: #FAF6F1; text-decoration: none; transition: background 0.2s;">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                    </a>
                    <a href="https://zalo.me/0974933907" target="_blank" rel="noopener" aria-label="Zalo" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.08); color: #FAF6F1; font-size: 11px; font-weight: 800; text-decoration: none;">
                        Zalo
                    </a>
                    <a href="https://youtube.com" target="_blank" rel="noopener" aria-label="YouTube" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.08); color: #FAF6F1; text-decoration: none;">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Column 2: About S54 --}}
            <div>
                <h4 style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 15px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #FFFFFF !important; margin: 0 0 16px 0;">
                    {{ app()->getLocale() === 'vi' ? 'Về S54 Coffee' : 'About S54' }}
                </h4>
                <div style="width: 36px; height: 2px; background-color: #D68E1D; margin-bottom: 18px;"></div>
                <ul style="list-style: none !important; padding: 0; margin: 0; line-height: 2.2;">
                    <li><a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'our-story']) }}" style="color: #E5DDD5 !important; text-decoration: none; transition: color 0.2s;">{{ app()->getLocale() === 'vi' ? 'Câu Chuyện Thương Hiệu' : 'Our Story' }}</a></li>
                    <li><a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'wholesale']) }}" style="color: #E5DDD5 !important; text-decoration: none; transition: color 0.2s;">{{ app()->getLocale() === 'vi' ? 'Giải Pháp B2B & Đại Lý' : 'Wholesale Solutions' }}</a></li>
                    <li><a href="{{ route('client.blog.index', ['locale' => app()->getLocale()]) }}" style="color: #E5DDD5 !important; text-decoration: none; transition: color 0.2s;">{{ app()->getLocale() === 'vi' ? 'Cẩm Nang Cà Phê' : 'Brewing Guides' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" style="color: #E5DDD5 !important; text-decoration: none; transition: color 0.2s;">{{ app()->getLocale() === 'vi' ? 'Tất Cả Sản Phẩm' : 'All Products' }}</a></li>
                </ul>
            </div>

            {{-- Column 3: Categories --}}
            <div>
                <h4 style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 15px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #FFFFFF !important; margin: 0 0 16px 0;">
                    {{ app()->getLocale() === 'vi' ? 'Dòng Sản Phẩm' : 'Product Lines' }}
                </h4>
                <div style="width: 36px; height: 2px; background-color: #D68E1D; margin-bottom: 18px;"></div>
                <ul style="list-style: none !important; padding: 0; margin: 0; line-height: 2.2;">
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" style="color: #E5DDD5 !important; text-decoration: none;">{{ app()->getLocale() === 'vi' ? 'Cà Phê Rang Mộc Thượng Hạng' : 'Roasted Whole Beans' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" style="color: #E5DDD5 !important; text-decoration: none;">{{ app()->getLocale() === 'vi' ? 'Specialty Arabica Cầu Đất' : 'Specialty Arabica' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" style="color: #E5DDD5 !important; text-decoration: none;">{{ app()->getLocale() === 'vi' ? 'Robusta Sẻ & Fine Robusta' : 'Robusta Reserve' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" style="color: #E5DDD5 !important; text-decoration: none;">{{ app()->getLocale() === 'vi' ? 'Cà Phê Hòa Tan 3in1 Cao Cấp' : 'Instant 3-in-1 Coffee' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" style="color: #E5DDD5 !important; text-decoration: none;">{{ app()->getLocale() === 'vi' ? 'Cà Phê Sấy Lạnh (Freeze-Dried)' : 'Freeze-Dried Coffee' }}</a></li>
                </ul>
            </div>

            {{-- Column 4: Newsletter & Guarantee --}}
            <div>
                <h4 style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 15px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #FFFFFF !important; margin: 0 0 16px 0;">
                    {{ app()->getLocale() === 'vi' ? 'Bản Tin & Ưu Đãi' : 'Newsletter' }}
                </h4>
                <div style="width: 36px; height: 2px; background-color: #D68E1D; margin-bottom: 18px;"></div>
                <p style="color: #BAADA1 !important; line-height: 1.5; margin-bottom: 14px;">
                    {{ app()->getLocale() === 'vi' ? 'Đăng ký nhận cẩm nang pha chế, mẫu thử miễn phí và ưu đãi dành riêng cho thành viên S54.' : 'Subscribe for exclusive brewing recipes, free samples, and VIP discounts.' }}
                </p>
                <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã đăng ký nhận bản tin S54 Coffee!');" style="display: flex; gap: 8px; margin-bottom: 16px;">
                    <input type="email" required placeholder="{{ app()->getLocale() === 'vi' ? 'Nhập email của bạn...' : 'Your email address...' }}" style="flex: 1; padding: 11px 14px; border: 1px solid rgba(255,255,255,0.15); background-color: rgba(255,255,255,0.06); color: #FFFFFF; border-radius: 4px; font-size: 13px; outline: none;">
                    <button type="submit" style="background-color: #D68E1D; color: #FFFFFF; border: none; padding: 11px 20px; border-radius: 4px; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; transition: background 0.2s;">{{ app()->getLocale() === 'vi' ? 'Gửi' : 'Join' }}</button>
                </form>
                <div style="display: flex; align-items: center; gap: 10px; color: #8A7B70; font-size: 12px;">
                    <span>🛡️ 100% Nguyên chất</span>
                    <span>•</span>
                    <span>⚡ Giao siêu tốc</span>
                </div>
            </div>
        </div>

        {{-- Bottom Copyright Bar --}}
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 24px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px; color: #8A7B70; font-size: 13px;">
            <p style="margin: 0; color: #BAADA1 !important;">
                © {{ now()->year }} S54 COFFEE — Good Solutions Co., Ltd. Tất cả quyền được bảo lưu.
            </p>
            <p style="margin: 0; color: #BAADA1 !important;">
                <span style="color: #D68E1D;">New Coffee, New Income</span> • Tinh Hoa Cà Phê Việt
            </p>
        </div>
    </div>
</footer>
