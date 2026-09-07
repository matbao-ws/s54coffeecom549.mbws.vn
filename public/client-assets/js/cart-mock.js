/**
 * S54 COFFEE - High-Performance E-Commerce Mock Cart & API Bridge
 * Zero-lag, 60fps, rock-solid session persistence
 */
(function () {
    'use strict';

    const STORAGE_KEY = 's54_cart_data_v2';

    const DEFAULT_CART = {
        items: [
            {
                id: 200003,
                variant_id: 100003,
                key: '200003:100003',
                title: 'Túi Cà Phê Hòa Tan 3in1 S54 Coffee 456g',
                price: 65000,
                original_price: 129000,
                final_price: 65000,
                line_price: 65000,
                quantity: 1,
                image: 'assets/images/s54/products/tui_3in1_456g.jpg',
                url: 'product-detail.html?id=200003'
            }
        ],
        item_count: 1,
        total_price: 65000,
        original_total_price: 129000,
        items_subtotal_price: 65000,
        total_weight: 456,
        currency: 'VND'
    };

    function loadCart() {
        try {
            const raw = sessionStorage.getItem(STORAGE_KEY);
            if (raw) {
                const parsed = JSON.parse(raw);
                if (parsed && Array.isArray(parsed.items)) {
                    recalculateTotals(parsed);
                    return parsed;
                }
            }
        } catch (e) {
            console.warn('[S54Cart] Fallback to default cart', e);
        }
        const initial = JSON.parse(JSON.stringify(DEFAULT_CART));
        recalculateTotals(initial);
        return initial;
    }

    function recalculateTotals(cart) {
        if (!cart || !Array.isArray(cart.items)) return;
        let count = 0;
        let total = 0;
        let weight = 0;

        cart.items.forEach(item => {
            const qty = Math.max(0, parseInt(item.quantity, 10) || 1);
            const price = typeof item.price === 'number' ? item.price : 35000;
            item.quantity = qty;
            item.line_price = price * qty;
            item.final_line_price = price * qty;
            count += qty;
            total += item.line_price;
            weight += (item.grams || 1000) * qty;
        });

        cart.item_count = count;
        cart.total_price = total;
        cart.original_total_price = total;
        cart.items_subtotal_price = total;
        cart.total_weight = weight;
    }

    let isDispatching = false;
    function saveCart(cart) {
        recalculateTotals(cart);
        try {
            sessionStorage.setItem(STORAGE_KEY, JSON.stringify(cart));
        } catch (e) {
            console.warn('[S54Cart] Save error', e);
        }
        window.__s54MockCart = cart;
        if (!isDispatching) {
            isDispatching = true;
            try {
                window.dispatchEvent(new CustomEvent('cart:updated', { detail: cart }));
            } finally {
                setTimeout(() => { isDispatching = false; }, 30);
            }
        }
        return cart;
    }

    let cartState = loadCart();
    window.__s54MockCart = cartState;

    // Cart public API
    window.S54Cart = {
        getCart: function () {
            return JSON.parse(JSON.stringify(cartState));
        },
        addItem: function (item) {
            if (!item) return saveCart(cartState);
            const cleanTitle = (item.title || 'S54 Cà Phê Hạt Rang Mộc').trim();
            const existing = cartState.items.find(i => 
                (item.id && String(i.id) === String(item.id)) || 
                (item.variant_id && String(i.variant_id) === String(item.variant_id)) ||
                (i.title && i.title === cleanTitle)
            );

            if (existing) {
                existing.quantity += (item.quantity || 1);
                if (item.image && !existing.image) existing.image = item.image;
            } else {
                const newId = item.id || Date.now();
                const price = item.price || 35000;
                const newItem = {
                    id: newId,
                    variant_id: item.variant_id || newId,
                    key: String(newId),
                    title: cleanTitle,
                    price: price,
                    original_price: price,
                    final_price: price,
                    line_price: price,
                    quantity: item.quantity || 1,
                    image: item.image || 'assets/images/s54/robusta_1.jpg',
                    url: item.url || 'product-detail.html'
                };
                cartState.items.push(newItem);
            }
            return saveCart(cartState);
        },
        updateQuantity: function (keyOrId, quantity) {
            const target = String(keyOrId);
            if (quantity <= 0) {
                cartState.items = cartState.items.filter(i => String(i.key) !== target && String(i.id) !== target && String(i.variant_id) !== target);
            } else {
                const item = cartState.items.find(i => String(i.key) === target || String(i.id) === target || String(i.variant_id) === target);
                if (item) {
                    item.quantity = quantity;
                }
            }
            return saveCart(cartState);
        },
        clear: function () {
            cartState.items = [];
            return saveCart(cartState);
        },
        reset: function () {
            cartState = JSON.parse(JSON.stringify(DEFAULT_CART));
            return saveCart(cartState);
        }
    };

    // Intercept fetch requests for Shopify Cart API cleanly
    const origFetch = window.fetch;
    window.fetch = function (url, opts) {
        const u = (typeof url === 'string') ? url : (url && url.url) || '';

        if (u.indexOf('/cart/add') !== -1 || u.indexOf('cart/add.js') !== -1) {
            const c = window.S54Cart.getCart();
            const lastItem = c.items[c.items.length - 1] || {};
            return Promise.resolve(new Response(JSON.stringify(lastItem), {
                status: 200,
                headers: { 'Content-Type': 'application/json' }
            }));
        }

        if (u.indexOf('/cart/change') !== -1 || u.indexOf('cart/change.js') !== -1 || u.indexOf('/cart/update') !== -1) {
            let body = null;
            if (opts && opts.body) {
                try {
                    body = typeof opts.body === 'string' ? JSON.parse(opts.body) : opts.body;
                } catch (e) {
                    body = {};
                }
            }
            if (body && (body.id || body.line || body.key) !== undefined) {
                const target = body.id || body.key || body.line;
                const qty = parseInt(body.quantity, 10);
                window.S54Cart.updateQuantity(target, isNaN(qty) ? 1 : qty);
            }
            return Promise.resolve(new Response(JSON.stringify(window.S54Cart.getCart()), {
                status: 200,
                headers: { 'Content-Type': 'application/json' }
            }));
        }

        if (u.indexOf('/cart/clear') !== -1 || u.indexOf('cart/clear.js') !== -1) {
            window.S54Cart.clear();
            return Promise.resolve(new Response(JSON.stringify(window.S54Cart.getCart()), {
                status: 200,
                headers: { 'Content-Type': 'application/json' }
            }));
        }

        if (u.indexOf('/cart') !== -1 || u.indexOf('cart.js') !== -1 || u.indexOf('cart.json') !== -1) {
            return Promise.resolve(new Response(JSON.stringify(window.S54Cart.getCart()), {
                status: 200,
                headers: { 'Content-Type': 'application/json' }
            }));
        }

        if (u.indexOf('sections=') !== -1) {
            return Promise.resolve(new Response(JSON.stringify({
                'cart-contents': '<div class="c-cart-contents"></div>'
            }), {
                status: 200,
                headers: { 'Content-Type': 'application/json' }
            }));
        }

        if (u.indexOf('/localization') !== -1) {
            return Promise.resolve(new Response(JSON.stringify({ success: true }), {
                status: 200,
                headers: { 'Content-Type': 'application/json' }
            }));
        }

        return origFetch ? origFetch.apply(this, arguments) : Promise.resolve(new Response('{}', { status: 200 }));
    };
})();
