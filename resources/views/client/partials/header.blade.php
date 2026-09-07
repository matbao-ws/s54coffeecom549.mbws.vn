<header class="c-header c-header--solid" contenteditable="false">
    <div class="c-announcement-bar" style="background-color: #2F221A; color: #FAF6F1; text-align: center; padding: 6px 16px; font-size: 12px; font-weight: 600; letter-spacing: 0.5px;">
        <span>🔥 {{ app()->getLocale() === 'vi' ? 'MIỄN PHÍ GIAO HÀNG TOÀN QUỐC CHO ĐƠN TỪ 500.000₫ | HOTLINE: 0974.933.907' : 'FREE NATIONWIDE SHIPPING ON ORDERS OVER 500,000₫ | HOTLINE: 0974.933.907' }}</span>
    </div>
    <div class="c-header__wrapper o-wrapper">
        <div class="c-header__brand">
            <a href="{{ route('client.home', ['locale' => app()->getLocale()]) }}" class="c-header__logo-link">
                <span style="font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 700; color: #FAF6F1; letter-spacing: 1.5px;">S54 COFFEE</span>
            </a>
        </div>

        <nav class="c-header__nav is-desktop-only">
            <ul class="c-main-menu">
                <li class="c-main-menu__item {{ request()->routeIs('client.catalog.*') ? 'is-active' : '' }}">
                    <a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" class="c-main-menu__link">
                        <span>{{ app()->getLocale() === 'vi' ? 'Sản Phẩm' : 'Products' }}</span>
                    </a>
                </li>
                <li class="c-main-menu__item {{ request()->is('*our-story*') ? 'is-active' : '' }}">
                    <a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'our-story']) }}" class="c-main-menu__link">
                        <span>{{ app()->getLocale() === 'vi' ? 'Câu Chuyện' : 'Our Story' }}</span>
                    </a>
                </li>
                <li class="c-main-menu__item {{ request()->is('*wholesale*') ? 'is-active' : '' }}">
                    <a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'wholesale']) }}" class="c-main-menu__link">
                        <span>{{ app()->getLocale() === 'vi' ? 'B2B & Đại Lý' : 'Wholesale' }}</span>
                    </a>
                </li>
                <li class="c-main-menu__item {{ request()->routeIs('client.blog.*') ? 'is-active' : '' }}">
                    <a href="{{ route('client.blog.index', ['locale' => app()->getLocale()]) }}" class="c-main-menu__link">
                        <span>{{ app()->getLocale() === 'vi' ? 'Cẩm Nang Cà Phê' : 'Journal' }}</span>
                    </a>
                </li>
            </ul>
        </nav>

        <ul class="c-header__additional">
            <li class="c-header__additional-item is-desktop-only">
                <a href="tel:0974933907" class="c-header__phone-link" style="color: #FAF6F1; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px; font-size: 13px;">
                    <span>📞</span> <span>0974.933.907</span>
                </a>
            </li>
            <li class="c-header__additional-item">
                <div class="s54-lang-switch" style="display: flex; gap: 4px; font-size: 12px; font-weight: 700; color: #FAF6F1;">
                    <a href="{{ url('/vi' . substr(request()->getRequestUri(), 3)) }}" style="color: {{ app()->getLocale() === 'vi' ? '#D68E1D' : '#FAF6F1' }}; text-decoration: none; padding: 2px 6px;">VI</a>
                    <span>|</span>
                    <a href="{{ url('/en' . substr(request()->getRequestUri(), 3)) }}" style="color: {{ app()->getLocale() === 'en' ? '#D68E1D' : '#FAF6F1' }}; text-decoration: none; padding: 2px 6px;">EN</a>
                </div>
            </li>
            <li class="c-header__additional-item">
                <button type="button" class="c-header__link is-cart" id="s54-cart-trigger" aria-label="Cart" style="background: none; border: none; cursor: pointer; position: relative; padding: 6px;">
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
</header>
