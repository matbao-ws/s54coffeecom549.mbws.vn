<header class="c-header c-header--solid" contenteditable="false">
    <div class="c-announcement-bar" style="background-color: #241A14; color: #FAF6F1; text-align: center; padding: 6px 16px; font-size: 11.5px; font-weight: 600; letter-spacing: 0.5px; border-bottom: 1px solid rgba(255,255,255,0.06);">
        <span>🔥 {{ app()->getLocale() === 'vi' ? 'MIỄN PHÍ GIAO HÀNG TOÀN QUỐC CHO ĐƠN TỪ 500.000₫ | HOTLINE: 0974.933.907' : 'FREE NATIONWIDE SHIPPING ON ORDERS OVER 500,000₫ | HOTLINE: 0974.933.907' }}</span>
    </div>
    
    <div class="c-header__wrapper o-wrapper" style="display: flex; align-items: center; justify-content: space-between; padding: 12px clamp(16px, 4vw, 48px); max-width: 1440px; margin: 0 auto; gap: 16px;">
        
        {{-- Mobile Hamburger Toggle --}}
        <button type="button" class="c-header__toggle is-mobile-only" id="s54-mobile-toggle" aria-label="Toggle Menu" style="background: none; border: none; cursor: pointer; padding: 6px; display: none; align-items: center; justify-content: center;">
            <svg fill="none" viewBox="0 0 24 24" width="24" height="24" stroke="#FAF6F1" stroke-width="2.2" stroke-linecap="round">
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
        <ul class="c-header__additional" style="display: flex; align-items: center; gap: 14px; list-style: none; margin: 0; padding: 0;">
            <li class="c-header__additional-item is-desktop-only" style="list-style: none;">
                <a href="tel:0974933907" class="c-header__phone-link" style="color: #FAF6F1; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px; font-size: 13px;">
                    <span>📞</span> <span>0974.933.907</span>
                </a>
            </li>
            <li class="c-header__additional-item is-mobile-only" style="list-style: none;">
                <div class="s54-lang-switch s54-mobile-lang-pill" style="display: flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 700; color: #FAF6F1;">
                    <a href="{{ url('/vi' . substr(request()->getRequestUri(), 3)) }}" style="color: {{ app()->getLocale() === 'vi' ? '#D68E1D' : '#FAF6F1' }}; text-decoration: none; padding: 2px 5px; border-radius: 3px;">VI</a>
                    <span style="opacity: 0.4;">|</span>
                    <a href="{{ url('/en' . substr(request()->getRequestUri(), 3)) }}" style="color: {{ app()->getLocale() === 'en' ? '#D68E1D' : '#FAF6F1' }}; text-decoration: none; padding: 2px 5px; border-radius: 3px;">EN</a>
                </div>
            </li>
            <li class="c-header__additional-item" style="list-style: none;">
                <button type="button" class="c-header__link is-cart" id="s54-cart-trigger" aria-label="Cart" style="background: none; border: none; cursor: pointer; position: relative; padding: 6px; display: flex; align-items: center; justify-content: center;">
                    <svg fill="none" viewBox="0 0 24 24" width="22" height="22" stroke="#FAF6F1" stroke-width="1.8">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                    <span class="c-header__cart-count" id="s54-cart-badge" style="position: absolute; top: -2px; right: -4px; background-color: #D68E1D; color: #FFFFFF; font-size: 10px; font-weight: 800; border-radius: 10px; padding: 1px 6px; min-width: 16px; text-align: center;">0</span>
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
                        <a href="{{ url('/vi' . substr(request()->getRequestUri(), 3)) }}" style="color: {{ app()->getLocale() === 'vi' ? '#D68E1D' : '#FAF6F1' }}; text-decoration: none; padding: 4px 10px; background: rgba(255,255,255,0.08); border-radius: 4px;">🇻🇳 VI</a>
                        <a href="{{ url('/en' . substr(request()->getRequestUri(), 3)) }}" style="color: {{ app()->getLocale() === 'en' ? '#D68E1D' : '#FAF6F1' }}; text-decoration: none; padding: 4px 10px; background: rgba(255,255,255,0.08); border-radius: 4px;">🇬🇧 EN</a>
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
