#!/usr/bin/env python3
"""
Upgrade product-detail.html and theme/product-detail.html:
1. Add bilingual fields (name_en, category_en, short_desc_en, long_desc_en) to window.S54_PRODUCTS
2. Update initProductDetail() to dynamically adapt to active language (VI / EN)
3. Listen to 'language:changed' event to immediately re-render product details without page refresh
"""

import os
import json
import re

PRODUCTS_BILINGUAL = [
    {
        "id": 200001,
        "num_id": "1",
        "name": "Combo 5 gói cà phê hòa tan S54 dùng thử",
        "name_en": "S54 3in1 Instant Coffee 5-Pack Trial",
        "category": "Cà phê hòa tan",
        "category_en": "Instant Coffee",
        "short_desc": "Cà phê hòa tan 3in1 S54 Coffee là lựa chọn lý tưởng cho những ai yêu thích hương vị cà phê tiện lợi nhưng vẫn đậm đà.",
        "short_desc_en": "S54 Coffee 3in1 instant coffee is the ideal choice for those who love rich, authentic coffee with modern convenience.",
        "long_desc": "Sản phẩm được sản xuất tại Việt Nam, kết hợp hài hòa giữa cà phê hòa tan – bột kem – đường, mang đến ly cà phê thơm ngon, cân bằng vị béo – ngọt – đắng, phù hợp cho mọi thời điểm trong ngày. Mỗi túi gồm các gói 19g nhỏ gọn, dễ pha, đáp ứng nhu cầu thưởng thức nhanh chóng.",
        "long_desc_en": "Crafted in Vietnam, harmoniously combining instant coffee, non-dairy creamer, and sugar to deliver a smooth, balanced cup with optimal richness, sweetness, and pleasant bitterness. Compact 19g sachets, quick and easy to brew anywhere.",
        "sale_price": "15.000 VND",
        "regular_price": "29.000VND",
        "image": "assets/images/s54/products/combo_5goi_dung_thu.jpg"
    },
    {
        "id": 200002,
        "num_id": "2",
        "name": "Combo 12 gói cà phê hòa tan S54 dùng thử",
        "name_en": "S54 3in1 Instant Coffee 12-Pack Trial",
        "category": "Cà phê hòa tan",
        "category_en": "Instant Coffee",
        "short_desc": "Combo 12 gói cà phê hòa tan 3in1 tiện lợi, tiết kiệm, phù hợp cho gia đình và văn phòng.",
        "short_desc_en": "Value 12-pack 3in1 instant coffee combo, perfect for daily home and office enjoyment.",
        "long_desc": "Sản phẩm được sản xuất tại Việt Nam, kết hợp hài hòa giữa cà phê hòa tan – bột kem – đường, mang đến ly cà phê thơm ngon, cân bằng vị béo – ngọt – đắng, phù hợp cho mọi thời điểm trong ngày.",
        "long_desc_en": "Crafted in Vietnam, harmoniously combining instant coffee, non-dairy creamer, and sugar to deliver a smooth, balanced cup with optimal richness, sweetness, and pleasant bitterness.",
        "sale_price": "35.000 VND",
        "regular_price": "70.000VND",
        "image": "assets/images/s54/products/combo_12goi_dung_thu.jpg"
    },
    {
        "id": 200003,
        "num_id": "3",
        "name": "Túi cà phê hòa tan 3in1 S54 Coffee 456g",
        "name_en": "S54 Coffee 3in1 Instant Bag 456g",
        "category": "Cà phê hòa tan",
        "category_en": "Instant Coffee",
        "short_desc": "Túi 24 gói x 19g – cà phê hòa tan 3in1 đậm đà, tiện lợi, chuẩn gu thưởng thức cà phê Việt.",
        "short_desc_en": "Bag of 24 sachets x 19g – rich, aromatic, and convenient 3in1 instant coffee for the whole family.",
        "long_desc": "Sản phẩm kết hợp hài hòa giữa cà phê hòa tan nguyên chất, bột kem không sữa và đường tinh luyện. Mỗi túi gồm 24 gói nhỏ 19g, tiện lợi pha nóng hoặc pha đá tại nhà và văn phòng.",
        "long_desc_en": "Harmonious blend of pure instant coffee, non-dairy creamer, and refined sugar. Each bag contains 24 convenient 19g sachets, perfect for hot or iced coffee at home and office.",
        "sale_price": "65.000 VND",
        "regular_price": "129.000VND",
        "image": "assets/images/s54/products/tui_3in1_456g.jpg"
    },
    {
        "id": 200004,
        "num_id": "4",
        "name": "Combo 2 túi cà phê hòa tan 3in1 S54",
        "name_en": "S54 3in1 Instant 2-Bag Combo",
        "category": "Cà phê hòa tan",
        "category_en": "Instant Coffee",
        "short_desc": "Combo 2 túi tiết kiệm – tổng 48 gói cà phê hòa tan 3in1 thượng hạng.",
        "short_desc_en": "Value 2-bag combo – 48 sachets x 19g authentic 3in1 instant coffee.",
        "long_desc": "Gói tiết kiệm 2 túi (tổng cộng 48 gói x 19g) mang đến giải pháp cà phê sạch, thơm ngon và kinh tế nhất cho người yêu cà phê mỗi ngày.",
        "long_desc_en": "Smart savings combo of 2 bags (48 sachets total) for coffee lovers seeking consistent daily flavor and convenience.",
        "sale_price": "119.000VND",
        "regular_price": "219.000VND",
        "image": "assets/images/s54/products/combo_2tui_3in1.jpg"
    },
    {
        "id": 200005,
        "num_id": "5",
        "name": "Combo 3 túi cà phê hòa tan 3in1 S54",
        "name_en": "S54 3in1 Instant 3-Bag Combo",
        "category": "Cà phê hòa tan",
        "category_en": "Instant Coffee",
        "short_desc": "Combo 3 túi siêu tiết kiệm – 72 gói cho cả gia đình và văn phòng làm việc.",
        "short_desc_en": "Super value 3-bag combo – 72 sachets for families and offices.",
        "long_desc": "Bộ 3 túi lớn với 72 gói nhỏ tiện lợi. Thưởng thức hương vị cà phê thơm béo đậm đà mỗi ngày với mức giá ưu đãi hấp dẫn nhất từ S54 Coffee.",
        "long_desc_en": "Best-value family bundle of 3 bags (72 sachets total). Enjoy authentic Vietnamese 3in1 instant coffee every day with maximum savings.",
        "sale_price": "199.000VND",
        "regular_price": "299.000VND",
        "image": "assets/images/s54/products/combo_2tui_3in1.jpg"
    },
    {
        "id": 200006,
        "num_id": "6",
        "name": "Cà phê hạt rang Robusta S54 250gr",
        "name_en": "S54 Roasted Robusta Beans 250g",
        "category": "Cà phê hạt rang",
        "category_en": "Roasted Beans",
        "short_desc": "Cà phê hạt rang mộc 100% Robusta nguyên chất từ vùng đất đỏ bazan Tây Nguyên (250g).",
        "short_desc_en": "100% pure artisan roasted Robusta beans from the Central Highlands (250g).",
        "long_desc": "Cà phê hạt rang mộc S54 Robusta tuyển chọn 100% hạt chín mọng từ Đắk Lắk. Rang công nghệ Hot-Air chuẩn mộc, không tẩm bơ bắp, vị đậm mạnh tự nhiên, crema sánh mịn.",
        "long_desc_en": "S54 Robusta whole beans selected from 100% ripe cherries in Dak Lak. Hot-Air roasted without additives, featuring strong body, natural richness, and thick golden crema.",
        "sale_price": "250.000 VND",
        "regular_price": "150.000 VND",
        "image": "assets/images/s54/products/robusta_250g.jpg"
    },
    {
        "id": 200007,
        "num_id": "7",
        "name": "Cà phê hạt rang Robusta S54 500gr",
        "name_en": "S54 Roasted Robusta Beans 500g",
        "category": "Cà phê hạt rang",
        "category_en": "Roasted Beans",
        "short_desc": "Cà phê hạt rang mộc 500g – đậm đà, thơm mộc, hậu vị ngọt sâu lắng.",
        "short_desc_en": "100% pure artisan roasted Robusta beans from the Central Highlands (500g).",
        "long_desc": "Dung tích 500g chuẩn cho quán cà phê và gia đình. Hạt Robusta tuyển chọn kỹ lưỡng, bảo quản túi zip cao cấp có van 1 chiều bảo vệ trọn vẹn hương thơm nguyên bản.",
        "long_desc_en": "Standard 500g pack ideal for cafes and connoisseurs. Premium one-way valve zipper bag protects the fresh artisan roast aroma and rich terroir flavors.",
        "sale_price": "225.000 VND",
        "regular_price": "500.000 VND",
        "image": "assets/images/s54/products/robusta_500g.jpg"
    },
    {
        "id": 200008,
        "num_id": "8",
        "name": "Máy Xay Cà Phê Cầm Tay VBZ01-5",
        "name_en": "VBZ01-5 Manual Coffee Grinder",
        "category": "Máy xay cà phê cầm tay",
        "category_en": "Manual Coffee Grinder",
        "short_desc": "Máy xay cà phê cầm tay cao cấp cối thép CNC 5 trục, điều chỉnh độ mịn linh hoạt, màu đen sang trọng.",
        "short_desc_en": "Premium manual coffee grinder with 5-axis CNC burr, adjustable grind size, matte black finish.",
        "long_desc": "Thiết kế nhỏ gọn, thân kim loại cầm chắc tay cùng cối xay CNC 5 trục gia công chính xác. Hỗ trợ xay hạt đồng đều cho cả pha Espresso, Pour Over và Phin truyền thống.",
        "long_desc_en": "Compact, sturdy all-metal body with high-precision 5-axis CNC burr for consistent grinds across Espresso, Pour Over, and traditional Phin drip brewing.",
        "sale_price": "646.000 VND",
        "regular_price": "950.000 VND",
        "image": "assets/images/s54/products/may_xay_vbz01_5.jpg"
    },
    {
        "id": 200009,
        "num_id": "9",
        "name": "Máy Xay Cà Phê Cầm Tay VBZ08-5",
        "name_en": "VBZ08-5 Manual Coffee Grinder",
        "category": "Máy xay cà phê cầm tay",
        "category_en": "Manual Coffee Grinder",
        "short_desc": "Lõi xay inox SUS420 CNC 5 trục, thân nhôm kim loại cao cấp, hệ thống trục kép ổn định.",
        "short_desc_en": "SUS420 stainless steel 5-axis CNC burr grinder, all-metal aluminum body.",
        "long_desc": "Dòng máy xay cao cấp nhất với lưỡi dao SUS420 siêu sắc bén đường kính 38mm. Cơ chế trục kép giúp thao tác xay nhẹ nhàng, triệt tiêu rung lắc, giữ trọn hương vị hạt.",
        "long_desc_en": "Flagship manual grinder featuring 38mm SUS420 CNC conical burr and dual bearing stabilization for silky, effortless grinding without particle dispersion.",
        "sale_price": "720.000 VND",
        "regular_price": "900.000 VND",
        "image": "assets/images/s54/products/may_xay_vbz08_5.jpg"
    },
    {
        "id": 200010,
        "num_id": "10",
        "name": "Máy Xay Cà Phê Cầm Tay VBZ03-5",
        "name_en": "VBZ03-5 Manual Coffee Grinder",
        "category": "Máy xay cà phê cầm tay",
        "category_en": "Manual Coffee Grinder",
        "short_desc": "Cơ chế chỉnh độ mịn bên ngoài tiện lợi, cối xay CNC thép không gỉ, thiết kế chống trượt.",
        "short_desc_en": "External grind size adjustment mechanism, CNC stainless steel burr, compact portable design.",
        "long_desc": "Nổi bật với vòng xoay chỉnh độ mịn bên ngoài thân máy không cần tháo hộp bột. Cối xay CNC 5 trục cao cấp, dễ vệ sinh và cực kỳ bền bỉ theo thời gian.",
        "long_desc_en": "Features an intuitive external grind adjustment dial without opening the catcher. Premium 5-axis CNC burr, easy maintenance, and outstanding long-term durability.",
        "sale_price": "805.000 VND",
        "regular_price": "1.150.000 VND",
        "image": "assets/images/s54/products/may_xay_vbz03_5.jpg"
    },
    {
        "id": 200011,
        "num_id": "11",
        "name": "MÁY XAY CÀ PHÊ CẦM TAY VBS02-5",
        "name_en": "VBS02-5 Manual Coffee Grinder",
        "category": "Máy xay cà phê cầm tay",
        "category_en": "Manual Coffee Grinder",
        "short_desc": "Cối xay CNC 5 trục xay mịn đều, không dùng điện, phù hợp du lịch và văn phòng.",
        "short_desc_en": "High precision 5-axis CNC burr grinder, uniform grind distribution, travel-ready.",
        "long_desc": "Máy xay gọn nhẹ, tay quay công thái học lực xoay êm ái. Thích hợp mang theo đi dã ngoại, du lịch hoặc sử dụng mỗi ngày tại văn phòng làm việc.",
        "long_desc_en": "Lightweight and travel-ready manual grinder with ergonomic handle. Ideal for outdoor adventures, office breaks, and home brewing rituals.",
        "sale_price": "702.000 VND",
        "regular_price": "900.000 VND",
        "image": "assets/images/s54/products/may_xay_vbs02_5.jpg"
    },
    {
        "id": 200012,
        "num_id": "12",
        "name": "Máy Xay Cà Phê Cầm Tay KMDJ-HC",
        "name_en": "KMDJ-HC Manual Coffee Grinder",
        "category": "Máy xay cà phê cầm tay",
        "category_en": "Manual Coffee Grinder",
        "short_desc": "40 mức điều chỉnh độ mịn, lõi gốm ceramic không sinh nhiệt, hộp bột thủy tinh trong suốt.",
        "short_desc_en": "40-level precise grind adjustment, high hardness ceramic burr, clear glass powder container.",
        "long_desc": "Trang bị lõi xay gốm cao cấp không làm nóng bột cà phê khi xay. Hộp chứa thủy tinh trong suốt sang trọng, 40 nấc chỉnh độ mịn linh hoạt cho mọi phương pháp pha.",
        "long_desc_en": "Equipped with ceramic conical burr preventing heat buildup and static cling. Transparent glass container with 40 precise grind settings for versatile brewing.",
        "sale_price": "350.000VND",
        "regular_price": "500.000 VND",
        "image": "assets/images/s54/products/may_xay_kmdj_hc.jpg"
    }
]

PRODUCTS_JS_CODE = json.dumps(PRODUCTS_BILINGUAL, ensure_ascii=False)

INIT_SCRIPT_CODE = '''
    function getActiveLang() {
        return (window.S54I18n && typeof window.S54I18n.getLanguage === 'function')
            ? window.S54I18n.getLanguage()
            : (localStorage.getItem('s54_storefront_lang') || 'vi');
    }

    function parseVndNumber(str) {
        if (!str) return 0;
        const cleaned = String(str).replace(/\\./g, '').replace(/[^0-9]/g, '');
        return parseInt(cleaned, 10) || 0;
    }

    function formatVnd(num) {
        return new Intl.NumberFormat('vi-VN').format(num) + '₫';
    }

    function initProductDetail() {
        const activeLang = getActiveLang();
        const params = new URLSearchParams(window.location.search);
        let pid = params.get('id') || '200003';
        
        // Match product by id or num_id
        let product = window.S54_PRODUCTS.find(p => String(p.id) === String(pid) || String(p.num_id) === String(pid));
        if (!product) {
            product = window.S54_PRODUCTS[2]; // Default to Túi 456g
        }

        const displayName = (activeLang === 'en' && product.name_en) ? product.name_en : product.name;
        const displayCategory = (activeLang === 'en' && product.category_en) ? product.category_en : product.category;
        const displayShortDesc = (activeLang === 'en' && product.short_desc_en) ? product.short_desc_en : (product.short_desc || '');
        const displayLongDesc = (activeLang === 'en' && product.long_desc_en) ? product.long_desc_en : (product.long_desc || '');

        const saleNum = parseVndNumber(product.sale_price);
        const regNum = parseVndNumber(product.regular_price) || Math.round(saleNum * 1.5);
        const subNum = Math.round(saleNum * 0.8); // 20% discount on subscription

        // 1. Update Title & Meta
        document.title = displayName + " | S54 COFFEE";
        const metaDesc = document.getElementById('dynamic-meta-desc');
        if (metaDesc) metaDesc.setAttribute('content', displayShortDesc || displayName);

        const ogTitle = document.getElementById('dynamic-og-title');
        if (ogTitle) ogTitle.setAttribute('content', displayName + " | S54 COFFEE");

        const bcTitle = document.getElementById('dynamic-breadcrumb-title');
        if (bcTitle) bcTitle.textContent = displayName;

        // 2. Update Badge & Headings
        const pBadge = document.getElementById('dynamic-product-badge');
        if (pBadge) pBadge.textContent = displayCategory;

        const pTitle = document.getElementById('dynamic-product-title');
        if (pTitle) pTitle.textContent = displayName;

        const pShortDesc = document.getElementById('dynamic-short-desc');
        if (pShortDesc) {
            pShortDesc.textContent = displayShortDesc || (activeLang === 'en' 
                ? 'Premium pure authentic S54 coffee preserving natural Central Highlands terroir flavor.'
                : 'Sản phẩm cà phê S54 Coffee nguyên chất thượng hạng, lưu giữ trọn vẹn hương vị mộc mạc của đất trời Tây Nguyên.');
        }

        // 3. Update Gallery Images (Primary + Thumbnails)
        const galleryImgs = document.querySelectorAll('.c-product-gallery img, .c-product-gallery__media-container img, [data-gallery] img');
        galleryImgs.forEach(img => {
            img.src = product.image;
            img.srcset = product.image + ' 1x, ' + product.image + ' 2x';
            img.alt = displayName;
        });

        const galleryZooms = document.querySelectorAll('.c-product-gallery a.MagicZoom, [data-gallery="zoom"]');
        galleryZooms.forEach(a => {
            a.href = product.image;
        });

        // 4. Update Prices (One-time and Subscription)
        const oneTimePriceEls = document.querySelectorAll('.o-subscription-options__option-price[data-product-money], .o-product-pricing__money, .o-product-thumbnail__price-sale');
        oneTimePriceEls.forEach(el => {
            el.textContent = formatVnd(saleNum);
            el.setAttribute('data-money', saleNum);
            el.setAttribute('data-product-id', product.id);
        });

        const compareEls = document.querySelectorAll('.o-pricing__compare, .o-product-thumbnail__price-compare, [data-recharge-compare]');
        compareEls.forEach(el => {
            el.textContent = formatVnd(regNum);
            el.setAttribute('data-money', regNum);
        });

        const subPriceEl = document.querySelector('[data-recharge-price]');
        if (subPriceEl) {
            subPriceEl.textContent = formatVnd(subNum);
        }

        // If product is grinder (Máy xay), hide subscription option cleanly
        const subOption = document.querySelector('.o-subscription-options__option.is-subscription');
        if (subOption) {
            if (product.category && product.category.toLowerCase().includes('máy xay')) {
                subOption.style.display = 'none';
            } else {
                subOption.style.display = '';
            }
        }

        // 5. Update Promotion Gift Box
        const giftBox = document.querySelector('.subscription-free-gift-test');
        if (giftBox) {
            if (activeLang === 'en') {
                giftBox.innerHTML = `
                    <span style="color: #2F221A; font-weight: 600;">🎁 Special Offer From S54 Coffee</span>
                    <strong style="color: #D68E1D; display: block; margin-top: 4px;">Free exclusive brewing guide with every order today</strong>
                `;
            } else {
                giftBox.innerHTML = `
                    <span style="color: #2F221A; font-weight: 600;">🎁 Ưu Đãi Đặc Biệt Từ S54 Coffee</span>
                    <strong style="color: #D68E1D; display: block; margin-top: 4px;">Tặng kèm cẩm nang pha chế độc quyền cho mọi đơn hàng hôm nay</strong>
                `;
            }
        }

        // 6. Update Description Tab
        const descTab = document.querySelector('.c-product-tabs__content[data-tab-content="description"]');
        if (descTab) {
            let contentHtml = '<h3 style="font-family: Cormorant Garamond, serif; font-size: 24px; color: #2F221A; margin-bottom: 16px;">' + displayName + '</h3>';
            if (displayShortDesc) {
                contentHtml += '<p style="font-size: 15.5px; font-weight: 600; color: #2F221A; margin-bottom: 14px;">' + displayShortDesc + '</p>';
            }
            if (displayLongDesc) {
                let parts = displayLongDesc.split('\\n\\n');
                parts.forEach(pt => {
                    pt = pt.trim();
                    if (pt) {
                        contentHtml += '<p style="color: #5C4A3E; line-height: 1.8; margin-bottom: 10px;">' + pt + '</p>';
                    }
                });
            } else {
                contentHtml += activeLang === 'en'
                    ? '<p style="color: #5C4A3E; line-height: 1.8;">Selected from the highest quality Robusta & Arabica beans from the fertile Central Highlands basalt soil, processed with modern roasting technology to ensure authentic, clean, and pure flavor.</p>'
                    : '<p style="color: #5C4A3E; line-height: 1.8;">Sản phẩm được tuyển chọn từ những hạt cà phê Robusta & Arabica chất lượng cao nhất của vùng đất đỏ bazan Tây Nguyên, chế biến trên dây chuyền công nghệ hiện đại đảm bảo giữ trọn vẹn hương vị tự nhiên, an toàn và tinh khiết.</p>';
            }
            descTab.innerHTML = contentHtml;
        }

        // 7. Connect Quick Add / Add to Cart
        const form = document.querySelector('.c-product-main__form');
        if (form) {
            const idInput = form.querySelector('input[name="id"]');
            if (idInput) idInput.value = product.id;

            const addBtn = form.querySelector('[data-product-form-add], button[type="submit"]');
            if (addBtn) {
                addBtn.onclick = function(e) {
                    e.preventDefault();
                    if (window.S54Cart && typeof window.S54Cart.addItem === 'function') {
                        window.S54Cart.addItem({
                            id: product.id,
                            title: displayName,
                            price: saleNum,
                            image: product.image,
                            quantity: 1
                        });
                    }
                };
            }
        }

        // 8. Update Related Products Cards with Authentic S54 Products
        const relatedTiles = document.querySelectorAll('.c-featured-collections .o-product-thumbnail');
        const otherProds = window.S54_PRODUCTS.filter(p => String(p.id) !== String(product.id));
        relatedTiles.forEach((tile, index) => {
            if (index < otherProds.length) {
                const rp = otherProds[index];
                const rpName = (activeLang === 'en' && rp.name_en) ? rp.name_en : rp.name;
                const rpCategory = (activeLang === 'en' && rp.category_en) ? rp.category_en : rp.category;
                const rpShortDesc = (activeLang === 'en' && rp.short_desc_en) ? rp.short_desc_en : (rp.short_desc || rp.name);

                const link = tile.querySelector('a.o-product-thumbnail__link');
                if (link) link.href = 'product-detail.html?id=' + rp.id;

                const img = tile.querySelector('img.o-product-thumbnail__image');
                if (img) {
                    img.src = rp.image;
                    img.srcset = rp.image + ' 1x, ' + rp.image + ' 2x';
                    img.alt = rpName;
                }

                const title = tile.querySelector('.o-product-thumbnail__title');
                if (title) title.textContent = rpName;

                const excerpt = tile.querySelector('.o-product-thumbnail__excerpt');
                if (excerpt) excerpt.textContent = rpShortDesc;

                const price = tile.querySelector('.o-product-thumbnail__price, .o-pricing__money');
                if (price) price.textContent = formatVnd(parseVndNumber(rp.sale_price));

                const badge = tile.querySelector('.o-product-thumbnail__badge');
                if (badge) badge.textContent = rpCategory;
            }
        });
    }

    // Auto-init and listen for language changes
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProductDetail);
    } else {
        initProductDetail();
    }

    window.addEventListener('language:changed', function () {
        initProductDetail();
    });
'''

def update_file(file_path):
    with open(file_path, 'r', encoding='utf-8') as f:
        html = f.read()

    # Replace window.S54_PRODUCTS
    pattern = r'window\.S54_PRODUCTS\s*=\s*\[.*?\];\s*function initProductDetail\(\).*?window\.addEventListener\([\'"]language:changed[\'"],.*?\}\);'
    
    # Or replace from `window.S54_PRODUCTS = [` down to `</script>\s*<script src="assets/js/i18n.js`
    replacement = f"""window.S54_PRODUCTS = {PRODUCTS_JS_CODE};
(function() {{
    'use strict';
{INIT_SCRIPT_CODE}
}})();"""

    # Check if we can find the section
    start_marker = "window.S54_PRODUCTS = ["
    end_marker = '</script>\n    <script src="assets/js/i18n.js'
    if end_marker not in html:
        end_marker = '</script>\n<script src="assets/js/i18n.js'
    if end_marker not in html:
        end_marker = "</script>\n    <script src=\"assets/js/i18n.js"

    start_idx = html.find(start_marker)
    if start_idx == -1:
        print(f"Could not find start_marker in {file_path}")
        return

    # Find the closing </script> before </body>
    closing_idx = html.rfind("</script>", start_idx)
    if closing_idx == -1:
        print(f"Could not find closing script in {file_path}")
        return

    new_html = html[:start_idx] + replacement + "\n" + html[closing_idx:]
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(new_html)
    print(f"Successfully updated {file_path}")

def main():
    base_dir = '/home/binhphan/matbao-ws/clients/s54coffeecom549.mbws.vn'
    update_file(os.path.join(base_dir, 'product-detail.html'))
    update_file(os.path.join(base_dir, 'theme/product-detail.html'))

if __name__ == '__main__':
    main()
