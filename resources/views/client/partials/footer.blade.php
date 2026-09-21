@php
    $locale = app()->getLocale();
    $site = app(\App\Services\SiteContentService::class);
    $settings = \App\Models\ProjectSetting::query()->get()->pluck('setting_value', 'setting_key');
    $footerSettings = $settings->get('footer_settings', []);
    $contactSettings = $settings->get('contact', []);

    $reqUri = request()->getRequestUri();
    $switchViUrl = preg_match('#^/(vi|en)(/|\?|$)#', $reqUri)
        ? preg_replace('#^/(vi|en)(/|\?|$)#', '/vi$2', $reqUri)
        : ('/vi' . (str_starts_with($reqUri, '/') ? $reqUri : '/' . $reqUri));
    $switchEnUrl = preg_match('#^/(vi|en)(/|\?|$)#', $reqUri)
        ? preg_replace('#^/(vi|en)(/|\?|$)#', '/en$2', $reqUri)
        : ('/en' . (str_starts_with($reqUri, '/') ? $reqUri : '/' . $reqUri));

    $companyName = $site->value('footer.company_name') 
        ?? ($footerSettings['company_name'] ?? null) 
        ?? ($settings->get('company_name') ?? null) 
        ?? ($locale === 'vi' ? 'CÔNG TY TNHH GIẢI PHÁP TỐT' : 'GOOD SOLUTIONS CO., LTD');

    $tagline = $site->value('footer.tagline') 
        ?? ($footerSettings['tagline'] ?? null) 
        ?? ($locale === 'vi' 
            ? '"New Coffee, New Income" — Tinh hoa cà phê Việt vang danh thương trường từ năm 2017' 
            : '"New Coffee, New Income" — The essence of pure Vietnamese coffee since 2017');

    $address = $site->value('footer.address') 
        ?? ($footerSettings['address'] ?? null) 
        ?? ($contactSettings['address'] ?? null) 
        ?? ($locale === 'vi' 
            ? 'Số 32, Đường 16, Manhattan, Vinhomes Grand Park, Phường Long Bình, TP. Thủ Đức, TP. Hồ Chí Minh' 
            : 'No. 32, 16th Street, Manhattan, Vinhomes Grand Park, Long Binh Ward, Thu Duc City, HCMC');

    $hotline = $site->value('footer.hotline') 
        ?? ($footerSettings['hotline'] ?? null) 
        ?? ($contactSettings['phone'] ?? null) 
        ?? '0911.833.911 - 0933.873.873';

    $email = $site->value('footer.email') 
        ?? ($footerSettings['email'] ?? null) 
        ?? ($contactSettings['email'] ?? null) 
        ?? 'info@goodsolutions.com.vn';

    $website = $site->value('footer.website') 
        ?? ($footerSettings['website'] ?? null) 
        ?? 'goodsolutions.com.vn';

    $websiteUrl = !empty($footerSettings['website_url']) 
        ? $footerSettings['website_url'] 
        : ('https://' . preg_replace('#^https?://#', '', $website));

    $col2Title = $site->value('footer.col2_title') 
        ?? ($footerSettings['col2_title'] ?? null) 
        ?? ($locale === 'vi' ? 'Sản Phẩm S54' : 'Products');

    $col3Title = $site->value('footer.col3_title') 
        ?? ($footerSettings['col3_title'] ?? null) 
        ?? ($locale === 'vi' ? 'Về S54 & Dịch Vụ' : 'About & Policies');

    $col4Title = $site->value('footer.col4_title') 
        ?? ($footerSettings['col4_title'] ?? null) 
        ?? ($locale === 'vi' ? 'Đăng Ký Nhận Ưu Đãi' : 'Newsletter');

    $newsletterDesc = $site->value('footer.newsletter_desc') 
        ?? ($footerSettings['newsletter_desc'] ?? null) 
        ?? ($locale === 'vi' 
            ? 'Nhận ngay voucher ưu đãi 15% cho đơn hàng đầu tiên cùng cẩm nang pha chế độc quyền từ S54 Coffee.' 
            : 'Get a 15% discount voucher for your first order and exclusive brewing recipes from S54 Coffee.');

    $copyright = $site->value('footer.copyright') 
        ?? ($footerSettings['copyright'] ?? null) 
        ?? ('© ' . now()->year . ' <strong>S54 COFFEE</strong> by <strong>Good Solutions Co., Ltd</strong>. ' . ($locale === 'vi' ? 'Giữ toàn quyền bản quyền.' : 'All rights reserved.'));
@endphp

<footer class="c-footer s54-footer" data-footer>
    <div class="s54-footer__container">
        
        <!-- Top Grid: 4 Clean Columns -->
        <div class="s54-footer__grid">
            
            <!-- Col 1: Brand Identity & Legal Info -->
            <div class="s54-footer__col s54-footer__col--brand">
                <a href="{{ route('client.home', ['locale' => $locale]) }}" class="s54-footer__logo-link" title="S54 COFFEE">
                    <img src="{{ asset('client-assets/images/s54/s54_logo.png') }}" alt="S54 COFFEE" class="s54-footer__logo-img" width="180" height="38" />
                </a>
                <p class="s54-footer__company-name">
                    <x-client::editable key="footer.company_name" tag="span">{{ $companyName }}</x-client::editable>
                </p>
                <p class="s54-footer__brand-tagline">
                    <x-client::editable key="footer.tagline" tag="span">{{ $tagline }}</x-client::editable>
                </p>
                
                <ul class="s54-footer__contact-list">
                    <li>
                        <span class="s54-footer__contact-icon">📍</span>
                        <span><x-client::editable key="footer.address" tag="span">{{ $address }}</x-client::editable></span>
                    </li>
                    <li>
                        <span class="s54-footer__contact-icon">📞</span>
                        <span>Hotline: <x-client::editable key="footer.hotline" tag="span">{{ $hotline }}</x-client::editable></span>
                    </li>
                    <li>
                        <span class="s54-footer__contact-icon">✉️</span>
                        <span>Email: <a href="mailto:{{ $email }}" style="color: inherit; text-decoration: none;"><x-client::editable key="footer.email" tag="span">{{ $email }}</x-client::editable></a></span>
                    </li>
                    <li>
                        <span class="s54-footer__contact-icon">🌐</span>
                        <span>Website: <a href="{{ $websiteUrl }}" target="_blank" rel="noopener" style="color: inherit; text-decoration: none;"><x-client::editable key="footer.website" tag="span">{{ $website }}</x-client::editable></a></span>
                    </li>
                </ul>
            </div>

            <!-- Col 2: Sản Phẩm & Mua Sắm -->
            <div class="s54-footer__col">
                <h4 class="s54-footer__heading" style="color: #FFFFFF !important;">
                    <x-client::editable key="footer.col2_title" tag="span">{{ $col2Title }}</x-client::editable>
                </h4>
                <ul class="s54-footer__links">
                    <li><a href="{{ route('client.catalog.index', ['locale' => $locale]) }}">{{ $locale === 'vi' ? 'Tất Cả Sản Phẩm' : 'All Products' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => $locale]) }}">{{ $locale === 'vi' ? 'S54 Robusta Rang Mộc' : 'Roasted Robusta' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => $locale]) }}">{{ $locale === 'vi' ? 'S54 Arabica Cầu Đất' : 'Specialty Arabica' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => $locale]) }}">{{ $locale === 'vi' ? 'Cà Phê Hòa Tan 3in1 (456g)' : 'Instant 3-in-1 Coffee' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => $locale]) }}">{{ $locale === 'vi' ? 'Cà Phê Sấy Lạnh Cao Cấp' : 'Freeze-Dried Coffee' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => $locale]) }}">{{ $locale === 'vi' ? 'Cà Phê Túi Lọc Drip Bag' : 'Drip Bag Coffee' }}</a></li>
                    <li><a href="{{ route('client.catalog.index', ['locale' => $locale]) }}">{{ $locale === 'vi' ? 'Cà Phê Xay Pha Phin' : 'Ground Phin Coffee' }}</a></li>
                </ul>
            </div>

            <!-- Col 3: Về S54 & Dịch Vụ -->
            <div class="s54-footer__col">
                <h4 class="s54-footer__heading" style="color: #FFFFFF !important;">
                    <x-client::editable key="footer.col3_title" tag="span">{{ $col3Title }}</x-client::editable>
                </h4>
                <ul class="s54-footer__links">
                    <li><a href="{{ route('client.pages.show', ['locale' => $locale, 'slug' => 'our-story']) }}">{{ $locale === 'vi' ? 'Câu Chuyện Thương Hiệu' : 'Our Story' }}</a></li>
                    <li><a href="{{ route('client.blog.index', ['locale' => $locale]) }}">{{ $locale === 'vi' ? 'Bản Tin & Tri Thức Cà Phê' : 'Coffee Journal' }}</a></li>
                    <li><a href="{{ route('client.pages.show', ['locale' => $locale, 'slug' => 'wholesale']) }}">{{ $locale === 'vi' ? 'Cung Ứng B2B & Đại Lý' : 'B2B & Wholesale' }}</a></li>
                    <li><a href="{{ route('client.pages.show', ['locale' => $locale, 'slug' => 'chinh-sach-van-chuyen']) }}">{{ $locale === 'vi' ? 'Chính Sách Vận Chuyển' : 'Shipping Policy' }}</a></li>
                    <li><a href="{{ route('client.pages.show', ['locale' => $locale, 'slug' => 'chinh-sach-doi-tra']) }}">{{ $locale === 'vi' ? 'Chính Sách Đổi Trả & Bảo Hành' : 'Return Policy' }}</a></li>
                    <li><a href="{{ route('client.pages.show', ['locale' => $locale, 'slug' => 'chinh-sach-bao-mat']) }}">{{ $locale === 'vi' ? 'Chính Sách Bảo Mật' : 'Privacy Policy' }}</a></li>
                    <li><a href="{{ route('client.contact', ['locale' => $locale]) }}">{{ $locale === 'vi' ? 'Liên Hệ Hợp Tác' : 'Contact & Partnership' }}</a></li>
                </ul>
            </div>

            <!-- Col 4: Đăng Ký Nhận Tin & Kết Nối -->
            <div class="s54-footer__col s54-footer__col--newsletter">
                <h4 class="s54-footer__heading" style="color: #FFFFFF !important;">
                    <x-client::editable key="footer.col4_title" tag="span">{{ $col4Title }}</x-client::editable>
                </h4>
                <p class="s54-footer__newsletter-desc">
                    <x-client::editable key="footer.newsletter_desc" tag="span">{{ $newsletterDesc }}</x-client::editable>
                </p>
                
                <form class="s54-footer__form" onsubmit="event.preventDefault(); alert('{{ $locale === 'vi' ? 'Cảm ơn bạn đã đăng ký nhận tin từ S54 Coffee!' : 'Thank you for subscribing to S54 Coffee!' }}');">
                    <div class="s54-footer__input-wrap">
                        <input type="email" class="s54-footer__input" placeholder="{{ $locale === 'vi' ? 'Nhập địa chỉ email của bạn...' : 'Your email address...' }}" required />
                        <button type="submit" class="s54-footer__submit-btn" aria-label="{{ $locale === 'vi' ? 'Đăng ký nhận tin' : 'Subscribe to newsletter' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </form>

                <div class="s54-footer__social-wrap">
                    <span class="s54-footer__social-title">{{ $locale === 'vi' ? 'Kết Nối Với Chúng Tôi:' : 'Connect With Us:' }}</span>
                    <div class="s54-footer__social-icons">
                        <a href="https://www.facebook.com/S54COFFEE" target="_blank" rel="noopener" class="s54-footer__social-btn" aria-label="Facebook">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                        </a>
                        <a href="https://zalo.me/0974933907" target="_blank" rel="noopener" class="s54-footer__social-btn" aria-label="Zalo">
                            <span style="font-weight: 800; font-size: 11px;">Zalo</span>
                        </a>
                        <a href="https://www.youtube.com/@S54COFFEE" target="_blank" rel="noopener" class="s54-footer__social-btn" aria-label="YouTube">
                            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24" style="display: block;">
                                <path d="M21.58 7.19a2.51 2.51 0 0 0-1.77-1.78C18.25 5 12 5 12 5s-6.25 0-7.81.41A2.51 2.51 0 0 0 2.42 7.19C2 8.76 2 12 2 12s0 3.24.42 4.81a2.51 2.51 0 0 0 1.77 1.78C5.75 19 12 19 12 19s6.25 0 7.81-.41a2.51 2.51 0 0 0 1.77-1.78C22 15.24 22 12 22 12s0-3.24-.42-4.81zM10 15V9l5.2 3-5.2 3z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Bar: Legal Copyright, Payment Badges & Language Switcher -->
        <div class="s54-footer__bottom">
            <div class="s54-footer__copyright">
                <x-client::editable key="footer.copyright" tag="span">{!! $copyright !!}</x-client::editable>
            </div>
            
            <div class="s54-footer__payments">
                <span class="s54-footer__pay-badge">{{ $locale === 'vi' ? 'Chuyển Khoản' : 'Bank Transfer' }}</span>
                <span class="s54-footer__pay-badge">COD</span>
                <span class="s54-footer__pay-badge">VNPAY</span>
                <span class="s54-footer__pay-badge">Momo</span>
                <span class="s54-footer__pay-badge">VISA</span>
                <span class="s54-footer__pay-badge">Mastercard</span>
            </div>

            <div class="c-lang-switcher c-lang-switcher--footer" data-lang-switcher>
                <a href="{{ $switchViUrl }}" class="c-lang-btn {{ $locale === 'vi' ? 'is-active' : '' }}" aria-label="Tiếng Việt" style="white-space: nowrap !important; display: inline-flex !important; align-items: center !important; gap: 6px !important;">
                    <svg class="s54-flag-icon" width="16" height="11" viewBox="0 0 30 20" style="width: 16px !important; height: 11px !important; min-width: 16px !important; max-width: 16px !important; min-height: 11px !important; max-height: 11px !important; border-radius: 1.5px; flex-shrink: 0; display: inline-block; vertical-align: middle;">
                        <rect width="30" height="20" fill="#DA251D"/>
                        <polygon points="15,4 16.35,8.15 20.71,8.15 17.18,10.71 18.53,14.85 15,12.29 11.47,14.85 12.82,10.71 9.29,8.15 13.65,8.15" fill="#FFFF00"/>
                    </svg>
                    <span>Tiếng Việt</span>
                </a>
                <span class="c-lang-divider">|</span>
                <a href="{{ $switchEnUrl }}" class="c-lang-btn {{ $locale === 'en' ? 'is-active' : '' }}" aria-label="English" style="white-space: nowrap !important; display: inline-flex !important; align-items: center !important; gap: 6px !important;">
                    <svg class="s54-flag-icon" width="16" height="11" viewBox="0 0 60 40" style="width: 16px !important; height: 11px !important; min-width: 16px !important; max-width: 16px !important; min-height: 11px !important; max-height: 11px !important; border-radius: 1.5px; flex-shrink: 0; display: inline-block; vertical-align: middle; overflow: hidden;">
                        <rect width="60" height="40" fill="#012169"/>
                        <path d="M0 0 L60 40 M60 0 L0 40" stroke="#FFFFFF" stroke-width="8"/>
                        <path d="M0 0 L60 40 M60 0 L0 40" stroke="#C8102E" stroke-width="4"/>
                        <path d="M30 0 v40 M0 20 h60" stroke="#FFFFFF" stroke-width="12"/>
                        <path d="M30 0 v40 M0 20 h60" stroke="#C8102E" stroke-width="6"/>
                    </svg>
                    <span>English</span>
                </a>
            </div>
        </div>

    </div>
</footer>
