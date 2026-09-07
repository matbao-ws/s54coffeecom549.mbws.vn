<footer class="c-footer" contenteditable="false" style="background-color: #241A14; color: #E5DDD5; padding: 60px 0 30px; font-size: 14px;">
    <div class="o-wrapper" style="max-width: 1440px; margin: 0 auto; padding: 0 clamp(20px, 4vw, 48px);">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 40px; margin-bottom: 48px;">
            <div>
                <h4 style="font-family: 'Cormorant Garamond', serif; font-size: 24px; font-weight: 700; color: #FAF6F1; margin-bottom: 16px;">S54 COFFEE</h4>
                <p style="color: #BAADA1; line-height: 1.6; margin-bottom: 12px;">CÔNG TY TNHH GIẢI PHÁP TỐT (Good Solutions Co., Ltd)</p>
                <p style="color: #BAADA1; line-height: 1.6; margin-bottom: 8px;">📍 Số 35, Đường T8, Manhattan, Vinhomes Grand Park, TP. Thủ Đức, TP.HCM</p>
                <p style="color: #BAADA1; line-height: 1.6; margin-bottom: 8px;">📞 Hotline: 0974.933.907</p>
                <p style="color: #BAADA1; line-height: 1.6;">✉️ Email: contact@s54coffee.com</p>
            </div>
            <div>
                <h4 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #FAF6F1; margin-bottom: 16px;">{{ app()->getLocale() === 'vi' ? 'Về S54 Coffee' : 'About S54' }}</h4>
                <ul style="list-style: none; padding: 0; margin: 0; line-height: 2;">
                    <li><a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'our-story']) }}" style="color: #BAADA1; text-decoration: none;">{{ app()->getLocale() === 'vi' ? 'Câu Chuyện Thương Hiệu' : 'Our Story' }}</a></li>
                    <li><a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'wholesale']) }}" style="color: #BAADA1; text-decoration: none;">{{ app()->getLocale() === 'vi' ? 'Giải Pháp B2B & Đại Lý' : 'Wholesale Solutions' }}</a></li>
                    <li><a href="{{ route('client.blog.index', ['locale' => app()->getLocale()]) }}" style="color: #BAADA1; text-decoration: none;">{{ app()->getLocale() === 'vi' ? 'Cẩm Nang Cà Phê' : 'Brewing Guides' }}</a></li>
                </ul>
            </div>
            <div>
                <h4 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #FAF6F1; margin-bottom: 16px;">{{ app()->getLocale() === 'vi' ? 'Danh Mục Sản Phẩm' : 'Product Categories' }}</h4>
                <ul style="list-style: none; padding: 0; margin: 0; line-height: 2;">
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" style="color: #BAADA1; text-decoration: none;">{{ app()->getLocale() === 'vi' ? 'Cà Phê Rang Mộc' : 'Roasted Beans' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" style="color: #BAADA1; text-decoration: none;">{{ app()->getLocale() === 'vi' ? 'Specialty Cao Cấp' : 'Specialty Range' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" style="color: #BAADA1; text-decoration: none;">{{ app()->getLocale() === 'vi' ? 'Cà Phê Hòa Tan 3in1' : 'Instant 3-in-1' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" style="color: #BAADA1; text-decoration: none;">{{ app()->getLocale() === 'vi' ? 'Cà Phê Sấy Lạnh (Freeze-Dried)' : 'Freeze-Dried Coffee' }}</a></li>
                </ul>
            </div>
            <div>
                <h4 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #FAF6F1; margin-bottom: 16px;">{{ app()->getLocale() === 'vi' ? 'Bản Tin S54' : 'Newsletter' }}</h4>
                <p style="color: #BAADA1; line-height: 1.5; margin-bottom: 14px;">{{ app()->getLocale() === 'vi' ? 'Đăng ký nhận cẩm nang thưởng thức và ưu đãi dành riêng cho thành viên.' : 'Subscribe to receive brewing guides and exclusive member benefits.' }}</p>
                <form action="#" method="POST" style="display: flex; gap: 8px;">
                    <input type="email" placeholder="{{ app()->getLocale() === 'vi' ? 'Email của bạn...' : 'Your email...' }}" style="flex: 1; padding: 10px 14px; border: 1px solid #4A3A2F; background-color: #2F221A; color: #FAF6F1; border-radius: 4px; font-size: 13px;">
                    <button type="submit" style="background-color: #D68E1D; color: #FFFFFF; border: none; padding: 10px 18px; border-radius: 4px; font-weight: 700; font-size: 12px; text-transform: uppercase; cursor: pointer;">{{ app()->getLocale() === 'vi' ? 'Gửi' : 'Join' }}</button>
                </form>
            </div>
        </div>

        <div style="border-top: 1px solid #3B2D24; padding-top: 24px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px; color: #8A7B70; font-size: 13px;">
            <p style="margin: 0;">© {{ now()->year }} S54 COFFEE — Good Solutions Co., Ltd. All rights reserved.</p>
            <p style="margin: 0;">New Coffee, New Income • Tinh Hoa Cà Phê Việt</p>
        </div>
    </div>
</footer>
