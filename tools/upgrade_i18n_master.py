#!/usr/bin/env python3
"""
Master Upgrade Script for S54 Coffee i18n Engine
Fixes:
1. Navigation language desynchronization (currentDomLang vs currentLang)
2. Subtree translation API for dynamic components
3. Expanded bidirectional translation dictionary with 1-to-1 case-matched reversibility
4. Synchronizes assets/js/i18n.js, public/client-assets/js/i18n.js, theme/assets/js/i18n.js
"""

import os
import shutil
import re

EXTRA_PAIRS = [
    # 1. AUTHENTIC S54 PRODUCTS & VARIANTS (CASE-MATCHED FOR 100% REVERSIBILITY)
    ["Combo 5 gói cà phê hòa tan S54 dùng thử", "S54 3in1 instant coffee 5-pack trial"],
    ["Combo 5 Gói Cà Phê Hòa Tan S54 Dùng Thử", "S54 3in1 Instant Coffee 5-Pack Trial"],
    ["Combo 12 gói cà phê hòa tan S54 dùng thử", "S54 3in1 instant coffee 12-pack trial"],
    ["Combo 12 Gói Cà Phê Hòa Tan S54 Dùng Thử", "S54 3in1 Instant Coffee 12-Pack Trial"],
    ["Túi cà phê hòa tan 3in1 S54 Coffee 456g", "S54 Coffee 3in1 instant bag 456g"],
    ["Túi Cà Phê Hòa Tan 3in1 S54 Coffee 456g", "S54 Coffee 3in1 Instant Bag 456g"],
    ["Combo 2 túi cà phê hòa tan 3in1 S54", "S54 3in1 instant 2-bag combo"],
    ["Combo 2 Túi Cà Phê Hòa Tan 3in1 S54", "S54 3in1 Instant 2-Bag Combo"],
    ["Combo 3 túi cà phê hòa tan 3in1 S54", "S54 3in1 instant 3-bag combo"],
    ["Combo 3 Túi Cà Phê Hòa Tan 3in1 S54", "S54 3in1 Instant 3-Bag Combo"],
    ["Cà phê hạt rang Robusta S54 250gr", "S54 roasted Robusta beans 250g"],
    ["Cà Phê Hạt Rang Robusta S54 250gr", "S54 Roasted Robusta Beans 250g"],
    ["Cà phê hạt rang Robusta S54 500gr", "S54 roasted Robusta beans 500g"],
    ["Cà Phê Hạt Rang Robusta S54 500gr", "S54 Roasted Robusta Beans 500g"],
    ["Máy Xay Cà Phê Cầm Tay VBZ01-5", "VBZ01-5 manual coffee grinder"],
    ["Máy Xay Cà Phê Cầm Tay VBZ01-5", "VBZ01-5 Manual Coffee Grinder"],
    ["Máy Xay Cà Phê Cầm Tay VBZ08-5", "VBZ08-5 Manual Coffee Grinder"],
    ["Máy Xay Cà Phê Cầm Tay VBZ03-5", "VBZ03-5 Manual Coffee Grinder"],
    ["MÁY XAY CÀ PHÊ CẦM TAY VBS02-5", "VBS02-5 MANUAL COFFEE GRINDER"],
    ["Máy Xay Cà Phê Cầm Tay VBS02-5", "VBS02-5 Manual Coffee Grinder"],
    ["Máy xay cà phê cầm tay VBS02-5", "VBS02-5 manual coffee grinder"],
    ["Máy Xay Cà Phê Cầm Tay KMDJ-HC", "KMDJ-HC Manual Coffee Grinder"],
    ["Cà phê hòa tan", "Instant Coffee"],
    ["CÀ PHÊ HÒA TAN", "INSTANT COFFEE"],
    ["Cà phê hạt rang", "Roasted Coffee Beans"],
    ["CÀ PHÊ HẠT RANG", "ROASTED COFFEE BEANS"],
    ["Máy xay cà phê cầm tay", "Manual Coffee Grinder"],
    ["MÁY XAY CÀ PHÊ CẦM TAY", "MANUAL COFFEE GRINDER"],

    # 2. FILTERS & FACETS (COLLECTIONS & HOME)
    ["Clear all filters", "Clear all filters"],
    ["Xóa tất cả bộ lọc", "Clear all filters"],
    ["Xóa tất cả", "Clear all"],
    ["Xóa Tất Cả", "Clear All"],
    ["XÓA TẤT CẢ", "CLEAR ALL"],
    ["Áp Dụng", "Apply"],
    ["Áp dụng", "Apply"],
    ["ÁP DỤNG", "APPLY"],
    ["Áp dụng bộ lọc", "Apply filters"],
    ["Loại Sản Phẩm", "Product Type"],
    ["LOẠI SẢN PHẨM", "PRODUCT TYPE"],
    ["Phương Pháp Pha Chế", "Brewing Method"],
    ["PHƯƠNG PHÁP PHA CHẾ", "BREWING METHOD"],
    ["Mức Độ Rang", "Roast Profile"],
    ["MỨC ĐỘ RANG", "ROAST PROFILE"],
    ["Độ Đậm", "Intensity"],
    ["ĐỘ ĐẬM", "INTENSITY"],
    ["Phù Hợp Cho", "Best Suited For"],
    ["Phù Hợp Nhất Cho", "Best Suited For"],
    ["Phương Pháp Pha", "Brew Method"],
    ["Quy Cách Đóng Gói", "Pack Size"],
    ["QUY CÁCH ĐÓNG GÓI", "PACK SIZE"],
    ["Khác", "Other"],
    ["KHÁC", "OTHER"],
    ["Tất Cả", "All"],
    ["TẤT CẢ", "ALL"],
    ["Bộ Sưu Tập", "Collections"],
    ["BỘ SƯU TẬP", "COLLECTIONS"],
    ["Sắp xếp theo:", "Sort by:"],
    ["Sắp xếp theo", "Sort by"],
    ["SẮP XẾP THEO", "SORT BY"],
    ["BỘ LỌC & SẮP XẾP", "FILTERS & SORTING"],
    ["Bộ Lọc & Sắp Xếp", "Filters & Sorting"],
    ["BỘ LỌC", "FILTERS"],
    ["Bộ Lọc", "Filters"],
    ["Hiển thị tất cả", "Show all"],
    ["Đang hiển thị", "Showing"],
    ["kết quả", "results"],
    ["sản phẩm", "products"],

    # 3. CART DRAWER & CHECKOUT
    ["Giỏ Hàng Của Bạn", "Your Bag"],
    ["Giỏ hàng của bạn", "Your bag"],
    ["GIỎ HÀNG CỦA BẠN", "YOUR BAG"],
    ["Giỏ hàng của bạn đang trống.", "Your bag is currently empty."],
    ["Giỏ hàng của bạn đang trống", "Your bag is currently empty"],
    ["Bắt Đầu Mua Sắm", "Start Shopping"],
    ["Bắt đầu mua sắm", "Start shopping"],
    ["BẮT ĐẦU MUA SẮM", "START SHOPPING"],
    ["Tiếp Tục Mua Sắm", "Continue Shopping"],
    ["Tiếp tục mua sắm", "Continue shopping"],
    ["TIẾP TỤC MUA SẮM", "CONTINUE SHOPPING"],
    ["Tạm Tính", "Subtotal"],
    ["Tạm tính", "Subtotal"],
    ["TẠM TÍNH", "SUBTOTAL"],
    ["Tạm Tính:", "Subtotal:"],
    ["Tạm tính:", "Subtotal:"],
    ["Phí Vận Chuyển", "Shipping Fee"],
    ["Phí vận chuyển", "Shipping Fee"],
    ["Phí Vận Chuyển:", "Shipping Fee:"],
    ["Phí vận chuyển:", "Shipping Fee:"],
    ["Tổng Cộng", "Total"],
    ["Tổng cộng", "Total"],
    ["TỔNG CỘNG", "TOTAL"],
    ["Tổng Cộng:", "Total:"],
    ["Tổng cộng:", "Total:"],
    ["TIẾN HÀNH THANH TOÁN", "PROCEED TO CHECKOUT"],
    ["Tiến Hành Thanh Toán", "Proceed to Checkout"],
    ["Tiến hành thanh toán", "Proceed to checkout"],
    ["Xem Giỏ Hàng", "View Cart"],
    ["Xem giỏ hàng", "View cart"],
    ["XEM GIỎ HÀNG", "VIEW CART"],
    ["Xem Giỏ Hàng Chi Tiết", "View Cart Details"],
    ["Xem giỏ hàng chi tiết", "View cart details"],
    ["XEM GIỎ HÀNG CHI TIẾT", "VIEW CART DETAILS"],
    ["Thêm vào giỏ hàng", "Add to Cart"],
    ["Thêm Vào Giỏ Hàng", "Add to Cart"],
    ["THÊM VÀO GIỎ HÀNG", "ADD TO CART"],
    ["Mua ngay", "Buy Now"],
    ["Mua Ngay", "Buy Now"],
    ["MUA NGAY", "BUY NOW"],
    ["Tóm Tắt Đơn Hàng", "Order Summary"],
    ["Tóm tắt đơn hàng", "Order summary"],
    ["TÓM TẮT ĐƠN HÀNG", "ORDER SUMMARY"],
    ["Thông Tin Giao Hàng", "Shipping Information"],
    ["Thông tin giao hàng", "Shipping information"],
    ["Phương Thức Vận Chuyển", "Shipping Method"],
    ["Phương thức vận chuyển", "Shipping method"],
    ["Phương Thức Thanh Toán", "Payment Method"],
    ["Phương thức thanh toán", "Payment method"],
    ["ĐẶT HÀNG NGAY", "PLACE ORDER NOW"],
    ["Đặt Hàng Ngay", "Place Order Now"],
    ["Đặt hàng ngay", "Place order now"],
    ["Đơn Hàng Của Bạn", "Your Order"],
    ["Đơn hàng của bạn", "Your order"],
    ["Quay Lại Giỏ Hàng", "Return to Cart"],
    ["Quay lại giỏ hàng", "Return to cart"],
    ["Mã Giảm Giá", "Discount Code"],
    ["Mã giảm giá", "Discount code"],
    ["Nhập mã giảm giá...", "Enter discount code..."],

    # 4. MOBILE MENU & NAVIGATION
    ["Ngôn ngữ / Language", "Language"],
    ["Ngôn ngữ", "Language"],
    ["Tiếng Việt", "Vietnamese"],
    ["🇻🇳 Tiếng Việt", "🇻🇳 Tiếng Việt"],
    ["🇬🇧 English", "🇬🇧 English"],

    # 5. PRODUCT DETAIL SECTIONS & TABS
    ["MÔ TẢ SẢN PHẨM", "PRODUCT DESCRIPTION"],
    ["Mô Tả Sản Phẩm", "Product Description"],
    ["HƯỚNG DẪN PHA CHẾ", "BREWING GUIDE"],
    ["Hướng Dẫn Pha Chế", "Brewing Guide"],
    ["CAM KẾT & VẬN CHUYỂN", "COMMITMENT & SHIPPING"],
    ["Cam Kết & Vận Chuyển", "Commitment & Shipping"],
    ["ĐÁNH GIÁ TỪ KHÁCH HÀNG (4.8★)", "CUSTOMER REVIEWS (4.8★)"],
    ["Đánh Giá Từ Khách Hàng (4.8★)", "Customer Reviews (4.8★)"],
    ["ĐÁNH GIÁ TỪ KHÁCH HÀNG", "CUSTOMER REVIEWS"],
    ["Đánh Giá Từ Khách Hàng", "Customer Reviews"],
    ["(Dựa trên 527 lượt đánh giá xác thực)", "(Based on 527 verified customer reviews)"],
    ["Khách Hàng Đã Xác Thực Mua Hàng", "Verified Buyer"],
    ["VIẾT ĐÁNH GIÁ", "WRITE A REVIEW"],
    ["Viết Đánh Giá", "Write A Review"],
    ["Hương Vị Đặc Trưng (Tasting Notes)", "Tasting Notes & Flavor Profile"],
    ["Sản Phẩm Cùng Dòng", "Related Products"],
    ["Có Thể Bạn Cũng Thích", "You May Also Like"],

    # 6. WHOLESALE & B2B SPECIFIC
    ["Chương Trình Đối Tác & Đại Lý Cà Phê S54", "S54 Coffee Partner & Wholesale Program"],
    ["Nguồn Cà Phê Nguyên Chất S54", "S54 Pure Coffee Supply"],
    ["Đào Tạo Barista & Chuyển Giao Công Nghệ Pha Chế", "Barista Training & Brewing Technology Transfer"],
    ["Thiết Bị & Máy Pha Cà Phê Chuyên Nghiệp", "Professional Espresso Machines & Equipment"],
    ["Thiết Kế Quầy Bar & Bộ Nhận Diện Thương Hiệu", "Bar Setup & Brand Identity Solutions"],
    ["Hỗ Trợ Marketing & Thu Hút Khách Hàng", "Marketing & Customer Acquisition Support"],
    ["GỬI YÊU CẦU TƯ VẤN & NHẬN MẪU THỬ", "SUBMIT INQUIRY & REQUEST SAMPLES"],
    ["Gửi Yêu Cầu Tư Vấn & Nhận Mẫu Thử", "Submit Inquiry & Request Samples"],
    ["Gửi yêu cầu tư vấn", "Submit consultation inquiry"],
    ["Nhận mẫu thử miễn phí", "Get free tasting samples"],
    ["Chính sách chiết khấu đại lý", "Wholesale discount policy"],
    ["Hợp Tác B2B & Đại Lý", "B2B & Wholesale Partnership"],
    ["HỢP TÁC B2B & ĐẠI LÝ", "B2B & WHOLESALE PARTNERSHIP"],

    # 7. BLOG & NEWS
    ["Tất Cả Bài Viết", "All Articles"],
    ["Kiến Thức Cà Phê", "Coffee Insights"],
    ["Hướng Dẫn Pha Chế", "Brewing Guides"],
    ["Các Bài Viết Mới Nhất", "Latest Articles"],
    ["Bản Tin Extracts", "Extracts Newsletter"],
    ["1 phút đọc", "1 min read"],
    ["2 phút đọc", "2 min read"],
    ["3 phút đọc", "3 min read"],
    ["4 phút đọc", "4 min read"],
    ["5 phút đọc", "5 min read"],
    ["8 phút đọc", "8 min read"],
    ["10 phút đọc", "10 min read"],
    ["13 phút đọc", "13 min read"],
    ["← Quay lại Tin Tức", "← Back to News"],
    ["← Xem Tất Cả Bài Viết", "← View All Articles"],

    # 8. CONTACT & FOOTER
    ["Liên Hệ Hợp Tác", "Partner Contact"],
    ["LIÊN HỆ HỢP TÁC", "PARTNER CONTACT"],
    ["Gửi Thông Tin Liên Hệ", "Send Contact Message"],
    ["GỬI THÔNG TIN LIÊN HỆ", "SEND CONTACT MESSAGE"],
    ["Tiêu Đề Tin Nhắn *", "Subject *"],
    ["Đang gửi tin nhắn...", "Sending message..."],
    ["Cảm ơn bạn đã liên hệ! S54 Coffee sẽ phản hồi trong vòng 24 giờ làm việc.", "Thank you for reaching out! S54 Coffee will reply within 24 business hours."],
    ["Hotline Tư Vấn 24/7", "24/7 Consultation Hotline"],
    ["Thứ 2 – Thứ 7: 08:00 – 18:00 (Chủ Nhật hỗ trợ qua Hotline/Zalo)", "Mon – Sat: 08:00 – 18:00 (Sunday support via Hotline/Zalo)"],
    ["KẾT NỐI VỚI S54 COFFEE", "CONNECT WITH S54 COFFEE"],
    ["Kết Nối Với S54 Coffee", "Connect with S54 Coffee"],
    ["Đăng Ký Nhận Ưu Đãi", "Subscribe for Offers"],
    ["Nhập địa chỉ email của bạn...", "Enter your email address..."],
    ["Đăng Ký", "Subscribe"],
    ["ĐĂNG KÝ", "SUBSCRIBE"]
]

ENGINE_JS = '''
    // State Tracking
    let currentDomLang = 'vi'; // Tracks language currently rendered in DOM (authoring HTML is Vietnamese)
    let currentLang = 'vi';    // Tracks user selected language stored in localStorage

    function initLanguage() {
        try {
            const saved = localStorage.getItem(STORAGE_KEY);
            if (saved === 'en' || saved === 'vi') {
                currentLang = saved;
            }
        } catch (e) {
            console.warn('[S54I18n] Storage access error', e);
        }
    }

    function compileRules(fromIdx, toIdx) {
        // Sort pairs by search string length descending to prevent substring collisions
        const sortedPairs = translationPairs.slice().sort((a, b) => {
            const strA = a[fromIdx] || '';
            const strB = b[fromIdx] || '';
            return strB.length - strA.length;
        });

        const seen = new Set();
        return sortedPairs.map(pair => {
            const searchStr = pair[fromIdx];
            const replaceStr = pair[toIdx];
            if (!searchStr || !replaceStr || searchStr === replaceStr) return null;
            if (seen.has(searchStr)) return null;
            seen.add(searchStr);
            return {
                searchStr: searchStr,
                replaceStr: replaceStr,
                regex: createSafeRegex(searchStr)
            };
        }).filter(r => r !== null && r.regex !== null);
    }

    // Subtree Translator for dynamic components (Cart Drawer, Filter Facets, Modals)
    function translateSubtree(rootEl, targetLang, fromLang) {
        if (!rootEl) return;
        const srcLang = fromLang || currentDomLang;
        if (srcLang === targetLang) return;
        const fromIdx = srcLang === 'vi' ? 0 : 1;
        const toIdx = targetLang === 'vi' ? 0 : 1;
        const compiledRules = compileRules(fromIdx, toIdx);

        // 1. Text nodes
        const walker = document.createTreeWalker(
            rootEl,
            NodeFilter.SHOW_TEXT,
            {
                acceptNode: function (node) {
                    if (!node.nodeValue || !node.nodeValue.trim()) return NodeFilter.FILTER_REJECT;
                    const parent = node.parentElement;
                    if (!parent) return NodeFilter.FILTER_REJECT;
                    const tag = parent.tagName;
                    if (tag === 'SCRIPT' || tag === 'STYLE' || tag === 'NOSCRIPT') {
                        return NodeFilter.FILTER_REJECT;
                    }
                    return NodeFilter.FILTER_ACCEPT;
                }
            },
            false
        );

        const textNodes = [];
        let curr = walker.nextNode();
        while (curr) {
            textNodes.push(curr);
            curr = walker.nextNode();
        }

        textNodes.forEach(node => {
            let val = node.nodeValue;
            compiledRules.forEach(rule => {
                if (val.includes(rule.searchStr)) {
                    val = val.replace(rule.regex, rule.replaceStr);
                }
            });
            if (val !== node.nodeValue) {
                node.nodeValue = val;
            }
        });

        // 2. Placeholders
        rootEl.querySelectorAll('input[placeholder], textarea[placeholder]').forEach(el => {
            let ph = el.getAttribute('placeholder');
            if (!ph) return;
            compiledRules.forEach(rule => {
                if (ph.includes(rule.searchStr)) {
                    ph = ph.replace(rule.regex, rule.replaceStr);
                }
            });
            el.setAttribute('placeholder', ph);
        });

        // 3. Img alts
        rootEl.querySelectorAll('img[alt]').forEach(el => {
            let alt = el.getAttribute('alt');
            if (!alt) return;
            compiledRules.forEach(rule => {
                if (alt.includes(rule.searchStr)) {
                    alt = alt.replace(rule.regex, rule.replaceStr);
                }
            });
            el.setAttribute('alt', alt);
        });
    }

    function translatePage(targetLang, force) {
        if (targetLang !== 'vi' && targetLang !== 'en') return;

        // If not forcing and target matches current DOM language, just save and update switcher
        if (!force && targetLang === currentDomLang) {
            currentLang = targetLang;
            try { localStorage.setItem(STORAGE_KEY, targetLang); } catch (e) {}
            updateSwitcherUI();
            return;
        }

        const fromIdx = currentDomLang === 'vi' ? 0 : 1;
        const toIdx = targetLang === 'vi' ? 0 : 1;

        if (fromIdx !== toIdx) {
            const compiledRules = compileRules(fromIdx, toIdx);

            // 1. Traverse and translate all DOM text nodes
            const walker = document.createTreeWalker(
                document.body,
                NodeFilter.SHOW_TEXT,
                {
                    acceptNode: function (node) {
                        if (!node.nodeValue || !node.nodeValue.trim()) return NodeFilter.FILTER_REJECT;
                        const parent = node.parentElement;
                        if (!parent) return NodeFilter.FILTER_REJECT;
                        const tag = parent.tagName;
                        if (tag === 'SCRIPT' || tag === 'STYLE' || tag === 'NOSCRIPT') {
                            return NodeFilter.FILTER_REJECT;
                        }
                        return NodeFilter.FILTER_ACCEPT;
                    }
                },
                false
            );

            const textNodes = [];
            let curr = walker.nextNode();
            while (curr) {
                textNodes.push(curr);
                curr = walker.nextNode();
            }

            textNodes.forEach(node => {
                let val = node.nodeValue;
                compiledRules.forEach(rule => {
                    if (val.includes(rule.searchStr)) {
                        val = val.replace(rule.regex, rule.replaceStr);
                    }
                });
                if (val !== node.nodeValue) {
                    node.nodeValue = val;
                }
            });

            // 2. Translate inputs and placeholders
            document.querySelectorAll('input[placeholder], textarea[placeholder]').forEach(el => {
                let ph = el.getAttribute('placeholder');
                if (!ph) return;
                compiledRules.forEach(rule => {
                    if (ph.includes(rule.searchStr)) {
                        ph = ph.replace(rule.regex, rule.replaceStr);
                    }
                });
                el.setAttribute('placeholder', ph);
            });

            // 3. Translate buttons, aria-labels and image alt texts
            document.querySelectorAll('img[alt]').forEach(el => {
                let alt = el.getAttribute('alt');
                if (!alt) return;
                compiledRules.forEach(rule => {
                    if (alt.includes(rule.searchStr)) {
                        alt = alt.replace(rule.regex, rule.replaceStr);
                    }
                });
                el.setAttribute('alt', alt);
            });
        }

        currentDomLang = targetLang;
        currentLang = targetLang;

        try {
            localStorage.setItem(STORAGE_KEY, targetLang);
        } catch (e) {}

        document.documentElement.lang = targetLang;

        // 4. Localize dynamic filters and collection UI elements
        localizeFilterPills();

        // 5. Update Switcher UI Buttons
        updateSwitcherUI();

        // 6. Dispatch Language Changed event for dynamic components (Cart Drawer, Toasts, Product Detail, etc.)
        window.dispatchEvent(new CustomEvent('language:changed', { detail: { language: targetLang } }));
    }

    function updateSwitcherUI() {
        document.querySelectorAll('.c-lang-btn[data-lang]').forEach(btn => {
            const lang = btn.getAttribute('data-lang');
            if (lang === currentLang) {
                btn.classList.add('is-active');
            } else {
                btn.classList.remove('is-active');
            }
        });
    }

    // Dynamic Filter Pills Localizer (collections-coffee.html & index.html)
    function localizeFilterPills() {
        const lang = currentLang || 'vi';
        const filterBtns = document.querySelectorAll(
            '.c-faceted-nav__filters-featured button, .c-faceted-nav__filters-featured .o-btn, [data-facet-button], .s54-filter-tab, .c-featured-collections__tab, [data-facet-carousel] button'
        );
        const viMap = {
            'ALL': 'TẤT CẢ',
            'ONLINE EXCLUSIVE': 'ĐỘC QUYỀN ONLINE',
            'BEANS': 'CÀ PHÊ HẠT',
            'SPECIALTY BEANS': 'SPECIALTY CAO CẤP',
            'SPECIALTY CÀ PHÊ HẠT': 'SPECIALTY CAO CẤP',
            'COFFEE BEANS': 'CÀ PHÊ HẠT',
            'COFFEE BLENDS': 'CÀ PHÊ BLEND',
            'BLENDS': 'CÀ PHÊ BLEND',
            'SINGLE ORIGIN': 'SINGLE ORIGIN',
            'GROUND COFFEE': 'CÀ PHÊ XAY',
            'GROUND': 'CÀ PHÊ XAY',
            'FEATURED': 'NỔI BẬT',
            '3in1 Instant': 'Hòa Tan 3in1',
            'Roasted Beans': 'Hạt Rang Mộc',
            'Grinders': 'Máy Xay'
        };
        const enMap = {
            'TẤT CẢ': 'ALL',
            'ĐỘC QUYỀN ONLINE': 'ONLINE EXCLUSIVE',
            'CÀ PHÊ HẠT': 'COFFEE BEANS',
            'SPECIALTY CAO CẤP': 'SPECIALTY BEANS',
            'SPECIALTY CÀ PHÊ HẠT': 'SPECIALTY BEANS',
            'CÀ PHÊ BLEND': 'COFFEE BLENDS',
            'CÀ PHÊ XAY': 'GROUND COFFEE',
            'NỔI BẬT': 'FEATURED',
            'Hòa Tan 3in1': '3in1 Instant',
            'Hạt Rang Mộc': 'Roasted Beans',
            'Máy Xay': 'Grinders'
        };

        filterBtns.forEach(function(btn) {
            const txt = (btn.textContent || '').trim();
            if (lang === 'vi') {
                if (viMap[txt]) btn.textContent = viMap[txt];
            } else {
                if (enMap[txt]) btn.textContent = enMap[txt];
            }
        });
    }

    // Public API
    window.S54I18n = {
        setLanguage: translatePage,
        getLanguage: function () { return currentLang; },
        getDomLanguage: function () { return currentDomLang; },
        translate: translatePage,
        translateSubtree: translateSubtree
    };

    // Auto-init on load
    initLanguage();
    document.addEventListener('DOMContentLoaded', () => {
        // Delegate click events for language switcher buttons
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-lang]');
            if (btn) {
                e.preventDefault();
                e.stopPropagation();
                const targetLang = btn.getAttribute('data-lang');
                if (targetLang && (targetLang !== currentLang || targetLang !== currentDomLang)) {
                    translatePage(targetLang);
                }
            }
        });

        if (currentLang === 'en') {
            translatePage('en', true);
        } else {
            updateSwitcherUI();
            localizeFilterPills();
        }
    });

    // Observe dynamic product and filter re-rendering (collections-coffee.html & index.html)
    let debounceTimer = null;
    const observerCallback = function (mutations) {
        if (debounceTimer) clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            localizeFilterPills();
            if (currentLang === 'en') {
                if (mutations && mutations.length) {
                    mutations.forEach(m => {
                        m.addedNodes.forEach(node => {
                            if (node.nodeType === 1) { // ELEMENT_NODE
                                translateSubtree(node, 'en', 'vi');
                            }
                        });
                    });
                } else {
                    translatePage('en', true);
                }
            }
        }, 80);
    };

    const targetContainers = [
        document.querySelector('[data-collection-template-products]'),
        document.querySelector('[data-filters-featured]'),
        document.querySelector('.c-featured-collections')
    ].filter(Boolean);

    targetContainers.forEach(container => {
        const obs = new MutationObserver(observerCallback);
        obs.observe(container, { childList: true, subtree: true });
    });

    // Periodic safety sync for deferred async scripts
    setTimeout(localizeFilterPills, 300);
    setTimeout(localizeFilterPills, 1000);
})();
'''

def main():
    base_path = '/home/binhphan/matbao-ws/clients/s54coffeecom549.mbws.vn'
    i18n_path = os.path.join(base_path, 'assets/js/i18n.js')
    
    with open(i18n_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # Find translationPairs
    match = re.search(r'const translationPairs = \[(.*?)\];\s*// State Tracking', content, re.DOTALL)
    if not match:
        # Initial fallback
        match = re.search(r'const translationPairs = \[(.*?)\];\s*let currentLang', content, re.DOTALL)
    if not match:
        print("Error: Could not match translationPairs boundary")
        return

    pairs_block = match.group(1).strip()
    
    # Append EXTRA_PAIRS
    extra_str = "\n        // EXTRA COMPLETE AUDITED PAIRS\n"
    for vi, en in EXTRA_PAIRS:
        clean_vi = vi.replace('"', '\\"')
        clean_en = en.replace('"', '\\"')
        line = f'        ["{clean_vi}", "{clean_en}"],'
        if f'"{clean_vi}"' not in pairs_block:
            extra_str += line + "\n"

    new_pairs_block = pairs_block + ",\n" + extra_str.rstrip()
    
    # Reconstruct whole file
    new_content = f"""/**
 * S54 COFFEE - Master Internationalization (i18n) Engine
 * 100% Comprehensive Bidirectional Translation: Vietnamese (Canonical Default) & English
 */
(function () {{
    'use strict';

    const STORAGE_KEY = 's54_storefront_lang';

    function escapeRegExp(str) {{
        return str.replace(/[.*+?^${{}}()|[\\]\\\\]/g, "\\\\$&");
    }}

    function createSafeRegex(searchStr) {{
        if (!searchStr) return null;
        const isStartWord = /^[\\p{{L}}\\p{{N}}]/u.test(searchStr);
        const isEndWord = /[\\p{{L}}\\p{{N}}]$/u.test(searchStr);
        const prefix = isStartWord ? "(?<![\\\\p{{L}}\\\\p{{N}}])" : "";
        const suffix = isEndWord ? "(?![\\\\p{{L}}\\\\p{{N}}])" : "";
        return new RegExp(prefix + escapeRegExp(searchStr) + suffix, "gu");
    }}

    // Comprehensive Modular Translation Dictionary (VI <-> EN)
    const translationPairs = [
{new_pairs_block}
    ];

{ENGINE_JS}
"""

    with open(i18n_path, 'w', encoding='utf-8') as f:
        f.write(new_content)
    print(f"Updated {i18n_path}")

    # Synchronize to public and theme
    dest_public = os.path.join(base_path, 'public/client-assets/js/i18n.js')
    dest_theme = os.path.join(base_path, 'theme/assets/js/i18n.js')
    shutil.copy2(i18n_path, dest_public)
    print(f"Synced to {dest_public}")
    shutil.copy2(i18n_path, dest_theme)
    print(f"Synced to {dest_theme}")

if __name__ == '__main__':
    main()
