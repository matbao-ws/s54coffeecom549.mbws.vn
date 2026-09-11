#!/usr/bin/env python3
"""
Refined, rock-solid upgrade for product-detail.html and theme/product-detail.html:
1. Replaces the product gallery with 100% clean 2-column flex layout (nowrap on desktop, column on mobile).
2. Uses gorgeous, authentic consumer coffee photos (no trucks/warehouses!).
3. Strips out all leftover legacy Keen-slider/Flickity navigation elements and unclosed tags.
4. Moves the Lightbox markup to the bottom of <body> so it doesn't interfere with flex layout.
5. Fixes SVG sizes (star icon 13px, zoom icon 18px, arrows 18px).
6. Syncs CSS across all custom.css stylesheets.
"""

import os
import json
import re

PRODUCTS = [
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
        "image": "assets/images/s54/products/combo_5goi_dung_thu.jpg",
        "gallery": [
            "assets/images/s54/products/combo_5goi_dung_thu.jpg",
            "assets/images/s54/instant_sachet.png",
            "assets/images/s54/instant_box.png",
            "assets/images/s54/blog_cup.jpg",
            "assets/images/s54/freeze_dried_blend.jpg"
        ]
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
        "image": "assets/images/s54/products/combo_12goi_dung_thu.jpg",
        "gallery": [
            "assets/images/s54/products/combo_12goi_dung_thu.jpg",
            "assets/images/s54/instant_sachet.png",
            "assets/images/s54/instant_box.png",
            "assets/images/s54/blog_cup.jpg",
            "assets/images/s54/freeze_dried_blend.jpg"
        ]
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
        "image": "assets/images/s54/products/tui_3in1_456g.jpg",
        "gallery": [
            "assets/images/s54/products/tui_3in1_456g.jpg",
            "assets/images/s54/instant_box.png",
            "assets/images/s54/instant_sachet.png",
            "assets/images/s54/blog_cup.jpg",
            "assets/images/s54/freeze_dried_blend.jpg"
        ]
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
        "image": "assets/images/s54/products/combo_2tui_3in1.jpg",
        "gallery": [
            "assets/images/s54/products/combo_2tui_3in1.jpg",
            "assets/images/s54/products/tui_3in1_456g.jpg",
            "assets/images/s54/instant_box.png",
            "assets/images/s54/instant_sachet.png",
            "assets/images/s54/blog_cup.jpg"
        ]
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
        "image": "assets/images/s54/products/combo_2tui_3in1.jpg",
        "gallery": [
            "assets/images/s54/products/combo_2tui_3in1.jpg",
            "assets/images/s54/products/tui_3in1_456g.jpg",
            "assets/images/s54/instant_box.png",
            "assets/images/s54/instant_sachet.png",
            "assets/images/s54/freeze_dried_blend.jpg"
        ]
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
        "image": "assets/images/s54/products/robusta_250g.jpg",
        "gallery": [
            "assets/images/s54/products/robusta_250g.jpg",
            "assets/images/s54/robusta_1.jpg",
            "assets/images/s54/robusta_2.jpg",
            "assets/images/s54/robusta_3.jpg",
            "assets/images/s54/arabica_beans.jpg"
        ]
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
        "image": "assets/images/s54/products/robusta_500g.jpg",
        "gallery": [
            "assets/images/s54/products/robusta_500g.jpg",
            "assets/images/s54/robusta_1.jpg",
            "assets/images/s54/robusta_2.jpg",
            "assets/images/s54/robusta_3.jpg",
            "assets/images/s54/arabica_beans.jpg"
        ]
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
        "image": "assets/images/s54/products/may_xay_vbz01_5.jpg",
        "gallery": [
            "assets/images/s54/products/may_xay_vbz01_5.jpg",
            "assets/images/s54/products/may_xay_vbz08_5.jpg",
            "assets/images/s54/products/may_xay_vbz03_5.jpg",
            "assets/images/s54/products/may_xay_vbs02_5.jpg"
        ]
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
        "image": "assets/images/s54/products/may_xay_vbz08_5.jpg",
        "gallery": [
            "assets/images/s54/products/may_xay_vbz08_5.jpg",
            "assets/images/s54/products/may_xay_vbz01_5.jpg",
            "assets/images/s54/products/may_xay_vbz03_5.jpg",
            "assets/images/s54/products/may_xay_vbs02_5.jpg"
        ]
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
        "image": "assets/images/s54/products/may_xay_vbz03_5.jpg",
        "gallery": [
            "assets/images/s54/products/may_xay_vbz03_5.jpg",
            "assets/images/s54/products/may_xay_vbz01_5.jpg",
            "assets/images/s54/products/may_xay_vbz08_5.jpg",
            "assets/images/s54/products/may_xay_vbs02_5.jpg"
        ]
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
        "image": "assets/images/s54/products/may_xay_vbs02_5.jpg",
        "gallery": [
            "assets/images/s54/products/may_xay_vbs02_5.jpg",
            "assets/images/s54/products/may_xay_vbz01_5.jpg",
            "assets/images/s54/products/may_xay_vbz08_5.jpg",
            "assets/images/s54/products/may_xay_kmdj_hc.jpg"
        ]
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
        "image": "assets/images/s54/products/may_xay_kmdj_hc.jpg",
        "gallery": [
            "assets/images/s54/products/may_xay_kmdj_hc.jpg",
            "assets/images/s54/products/may_xay_vbz01_5.jpg",
            "assets/images/s54/products/may_xay_vbz03_5.jpg",
            "assets/images/s54/products/may_xay_vbs02_5.jpg"
        ]
    }
]

GALLERY_CONTAINER_HTML = '''<div class="c-product-gallery c-product-main__gallery s54-product-gallery" id="s54-product-gallery">
  <!-- 1. Main Hero Image Card -->
  <div class="s54-gallery-hero" id="s54-gallery-hero">
    <!-- Official Store Badge -->
    <div class="s54-gallery-tag">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="#D68E1D" stroke="#D68E1D" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
      <span>100% CHÍNH HÃNG • S54 COFFEE</span>
    </div>

    <!-- Zoom Action (Top Right) -->
    <button type="button" class="s54-gallery-zoom-action" id="s54-gallery-zoom-btn" title="Phóng to ảnh" aria-label="Phóng to ảnh">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
    </button>

    <!-- Main Hero Image Display -->
    <div class="s54-gallery-hero-inner" id="s54-gallery-hero-stage" title="Click để xem ảnh lớn">
      <img id="s54-gallery-main-img" 
           src="assets/images/s54/products/combo_12goi_dung_thu.jpg" 
           alt="S54 Coffee" 
           fetchpriority="high" />
    </div>

    <!-- Navigation Arrows inside card -->
    <button type="button" class="s54-gallery-nav-btn prev" id="s54-gallery-prev" aria-label="Ảnh trước">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
    </button>
    <button type="button" class="s54-gallery-nav-btn next" id="s54-gallery-next" aria-label="Ảnh tiếp theo">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
    </button>

    <!-- Counter Badge -->
    <div class="s54-gallery-counter" id="s54-gallery-counter">1 / 5</div>
  </div>

  <!-- 2. Interactive Thumbnails Strip -->
  <div class="s54-gallery-thumbs" id="s54-gallery-thumbs" role="tablist" aria-label="Danh sách hình ảnh sản phẩm"></div>
</div>'''

LIGHTBOX_HTML = '''<!-- S54 Fullscreen Lightbox Modal (Placed outside main content) -->
<div class="s54-lightbox" id="s54-lightbox" role="dialog" aria-modal="true" aria-hidden="true">
  <div class="s54-lightbox-backdrop" id="s54-lightbox-backdrop"></div>
  <div class="s54-lightbox-container">
    <button type="button" class="s54-lightbox-close" id="s54-lightbox-close" aria-label="Đóng (Esc)">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
    <div class="s54-lightbox-stage">
      <img id="s54-lightbox-img" src="" alt="S54 Full Image" />
    </div>
    <button type="button" class="s54-lightbox-nav prev" id="s54-lightbox-prev" aria-label="Ảnh trước">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
    </button>
    <button type="button" class="s54-lightbox-nav next" id="s54-lightbox-next" aria-label="Ảnh tiếp theo">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
    </button>
    <div class="s54-lightbox-footer">
      <span class="s54-lightbox-counter" id="s54-lightbox-counter">1 / 5</span>
      <span class="s54-lightbox-title" id="s54-lightbox-title">S54 COFFEE</span>
    </div>
  </div>
</div>'''

NEW_GALLERY_CSS = '''
/* ==========================================================================
   S54 ULTRA-LUXURY PRODUCT GALLERY & 2-COLUMN LAYOUT
   ========================================================================== */

/* Main Section: Rigid 2-Column Flex Row */
.c-product-main {
    max-width: 1280px !important;
    margin: 0 auto !important;
    padding: 24px 24px 80px 24px !important;
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: nowrap !important;
    justify-content: space-between !important;
    align-items: flex-start !important;
    gap: 48px !important;
    box-sizing: border-box !important;
}

/* Left Column: Product Gallery */
.s54-product-gallery,
.c-product-main__gallery {
    flex: 1 1 calc(54% - 24px) !important;
    max-width: calc(54% - 24px) !important;
    width: calc(54% - 24px) !important;
    box-sizing: border-box !important;
    position: relative !important;
    display: flex !important;
    flex-direction: column !important;
    gap: 16px !important;
}

/* Right Column: Product Details */
.c-product-main__details {
    flex: 1 1 calc(46% - 24px) !important;
    max-width: calc(46% - 24px) !important;
    width: calc(46% - 24px) !important;
    background: #FAF6F1 !important;
    border-radius: 16px !important;
    padding: 36px 32px !important;
    box-shadow: 0 4px 24px rgba(47, 34, 26, 0.05) !important;
    box-sizing: border-box !important;
}

@media (max-width: 991px) {
    .c-product-main {
        flex-direction: column !important;
        flex-wrap: wrap !important;
        padding: 16px 16px 60px 16px !important;
        gap: 32px !important;
    }
    .s54-product-gallery,
    .c-product-main__gallery,
    .c-product-main__details {
        flex: 0 0 100% !important;
        max-width: 100% !important;
        width: 100% !important;
    }
}

/* Hide any legacy Keen-slider / Flickity buttons completely */
.c-product-gallery__navigation,
.c-product-gallery__previous,
.c-product-gallery__next,
.c-product-gallery__progress,
[data-product-gallery-carousel-navigation] {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    pointer-events: none !important;
}

/* 1. Main Hero Stage */
.s54-gallery-hero {
    position: relative !important;
    width: 100% !important;
    height: 500px !important;
    background: #FAF6F1 !important;
    border-radius: 16px !important;
    border: 1px solid rgba(47, 34, 26, 0.08) !important;
    box-shadow: 0 4px 24px rgba(47, 34, 26, 0.05) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    overflow: hidden !important;
    box-sizing: border-box !important;
    user-select: none !important;
}

@media (max-width: 767px) {
    .s54-gallery-hero {
        height: 380px !important;
    }
}

/* Hero Badge Tag with Exact SVG Dimensions */
.s54-gallery-tag {
    position: absolute !important;
    top: 18px !important;
    left: 18px !important;
    z-index: 5 !important;
    background: #2F221A !important;
    color: #FAF6F1 !important;
    font-family: 'Inter', sans-serif !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    letter-spacing: 0.8px !important;
    text-transform: uppercase !important;
    padding: 6px 14px !important;
    border-radius: 20px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 7px !important;
    box-shadow: 0 2px 10px rgba(47, 34, 26, 0.2) !important;
    pointer-events: none !important;
}

.s54-gallery-tag svg {
    width: 13px !important;
    height: 13px !important;
    min-width: 13px !important;
    min-height: 13px !important;
    max-width: 13px !important;
    max-height: 13px !important;
    display: inline-block !important;
    vertical-align: middle !important;
    color: #D68E1D !important;
    fill: #D68E1D !important;
}

/* Zoom Trigger Button */
.s54-gallery-zoom-action {
    position: absolute !important;
    top: 18px !important;
    right: 18px !important;
    z-index: 5 !important;
    width: 38px !important;
    height: 38px !important;
    border-radius: 50% !important;
    background: rgba(255, 255, 255, 0.95) !important;
    border: 1px solid rgba(47, 34, 26, 0.1) !important;
    color: #2F221A !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    box-shadow: 0 2px 10px rgba(47, 34, 26, 0.08) !important;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.s54-gallery-zoom-action svg {
    width: 18px !important;
    height: 18px !important;
    min-width: 18px !important;
    min-height: 18px !important;
    display: block !important;
}

.s54-gallery-zoom-action:hover {
    background: #2F221A !important;
    color: #FAF6F1 !important;
    transform: scale(1.08) !important;
}

/* Hero Stage Inner */
.s54-gallery-hero-inner {
    width: 100% !important;
    height: 100% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 24px !important;
    cursor: zoom-in !important;
    box-sizing: border-box !important;
}

#s54-gallery-main-img {
    max-width: 90% !important;
    max-height: 440px !important;
    width: auto !important;
    height: auto !important;
    object-fit: contain !important;
    border-radius: 8px !important;
    display: block !important;
    margin: auto !important;
    box-shadow: 0 8px 30px rgba(47, 34, 26, 0.08) !important;
    transition: opacity 0.22s ease-in-out, transform 0.28s cubic-bezier(0.2, 0, 0.2, 1) !important;
}

.s54-gallery-hero-inner:hover #s54-gallery-main-img {
    transform: scale(1.035) !important;
}

/* Floating Navigation Buttons */
.s54-gallery-nav-btn {
    position: absolute !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    z-index: 6 !important;
    width: 42px !important;
    height: 42px !important;
    border-radius: 50% !important;
    background: rgba(255, 255, 255, 0.95) !important;
    border: 1px solid rgba(47, 34, 26, 0.1) !important;
    color: #2F221A !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    box-shadow: 0 4px 16px rgba(47, 34, 26, 0.12) !important;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.s54-gallery-nav-btn svg {
    width: 18px !important;
    height: 18px !important;
    min-width: 18px !important;
    min-height: 18px !important;
    display: block !important;
}

.s54-gallery-nav-btn.prev {
    left: 14px !important;
}

.s54-gallery-nav-btn.next {
    right: 14px !important;
}

.s54-gallery-nav-btn:hover {
    background: #2F221A !important;
    color: #FAF6F1 !important;
    transform: translateY(-50%) scale(1.08) !important;
}

@media (max-width: 767px) {
    .s54-gallery-nav-btn {
        width: 36px !important;
        height: 36px !important;
    }
}

/* Counter Badge */
.s54-gallery-counter {
    position: absolute !important;
    bottom: 16px !important;
    right: 16px !important;
    z-index: 5 !important;
    background: rgba(47, 34, 26, 0.82) !important;
    backdrop-filter: blur(4px) !important;
    color: #FAF6F1 !important;
    font-family: 'Inter', sans-serif !important;
    font-size: 11.5px !important;
    font-weight: 600 !important;
    padding: 4px 12px !important;
    border-radius: 12px !important;
    letter-spacing: 0.5px !important;
    pointer-events: none !important;
}

/* 2. Interactive Thumbnails Strip */
.s54-gallery-thumbs {
    display: flex !important;
    gap: 12px !important;
    justify-content: center !important;
    align-items: center !important;
    flex-wrap: wrap !important;
    padding: 2px !important;
}

.s54-gallery-thumb {
    width: 78px !important;
    height: 78px !important;
    border-radius: 12px !important;
    background: #FAF6F1 !important;
    border: 2px solid transparent !important;
    padding: 4px !important;
    cursor: pointer !important;
    overflow: hidden !important;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative !important;
    box-sizing: border-box !important;
    flex-shrink: 0 !important;
}

.s54-gallery-thumb img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    border-radius: 8px !important;
    display: block !important;
}

.s54-gallery-thumb:hover {
    border-color: #D68E1D !important;
    transform: translateY(-2px) !important;
}

.s54-gallery-thumb.is-active {
    border-color: #2F221A !important;
    box-shadow: 0 4px 14px rgba(47, 34, 26, 0.2) !important;
    transform: translateY(-2px) !important;
    background: #FFFFFF !important;
}

@media (max-width: 767px) {
    .s54-gallery-thumbs {
        justify-content: flex-start !important;
        overflow-x: auto !important;
        flex-wrap: nowrap !important;
        padding-bottom: 8px !important;
        -webkit-overflow-scrolling: touch !important;
    }
    .s54-gallery-thumb {
        width: 64px !important;
        height: 64px !important;
    }
}

/* 3. Fullscreen Lightbox Modal */
.s54-lightbox {
    position: fixed !important;
    inset: 0 !important;
    z-index: 999999 !important;
    background: rgba(15, 10, 8, 0.94) !important;
    backdrop-filter: blur(12px) !important;
    display: none;
    align-items: center !important;
    justify-content: center !important;
    opacity: 0;
    transition: opacity 0.25s ease !important;
    padding: 20px !important;
    box-sizing: border-box !important;
}

.s54-lightbox.is-open {
    display: flex !important;
    opacity: 1 !important;
}

.s54-lightbox-backdrop {
    position: absolute !important;
    inset: 0 !important;
    z-index: 1 !important;
    cursor: pointer !important;
}

.s54-lightbox-container {
    position: relative !important;
    z-index: 2 !important;
    max-width: 92vw !important;
    max-height: 90vh !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
}

.s54-lightbox-close {
    position: fixed !important;
    top: 24px !important;
    right: 24px !important;
    z-index: 10 !important;
    width: 44px !important;
    height: 44px !important;
    border-radius: 50% !important;
    background: rgba(255, 255, 255, 0.15) !important;
    border: 1px solid rgba(255, 255, 255, 0.25) !important;
    color: #FAF6F1 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
}

.s54-lightbox-close:hover {
    background: #D68E1D !important;
    color: #1F1611 !important;
    transform: scale(1.08) !important;
}

.s54-lightbox-stage {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    max-width: 86vw !important;
    max-height: 78vh !important;
}

#s54-lightbox-img {
    max-width: 100% !important;
    max-height: 78vh !important;
    object-fit: contain !important;
    border-radius: 12px !important;
    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.6) !important;
    transition: opacity 0.2s ease !important;
}

.s54-lightbox-nav {
    position: fixed !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    z-index: 10 !important;
    width: 48px !important;
    height: 48px !important;
    border-radius: 50% !important;
    background: rgba(255, 255, 255, 0.15) !important;
    border: 1px solid rgba(255, 255, 255, 0.25) !important;
    color: #FAF6F1 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
}

.s54-lightbox-nav.prev {
    left: 24px !important;
}

.s54-lightbox-nav.next {
    right: 24px !important;
}

.s54-lightbox-nav:hover {
    background: #D68E1D !important;
    color: #1F1611 !important;
    transform: translateY(-50%) scale(1.08) !important;
}

.s54-lightbox-footer {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    margin-top: 14px !important;
    font-family: 'Inter', sans-serif !important;
    color: #FAF6F1 !important;
    font-size: 13px !important;
    background: rgba(0, 0, 0, 0.4) !important;
    padding: 6px 16px !important;
    border-radius: 20px !important;
}

.s54-lightbox-counter {
    font-weight: 700 !important;
    color: #D68E1D !important;
}
'''

def upgrade_file(file_path):
    print(f"Upgrading {file_path}...")
    with open(file_path, "r", encoding="utf-8") as f:
        content = f.read()

    # 1. Cleanly replace the gallery block inside <section class="c-product-main" ...>
    # Find start of section and start of details
    section_tag = 'data-section-id="template--15747875176623__product-main"'
    details_tag = '<div class="c-product-main__details">'

    if section_tag in content and details_tag in content:
        sec_idx = content.find(section_tag)
        tag_close_idx = content.find('>', sec_idx)
        details_idx = content.find(details_tag)

        # Replace everything between tag_close_idx + 1 and details_idx with just GALLERY_CONTAINER_HTML
        content = (
            content[:tag_close_idx + 1]
            + "\n  " + GALLERY_CONTAINER_HTML
            + "\n\n  " + content[details_idx:]
        )
        print("  - Cleanly replaced gallery section markup (stripped all leftovers)")

    # 2. Ensure Lightbox is at the bottom of the body (before </body>)
    # First remove any existing lightbox markup
    content = re.sub(r'<!-- S54 Fullscreen Lightbox Modal[\s\S]*?</div>\s*</div>\s*</div>', '', content)
    content = re.sub(r'<div class="s54-lightbox"[\s\S]*?</div>\s*</div>\s*</div>', '', content)
    
    # Place LIGHTBOX_HTML right before </body> or before #scrollTopBtn
    if '<button class="c-scroll-top"' in content:
        content = content.replace('<button class="c-scroll-top"', LIGHTBOX_HTML + '\n\n<button class="c-scroll-top"', 1)
        print("  - Placed LIGHTBOX_HTML at the bottom before scrollTopBtn")
    elif '</body>' in content:
        content = content.replace('</body>', LIGHTBOX_HTML + '\n</body>', 1)
        print("  - Placed LIGHTBOX_HTML before </body>")

    # 3. Replace the CSS block with NEW_GALLERY_CSS
    css_start = "/* ==========================================================================\n   S54 ULTRA-LUXURY PRODUCT GALLERY"
    if css_start in content:
        # Find where it ends before </style>
        css_idx = content.find(css_start)
        style_close_idx = content.find('</style>', css_idx)
        content = content[:css_idx] + NEW_GALLERY_CSS.strip() + "\n" + content[style_close_idx:]
        print("  - Updated inline NEW_GALLERY_CSS in <style>")
    else:
        content = content.replace('</style>', NEW_GALLERY_CSS + '\n</style>', 1)
        print("  - Injected NEW_GALLERY_CSS into <style>")

    # 4. Update window.S54_PRODUCTS
    prod_json = json.dumps(PRODUCTS, ensure_ascii=False)
    products_regex = re.compile(r'window\.S54_PRODUCTS\s*=\s*\[[\s\S]*?\];', re.MULTILINE)
    if products_regex.search(content):
        content = products_regex.sub(f'window.S54_PRODUCTS = {prod_json};', content, count=1)
        print("  - Updated window.S54_PRODUCTS with genuine consumer gallery images")

    with open(file_path, "w", encoding="utf-8") as f:
        f.write(content)
    print(f"Done upgrading {file_path}!\n")

def update_css_files():
    css_paths = [
        "assets/css/custom.css",
        "public/client-assets/css/custom.css",
        "theme/assets/css/custom.css"
    ]
    for path in css_paths:
        if os.path.exists(path):
            with open(path, "r", encoding="utf-8") as f:
                c = f.read()
            css_start = "/* ==========================================================================\n   S54 ULTRA-LUXURY PRODUCT GALLERY"
            if css_start in c:
                idx = c.find(css_start)
                c = c[:idx] + NEW_GALLERY_CSS + "\n"
            else:
                c += "\n" + NEW_GALLERY_CSS + "\n"
            with open(path, "w", encoding="utf-8") as f:
                f.write(c)
            print(f"Updated NEW_GALLERY_CSS in {path}")

if __name__ == "__main__":
    upgrade_file("product-detail.html")
    if os.path.exists("theme/product-detail.html"):
        upgrade_file("theme/product-detail.html")
    update_css_files()
