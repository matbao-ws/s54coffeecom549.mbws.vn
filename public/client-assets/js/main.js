/**
 * S54 COFFEE - Master Interactive Controller
 * High-Performance E-Commerce Storefront Engine
 */
(function() {
    'use strict';

    const freeShippingThreshold = 599000;

    /* =====================================================================
       1. i18n Translation Dictionary
       ===================================================================== */
    const strings = {
        vi: {
            cart_title: 'Giỏ Hàng Của Bạn',
            cart_checkout: 'TIẾN HÀNH THANH TOÁN',
            cart_subtotal: 'Tạm Tính',
            cart_empty_title: 'Giỏ hàng của bạn đang trống.',
            cart_start_shopping: 'Bắt Đầu Mua Sắm',
            cart_freeship_qualified: '🎉 Bạn đã được MIỄN PHÍ VẬN CHUYỂN!',
            cart_freeship_remaining: 'Thêm {{amount}} nữa để được MIỄN PHÍ VẬN CHUYỂN',
            cart_proceed_checkout: 'Đang chuyển đến cổng thanh toán bảo mật...',
            cart_view_cart: 'Xem Giỏ Hàng Chi Tiết',
            cart_btn_added: 'ĐÃ THÊM!',
            cart_added_toast: '✓ Đã thêm "{{title}}" vào giỏ hàng',
            home_newsletter_success: '✓ Cảm ơn bạn! Đã đăng ký thành công với {{email}}'
        },
        en: {
            cart_title: 'Your Bag',
            cart_checkout: 'CHECKOUT',
            cart_subtotal: 'Subtotal',
            cart_empty_title: 'Your bag is currently empty.',
            cart_start_shopping: 'Start Shopping',
            cart_freeship_qualified: '🎉 You qualify for FREE Delivery!',
            cart_freeship_remaining: 'Add {{amount}} more for FREE Shipping',
            cart_proceed_checkout: 'Proceeding to Secure Checkout...',
            cart_view_cart: 'View Cart Details',
            cart_btn_added: 'ADDED!',
            cart_added_toast: '✓ Added "{{title}}" to your bag',
            home_newsletter_success: '✓ Thank you! Subscribed with {{email}}'
        }
    };

    function _t(key, params) {
        const lang = (window.S54I18n && typeof window.S54I18n.getLanguage === 'function') 
            ? window.S54I18n.getLanguage() : 'vi';
        let str = (strings[lang] && strings[lang][key]) || (strings.vi[key]) || key;
        if (params && typeof params === 'object') {
            Object.keys(params).forEach(k => {
                str = str.replace(new RegExp('{{' + k + '}}', 'g'), params[k]);
            });
        }
        return str;
    }

    function formatPrice(amount) {
        if (typeof amount !== 'number') amount = parseFloat(amount) || 0;
        return new Intl.NumberFormat('vi-VN').format(Math.round(amount)) + '₫';
    }

    function getCart() {
        if (window.S54Cart && typeof window.S54Cart.getCart === 'function') {
            return window.S54Cart.getCart();
        }
        return window.__s54MockCart || { items: [], total_price: 0, item_count: 0 };
    }

    /* =====================================================================
       2. Cart Drawer DOM & UI Controller
       ===================================================================== */
    function ensureCartDrawer() {
        let drawer = document.querySelector('.c-cart-drawer');
        let overlay = document.querySelector('.c-cart-drawer__overlay');

        if (!drawer) {
            drawer = document.createElement('div');
            drawer.className = 'c-cart-drawer';
            drawer.innerHTML = `
                <div class="c-cart-drawer__header">
                    <h3 class="c-cart-drawer__title">${_t('cart_title')}</h3>
                    <button class="c-cart-drawer__close" aria-label="Đóng giỏ hàng">✕</button>
                </div>
                <div class="c-cart-drawer__free-shipping">
                    <div class="c-cart-drawer__free-shipping-text">${_t('cart_freeship_remaining', { amount: '599.000₫' })}</div>
                    <div class="c-cart-drawer__progress-bar">
                        <div class="c-cart-drawer__progress-fill"></div>
                    </div>
                </div>
                <div class="c-cart-drawer__body"></div>
                <div class="c-cart-drawer__footer">
                    <div class="c-cart-drawer__subtotal">
                        <span>${_t('cart_subtotal')}</span>
                        <span class="c-cart-drawer__subtotal-amount">0₫</span>
                    </div>
                    <button class="c-cart-drawer__checkout-btn">${_t('cart_checkout')}</button>
                    <a href="cart.html" class="c-cart-drawer__view-cart" style="display: block; text-align: center; margin-top: 10px; font-size: 13px; font-weight: 600; color: #6E6259; text-decoration: underline;">${_t('cart_view_cart')}</a>
                </div>
            `;
            document.body.appendChild(drawer);

            drawer.querySelector('.c-cart-drawer__close').addEventListener('click', closeCartDrawer);
            drawer.querySelector('.c-cart-drawer__checkout-btn').addEventListener('click', () => {
                window.location.href = 'checkout.html';
            });

            drawer.addEventListener('click', (e) => {
                const action = e.target.dataset.action;
                const id = e.target.dataset.id;
                if (!action || !id) return;
                e.preventDefault();
                e.stopPropagation();

                const cart = getCart();
                const item = (cart.items || []).find(i => String(i.id) === String(id) || String(i.key) === String(id));
                if (!item) return;

                if (window.S54Cart) {
                    const key = item.key || item.id;
                    if (action === 'increase') window.S54Cart.updateQuantity(key, item.quantity + 1);
                    else if (action === 'decrease') window.S54Cart.updateQuantity(key, item.quantity - 1);
                    else if (action === 'remove') window.S54Cart.updateQuantity(key, 0);
                }
                updateCartUI();
            });
        }

        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'c-cart-drawer__overlay';
            overlay.addEventListener('click', closeCartDrawer);
            document.body.appendChild(overlay);
        }
    }

    function updateCartUI() {
        const cart = getCart();
        const items = cart.items || [];
        const totalItems = cart.item_count !== undefined ? cart.item_count : items.reduce((sum, i) => sum + i.quantity, 0);
        const subtotal = (cart.total_price !== undefined ? cart.total_price : items.reduce((sum, i) => sum + (i.price * i.quantity), 0));

        // Update badge
        document.querySelectorAll('.c-header__cart-count, [data-cart-count], .c-icon-cart__count, .c-cart-count').forEach(badge => {
            badge.textContent = totalItems;
            badge.style.display = totalItems > 0 ? 'inline-flex' : 'none';
        });

        const drawerTitle = document.querySelector('.c-cart-drawer__title');
        if (drawerTitle) drawerTitle.textContent = _t('cart_title');

        const checkoutBtn = document.querySelector('.c-cart-drawer__checkout-btn');
        if (checkoutBtn) checkoutBtn.textContent = _t('cart_checkout');

        const subtotalLabel = document.querySelector('.c-cart-drawer__subtotal span:first-child');
        if (subtotalLabel) subtotalLabel.textContent = _t('cart_subtotal');

        const viewCartEl = document.querySelector('.c-cart-drawer__view-cart');
        if (viewCartEl) viewCartEl.textContent = _t('cart_view_cart');

        const cartBody = document.querySelector('.c-cart-drawer__body');
        if (cartBody) {
            if (items.length === 0) {
                cartBody.innerHTML = `
                    <div style="text-align: center; padding: 60px 20px; color: #6E6259;">
                        <p style="font-size: 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; margin-bottom: 16px;">${_t('cart_empty_title')}</p>
                        <button type="button" class="c-cart-drawer__shop-btn" style="padding: 12px 28px; background-color: #2F221A; color: #FFFFFF; border: none; border-radius: 4px; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13px; letter-spacing: 1px; text-transform: uppercase;">${_t('cart_start_shopping')}</button>
                    </div>
                `;
                const shopBtn = cartBody.querySelector('.c-cart-drawer__shop-btn');
                if (shopBtn) shopBtn.addEventListener('click', () => {
                    closeCartDrawer();
                    if (!window.location.href.includes('collections-coffee')) {
                        window.location.href = 'collections-coffee.html';
                    }
                });
            } else {
                cartBody.innerHTML = items.map(item => {
                    const itemPrice = item.price;
                    return `
                    <div class="c-cart-drawer__item" data-id="${item.id || item.key}">
                        <img src="${item.image || 'assets/images/s54/robusta_1.jpg'}" alt="${item.title}" class="c-cart-drawer__item-img">
                        <div class="c-cart-drawer__item-details">
                            <h4 class="c-cart-drawer__item-title">${item.title}</h4>
                            <div class="c-cart-drawer__item-price">${formatPrice(itemPrice)}</div>
                            <div class="c-cart-drawer__qty-wrap">
                                <button type="button" class="c-cart-drawer__qty-btn" data-action="decrease" data-id="${item.id || item.key}">−</button>
                                <span class="c-cart-drawer__qty-val">${item.quantity}</span>
                                <button type="button" class="c-cart-drawer__qty-btn" data-action="increase" data-id="${item.id || item.key}">+</button>
                            </div>
                        </div>
                        <button type="button" class="c-cart-drawer__item-remove" data-action="remove" data-id="${item.id || item.key}" aria-label="Xóa">✕</button>
                    </div>`;
                }).join('');
            }
        }

        // Free shipping progress bar
        const freeShippingMsg = document.querySelector('.c-cart-drawer__free-shipping-text');
        const progressFill = document.querySelector('.c-cart-drawer__progress-fill');
        if (freeShippingMsg && progressFill) {
            if (subtotal >= freeShippingThreshold) {
                freeShippingMsg.textContent = _t('cart_freeship_qualified');
                progressFill.style.width = '100%';
            } else {
                const diff = freeShippingThreshold - subtotal;
                freeShippingMsg.textContent = _t('cart_freeship_remaining', { amount: formatPrice(diff) });
                progressFill.style.width = `${Math.min(100, Math.max(8, (subtotal / freeShippingThreshold) * 100))}%`;
            }
        }

        const subtotalEl = document.querySelector('.c-cart-drawer__subtotal-amount');
        if (subtotalEl) subtotalEl.textContent = formatPrice(subtotal);
    }

    function openCartDrawer() {
        ensureCartDrawer();
        const drawer = document.querySelector('.c-cart-drawer');
        const overlay = document.querySelector('.c-cart-drawer__overlay');
        if (drawer) drawer.classList.add('is-open');
        if (overlay) overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        updateCartUI();
    }

    function closeCartDrawer() {
        const drawer = document.querySelector('.c-cart-drawer');
        const overlay = document.querySelector('.c-cart-drawer__overlay');
        if (drawer) drawer.classList.remove('is-open');
        if (overlay) overlay.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    function showToast(message) {
        let toast = document.querySelector('.c-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.className = 'c-toast';
            document.body.appendChild(toast);
        }
        toast.textContent = message;
        toast.classList.add('is-active');
        setTimeout(() => toast.classList.remove('is-active'), 2500);
    }

    window.openCartDrawer = openCartDrawer;
    window.closeCartDrawer = closeCartDrawer;
    window.showToast = showToast;
    window.updateCartUI = updateCartUI;

    window.addEventListener('cart:updated', updateCartUI);
    window.addEventListener('language:changed', updateCartUI);

    /* =====================================================================
       3. Bulletproof Add-To-Cart Processor
       ===================================================================== */
    let isProcessing = false;

    function handleAddToCart(targetEl, e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
            if (typeof e.stopImmediatePropagation === 'function') e.stopImmediatePropagation();
        }

        if (isProcessing) return;
        isProcessing = true;

        try {
            const card = targetEl.closest('.o-product-thumbnail') || 
                         targetEl.closest('.c-product-card') || 
                         targetEl.closest('.c-product-main') || 
                         targetEl.closest('form') ||
                         targetEl.closest('.shopify-section') || 
                         document;

            let title = 'S54 Robusta Cà Phê Rang Mộc Thượng Hạng';
            let price = 35000;
            let img = 'assets/images/s54/products/tui_3in1_456g.jpg';
            let id = Date.now();
            let qty = 1;
            let url = 'product-detail.html';

            // 1. Extract ID & URL
            const idInput = card.querySelector('input[name="id"], [data-product-select]');
            if (idInput && idInput.value) {
                const parsedId = parseInt(idInput.value, 10);
                if (!isNaN(parsedId)) id = parsedId;
            }
            const linkEl = card.querySelector('a[href*="id="], a.o-product-thumbnail__link, a.c-product-card__link');
            if (linkEl) {
                const href = linkEl.getAttribute('href') || '';
                if (href) url = href;
                const m = href.match(/id=([0-9]+)/);
                if (m && id === Date.now()) id = parseInt(m[1], 10);
            }

            // 2. Extract Title
            const titleEl = card.querySelector('.o-product-thumbnail__title, .c-product-card__title, .c-product-main__title, h1, h2, h3, h4, .o-heading');
            if (titleEl && titleEl.textContent) {
                title = titleEl.textContent.trim().replace(/\s+/g, ' ');
            }

            // 3. Extract Price - BULLETPROOF VND EXTRACTION (Never concatenate sale + compare price!)
            let extractedPrice = null;

            // Strategy A: Targeted sale price elements only
            const saleSelectors = [
                '.o-product-thumbnail__price-sale',
                '.o-pricing__price:not(.o-pricing__compare)',
                '[data-product-money]',
                '.c-product-card__price-sale',
                '.o-subscription-options__option-price[data-product-money]',
                '.special-price',
                '.price--sale'
            ];
            for (let s = 0; s < saleSelectors.length; s++) {
                const sel = card.querySelector(saleSelectors[s]);
                if (sel) {
                    const dataMoney = sel.getAttribute('data-money') || sel.getAttribute('data-price');
                    if (dataMoney) {
                        const p = parseInt(String(dataMoney).replace(/\./g, '').replace(/[^0-9]/g, ''), 10);
                        if (!isNaN(p) && p >= 1000 && p < 10000000) { extractedPrice = p; break; }
                    }
                    const textP = parseInt(sel.textContent.replace(/\./g, '').replace(/[^0-9]/g, ''), 10);
                    if (!isNaN(textP) && textP >= 1000 && textP < 10000000) { extractedPrice = textP; break; }
                }
            }

            // Strategy B: Match official S54 catalogue if Strategy A is missing or abnormal
            if (!extractedPrice && window.S54_PRODUCTS && Array.isArray(window.S54_PRODUCTS)) {
                const prod = window.S54_PRODUCTS.find(p => String(p.id) === String(id) || String(p.num_id) === String(id));
                if (prod && prod.sale_price) {
                    const p = parseInt(String(prod.sale_price).replace(/\./g, '').replace(/[^0-9]/g, ''), 10);
                    if (!isNaN(p) && p > 0) extractedPrice = p;
                }
            }

            // Strategy C: Generic container with compare price/strikethrough stripped
            if (!extractedPrice) {
                const genericEl = card.querySelector('.o-product-thumbnail__price, .c-product-card__price, .price, .c-product-form__pricing, .o-pricing');
                if (genericEl) {
                    const clone = genericEl.cloneNode(true);
                    clone.querySelectorAll('s, del, strike, .o-product-thumbnail__price-compare, .o-pricing__compare, [data-product-compare-money], .compare-at-price').forEach(el => el.remove());
                    let p = parseInt(clone.textContent.replace(/\./g, '').replace(/[^0-9]/g, ''), 10);
                    if (!isNaN(p) && p > 0) {
                        if (p > 10000000) {
                            const knownPrices = [15000, 35000, 65000, 119000, 199000, 150000, 225000, 250000, 350000, 646000, 702000, 720000, 805000];
                            for (let kp of knownPrices) {
                                if (String(p).startsWith(String(kp))) { p = kp; break; }
                            }
                        }
                        if (p >= 1000 && p < 10000000) extractedPrice = p;
                    }
                }
            }

            if (extractedPrice) price = extractedPrice;

            // 4. Extract Quantity
            const qtyInput = card.querySelector('input[name="quantity"], [data-product-form-qty], .c-product-form__qty');
            if (qtyInput && qtyInput.value) {
                const parsedQty = parseInt(qtyInput.value, 10);
                if (!isNaN(parsedQty) && parsedQty > 0) qty = parsedQty;
            }

            // 5. Extract Image
            const imgEl = card.querySelector('img:not(.c-header__logo img):not(.s54-footer img)');
            if (imgEl && (imgEl.src || imgEl.dataset.src)) {
                img = imgEl.src || imgEl.dataset.src;
            }

            // 6. Add to S54Cart
            if (window.S54Cart && typeof window.S54Cart.addItem === 'function') {
                window.S54Cart.addItem({
                    id: id,
                    variant_id: id,
                    title: title,
                    price: price,
                    quantity: qty,
                    image: img,
                    url: url
                });
            }

            // Button visual feedback
            const btn = targetEl.tagName === 'BUTTON' ? targetEl : targetEl.querySelector('button') || targetEl;
            if (btn) {
                const origText = btn.innerHTML;
                btn.innerHTML = '✓ ' + _t('cart_btn_added');
                btn.style.backgroundColor = '#D68E1D';
                btn.style.color = '#FFFFFF';
                setTimeout(() => {
                    btn.innerHTML = origText;
                    btn.style.backgroundColor = '';
                    btn.style.color = '';
                }, 800);
            }

            showToast(_t('cart_added_toast', { title: title }));
            openCartDrawer();
        } catch (err) {
            console.error('[S54Cart] Add error', err);
        } finally {
            setTimeout(() => { isProcessing = false; }, 300);
        }
    }

    // Capture-phase Global Click Listener
    document.addEventListener('click', function(e) {
        // 1. Cart Icon in Header
        const cartToggle = e.target.closest('[data-cart-drawer-toggle], .c-header__cart, a[href*="/cart"], .c-icon-cart, [data-cart-trigger], .c-header__icon--cart, .is-cart');
        if (cartToggle) {
            e.preventDefault();
            e.stopPropagation();
            if (typeof e.stopImmediatePropagation === 'function') e.stopImmediatePropagation();
            openCartDrawer();
            return;
        }

        // 2. Add To Bag Buttons
        const addBtn = e.target.closest('button[data-add-to-cart], .c-product-card__button, .c-product-card__add-to-cart, button.is-add-to-cart, [data-action="add-to-cart"], .o-product-thumbnail__add-btn, [data-product-form-add], button[name="add"], .c-product-form__add-btn, [data-quick-add-btn]');
        if (addBtn) {
            handleAddToCart(addBtn, e);
            return;
        }

        // 3. Orbe Modal Dismiss
        const orbeClose = e.target.closest('#md-btn__form__onSubmit, .md-app-modal__close-button, .md-app-modal-overlay');
        if (orbeClose) {
            e.preventDefault();
            e.stopPropagation();
            document.querySelectorAll('.md-app-modal, .md-app-modal-overlay, #md-app-modal').forEach(el => el.remove());
            document.body.style.overflow = '';
            return;
        }
    }, true);

    // Capture-phase Form Submit Listener
    document.addEventListener('submit', function(e) {
        const form = e.target.closest('form[action*="/cart/add"], [data-product-form], .c-product-form, .o-product-thumbnail__form');
        if (form) {
            handleAddToCart(form, e);
            return false;
        }
    }, true);

    /* =====================================================================
       4. DOM Ready & Standard UI Components
       ===================================================================== */
    document.addEventListener('DOMContentLoaded', () => {
        ensureCartDrawer();
        updateCartUI();

        // Lazy image fallback
        document.querySelectorAll('img[data-src]').forEach(img => {
            if (img.dataset.src && (!img.src || img.src.includes('data:image'))) img.src = img.dataset.src;
        });

        // Mobile Menu Toggle
        const menuToggle = document.querySelector('[data-menu-toggle]');
        const mainMenu = document.querySelector('[data-main-menu]');
        const menuClose = document.querySelector('[data-menu-close]');
        const menuBack = document.querySelector('[data-submenu-back]');

        if (menuToggle && mainMenu) {
            menuToggle.addEventListener('click', (e) => {
                e.preventDefault();
                mainMenu.classList.toggle('is-open');
                document.body.classList.toggle('menu-is-open');
            });
        }
        if (menuClose) {
            menuClose.addEventListener('click', () => {
                if (mainMenu) mainMenu.classList.remove('is-open');
                document.body.classList.remove('menu-is-open');
            });
        }
        if (menuBack) {
            menuBack.addEventListener('click', () => {
                const openSubmenu = mainMenu && mainMenu.querySelector('.c-main-menu__submenu.is-open');
                if (openSubmenu) openSubmenu.classList.remove('is-open');
            });
        }

        // Sticky Header Shrink
        const header = document.querySelector('.c-header, [data-header]');
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            if (header) {
                header.classList.toggle('is-scrolled', scrollY > 50);
            }
            lastScroll = scrollY;
        }, { passive: true });

        // Scroll-to-Top Button
        const scrollTopBtn = document.getElementById('scrollTopBtn');
        if (scrollTopBtn) {
            window.addEventListener('scroll', () => {
                scrollTopBtn.classList.toggle('is-visible', window.scrollY > 400);
            }, { passive: true });
            scrollTopBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        // Carousel Navigation
        document.querySelectorAll('[data-carousel]').forEach(carousel => {
            const container = carousel.closest('.c-product-carousel, .c-article-feed, .c-featured-collections, .shopify-section') || carousel.parentElement;
            const nextBtn = container.querySelector('[data-carousel-next], .c-product-carousel__arrow--next, .c-collection-carousel__control--next, .c-article-feed__control--next');
            const prevBtn = container.querySelector('[data-carousel-prev], .c-product-carousel__arrow--prev, .c-collection-carousel__control--prev, .c-article-feed__control--prev');
            const scrollTarget = carousel;
            const scrollAmount = Math.min(340, window.innerWidth * 0.8);

            if (nextBtn) nextBtn.addEventListener('click', (e) => { e.preventDefault(); scrollTarget.scrollBy({ left: scrollAmount, behavior: 'smooth' }); });
            if (prevBtn) prevBtn.addEventListener('click', (e) => { e.preventDefault(); scrollTarget.scrollBy({ left: -scrollAmount, behavior: 'smooth' }); });
        });

        // Video Controller synced with native video events handled by sections.featured-video.js

        // Newsletter Form
        document.querySelectorAll('form[action*="contact"], .c-newsletter-form').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const input = form.querySelector('input[type="email"]');
                if (input && input.value) {
                    showToast(_t('home_newsletter_success', { email: input.value }));
                    input.value = '';
                }
            });
        });

        // Re-render Cart Drawer and pricing when language changes
        window.addEventListener('language:changed', () => {
            updateCartUI();
        });
    });
})();
