{{-- 1. Top Announcement Bar: Scrolls away naturally when scrolling down --}}
<div class="c-announcement-bar" id="s54-announcement-bar" style="background-color: #241A14; color: #FAF6F1; padding: 7px clamp(16px, 4vw, 48px); font-size: 11.5px; font-weight: 600; letter-spacing: 0.3px; border-bottom: 1px solid rgba(255,255,255,0.06); position: relative; z-index: 100;">
    <div style="max-width: 1440px; margin: 0 auto; display: flex; align-items: center; justify-content: center; text-align: center;">
        <span>🔥 {{ app()->getLocale() === 'vi' ? 'MIỄN PHÍ GIAO HÀNG TOÀN QUỐC CHO ĐƠN TỪ 500.000₫ | HOTLINE: 0974.933.907' : 'FREE NATIONWIDE SHIPPING ON ORDERS OVER 500,000₫ | HOTLINE: 0974.933.907' }}</span>
    </div>
</div>

{{-- 2. Main Sticky Header: Sticks to top: 0 when scrolling --}}
<header class="c-header c-header--solid" id="s54-sticky-header" contenteditable="false" style="position: sticky; top: 0; z-index: 1000; background-color: #2F221A; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);">
    <div class="c-header__wrapper o-wrapper" style="display: flex; align-items: center; justify-content: space-between; padding: 12px clamp(16px, 4vw, 48px); max-width: 1440px; margin: 0 auto; gap: 16px;">
        
        {{-- Mobile Hamburger Toggle --}}
        <button type="button" class="c-header__toggle is-mobile-only" id="s54-mobile-toggle" aria-label="Toggle Menu" style="background: none; border: none; cursor: pointer; padding: 6px; display: none; align-items: center; justify-content: center;">
            <svg fill="none" viewBox="0 0 24 24" width="20" height="20" stroke="#FAF6F1" stroke-width="2.2" stroke-linecap="round" style="width: 20px !important; height: 20px !important; max-width: 20px !important; max-height: 20px !important; display: block; flex-shrink: 0;">
                <line x1="3" y1="6" x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>

        {{-- Brand Logo --}}
        <div class="c-header__brand" style="display: flex; align-items: center;">
            <a href="{{ route('client.home', ['locale' => app()->getLocale()]) }}" class="c-header__logo-link c-header__logo" title="S54 COFFEE" style="text-decoration: none; display: inline-flex; align-items: center;">
                <img src="{{ asset('client-assets/images/s54/s54_logo.png') }}" alt="S54 COFFEE" width="180" height="38" class="c-header__logo-img" style="height: 38px; width: auto; max-width: 180px; object-fit: contain; display: block;" />
            </a>
        </div>

        {{-- Desktop Navigation Menu --}}
        <nav class="c-header__nav is-desktop-only" style="display: flex; align-items: center; justify-content: center; flex: 1;">
            <ul class="c-main-menu" style="display: flex; align-items: center; gap: clamp(16px, 2.5vw, 36px); list-style: none; margin: 0; padding: 0;">
                <li class="c-main-menu__item {{ request()->routeIs('client.catalog.*') ? 'is-active' : '' }}" style="list-style: none; margin: 0; padding: 0;">
                    <a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" class="c-main-menu__link" style="color: #FAF6F1; text-decoration: none; font-size: 14px; font-weight: 500;">
                        <span>{{ app()->getLocale() === 'vi' ? 'Sản Phẩm' : 'Products' }}</span>
                    </a>
                </li>
                <li class="c-main-menu__item {{ request()->is('*our-story*') ? 'is-active' : '' }}" style="list-style: none; margin: 0; padding: 0;">
                    <a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'our-story']) }}" class="c-main-menu__link" style="color: #FAF6F1; text-decoration: none; font-size: 14px; font-weight: 500;">
                        <span>{{ app()->getLocale() === 'vi' ? 'Câu Chuyện' : 'Our Story' }}</span>
                    </a>
                </li>
                <li class="c-main-menu__item {{ request()->is('*wholesale*') ? 'is-active' : '' }}" style="list-style: none; margin: 0; padding: 0;">
                    <a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'wholesale']) }}" class="c-main-menu__link" style="color: #FAF6F1; text-decoration: none; font-size: 14px; font-weight: 500;">
                        <span>{{ app()->getLocale() === 'vi' ? 'B2B & Đại Lý' : 'Wholesale' }}</span>
                    </a>
                </li>
                <li class="c-main-menu__item {{ request()->routeIs('client.blog.*') ? 'is-active' : '' }}" style="list-style: none; margin: 0; padding: 0;">
                    <a href="{{ route('client.blog.index', ['locale' => app()->getLocale()]) }}" class="c-main-menu__link" style="color: #FAF6F1; text-decoration: none; font-size: 14px; font-weight: 500;">
                        <span>{{ app()->getLocale() === 'vi' ? 'Cẩm Nang Cà Phê' : 'Journal' }}</span>
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Right Actions: Phone Hotline, Lang Switch, Cart --}}
        <ul class="c-header__additional" style="display: flex; align-items: center; gap: 10px; list-style: none; margin: 0; padding: 0;">
            <li class="c-header__additional-item is-desktop-only" style="list-style: none;">
                <a href="tel:0974933907" class="c-header__phone-link" style="color: #FAF6F1; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 7px; font-size: 12.5px; height: 32px; padding: 0 12px; border-radius: 16px; background: rgba(214, 142, 29, 0.1); border: 1px solid rgba(214, 142, 29, 0.3); transition: all 0.2s ease;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#D68E1D" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 13px !important; height: 13px !important; max-width: 13px !important; max-height: 13px !important; display: inline-block !important; flex-shrink: 0;">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                    <span>0974.933.907</span>
                </a>
            </li>

            {{-- Header Language Switcher Pill (Universal Desktop & Mobile) --}}
            <li class="c-header__additional-item" style="list-style: none;">
                <div class="s54-header-lang-pill" style="display: inline-flex !important; flex-direction: row !important; align-items: center !important; gap: 2px !important; padding: 2px 4px !important; border-radius: 16px !important; background: rgba(255,255,255,0.08) !important; border: 1px solid rgba(255,255,255,0.14) !important; height: 30px !important; box-sizing: border-box !important; flex-shrink: 0 !important;">
                    <a href="{{ url('/vi' . substr(request()->getRequestUri(), 3)) }}" class="s54-lang-btn {{ app()->getLocale() === 'vi' ? 'is-active' : '' }}" style="display: inline-flex !important; flex-direction: row !important; align-items: center !important; gap: 4px !important; padding: 3px 8px !important; border-radius: 12px !important; font-size: 11.5px !important; font-weight: 700 !important; text-decoration: none !important; color: {{ app()->getLocale() === 'vi' ? '#FFFFFF' : 'rgba(250,246,241,0.65)' }} !important; background: {{ app()->getLocale() === 'vi' ? '#D68E1D' : 'transparent' }} !important; transition: all 0.2s ease !important; line-height: 1 !important; white-space: nowrap !important; flex-shrink: 0 !important;" title="Tiếng Việt">
                        <svg class="s54-flag-icon" width="15" height="10" viewBox="0 0 30 20" style="width: 15px !important; height: 10px !important; min-width: 15px !important; max-width: 15px !important; min-height: 10px !important; max-height: 10px !important; border-radius: 1.5px !important; flex-shrink: 0 !important; display: inline-block !important; vertical-align: middle !important;">
                            <rect width="30" height="20" fill="#DA251D"/>
                            <polygon points="15,4 16.35,8.15 20.71,8.15 17.18,10.71 18.53,14.85 15,12.29 11.47,14.85 12.82,10.71 9.29,8.15 13.65,8.15" fill="#FFFF00"/>
                        </svg>
                        <span style="display: inline-block !important; line-height: 1 !important; font-size: 11px !important; font-weight: 700 !important;">VI</span>
                    </a>
                    <a href="{{ url('/en' . substr(request()->getRequestUri(), 3)) }}" class="s54-lang-btn {{ app()->getLocale() === 'en' ? 'is-active' : '' }}" style="display: inline-flex !important; flex-direction: row !important; align-items: center !important; gap: 4px !important; padding: 3px 8px !important; border-radius: 12px !important; font-size: 11.5px !important; font-weight: 700 !important; text-decoration: none !important; color: {{ app()->getLocale() === 'en' ? '#FFFFFF' : 'rgba(250,246,241,0.65)' }} !important; background: {{ app()->getLocale() === 'en' ? '#D68E1D' : 'transparent' }} !important; transition: all 0.2s ease !important; line-height: 1 !important; white-space: nowrap !important; flex-shrink: 0 !important;" title="English">
                        <svg class="s54-flag-icon" width="15" height="10" viewBox="0 0 60 40" style="width: 15px !important; height: 10px !important; min-width: 15px !important; max-width: 15px !important; min-height: 10px !important; max-height: 10px !important; border-radius: 1.5px !important; flex-shrink: 0 !important; display: inline-block !important; vertical-align: middle !important; overflow: hidden !important;">
                            <rect width="60" height="40" fill="#012169"/>
                            <path d="M0 0 L60 40 M60 0 L0 40" stroke="#FFFFFF" stroke-width="8"/>
                            <path d="M0 0 L60 40 M60 0 L0 40" stroke="#C8102E" stroke-width="4"/>
                            <path d="M30 0 v40 M0 20 h60" stroke="#FFFFFF" stroke-width="12"/>
                            <path d="M30 0 v40 M0 20 h60" stroke="#C8102E" stroke-width="6"/>
                        </svg>
                        <span style="display: inline-block !important; line-height: 1 !important; font-size: 11px !important; font-weight: 700 !important;">EN</span>
                    </a>
                </div>
            </li>

            {{-- Cart Button --}}
            <li class="c-header__additional-item" style="list-style: none;">
                <button type="button" class="c-header__link is-cart" id="s54-cart-trigger" aria-label="Cart" style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 50%; width: 34px; height: 34px; cursor: pointer; position: relative; padding: 0; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#FAF6F1" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="c-header__icon is-cart" style="width: 17px !important; height: 17px !important; max-width: 17px !important; max-height: 17px !important; display: block !important; flex-shrink: 0;">
                        <path d="M16 11V7a4 4 0 0 0-8 0v4"/>
                        <path d="M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span class="c-header__cart-count" id="s54-cart-badge" style="position: absolute; top: -3px; right: -4px; background-color: #D68E1D; color: #FFFFFF; font-size: 9.5px; font-weight: 700; border-radius: 50%; width: 16px; height: 16px; min-width: 16px; display: flex; align-items: center; justify-content: center; border: 1.5px solid #241A14; line-height: 1; padding: 0; box-sizing: border-box;">0</span>
                </button>
            </li>
        </ul>
    </div>

    {{-- Mobile Slide-Out Navigation Drawer --}}
    <div class="s54-mobile-overlay" id="s54-mobile-overlay">
        <div class="s54-mobile-drawer" id="s54-mobile-drawer">
            <div class="s54-mobile-drawer__header">
                <a href="{{ route('client.home', ['locale' => app()->getLocale()]) }}" title="S54 COFFEE" style="display: inline-flex; align-items: center; text-decoration: none;">
                    <img src="{{ asset('client-assets/images/s54/s54_logo.png') }}" alt="S54 COFFEE" width="140" height="30" style="height: 30px; width: auto; max-width: 140px; object-fit: contain; display: block;" />
                </a>
                <button type="button" id="s54-mobile-close" aria-label="Close Menu" style="background: none; border: none; color: #FAF6F1; font-size: 24px; cursor: pointer; padding: 4px 8px; line-height: 1;">✕</button>
            </div>

            <nav class="s54-mobile-drawer__nav">
                <a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" class="s54-mobile-drawer__link {{ request()->routeIs('client.catalog.*') ? 'is-active' : '' }}">
                    <span>☕ {{ app()->getLocale() === 'vi' ? 'Sản Phẩm Cà Phê' : 'Coffee Products' }}</span>
                    <span>→</span>
                </a>
                <a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'our-story']) }}" class="s54-mobile-drawer__link {{ request()->is('*our-story*') ? 'is-active' : '' }}">
                    <span>📖 {{ app()->getLocale() === 'vi' ? 'Câu Chuyện S54' : 'Our Story' }}</span>
                    <span>→</span>
                </a>
                <a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'wholesale']) }}" class="s54-mobile-drawer__link {{ request()->is('*wholesale*') ? 'is-active' : '' }}">
                    <span>🤝 {{ app()->getLocale() === 'vi' ? 'Giải Pháp B2B & Đại Lý' : 'Wholesale & B2B' }}</span>
                    <span>→</span>
                </a>
                <a href="{{ route('client.blog.index', ['locale' => app()->getLocale()]) }}" class="s54-mobile-drawer__link {{ request()->routeIs('client.blog.*') ? 'is-active' : '' }}">
                    <span>📰 {{ app()->getLocale() === 'vi' ? 'Cẩm Nang Cà Phê' : 'Coffee Journal' }}</span>
                    <span>→</span>
                </a>
            </nav>

            <div class="s54-mobile-drawer__footer">
                <a href="tel:0974933907" style="display: flex; align-items: center; gap: 8px; color: #FAF6F1; text-decoration: none; font-weight: 600; font-size: 14px; margin-bottom: 16px; background: rgba(214,142,29,0.15); border: 1px solid #D68E1D; padding: 10px 14px; border-radius: 6px;">
                    <span>📞</span> <span>Hotline: 0974.933.907</span>
                </a>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 12px; color: #BAADA1; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Ngôn ngữ:</span>
                    <div style="display: flex; gap: 8px; font-weight: 700; font-size: 12px;">
                        <a href="{{ url('/vi' . substr(request()->getRequestUri(), 3)) }}" style="color: {{ app()->getLocale() === 'vi' ? '#FFFFFF' : '#FAF6F1' }}; background: {{ app()->getLocale() === 'vi' ? '#D68E1D' : 'rgba(255,255,255,0.08)' }}; text-decoration: none; padding: 5px 10px; border-radius: 6px; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;">
                            <svg width="15" height="10" viewBox="0 0 30 20" style="width: 15px !important; height: 10px !important; min-width: 15px !important; max-width: 15px !important; min-height: 10px !important; max-height: 10px !important; border-radius: 1.5px; flex-shrink: 0; display: inline-block; vertical-align: middle;"><rect width="30" height="20" fill="#DA251D"/><polygon points="15,4 16.35,8.15 20.71,8.15 17.18,10.71 18.53,14.85 15,12.29 11.47,14.85 12.82,10.71 9.29,8.15 13.65,8.15" fill="#FFFF00"/></svg>
                            <span>VI</span>
                        </a>
                        <a href="{{ url('/en' . substr(request()->getRequestUri(), 3)) }}" style="color: {{ app()->getLocale() === 'en' ? '#FFFFFF' : '#FAF6F1' }}; background: {{ app()->getLocale() === 'en' ? '#D68E1D' : 'rgba(255,255,255,0.08)' }}; text-decoration: none; padding: 5px 10px; border-radius: 6px; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;">
                            <svg width="15" height="10" viewBox="0 0 60 40" style="width: 15px !important; height: 10px !important; min-width: 15px !important; max-width: 15px !important; min-height: 10px !important; max-height: 10px !important; border-radius: 1.5px; flex-shrink: 0; display: inline-block; vertical-align: middle; overflow: hidden;"><rect width="60" height="40" fill="#012169"/><path d="M0 0 L60 40 M60 0 L0 40" stroke="#FFFFFF" stroke-width="8"/><path d="M0 0 L60 40 M60 0 L0 40" stroke="#C8102E" stroke-width="4"/><path d="M30 0 v40 M0 20 h60" stroke="#FFFFFF" stroke-width="12"/><path d="M30 0 v40 M0 20 h60" stroke="#C8102E" stroke-width="6"/></svg>
                            <span>EN</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
(function() {
    var toggleBtn = document.getElementById('s54-mobile-toggle');
    var closeBtn = document.getElementById('s54-mobile-close');
    var overlay = document.getElementById('s54-mobile-overlay');

    if (toggleBtn && overlay) {
        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            overlay.classList.add('is-active');
            document.body.style.overflow = 'hidden';
        });
    }

    function closeMobileMenu() {
        if (overlay) {
            overlay.classList.remove('is-active');
            document.body.style.overflow = '';
        }
    }

    if (closeBtn) closeBtn.addEventListener('click', closeMobileMenu);
    if (overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) closeMobileMenu();
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeMobileMenu();
    });
})();
</script>
