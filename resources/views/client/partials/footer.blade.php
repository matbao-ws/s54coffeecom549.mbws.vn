<footer class="c-footer s54-footer" data-footer contenteditable="false">
    <div class="s54-footer__container">
        
        <!-- Top Grid: 4 Clean Columns -->
        <div class="s54-footer__grid">
            
            <!-- Col 1: Brand Identity & Legal Info -->
            <div class="s54-footer__col s54-footer__col--brand">
                <a href="{{ route('client.home', ['locale' => app()->getLocale()]) }}" class="s54-footer__logo-link" title="S54 COFFEE">
                    <img src="{{ asset('client-assets/images/s54/s54_logo.png') }}" alt="S54 COFFEE" class="s54-footer__logo-img" width="180" height="38" />
                </a>
                <p class="s54-footer__company-name">CÔNG TY TNHH GIẢI PHÁP TỐT</p>
                <p class="s54-footer__brand-tagline">"New Coffee, New Income" — {{ app()->getLocale() === 'vi' ? 'Tinh hoa cà phê Việt rang mộc thượng hạng từ năm 2012.' : 'The essence of pure Vietnamese roasted coffee since 2012.' }}</p>
                
                <ul class="s54-footer__contact-list">
                    <li>
                        <span class="s54-footer__contact-icon">📍</span>
                        <span>{{ app()->getLocale() === 'vi' ? 'Số 35, Đường T8, Manhattan, Vinhomes Grand Park, Phường Long Bình, TP. Thủ Đức, TP. Hồ Chí Minh' : 'No. 35, T8 Street, Manhattan, Vinhomes Grand Park, Long Binh, Thu Duc City, HCMC' }}</span>
                    </li>
                    <li>
                        <span class="s54-footer__contact-icon">📞</span>
                        <span>Hotline: <a href="tel:0974933907">0974.933.907</a> — <a href="tel:0902873345">0902.873.345</a></span>
                    </li>
                    <li>
                        <span class="s54-footer__contact-icon">✉️</span>
                        <span>Email: <a href="mailto:infor@S54Coffee.com">infor@S54Coffee.com</a></span>
                    </li>
                    <li>
                        <span class="s54-footer__contact-icon">🌐</span>
                        <span>Website: <a href="https://goodsolutions.com.vn" target="_blank" rel="noopener">goodsolutions.com.vn</a></span>
                    </li>
                </ul>
            </div>

            <!-- Col 2: Sản Phẩm & Mua Sắm -->
            <div class="s54-footer__col">
                <h4 class="s54-footer__heading">{{ app()->getLocale() === 'vi' ? 'Sản Phẩm S54' : 'Products' }}</h4>
                <ul class="s54-footer__links">
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}">{{ app()->getLocale() === 'vi' ? 'Tất Cả Sản Phẩm' : 'All Products' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}">{{ app()->getLocale() === 'vi' ? 'S54 Robusta Rang Mộc' : 'Roasted Robusta' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}">{{ app()->getLocale() === 'vi' ? 'S54 Arabica Cầu Đất' : 'Specialty Arabica' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}">{{ app()->getLocale() === 'vi' ? 'Cà Phê Hòa Tan 3in1 (456g)' : 'Instant 3-in-1 Coffee' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}">{{ app()->getLocale() === 'vi' ? 'Cà Phê Sấy Lạnh Cao Cấp' : 'Freeze-Dried Coffee' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}">{{ app()->getLocale() === 'vi' ? 'Cà Phê Túi Lọc Drip Bag' : 'Drip Bag Coffee' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}">{{ app()->getLocale() === 'vi' ? 'Cà Phê Xay Pha Phin' : 'Ground Phin Coffee' }}</a></li>
                </ul>
            </div>

            <!-- Col 3: Về S54 & Dịch Vụ -->
            <div class="s54-footer__col">
                <h4 class="s54-footer__heading">{{ app()->getLocale() === 'vi' ? 'Về S54 & Dịch Vụ' : 'About & Policies' }}</h4>
                <ul class="s54-footer__links">
                    <li><a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'our-story']) }}">{{ app()->getLocale() === 'vi' ? 'Câu Chuyện Thương Hiệu' : 'Our Story' }}</a></li>
                    <li><a href="{{ route('client.blog.index', ['locale' => app()->getLocale()]) }}">{{ app()->getLocale() === 'vi' ? 'Bản Tin & Tri Thức Cà Phê' : 'Coffee Journal' }}</a></li>
                    <li><a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'wholesale']) }}">{{ app()->getLocale() === 'vi' ? 'Cung Ứng B2B & Đại Lý' : 'B2B & Wholesale' }}</a></li>
                    <li><a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'chinh-sach-van-chuyen']) }}">{{ app()->getLocale() === 'vi' ? 'Chính Sách Vận Chuyển' : 'Shipping Policy' }}</a></li>
                    <li><a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'chinh-sach-doi-tra']) }}">{{ app()->getLocale() === 'vi' ? 'Chính Sách Đổi Trả & Bảo Hành' : 'Return Policy' }}</a></li>
                    <li><a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'chinh-sach-bao-mat']) }}">{{ app()->getLocale() === 'vi' ? 'Chính Sách Bảo Mật' : 'Privacy Policy' }}</a></li>
                    <li><a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'wholesale']) }}">{{ app()->getLocale() === 'vi' ? 'Liên Hệ Hợp Tác' : 'Contact & Partnership' }}</a></li>
                </ul>
            </div>

            <!-- Col 4: Đăng Ký Nhận Tin & Kết Nối -->
            <div class="s54-footer__col s54-footer__col--newsletter">
                <h4 class="s54-footer__heading">{{ app()->getLocale() === 'vi' ? 'Đăng Ký Nhận Ưu Đãi' : 'Newsletter' }}</h4>
                <p class="s54-footer__newsletter-desc">{{ app()->getLocale() === 'vi' ? 'Nhận ngay voucher ưu đãi 15% cho đơn hàng đầu tiên cùng cẩm nang pha chế độc quyền từ S54 Coffee.' : 'Get a 15% discount voucher for your first order and exclusive brewing recipes from S54 Coffee.' }}</p>
                
                <form class="s54-footer__form" onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã đăng ký nhận tin từ S54 Coffee!');">
                    <div class="s54-footer__input-wrap">
                        <input type="email" class="s54-footer__input" placeholder="{{ app()->getLocale() === 'vi' ? 'Nhập địa chỉ email của bạn...' : 'Your email address...' }}" required />
                        <button type="submit" class="s54-footer__submit-btn" aria-label="Đăng ký">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </form>

                <div class="s54-footer__social-wrap">
                    <span class="s54-footer__social-title">{{ app()->getLocale() === 'vi' ? 'Kết Nối Với Chúng Tôi:' : 'Connect With Us:' }}</span>
                    <div class="s54-footer__social-icons">
                        <a href="https://www.facebook.com/S54COFFEE" target="_blank" rel="noopener" class="s54-footer__social-btn" aria-label="Facebook">
                            <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                        </a>
                        <a href="https://zalo.me/0974933907" target="_blank" rel="noopener" class="s54-footer__social-btn" aria-label="Zalo">
                            <span style="font-weight: 800; font-size: 11px;">Zalo</span>
                        </a>
                        <a href="https://www.youtube.com/@S54COFFEE" target="_blank" rel="noopener" class="s54-footer__social-btn" aria-label="YouTube">
                            <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Bar: Legal Copyright, Payment Badges & Language Switcher -->
        <div class="s54-footer__bottom">
            <div class="s54-footer__copyright">
                © {{ now()->year }} <strong>S54 COFFEE</strong> by <strong>Good Solutions Co., Ltd</strong>. {{ app()->getLocale() === 'vi' ? 'Giữ toàn quyền bản quyền.' : 'All rights reserved.' }}
            </div>
            
            <div class="s54-footer__payments">
                <span class="s54-footer__pay-badge">{{ app()->getLocale() === 'vi' ? 'Chuyển Khoản' : 'Bank Transfer' }}</span>
                <span class="s54-footer__pay-badge">COD</span>
                <span class="s54-footer__pay-badge">VNPAY</span>
                <span class="s54-footer__pay-badge">Momo</span>
                <span class="s54-footer__pay-badge">VISA</span>
                <span class="s54-footer__pay-badge">Mastercard</span>
            </div>

            <div class="c-lang-switcher c-lang-switcher--footer" data-lang-switcher>
                <a href="{{ url('/vi' . substr(request()->getRequestUri(), 3)) }}" class="c-lang-btn {{ app()->getLocale() === 'vi' ? 'is-active' : '' }}" aria-label="Tiếng Việt">🇻🇳 Tiếng Việt</a>
                <span class="c-lang-divider">|</span>
                <a href="{{ url('/en' . substr(request()->getRequestUri(), 3)) }}" class="c-lang-btn {{ app()->getLocale() === 'en' ? 'is-active' : '' }}" aria-label="English">🇬🇧 English</a>
            </div>
        </div>

    </div>
</footer>
