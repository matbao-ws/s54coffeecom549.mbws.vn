/**
 * S54 Coffee Client Cart Engine & Unified Storefront Bridge
 * High-Performance E-Commerce Engine (Zero-lag, 60fps, rock-solid persistence)
 */
(function() {
    'use strict';

    var STORAGE_KEY_LOCAL = 's54_cart_items_v2';
    var STORAGE_KEY_SESSION = 's54_cart_data_v2';
    var FREE_SHIP_THRESHOLD = 500000;

    function getLocale() {
        if (window.S54_LOCALE) return window.S54_LOCALE;
        var p = window.location.pathname.split('/');
        if (p.length > 1 && (p[1] === 'vi' || p[1] === 'en')) return p[1];
        return 'vi';
    }

    function formatVND(n) {
        if (typeof n !== 'number') n = parseFloat(n) || 0;
        return new Intl.NumberFormat('vi-VN').format(Math.round(n)) + '₫';
    }

    function sanitizePrice(price) {
        var p = typeof price === 'number' ? price : parseInt(String(price).replace(/\./g, '').replace(/[^0-9]/g, ''), 10);
        if (isNaN(p) || p <= 0) p = 35000;
        if (p > 10000000) {
            var knownPrices = [15000, 35000, 65000, 119000, 199000, 150000, 225000, 250000, 350000, 646000, 702000, 720000, 805000];
            for (var i = 0; i < knownPrices.length; i++) {
                if (String(p).startsWith(String(knownPrices[i]))) {
                    p = knownPrices[i];
                    break;
                }
            }
            if (p > 10000000) p = 35000;
        }
        if (p === 3500) p = 35000;
        if (p === 1500) p = 15000;
        if (p === 6500) p = 65000;
        return p;
    }

    // Load items from local or session storage
    function loadRawItems() {
        var rawList = [];
        try {
            var raw = localStorage.getItem(STORAGE_KEY_LOCAL);
            if (raw) {
                var parsed = JSON.parse(raw);
                if (Array.isArray(parsed)) rawList = parsed;
                else if (parsed && Array.isArray(parsed.items)) rawList = parsed.items;
            }
        } catch(e) {}

        if (rawList.length === 0) {
            try {
                var sRaw = sessionStorage.getItem(STORAGE_KEY_SESSION);
                if (sRaw) {
                    var sParsed = JSON.parse(sRaw);
                    if (sParsed && Array.isArray(sParsed.items)) rawList = sParsed.items;
                    else if (Array.isArray(sParsed)) rawList = sParsed;
                }
            } catch(e) {}
        }

        var mockToDbMap = {
            200001: 23, 200002: 23, 200003: 22, 200004: 10,
            200005: 10, 200006: 12, 200007: 13, 200008: 14,
            200009: 15, 200010: 16, 200011: 17, 200012: 18,
            100001: 23, 100002: 22, 100003: 10, 100004: 12,
            100005: 13, 100006: 14, 100007: 15, 100008: 16,
            100009: 17, 100010: 18
        };

        rawList.forEach(function(it) {
            var rawId = parseInt(it.id || it.product_id, 10);
            if (mockToDbMap[rawId]) {
                it.id = mockToDbMap[rawId];
                it.product_id = mockToDbMap[rawId];
            } else if (rawId > 1000 || isNaN(rawId)) {
                var lower = (it.title || it.name || '').toLowerCase();
                var resolvedId = 22;
                if (lower.includes('12 gói') || lower.includes('dùng thử') || lower.includes('5 gói')) resolvedId = 23;
                else if (lower.includes('456g') || lower.includes('túi')) resolvedId = 22;
                else if (lower.includes('combo 2')) resolvedId = 10;
                else if (lower.includes('250g')) resolvedId = 12;
                else if (lower.includes('500g')) resolvedId = 13;
                else if (lower.includes('vbz01')) resolvedId = 14;
                else if (lower.includes('vbz08')) resolvedId = 15;
                else if (lower.includes('vbz03')) resolvedId = 16;
                else if (lower.includes('vbs02')) resolvedId = 17;
                else if (lower.includes('kmdj')) resolvedId = 18;
                it.id = resolvedId;
                it.product_id = resolvedId;
            }
            var t = it.title || it.name || 'S54 Coffee';
            it.title = t;
            it.name = t;
        });

        return rawList;
    }

    var itemsState = loadRawItems();

    function persist() {
        var totalQty = 0;
        var subtotal = 0;

        itemsState.forEach(function(it) {
            it.quantity = Math.max(1, parseInt(it.quantity, 10) || 1);
            it.price = sanitizePrice(it.price);
            totalQty += it.quantity;
            subtotal += it.price * it.quantity;
        });

        var sessionData = {
            items: itemsState,
            item_count: totalQty,
            total_price: subtotal,
            original_total_price: subtotal,
            currency: 'VND'
        };

        try {
            localStorage.setItem(STORAGE_KEY_LOCAL, JSON.stringify(itemsState));
            sessionStorage.setItem(STORAGE_KEY_SESSION, JSON.stringify(sessionData));
        } catch(e) {}

        window.__s54MockCart = sessionData;
        window.dispatchEvent(new CustomEvent('cart:updated', { detail: sessionData }));
        updateCartUI();
        return sessionData;
    }

    // Public Cart API
    window.S54Cart = {
        getCart: function() {
            var totalQty = 0;
            var subtotal = 0;
            itemsState.forEach(function(it) {
                var q = Math.max(1, parseInt(it.quantity, 10) || 1);
                var p = sanitizePrice(it.price);
                totalQty += q;
                subtotal += p * q;
            });
            return {
                items: JSON.parse(JSON.stringify(itemsState)),
                item_count: totalQty,
                total_price: subtotal,
                currency: 'VND'
            };
        },
        addItem: function(item) {
            if (!item) return;
            var cleanTitle = (item.title || item.name || 'S54 Cà Phê').trim();
            var price = sanitizePrice(item.price);
            var id = parseInt(item.id || item.product_id, 10) || 22;

            var mockToDbMap = {
                200001: 23, 200002: 23, 200003: 22, 200004: 10,
                200005: 10, 200006: 12, 200007: 13, 200008: 14,
                200009: 15, 200010: 16, 200011: 17, 200012: 18,
                100001: 23, 100002: 22, 100003: 10, 100004: 12,
                100005: 13, 100006: 14, 100007: 15, 100008: 16,
                100009: 17, 100010: 18
            };
            if (mockToDbMap[id]) {
                id = mockToDbMap[id];
            } else if (id > 1000) {
                var lower = cleanTitle.toLowerCase();
                if (lower.includes('12 gói') || lower.includes('dùng thử') || lower.includes('5 gói')) id = 23;
                else if (lower.includes('456g') || lower.includes('túi')) id = 22;
                else if (lower.includes('combo 2')) id = 10;
                else if (lower.includes('250g')) id = 12;
                else if (lower.includes('500g')) id = 13;
                else if (lower.includes('vbz01')) id = 14;
                else if (lower.includes('vbz08')) id = 15;
                else if (lower.includes('vbz03')) id = 16;
                else if (lower.includes('vbs02')) id = 17;
                else if (lower.includes('kmdj')) id = 18;
                else id = 22;
            }

            var variantId = item.variant_id || item.variantId || id;
            var qty = parseInt(item.quantity, 10) || 1;
            var image = item.image || item.image_url || '';

            var existing = itemsState.find(function(i) {
                return (String(i.id) === String(id) && String(i.variant_id || i.variantId) === String(variantId)) ||
                       (i.title === cleanTitle && String(i.variant_id || i.variantId) === String(variantId));
            });

            if (existing) {
                existing.quantity += qty;
                if (image && !existing.image) existing.image = image;
            } else {
                itemsState.push({
                    id: id,
                    variant_id: variantId,
                    key: String(id) + ':' + String(variantId),
                    title: cleanTitle,
                    name: cleanTitle,
                    variant_title: item.variant_title || '',
                    price: price,
                    image: image,
                    quantity: qty
                });
            }

            persist();
            openDrawer();
            showToast('✓ Đã thêm "' + cleanTitle + '" vào giỏ hàng');
        },
        updateQuantity: function(keyOrId, newQty) {
            var q = parseInt(newQty, 10);
            var idx = itemsState.findIndex(function(i) {
                return String(i.key) === String(keyOrId) || String(i.id) === String(keyOrId) || String(i.variant_id) === String(keyOrId);
            });
            if (idx >= 0) {
                if (q <= 0) {
                    itemsState.splice(idx, 1);
                } else {
                    itemsState[idx].quantity = q;
                }
                persist();
            }
        },
        removeItem: function(keyOrId) {
            this.updateQuantity(keyOrId, 0);
        },
        clear: function() {
            itemsState = [];
            persist();
        }
    };

    function updateCartUI() {
        var cart = window.S54Cart.getCart();
        var items = cart.items || [];
        var totalQty = cart.item_count;
        var subtotal = cart.total_price;
        var isVi = getLocale() === 'vi';

        // Update all header badges
        document.querySelectorAll('#s54-cart-badge, .c-header__cart-count, [data-cart-count], .c-icon-cart__count').forEach(function(badge) {
            badge.textContent = totalQty;
            badge.style.display = totalQty > 0 ? 'inline-flex' : 'none';
        });

        // Update drawer elements
        var drawerCount = document.getElementById('s54-drawer-count');
        if (drawerCount) drawerCount.textContent = totalQty;

        var subtotalEl = document.getElementById('s54-drawer-subtotal');
        if (subtotalEl) subtotalEl.textContent = formatVND(subtotal);

        // Update drawer free shipping progress
        var freeshipText = document.getElementById('s54-drawer-freeship-text');
        var freeshipBar = document.getElementById('s54-drawer-freeship-bar');
        if (freeshipText && freeshipBar) {
            if (subtotal >= FREE_SHIP_THRESHOLD) {
                freeshipText.textContent = isVi ? '🎉 Bạn đã đủ điều kiện MIỄN PHÍ VẬN CHUYỂN!' : '🎉 You qualify for FREE Nationwide Delivery!';
                freeshipBar.style.width = '100%';
            } else {
                var diff = FREE_SHIP_THRESHOLD - subtotal;
                freeshipText.textContent = isVi ? 'Thêm ' + formatVND(diff) + ' nữa để được MIỄN PHÍ VẬN CHUYỂN' : 'Add ' + formatVND(diff) + ' more for FREE Shipping';
                freeshipBar.style.width = Math.min(100, Math.max(8, (subtotal / FREE_SHIP_THRESHOLD) * 100)) + '%';
            }
        }

        // Render drawer items
        var emptyState = document.getElementById('s54-cart-empty-state');
        var itemsList = document.getElementById('s54-cart-items-list');

        if (!itemsList) return;

        if (items.length === 0) {
            if (emptyState) emptyState.style.display = 'block';
            itemsList.style.display = 'none';
            itemsList.innerHTML = '';
        } else {
            if (emptyState) emptyState.style.display = 'none';
            itemsList.style.display = 'block';

            var html = '';
            items.forEach(function(it) {
                var itemKey = it.key || it.id;
                var line = (it.price || 0) * (it.quantity || 1);
                var itemTitle = it.title || it.name || 'S54 Coffee';
                var itemImg = it.image || '/client-assets/images/s54/products/tui_3in1_456g.jpg';
                html += `
                    <div style="display: flex; gap: 14px; padding: 14px 0; border-bottom: 1px solid #EBE7E1; align-items: center;" data-item-key="${itemKey}">
                        <img src="${itemImg}" alt="${itemTitle}" style="width: 56px; height: 56px; object-fit: contain; background: #FFFFFF; border-radius: 6px; padding: 2px; border: 1px solid #EBE7E1; flex-shrink: 0;">
                        <div style="flex: 1; min-width: 0;">
                            <h4 style="margin: 0 0 3px 0; font-size: 13.5px; font-weight: 700; color: #2F221A; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${itemTitle}</h4>
                            <p style="margin: 0 0 6px 0; font-size: 13px; font-weight: 700; color: #D68E1D;">${formatVND(it.price)}</p>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <button type="button" class="s54-drawer-qty-btn" data-action="dec" data-key="${itemKey}" style="width: 24px; height: 24px; border: 1px solid #D0C8C0; background: #FFFFFF; border-radius: 3px; cursor: pointer; font-size: 13px; line-height: 1;">−</button>
                                <span style="font-size: 13px; font-weight: 700; min-width: 18px; text-align: center;">${it.quantity}</span>
                                <button type="button" class="s54-drawer-qty-btn" data-action="inc" data-key="${itemKey}" style="width: 24px; height: 24px; border: 1px solid #D0C8C0; background: #FFFFFF; border-radius: 3px; cursor: pointer; font-size: 13px; line-height: 1;">+</button>
                                <button type="button" class="s54-drawer-remove-btn" data-key="${itemKey}" style="background: none; border: none; color: #A08D80; font-size: 12px; cursor: pointer; margin-left: 8px; text-decoration: underline;">${isVi ? 'Xóa' : 'Remove'}</button>
                            </div>
                        </div>
                        <div style="font-size: 13.5px; font-weight: 700; color: #2F221A; white-space: nowrap;">
                            ${formatVND(line)}
                        </div>
                    </div>
                `;
            });
            itemsList.innerHTML = html;
        }
    }

    function openDrawer() {
        var drawer = document.getElementById('s54-cart-drawer');
        var overlay = document.getElementById('s54-cart-overlay');
        if (drawer) drawer.style.right = '0';
        if (overlay) overlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
        updateCartUI();
    }

    function closeDrawer() {
        var drawer = document.getElementById('s54-cart-drawer');
        var overlay = document.getElementById('s54-cart-overlay');
        if (drawer) drawer.style.right = '-450px';
        if (overlay) overlay.style.display = 'none';
        document.body.style.overflow = '';
    }

    function showToast(msg) {
        var toast = document.getElementById('s54-global-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 's54-global-toast';
            toast.style.cssText = 'position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%); background: #2F221A; color: #FAF6F1; padding: 12px 24px; border-radius: 8px; font-size: 13.5px; font-weight: 600; box-shadow: 0 4px 20px rgba(0,0,0,0.25); z-index: 100000; display: none; transition: opacity 0.3s ease;';
            document.body.appendChild(toast);
        }
        toast.textContent = msg;
        toast.style.display = 'block';
        toast.style.opacity = '1';
        setTimeout(function() {
            toast.style.opacity = '0';
            setTimeout(function() { toast.style.display = 'none'; }, 300);
        }, 2200);
    }

    window.openCartDrawer = openDrawer;
    window.closeCartDrawer = closeDrawer;
    window.showToast = showToast;

    // Attach DOM Events
    document.addEventListener('DOMContentLoaded', function() {
        updateCartUI();

        // Cart trigger button (Header icon ONLY - NEVER intercept direct cart page links!)
        document.addEventListener('click', function(e) {
            if (e.target.closest('#s54-view-cart-link, .s54-direct-cart-link, .c-cart-drawer__view-cart, #s54-cart-drawer a')) {
                // Direct link inside drawer to view cart or checkout - ALWAYS allow normal navigation!
                return;
            }
            var cartTrigger = e.target.closest('#s54-cart-trigger, [data-cart-drawer-toggle], .c-header__cart, .c-icon-cart');
            if (cartTrigger) {
                e.preventDefault();
                openDrawer();
            }
        });

        // Close button & overlay
        var closeBtn = document.getElementById('s54-cart-close');
        var overlay = document.getElementById('s54-cart-overlay');
        if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
        if (overlay) overlay.addEventListener('click', closeDrawer);

        // Drawer checkout button: ALWAYS NAVIGATE TO ABSOLUTE LOCALE CHECKOUT URL
        var checkoutBtn = document.getElementById('s54-checkout-btn');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = '/' + getLocale() + '/checkout';
            });
        }

        // Drawer Quantity modifications & Item removal
        document.addEventListener('click', function(e) {
            var qtyBtn = e.target.closest('.s54-drawer-qty-btn');
            if (qtyBtn) {
                e.preventDefault();
                var key = qtyBtn.dataset.key;
                var action = qtyBtn.dataset.action;
                var cart = window.S54Cart.getCart();
                var item = (cart.items || []).find(function(i) { return String(i.key) === String(key); });
                if (item) {
                    var newQty = action === 'inc' ? (item.quantity + 1) : (item.quantity - 1);
                    window.S54Cart.updateQuantity(key, newQty);
                }
            }

            var remBtn = e.target.closest('.s54-drawer-remove-btn');
            if (remBtn) {
                e.preventDefault();
                window.S54Cart.removeItem(remBtn.dataset.key);
            }
        });

        // Quick add buttons on catalog / home cards
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.s54-quick-add-btn, .o-product-thumbnail__add-btn, [data-quick-add-btn]');
            if (btn && btn.id !== 's54-detail-add-btn') {
                e.preventDefault();
                e.stopPropagation();
                window.S54Cart.addItem({
                    id: btn.dataset.productId,
                    variant_id: btn.dataset.variantId || btn.dataset.productId,
                    title: btn.dataset.productName || btn.getAttribute('aria-label') || 'S54 Coffee',
                    price: parseFloat(btn.dataset.productPrice) || 145000,
                    image: btn.dataset.productImage || '',
                    quantity: 1
                });
            }
        });

        // Detail add button on product page
        var detailBtn = document.getElementById('s54-detail-add-btn');
        if (detailBtn) {
            detailBtn.addEventListener('click', function(e) {
                e.preventDefault();
                var qtyInput = document.getElementById('s54-qty-input');
                var qty = qtyInput ? (parseInt(qtyInput.value, 10) || 1) : 1;
                
                // Visual feedback on button
                var origText = detailBtn.innerHTML;
                detailBtn.innerHTML = '✓ ' + (getLocale() === 'vi' ? 'ĐÃ THÊM!' : 'ADDED!');
                detailBtn.style.backgroundColor = '#D68E1D';
                setTimeout(function() {
                    detailBtn.innerHTML = origText;
                    detailBtn.style.backgroundColor = '#2F221A';
                }, 900);

                var prodTitle = detailBtn.dataset.productName || (document.querySelector('h1') ? document.querySelector('h1').textContent.trim() : '') || 'S54 Coffee';
                window.S54Cart.addItem({
                    id: detailBtn.dataset.productId,
                    variant_id: detailBtn.dataset.variantId || detailBtn.dataset.productId,
                    title: prodTitle,
                    price: parseFloat(detailBtn.dataset.productPrice) || 145000,
                    image: detailBtn.dataset.productImage || '',
                    quantity: qty
                });
            });
        }

        // Quantity +/- on product detail page
        var plusBtn = document.getElementById('s54-qty-plus');
        var minusBtn = document.getElementById('s54-qty-minus');
        var qi = document.getElementById('s54-qty-input');
        if (plusBtn && qi) {
            plusBtn.addEventListener('click', function() {
                qi.value = (parseInt(qi.value, 10) || 1) + 1;
            });
        }
        if (minusBtn && qi) {
            minusBtn.addEventListener('click', function() {
                var v = parseInt(qi.value, 10) || 1;
                if (v > 1) qi.value = v - 1;
            });
        }

        // Variant selector buttons on product detail
        document.querySelectorAll('.s54-variant-btn').forEach(function(varBtn) {
            varBtn.addEventListener('click', function() {
                document.querySelectorAll('.s54-variant-btn').forEach(function(b) {
                    b.classList.remove('is-selected');
                    b.style.background = '#FFFFFF';
                    b.style.color = '#2F221A';
                    b.style.borderColor = '#D0C8C0';
                });
                this.classList.add('is-selected');
                this.style.background = '#2F221A';
                this.style.color = '#FAF6F1';
                this.style.borderColor = '#2F221A';

                var priceDisplay = document.getElementById('s54-product-price-display');
                if (priceDisplay && this.dataset.variantPriceFormatted) {
                    priceDisplay.textContent = this.dataset.variantPriceFormatted;
                }
                if (detailBtn) {
                    detailBtn.dataset.variantId = this.dataset.variantId;
                    detailBtn.dataset.productPrice = this.dataset.variantPrice;
                }
            });
        });
    });

})();
