/**
 * S54 COFFEE - Master Internationalization (i18n) Engine
 * 100% Comprehensive Bidirectional Translation: Vietnamese (Canonical Default) & English
 */
(function () {
    'use strict';

    const STORAGE_KEY = 's54_storefront_lang';

    function escapeRegExp(str) {
        return str.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
    }

    function createSafeRegex(searchStr) {
        if (!searchStr) return null;
        const isStartWord = /^[\p{L}\p{N}]/u.test(searchStr);
        const isEndWord = /[\p{L}\p{N}]$/u.test(searchStr);
        const prefix = isStartWord ? "(?<![\\p{L}\\p{N}])" : "";
        const suffix = isEndWord ? "(?![\\p{L}\\p{N}])" : "";
        return new RegExp(prefix + escapeRegExp(searchStr) + suffix, "gu");
    }

    // Comprehensive Modular Translation Dictionary (VI <-> EN)
    const translationPairs = [
        // 1. TOPBAR & GLOBAL NAVIGATION
        ["Miễn phí vận chuyển toàn quốc cho đơn từ 599.000₫ • Hotline: 0974.933.907", "Free nationwide shipping on orders over 599,000₫ • Hotline: (+84) 974.933.907"],
        ["MIỄN PHÍ VẬN CHUYỂN TOÀN QUỐC CHO ĐƠN TỪ 599.000₫ • HOTLINE: 0974.933.907", "FREE NATIONWIDE SHIPPING ON ORDERS OVER 599,000₫ • HOTLINE: (+84) 974.933.907"],
        ["Miễn phí vận chuyển toàn quốc cho đơn từ 599.000₫ • Hotline: 0383.707.578", "Free nationwide shipping on orders over 599,000₫ • Hotline: (+84) 974.933.907"],
        ["MIỄN PHÍ VẬN CHUYỂN TOÀN QUỐC CHO ĐƠN TỪ 599.000₫ • HOTLINE: 0383.707.578", "FREE NATIONWIDE SHIPPING ON ORDERS OVER 599,000₫ • HOTLINE: (+84) 974.933.907"],
        ["Tất Cả Sản Phẩm S54 Coffee", "All S54 Coffee Products"],
        ["TẤT CẢ SẢN PHẨM S54 COFFEE", "ALL S54 COFFEE PRODUCTS"],
        ["Tất Cả Sản Phẩm", "All Products"],
        ["TẤT CẢ SẢN PHẨM", "ALL PRODUCTS"],
        ["Cà Phê Hạt & Rang Mộc", "Coffee Beans & Roast"],
        ["CÀ PHÊ HẠT & RANG MỘC", "COFFEE BEANS & ROAST"],
        ["Hòa Tan & Sấy Lạnh", "Instant & Freeze-Dried"],
        ["HÒA TAN & SẤY LẠNH", "INSTANT & FREEZE-DRIED"],
        ["Câu Chuyện S54", "Our Story"],
        ["CÂU CHUYỆN S54", "OUR STORY"],
        ["Câu Chuyện Thương Hiệu S54", "S54 Brand Story & Heritage"],
        ["Câu Chuyện Thương Hiệu", "Brand Story"],
        ["CÂU CHUYỆN THƯƠNG HIỆU", "BRAND STORY"],
        ["Cung Ứng B2B & Đại Lý S54", "S54 B2B & Wholesale Supply"],
        ["Cung Ứng B2B & Đại Lý", "B2B & Wholesale Supply"],
        ["Cung ứng B2B & đại lý", "B2B & wholesale supply"],
        ["B2B & Đại Lý", "B2B & Wholesale"],
        ["B2B & ĐẠI LÝ", "B2B & WHOLESALE"],
        ["Tin Tức & Kiến Thức Cà Phê", "News & Coffee Insights"],
        ["Tin Tức", "News"],
        ["TIN TỨC", "NEWS"],
        ["Liên Hệ Hợp Tác", "Partner Contact"],
        ["LIÊN HỆ HỢP TÁC", "PARTNER CONTACT"],
        ["Liên Hệ", "Contact"],
        ["LIÊN HỆ", "CONTACT"],
        ["Sản Phẩm S54", "S54 Products"],
        ["Sản Phẩm", "Products"],
        ["SẢN PHẨM", "PRODUCTS"],
        ["Trang Chủ", "Home"],
        ["TRANG CHỦ", "HOME"],
        ["Về Trang Chủ", "Back to Home"],
        ["Góc Thưởng Thức S54", "S54 Coffee Journal"],

        // 2. HERO & HOMEPAGE EDITORIAL
        ["Tinh Hoa Cà Phê Việt®", "The Essence of Vietnamese Coffee®"],
        ["Tinh Hoa<br/>Cà Phê Việt®", "The Essence of<br/>Vietnamese Coffee®"],
        ["100% Cà phê rang mộc nguyên chất từ vùng đất đỏ Tây Nguyên", "100% Pure roasted coffee beans from Central Highlands volcanic soil"],
        ["“New Coffee, New Income” — Tinh hoa cà phê Việt rang mộc thượng hạng từ năm 2012.", "“New Coffee, New Income” — Pure Vietnamese artisan coffee heritage since 2012."],
        ["\"New Coffee, New Income\" — Tinh hoa cà phê Việt rang mộc thượng hạng từ năm 2012.", "“New Coffee, New Income” — Pure Vietnamese artisan coffee heritage since 2012."],
        ["Sản Phẩm Nổi Bật S54 Coffee", "Featured S54 Coffee Products"],
        ["MUA SẮM NGAY", "SHOP NOW"],
        ["Mua Sắm Ngay", "Shop Now"],
        ["HỢP TÁC B2B & ĐẠI LÝ", "B2B & WHOLESALE PARTNER"],
        ["Hợp Tác B2B & Đại Lý", "B2B & Wholesale Partner"],
        ["TÌM HIỂU THÊM", "LEARN MORE"],
        ["Tìm Hiểu Thêm", "Learn More"],
        ["XEM THÊM", "VIEW MORE"],
        ["Xem Thêm", "View More"],
        ["XEM TẤT CẢ", "VIEW ALL"],
        ["Xem Tất Cả", "View All"],
        ["XEM CHI TIẾT", "VIEW DETAILS"],
        ["Xem Chi Tiết", "View Details"],
        ["ĐỌC BÀI VIẾT", "READ ARTICLE"],
        ["Đọc Bài Viết", "Read Article"],
        ["Đọc Tiếp →", "Read More →"],
        ["Khám Phá Dòng Cà Phê S54", "Discover S54 Coffee Range"],
        ["“S54 Coffee mang đến giải pháp cà phê sạch nguyên chất, đậm đà vị truyền thống và phong cách hiện đại cho hàng triệu người tiêu dùng.”", "“S54 Coffee delivers pure, clean coffee solutions with authentic rich flavor and modern style to millions of consumers.”"],
        ["Hơn 12 Năm Kinh Nghiệm & Đam Mê Cà Phê Sạch", "Over 12 Years of Clean Coffee Passion & Expertise"],
        ["Thành lập từ năm 2012 bởi Công ty TNHH Giải Pháp Tốt (Good Solutions), S54 Coffee tự hào kế thừa tinh hoa cà phê Robusta & Arabica từ vùng đất đỏ bazan Tây Nguyên (Đắk Lắk, Lâm Đồng). Chúng tôi áp dụng quy trình kiểm soát nghiêm ngặt từ hạt giống, nông trại thông minh đến công nghệ rang mộc hiện đại, lưu giữ trọn vẹn hương thơm tự nhiên và hậu vị sâu lắng đặc trưng của cà phê Việt.", "Established in 2012 by Good Solutions Co., Ltd, S54 Coffee inherits the finest Robusta & Arabica beans from the Central Highlands (Dak Lak, Lam Dong). We employ rigorous quality control from smart farming to modern artisan roasting."],
        ["Nghệ Thuật Pha Chế & Thưởng Thức Cà Phê S54 Chuẩn Vị", "The Art of Brewing & Enjoying Authentic S54 Coffee"],
        ["Cùng chuyên gia S54 Coffee khám phá bí quyết chiết xuất tách Espresso thơm ngậy với lớp crema dày sánh mịn hoặc pha phin truyền thống đậm đà khó quên.", "Join S54 Coffee experts to discover the secrets of brewing rich Espresso with golden crema or traditional Vietnamese drip coffee."],

        // 3. COLLECTIONS PAGE (HERO, PILLS, FILTERS)
        ["Khám phá các dòng cà phê hòa tan 3in1, cà phê hạt rang Robusta nguyên chất và máy xay cà phê cầm tay cao cấp. New Coffee, New Income – S54 Coffee.", "Explore authentic 3in1 instant coffee, pure Central Highlands Robusta beans, and premium manual coffee grinders. New Coffee, New Income – S54 Coffee."],
        ["☕ Cà Phê Hòa Tan 3in1 & Hạt Rang", "☕ 3in1 Instant & Roasted Beans"],
        ["🌿 Máy Xay Cà Phê Cầm Tay", "🌿 Manual Coffee Grinders"],
        ["🚚 Freeship Đơn Từ 599.000₫", "🚚 Freeship Orders From 599,000₫"],
        ["🚚 Freeship Đơn Từ 599.000đ", "🚚 Freeship Orders From 599,000₫"],
        ["BỘ LỌC & SẮP XẾP", "FILTERS & SORTING"],
        ["Bộ Lọc & Sắp Xếp", "Filters & Sorting"],
        ["BỘ LỌC", "FILTERS"],
        ["Bộ Lọc", "Filters"],
        ["Xóa Tất Cả", "Clear All"],
        ["Xóa tất cả", "Clear all"],
        ["Clear all filters", "Clear all filters"],
        ["Áp Dụng", "Apply"],
        ["Áp dụng", "Apply"],
        ["Apply filters", "Apply filters"],
        ["Sắp Xếp Theo", "Sort By"],
        ["Sắp xếp theo:", "Sort by:"],
        ["Sắp xếp theo", "Sort by"],
        ["SẮP XẾP THEO", "SORT BY"],
        ["Nổi Bật", "Featured"],
        ["NỔI BẬT", "FEATURED"],
        ["Bán Chạy Nhất", "Best Selling"],
        ["Giá: Thấp Đến Cao", "Price: Low to High"],
        ["Giá: Cao Đến Thấp", "Price: High to Low"],
        ["Tên: A Đến Z", "Name: A to Z"],
        ["Tên: Z Đến A", "Name: Z to A"],
        ["Cũ Nhất", "Date: Old to New"],
        ["Mới Nhất", "Date: New to Old"],
        ["Loại Sản Phẩm", "Product Type"],
        ["Phương Pháp Pha Chế", "Brewing Method"],
        ["Mức Độ Rang", "Roast Profile"],
        ["Cà Phê Hòa Tan", "Instant Coffee"],
        ["Cà Phê Hạt Rang", "Roasted Beans"],
        ["Máy Xay Cà Phê", "Coffee Grinders"],
        ["Pha Phin & Espresso", "Phin & Espresso"],
        ["Pha Phin", "Traditional Phin"],
        ["Cầm Tay Du Lịch", "Portable Travel"],
        ["Rang Mộc Nguyên Bản", "Artisan Roast"],
        ["Rang Vừa Đậm (Medium Dark)", "Medium Dark Roast"],
        ["Độ Đậm (Intensity)", "Intensity"],
        ["intensity", "Intensity"],
        ["Phù Hợp Cho", "Best Suited For"],
        ["best suited for", "Best Suited For"],
        ["Phương Pháp Pha", "Brew Method"],
        ["brew method", "Brew Method"],
        ["Quy Cách Đóng Gói", "Pack Size"],
        ["pack size", "Pack Size"],
        ["Khác", "Other"],
        ["other", "Other"],

        // 4. PRODUCT BADGES
        ["COMBO DÙNG THỬ", "TRIAL COMBO"],
        ["Combo Dùng Thử", "Trial Combo"],
        ["BÁN CHẠY NHẤT", "BEST SELLER"],
        ["Bán Chạy Nhất", "Best Seller"],
        ["TIẾT KIỆM", "SAVINGS"],
        ["Tiết Kiệm", "Savings"],
        ["COMBO GIA ĐÌNH", "FAMILY COMBO"],
        ["Combo Gia Đình", "Family Combo"],
        ["CAO CẤP", "PREMIUM"],
        ["Cao Cấp", "Premium"],
        ["GIÁ TỐT", "BEST PRICE"],
        ["Giá Tốt", "Best Price"],
        ["GIÁ ƯU ĐÃI", "SPECIAL OFFER"],
        ["Giá Ưu Đãi", "Special Offer"],
        ["THIẾT BỊ", "EQUIPMENT"],
        ["Thiết Bị", "Equipment"],
        ["ĐỘC QUYỀN ONLINE", "ONLINE EXCLUSIVE"],
        ["Độc Quyền Online", "Online Exclusive"],
        ["Độc quyền online", "Online exclusive"],
        ["MỚI", "NEW"],
        ["Mới", "New"],
        ["HOT", "HOT"],

        // 5. PRODUCT TITLES (AUTHENTIC S54 PRODUCTS)
        ["Combo 5 Gói Cà Phê Hòa Tan S54 Dùng Thử", "S54 3in1 Instant Coffee 5-Pack Trial"],
        ["Combo 12 Gói Cà Phê Hòa Tan S54 Dùng Thử", "S54 3in1 Instant Coffee 12-Pack Trial"],
        ["Túi Cà Phê Hòa Tan 3in1 S54 Coffee 456g", "S54 Coffee 3in1 Instant Bag 456g"],
        ["Combo 2 Túi Cà Phê Hòa Tan 3in1 S54", "S54 3in1 Instant 2-Bag Combo"],
        ["Combo 3 Túi Cà Phê Hòa Tan 3in1 S54", "S54 3in1 Instant 3-Bag Combo"],
        ["Combo 12 gói cà phê hòa tan S54 dùng thử", "S54 3in1 instant coffee 12-pack trial"],
        ["Combo 5 gói cà phê hòa tan S54 dùng thử", "S54 3in1 instant coffee 5-pack trial"],
        ["Combo 2 túi cà phê hòa tan 3in1 S54", "S54 3in1 instant 2-bag combo"],
        ["Combo 3 túi cà phê hòa tan 3in1 S54", "S54 3in1 instant 3-bag combo"],
        ["Cà Phê Hạt Rang Robusta S54 250gr", "S54 Roasted Robusta Beans 250g"],
        ["Cà Phê Hạt Rang Robusta S54 500gr", "S54 Roasted Robusta Beans 500g"],
        ["Máy Xay Cà Phê Cầm Tay VBZ01-5", "VBZ01-5 Manual Coffee Grinder"],
        ["Máy Xay Cà Phê Cầm Tay VBZ08-5", "VBZ08-5 Manual Coffee Grinder"],
        ["Máy Xay Cà Phê Cầm Tay VBZ03-5", "VBZ03-5 Manual Coffee Grinder"],
        ["Máy Xay Cà Phê Cầm Tay VBS02-5", "VBS02-5 Manual Coffee Grinder"],
        ["Máy Xay Cà Phê Cầm Tay KMDJ-HC", "KMDJ-HC Manual Coffee Grinder"],
        ["Cà Phê Hạt S54 Robusta® Special Bar 1kg", "S54 Robusta® Special Bar Coffee Beans 1kg"],
        ["S54 Robusta Rang Mộc Nguyên Chất", "S54 Pure Roasted Robusta Beans"],
        ["S54 Robusta Rang Mộc", "S54 Pure Roasted Robusta"],
        ["S54 Arabica Cầu Đất Thượng Hạng", "S54 Premium Cau Dat Arabica"],
        ["S54 Arabica Cầu Đất", "S54 Cau Dat Arabica"],
        ["S54 Hòa Tan 3-in-1 Hộp 456g", "S54 3-in-1 Instant Coffee (456g)"],
        ["S54 Cà Phê Sấy Lạnh Cao Cấp", "S54 Premium Freeze-Dried Coffee"],
        ["Cà Phê Sấy Lạnh Cao Cấp", "Premium Freeze-Dried Coffee"],
        ["Cà Phê Sấy Lạnh", "Freeze-Dried Coffee"],
        ["S54 Cà Phê Túi Lọc Drip Bag", "S54 Drip Bag Filter Coffee"],
        ["Cà Phê Túi Lọc Drip Bag", "Drip Bag Filter Coffee"],
        ["Cà Phê Túi Lọc", "Drip Bag Coffee"],
        ["Cà Phê Hòa Tan 3in1 (456g)", "3-in-1 Instant Coffee (456g)"],
        ["Cà Phê Xay Pha Phin", "Traditional Drip Ground Coffee"],

        // 6. PRODUCT SHORT DESCRIPTIONS & EXCERPTS
        ["Cà phê hòa tan 3in1 tiện lợi, đậm đà hương vị cà phê Việt", "Convenient 3in1 instant coffee with rich authentic Vietnamese flavor"],
        ["Combo tiết kiệm 12 gói cà phê hòa tan 3in1 cho gia đình", "Value 12-pack 3in1 instant coffee combo for daily brewing"],
        ["Túi 24 gói x 19g – cà phê hòa tan 3in1 đậm đà, tiện lợi", "Bag of 24 sachets x 19g – rich, convenient 3in1 instant coffee"],
        ["Combo 2 túi tiết kiệm – 48 gói x 19g cà phê hòa tan 3in1", "Value 2-bag combo – 48 sachets x 19g 3in1 instant coffee"],
        ["Combo 3 túi siêu tiết kiệm – 72 gói cho cả gia đình", "Super value 3-bag combo – 72 sachets for the entire family"],
        ["Cà phê hạt rang mộc 100% Robusta nguyên chất từ Tây Nguyên", "100% pure artisan roasted Robusta beans from Central Highlands"],
        ["Cà phê hạt rang mộc 500g – đậm đà, thơm mộc, hậu vị ngọt", "Artisan roasted beans 500g – rich, aromatic with sweet aftertaste"],
        ["Máy xay cà phê cầm tay cao cấp, lưỡi thép không gỉ", "Premium manual coffee grinder with stainless steel conical burr"],
        ["Thiết kế tinh tế, xay mịn đều, phù hợp du lịch", "Elegant compact design, uniform grind, ideal for travel"],
        ["Máy xay cà phê cầm tay cao cấp nhất dòng VBZ", "Flagship manual coffee grinder in the VBZ series"],
        ["Máy xay cà phê cầm tay nhỏ gọn, tiện dụng", "Compact and portable manual coffee grinder"],
        ["Máy xay cà phê cầm tay giá rẻ, chất lượng tốt", "Affordable manual coffee grinder with reliable performance"],
        ["Cà phê hòa tan 3in1 tiện lợi, vị đậm đà", "Convenient 3in1 instant coffee with authentic rich taste"],

        // 7. PRODUCT DETAIL INTERACTIONS & ACCORDIONS
        ["Mua 1 lần", "One-time purchase"],
        ["Mua một lần", "One-time purchase"],
        ["Mua Một Lần", "One-Time Purchase"],
        ["Đăng Ký Định Kỳ & Tiết Kiệm 20%", "Subscribe & Save 20%"],
        ["Đăng ký định kỳ & Tiết kiệm 20%", "Subscribe & Save 20%"],
        ["Đăng Ký Định Kỳ & Tiết Kiệm 25%", "Subscribe & Save 25%"],
        ["Giao hàng định kỳ mỗi 2 tuần, tiết kiệm ngay 20% chi phí. Hủy bất cứ lúc nào không ràng buộc.", "Bi-weekly delivery, save 20% instantly. Cancel anytime with zero commitment."],
        ["TẶNG KÈM CẨM NANG PHA CHẾ S54 CHO MỌI ĐƠN HÀNG", "FREE S54 BREWING HANDBOOK WITH EVERY ORDER"],
        ["Khám phá các công thức pha chế espresso, phin truyền thống và cold brew tuyệt hảo từ chuyên gia S54 Coffee.", "Discover exclusive recipes for espresso, traditional Vietnamese phin, and refreshing cold brew from S54 Coffee experts."],
        ["XEM CẨM NANG NGAY", "EXPLORE BREWING GUIDE"],
        ["Xem Cẩm Nang Ngay", "Explore Brewing Guide"],
        ["Freeship toàn quốc đơn từ 599k", "Free nationwide shipping from 599k"],
        ["Đổi trả miễn phí 7 ngày nếu có lỗi", "Free 7-day returns for any defect"],
        ["100% Cà phê nguyên chất bảo đảm", "100% pure authentic coffee guaranteed"],
        ["Đã bao gồm thuế GTGT (VAT)", "Includes VAT"],
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
        ["Dựa trên 765 đánh giá thực tế", "Based on 765 customer reviews"],
        ["(527 Đánh Giá Của Khách Hàng)", "(527 Verified Customer Reviews)"],
        ["(765 Đánh Giá Của Khách Hàng)", "(765 Verified Customer Reviews)"],
        ["(103 Đánh Giá Của Khách Hàng)", "(103 Verified Customer Reviews)"],
        ["(119 Đánh Giá Của Khách Hàng)", "(119 Verified Customer Reviews)"],
        ["(208 Đánh Giá Của Khách Hàng)", "(208 Verified Customer Reviews)"],
        ["(224 Đánh Giá Của Khách Hàng)", "(224 Verified Customer Reviews)"],
        ["(87 Đánh Giá Của Khách Hàng)", "(87 Verified Customer Reviews)"],
        ["(89 Đánh Giá Của Khách Hàng)", "(89 Verified Customer Reviews)"],
        ["Đánh Giá Của Khách Hàng", "Customer Reviews"],
        ["Khách Hàng Đã Xác Thực Mua Hàng", "Verified Buyer"],
        ["Khách hàng đã xác thực mua hàng", "Verified Buyer"],
        ["Viết Đánh Giá", "Write A Review"],
        ["VIẾT ĐÁNH GIÁ", "WRITE A REVIEW"],
        ["Hương Vị Đặc Trưng (Tasting Notes)", "Tasting Notes & Flavor Profile"],
        ["Hương vị cà phê nguyên bản rất thơm ngon", "Authentic pure coffee flavor is wonderfully aromatic"],
        ["Chất lượng hạt & hương vị", "Bean Quality & Roast Profile"],
        ["Cách mua hàng định kỳ", "How Subscriptions Work"],
        ["Kích Cỡ / Định Dạng:", "Size / Format:"],
        ["Chọn Quy Cách", "Select Size"],
        ["Khối Lượng:", "Size:"],
        ["Còn Hàng", "In Stock"],
        ["Hết Hàng", "Sold Out"],
        ["HẾT HÀNG", "SOLD OUT"],
        ["Hết hàng", "Sold out"],
        ["MUA NGAY", "BUY NOW"],
        ["Mua Ngay", "Buy Now"],
        ["THÊM VÀO GIỎ", "ADD TO BAG"],
        ["Thêm Vào Giỏ", "Add to Bag"],
        ["ĐÃ THÊM!", "ADDED!"],
        ["Số Lượng:", "Quantity:"],
        ["Số Lượng", "Quantity"],
        ["SỐ LƯỢNG", "QUANTITY"],
        ["Sản Phẩm Cùng Dòng", "Related Products"],
        ["Có Thể Bạn Cũng Thích", "You May Also Like"],
        ["Có thể bạn cũng thích", "You May Also Like"],
        ["Đã thêm sản phẩm vào giỏ hàng!", "Added to cart successfully!"],
        ["Đánh giá 4.8 trên 5 sao", "Rated 4.8 out of 5 stars"],
        ["Đánh giá 4.9 trên 5 sao", "Rated 4.9 out of 5 stars"],
        ["Đánh giá 4.7 trên 5 sao", "Rated 4.7 out of 5 stars"],
        ["Đánh Giá", "Reviews"],
        ["Đánh giá", "Rated"],
        ["trên 5 sao", "out of 5 stars"],
        ["Sao", "Stars"],

        // 8. CUSTOMER REVIEW TESTIMONIALS
        ["Cối xay CNC kim loại cầm rất đầm tay, xay nhẹ và hạt ra rất đều. Dễ dàng chỉnh độ mịn để pha espresso hoặc phin truyền thống. Đóng gói rất kỹ.", "Solid all-metal CNC grinder with comfortable grip, smooth grinding and consistent particle size. Easy grind adjustments for espresso or traditional phin. Well packaged."],
        ["Gói tiện mang lên văn phòng. Vị ngọt vừa phải béo bùi, uống tỉnh táo suốt cả ngày làm việc. Cả phòng mình đều ghiền loại này của S54.", "Very convenient sachets for office use. Nicely balanced sweetness and rich creamy aroma, keeps me alert and focused all workday. Our entire office loves this S54 coffee."],
        ["Hạt rang chuẩn mộc, mở túi ra mùi thơm lan tỏa khắp phòng. Vị đậm đà êm dịu, không bị khét hay chua gắt, pha phin hay pha máy đều tuyệt vời.", "Authentic clean roasted beans, opening the bag fills the whole room with natural aroma. Bold yet smooth flavor without burnt or sour notes, tastes great with phin or espresso machine."],
        ["Cà phê đậm vị Tây Nguyên, thơm ngậy béo bùi, uống là ghiền. Đóng gói chỉn chu, giao hàng nhanh.", "Authentic Central Highlands coffee, wonderfully bold and nutty, instantly hooked. Neat packaging and fast delivery."],
        ["Uống cà phê của S54 từ những ngày đầu, dòng 3in1 này rất hợp gu người Việt, không quá ngọt gắt.", "Enjoyed S54 Coffee since their beginnings; this 3in1 perfectly suits Vietnamese palate without being overly sweet."],
        ["Hạt rang mộc không tẩm bơ bắp đậu, pha máy crema dày mịn, thơm phức. Giá cả lại rất hợp lý.", "Pure roasted beans without butter or fillers, yields thick silky crema and superb aroma. Very reasonable price."],

        // 9. CHECKOUT & CART
        ["1. Thông Tin Giao Hàng", "1. Shipping Information"],
        ["2. Phương Thức Thanh Toán", "2. Payment Method"],
        ["Thông Tin Giao Hàng", "Shipping Information"],
        ["Phương Thức Vận Chuyển", "Shipping Method"],
        ["Phương Thức Thanh Toán", "Payment Method"],
        ["Tóm Tắt Đơn Hàng", "Order Summary"],
        ["ĐẶT HÀNG NGAY", "PLACE ORDER NOW"],
        ["Đặt Hàng Ngay", "Place Order Now"],
        ["TIẾN HÀNH THANH TOÁN", "PROCEED TO CHECKOUT"],
        ["Tiến Hành Thanh Toán", "Proceed to Checkout"],
        ["TIẾP TỤC THANH TOÁN", "PROCEED TO CHECKOUT"],
        ["Tiếp Tục Thanh Toán", "Proceed to Checkout"],
        ["Quay Lại Giỏ Hàng", "Return to Cart"],
        ["Quay lại Giỏ hàng", "Return to Cart"],
        ["Giỏ Hàng Của Bạn", "Your Bag"],
        ["Giỏ Hàng", "Cart"],
        ["Tạm Tính", "Subtotal"],
        ["Tạm tính", "Subtotal"],
        ["Phí Vận Chuyển", "Shipping Fee"],
        ["Phí vận chuyển", "Shipping Fee"],
        ["Miễn phí (Đơn > 599k)", "Free (Orders > 599k)"],
        ["Miễn phí", "Free"],
        ["Tổng Cộng", "Total"],
        ["Tổng cộng", "Total"],
        ["Mã Giảm Giá", "Discount Code"],
        ["Nhập mã giảm giá...", "Enter discount code..."],
        ["ÁP DỤNG", "APPLY"],
        ["Áp dụng", "Apply"],
        ["Ghi chú đơn hàng (tuỳ chọn)", "Order notes (optional)"],
        ["Ghi chú thêm về đơn hàng, thời gian giao hàng mong muốn...", "Special instructions, preferred delivery time..."],
        ["Chuyển khoản Ngân hàng (VietQR)", "Bank Transfer (VietQR Instant)"],
        ["Thanh toán khi nhận hàng (COD)", "Cash on Delivery (COD)"],
        ["Cổng thanh toán VNPAY / Momo / Thẻ Quốc Tế", "VNPAY / Momo / International Cards"],
        ["Hỗ trợ thẻ ATM, Visa, MasterCard, JCB và ví điện tử.", "Supports local ATM, Visa, MasterCard, JCB and e-wallets."],
        ["Kiểm tra hàng trước khi thanh toán tiền mặt cho nhân viên giao hàng.", "Inspect items before paying cash directly to courier."],
        ["Quét mã QR qua app ngân hàng để thanh toán nhanh 24/7.", "Scan dynamic QR via banking app for instant 24/7 payment."],
        ["Quét mã QR chuyển khoản tức thì 24/7 không cần nhập thông tin.", "Scan dynamic QR code for instant 24/7 payment without manual typing."],
        ["Cam kết bảo mật:", "Security Guarantee:"],
        ["Mọi thông tin đặt hàng của Quý khách được mã hóa an toàn theo tiêu chuẩn SSL. Cần hỗ trợ nhanh? Gọi ngay Hotline:", "All order information is securely encrypted under SSL standards. Need immediate support? Call Hotline:"],
        ["Quận / Huyện *", "District *"],
        ["Tỉnh / Thành Phố *", "Province / City *"],
        ["Địa chỉ chi tiết (Số nhà, tên đường, tòa nhà...) *", "Detailed address (Street, building, apartment...) *"],
        ["Giỏ hàng của bạn đang trống.", "Your bag is currently empty."],
        ["Bắt Đầu Mua Sắm", "Start Shopping"],
        ["Bắt đầu mua sắm", "Start shopping"],
        ["Tiếp tục mua sắm", "Continue shopping"],
        ["TIẾP TỤC MUA SẮM", "CONTINUE SHOPPING"],
        ["🎉 Bạn đã được MIỄN PHÍ VẬN CHUYỂN!", "🎉 You qualify for FREE Delivery!"],
        ["Thêm 599.000₫ nữa để được MIỄN PHÍ VẬN CHUYỂN", "Add 599,000₫ more for FREE Shipping"],
        ["Xóa", "Remove"],
        ["Đơn giá", "Unit Price"],
        ["Thành tiền", "Total Price"],

        // 10. WHOLESALE & B2B
        ["Chương Trình Đối Tác & Đại Lý Cà Phê S54", "S54 Coffee Partner & Wholesale Program"],
        ["Nguồn Cà Phê Nguyên Chất S54", "S54 Pure Coffee Supply"],
        ["Đối Tác Tiêu Biểu", "Featured Partners & Case Studies"],
        ["Khách Hàng & Đối Tác Nói Gì Về Chúng Tôi", "What Our Clients & Partners Say"],
        ["Đào Tạo Barista & Chuyển Giao Công Nghệ Pha Chế", "Barista Training & Brewing Knowledge Transfer"],
        ["Thiết Bị & Máy Pha Cà Phê Chuyên Nghiệp", "Professional Espresso Machines & Equipment"],
        ["Thiết Kế Quầy Bar & Bộ Nhận Diện Thương Hiệu", "Bar Setup & Custom Brand Identity"],
        ["Hỗ Trợ Marketing & Thu Hút Khách Hàng", "Marketing & Customer Acquisition Support"],
        ["Thương Hiệu Vì Cộng Đồng & Nông Dân Việt", "Community Brand Supporting Vietnamese Farmers"],
        ["Doanh Nghiệp Uy Tín & Cam Kết Dài Lâu", "Trusted Enterprise & Long-term Commitment"],
        ["Liên Hệ Hợp Tác Ngay Hôm Nay", "Get In Touch & Partner With Us Today"],
        ["Họ và Tên *", "Full Name *"],
        ["Họ và tên *", "Full Name *"],
        ["Tên Quán / Doanh Nghiệp *", "Cafe / Business Name *"],
        ["Số Điện Thoại *", "Phone Number *"],
        ["Số điện thoại *", "Phone Number *"],
        ["Email Liên Hệ *", "Email Address *"],
        ["Địa Chỉ Quán / Tỉnh Thành *", "Location / City *"],
        ["Mô Hình Kinh Doanh", "Business Model"],
        ["Nhu Cầu Sản Lượng Dự Kiến (kg/tháng)", "Estimated Monthly Volume (kg/month)"],
        ["Nội Dung Cần Tư Vấn & Yêu Cầu Mẫu Thử", "Inquiry Details & Sample Request"],
        ["GỬI YÊU CẦU TƯ VẤN & NHẬN MẪU THỬ", "SUBMIT INQUIRY & REQUEST SAMPLES"],
        ["Cung Ứng B2B & Đại Lý S54", "S54 B2B & Wholesale Supply"],
        ["Đối tác chiến lược cung ứng nguồn cà phê sạch nguyên chất, thiết bị máy pha chuyên nghiệp và chuyển giao kỹ thuật pha chế cho hơn 500+ chuỗi nhà hàng, khách sạn & quán cafe.", "Strategic partner supplying pure roasted coffee, commercial espresso machines, and brewing technology transfer for over 500+ restaurants, hotels & cafes."],
        ["GIẢI PHÁP CUNG ỨNG B2B TOÀN DIỆN", "COMPREHENSIVE B2B COFFEE SOLUTIONS"],
        ["🌱 Vùng Trồng Đắk Lắk & Cầu Đất", "🌱 Dak Lak & Cau Dat Origins"],
        ["🔥 Công Nghệ Rang Hot-Air Hiện Đại", "🔥 Advanced Hot-Air Artisan Roasting"],
        ["🤝 Đồng Hành Cùng Nông Dân Việt", "🤝 Supporting Vietnamese Farmers"],
        ["☕ Chiết Khấu Đại Lý Tới 35%", "☕ Wholesale Margin Up To 35%"],
        ["📦 Gia Công OEM/ODM Xuất Khẩu", "📦 Private Label OEM/ODM Export"],
        ["🎓 Đào Tạo Barista Chuyên Nghiệp", "🎓 Professional Barista Training"],

        // 11. OUR STORY & BRAND HERITAGE
        ["Hành trình hơn 12 năm kiến tạo giá trị từ Công ty TNHH Giải Pháp Tốt (Good Solutions), chuẩn hóa nguồn cà phê sạch nguyên chất từ vùng đất đỏ Tây Nguyên và lan tỏa tinh hoa cà phê Việt.", "Over 12 years journey by Good Solutions Co., Ltd, standardizing pure clean coffee from Central Highlands red soil and spreading the essence of Vietnamese coffee."],
        ["HÀNH TRÌNH 12+ NĂM DI SẢN (2012 - 2026)", "12+ YEARS HERITAGE JOURNEY (2012 - 2026)"],
        ["S54 COFFEE • VIETNAMESE COFFEE. MADE FOR THE WORLD.", "S54 COFFEE • VIETNAMESE COFFEE. MADE FOR THE WORLD."],
        ["Hành Trình Tinh Hoa Cà Phê Việt & Sứ Mệnh 54 Dân Tộc", "The Vietnamese Coffee Heritage & 54 Ethnic Unity"],
        ["Tự hào mang tên gọi kết hợp giữa hình ảnh dải đất hình chữ S và 54 dân tộc anh em, S54 Coffee ra đời với sứ mệnh nâng tầm hạt cà phê Robusta và Arabica từ thủ phủ Tây Nguyên vươn tầm quốc tế theo phương châm \"New Coffee, New Income\".", "Named after the S-shaped Vietnamese land and 54 brotherly ethnic groups, S54 Coffee elevates Central Highlands Robusta & Arabica globally under the motto \"New Coffee, New Income\"."],
        ["GIỚI THIỆU CHUNG", "ABOUT S54 COFFEE"],
        ["Cà Phê Nguyên Bản Cho Năng Lượng & Giá Trị Bền Vững", "Pure Vietnamese Coffee For Energy & Sustainable Growth"],
        ["S54 Coffee mang đến những trải nghiệm cà phê nguyên bản, đậm đà—từ các dòng cà phê hòa tan 3in1 tiện lợi đến cà phê hạt rang chất lượng cao, lưu giữ trọn vẹn hương vị mộc mạc của đất trời Tây Nguyên.", "S54 Coffee delivers authentic, rich coffee experiences—from convenient 3-in-1 instant blends to premium roasted whole beans that preserve the true spirit of Central Highlands."],
        ["Với phương châm \"New Coffee, New Income\", S54 Coffee không chỉ cung cấp nguồn năng lượng tỉnh táo, sáng tạo mỗi ngày mà còn hướng tới xây dựng giá trị phát triển bền vững và cơ hội thu nhập cho cộng đồng.", "With our core motto \"New Coffee, New Income\", S54 Coffee empowers daily creative energy while creating sustainable economic opportunities for our farming community."],
        ["ĐỊNH HƯỚNG CHIẾN LƯỢC", "STRATEGIC PILLARS"],
        ["Tầm Nhìn • Sứ Mệnh • Giá Trị Cốt Lõi", "Vision • Mission • Core Values"],
        ["Tầm Nhìn", "Our Vision"],
        ["Trở thành thương hiệu cà phê Việt uy tín, vươn tầm quốc tế với các dòng sản phẩm chất lượng cao và sáng tạo.", "To become a globally prestigious Vietnamese coffee brand renowned for quality and innovation."],
        ["Sứ Mệnh", "Our Mission"],
        ["Mang đến tách cà phê chuẩn vị, truyền năng lượng tích cực và tạo dựng thu nhập bền vững cho cộng đồng (New Coffee, New Income).", "Delivering authentic coffee, inspiring positive energy, and creating sustainable incomes."],
        ["Giá Trị Cốt Lõi", "Core Values"],
        ["Trung thực: Minh bạch nguồn gốc và chất lượng.", "Honesty: Transparent origin and quality."],
        ["Chất lượng: Chuẩn vị nguyên bản từng mẻ rang.", "Quality: Authentic taste in every batch."],
        ["Cải tiến: Ứng dụng công nghệ hiện đại.", "Innovation: Modern roasting technology."],
        ["Đồng hành: Cùng phát triển bền vững.", "Partnership: Growing sustainably together."],
        ["HÀNH TRÌNH PHÁT TRIỂN", "OUR DEVELOPMENT MILESTONES"],
        ["Các Cột Mốc Đột Phá Của S54 Coffee", "Key Breakthrough Milestones"],
        ["Cột Mốc 1", "Milestone 1"],
        ["Nghiên Cứu & Phát Triển Chuẩn Vị Tây Nguyên", "R&D and Authentic Taste Formulation"],
        ["Nghiên cứu và phát triển thành công dòng sản phẩm cà phê hòa tan 3in1 tiện lợi & cà phê hạt rang chất lượng cao chuẩn vị thủ phủ Tây Nguyên.", "Successfully formulated authentic instant 3-in-1 and premium roasted whole beans from Central Highlands."],
        ["Cột Mốc 2", "Milestone 2"],
        ["Mở Rộng Hệ Thống Phân Phối & Lan Tỏa Thương Hiệu", "Expanding Distribution & Brand Outreach"],
        ["Mở rộng hệ thống phân phối, phát triển chuỗi cửa hàng trải nghiệm và định hình thông điệp thương hiệu S54 Coffee \"New Coffee, New Income\".", "Expanded commercial distribution networks and established the brand message \"New Coffee, New Income\"."],
        ["Cột Mốc 3", "Milestone 3"],
        ["Số Hóa Thương Hiệu & Nền Tảng Đa Kênh Hiện Đại", "Digital Transformation & Omnichannel Commerce"],
        ["Số hóa toàn diện thương hiệu, hoàn thiện website bán hàng chuyên nghiệp, tích hợp Core Admin quản trị hiện đại và mở rộng kết nối đối tác quốc tế.", "Fully digitized brand operations with a professional e-commerce platform and modern Core Admin backend."],
        ["HỆ THỐNG VĂN PHÒNG & CỬA HÀNG THỰC TẾ", "OUR OFFICES & COFFEE SHOPS"],
        ["Không Gian Trải Nghiệm S54 Coffee", "Experience S54 Coffee Spaces"],
        ["Văn Phòng S54 Coffee", "S54 Coffee Office"],
        ["The Manhattan, Vinhomes Grand Park, TP. Thủ Đức", "The Manhattan, Vinhomes Grand Park, Thu Duc City"],
        ["Trụ Sở Điều Hành", "Executive Headquarters"],
        ["Không gian làm việc sáng tạo & đào tạo barista", "Creative workspace and barista training center"],
        ["Quán Cafe S54 Coffee", "S54 Coffee Shop"],
        ["Điểm trải nghiệm cà phê nguyên bản tại Nhà Bè, TP.HCM", "Artisan coffee experience destination in Nha Be, HCMC"],
        ["“Thiết lập các giải pháp tốt trong việc cung cấp Cà phê Chất lượng với mức độ dịch vụ không ai sánh kịp.” — Triết lý Good Solutions & S54 Coffee.", "“To establish good solutions in providing quality coffee with unmatched levels of service.” — Philosophy of Good Solutions & S54 Coffee."],
        ["GIAI ĐOẠN 2012 - KHỞI NGUỒN ĐAM MÊ", "2012 - OUR PASSION & FOUNDING"],
        ["Thành Lập Good Solutions & Khát Vọng Cà Phê Sạch", "Founding of Good Solutions & Pure Clean Coffee Vision"],
        ["Năm 2012, Công ty TNHH Giải Pháp Tốt (Good Solutions) chính thức được thành lập với mục tiêu thiết lập những chuẩn mực mới cho ngành cà phê Việt Nam. Chứng kiến thực trạng cà phê pha tạp bắp đậu trên thị trường, những người sáng lập S54 đã quyết tâm xây dựng thương hiệu cà phê rang mộc 100% nguyên chất, minh bạch từ nguồn gốc nông trại đến từng tách cà phê trao tay người tiêu dùng.", "In 2012, Good Solutions Co., Ltd was established to set new standards for Vietnamese coffee. Witnessing widespread adulterated coffee on the market, S54 founders committed to building a 100% pure roasted coffee brand, transparent from farm origins to every cup served."],
        ["VÙNG TRỒNG NGUYÊN LIỆU", "COFFEE FARMING ORIGINS"],
        ["Liên Kết Nông Trại Đắk Lắk & Cầu Đất (Lâm Đồng)", "Partnering with Dak Lak & Cau Dat (Lam Dong) Farms"],
        ["S54 Coffee trực tiếp liên kết và bao tiêu sản lượng tại các nông trại thổ nhưỡng bazan màu mỡ ở Buôn Ma Thuột (Đắk Lắk) và Cầu Đất (Lâm Đồng) ở độ cao lý tưởng từ 800m - 1.500m. Chúng tôi kiên định quy chuẩn thu hái quả chín mọng trên cây đạt tỷ lệ trên 95%, áp dụng phương pháp sơ chế ướt (Full Washed) và phơi giàn kính tự nhiên để bảo tồn tối đa hương vị nguyên bản của thổ nhưỡng Việt Nam.", "S54 Coffee directly partners and secures harvest with fertile basalt soil farms in Buon Ma Thuot (Dak Lak) and Cau Dat (Lam Dong) at altitudes from 800m - 1,500m. We adhere to harvesting >95% ripe cherries, applying full-washed processing and natural greenhouse raised beds to preserve authentic Vietnamese terroir."],
        ["CÔNG NGHỆ SẢN XUẤT", "ROASTING TECHNOLOGY"],
        ["Công Nghệ Rang Hot-Air Chuẩn HACCP & ISO", "Hot-Air Roasting Technology with HACCP & ISO Standards"],
        ["Đầu tư nhà máy rang hiện đại với công nghệ khí nóng Hot-Air hồi lưu, S54 kiểm soát chính xác từng profile nhiệt độ và thời gian rang cho từng mẻ hạt. Công nghệ này giúp hạt cà phê chín đều từ lõi ra vỏ, không cháy cạnh, triệt tiêu vị khét và làm nổi bật các nốt hương sô cô la, caramel, thảo mộc tự nhiên cùng hậu vị ngọt thanh êm dịu.", "Investing in modern roasting facilities with recirculating Hot-Air convection, S54 precisely controls temperature profiles and roasting time. This ensures beans roast evenly from core to surface without burnt edges, highlighting notes of dark chocolate, caramel, and sweet smooth aftertaste."],
        ["ĐỔI MỚI SẢN PHẨM", "PRODUCT INNOVATION"],
        ["Đột Phá Hòa Tan 3-in-1 (456g) & Sấy Lạnh Cao Cấp", "Breakthrough 3-in-1 Instant (456g) & Premium Freeze-Dried Coffee"],
        ["Đáp ứng nhịp sống hiện đại mà vẫn giữ vững chuẩn mực gu thưởng thức, S54 Coffee phát triển thành công dòng cà phê hòa tan 3-in-1 hộp 456g đậm đà và cà phê sấy lạnh thăng hoa cao cấp. Quy trình trích ly và sấy ở nhiệt độ âm giúp giữ lại hơn 99% hợp chất hương thơm tự nhiên của hạt Robusta & Arabica thượng hạng.", "Meeting modern lifestyles while preserving authentic taste, S54 Coffee developed rich 3-in-1 instant coffee (456g box) and premium freeze-dried coffee. Sub-zero extraction and freeze-drying retain over 99% of the natural aromatic compounds of premium Robusta & Arabica beans."],
        ["ĐỒNG HÀNH & PHÁT TRIỂN", "COMMUNITY & GROWTH"],
        ["Đào Tạo Barista & Cung Ứng B2B Toàn Diện", "Barista Training & Comprehensive B2B Supply"],
        ["Không chỉ là nhà cung cấp nguyên liệu, S54 Coffee là đối tác chiến lược đồng hành cùng hơn 500+ nhà hàng, khách sạn và quán cà phê. Chúng tôi đào tạo kỹ năng Barista chuyên sâu, chuyển giao công thức pha chế độc quyền, setup quầy bar và cung cấp các dòng máy pha espresso công nghiệp tiêu chuẩn quốc tế.", "More than an ingredient supplier, S54 Coffee is a strategic partner accompanying 500+ restaurants, hotels, and cafes. We provide in-depth Barista training, exclusive brewing recipes, bar setup, and commercial espresso machinery."],

        // 12. BLOG & NEWS
        ["Tất Cả Bài Viết", "All Articles"],
        ["Kiến Thức Cà Phê", "Coffee Insights"],
        ["Câu Chuyện S54", "S54 Stories"],
        ["Hướng Dẫn Pha Chế", "Brewing Guides"],
        ["Bản Tin Extracts", "Extracts Newsletter"],
        ["Các Bài Viết Mới Nhất", "Latest Articles"],
        ["5 Lợi Ích Tuyệt Vời Của Việc Uống Cà Phê Có Thể Bạn Chưa Biết", "5 Amazing Benefits of Drinking Coffee You Might Not Know"],
        ["Bí Quyết Phân Biệt Cà Phê Rang Mộc Nguyên Chất & Cà Phê Pha Tạp", "How to Distinguish Pure Roasted Coffee vs Adulterated Blends"],
        ["1 phút đọc", "1 min read"],
        ["5 phút đọc", "5 min read"],
        ["8 phút đọc", "8 min read"],
        ["10 phút đọc", "10 min read"],
        ["13 phút đọc", "13 min read"],
        ["← Quay lại Tin Tức", "← Back to News"],
        ["← Xem Tất Cả Bài Viết", "← View All Articles"],

        // 13. FOOTER, CONTACT & POLICIES
        ["CÔNG TY TNHH GIẢI PHÁP TỐT", "GOOD SOLUTIONS COMPANY LIMITED"],
        ["Về S54 & Dịch Vụ", "About S54 & Services"],
        ["Đăng Ký Nhận Ưu Đãi", "Subscribe for Offers"],
        ["Nhận ngay voucher ưu đãi 15% cho đơn hàng đầu tiên cùng cẩm nang pha chế độc quyền từ S54 Coffee.", "Get 15% off your first order plus an exclusive brewing guide from S54 Coffee."],
        ["Nhập địa chỉ email của bạn...", "Enter your email address..."],
        ["Kết Nối Với Chúng Tôi:", "Connect With Us:"],
        ["Bản Tin & Tri Thức Cà Phê", "Coffee Journal & Insights"],
        ["Chính Sách Bảo Mật", "Privacy Policy"],
        ["Chính Sách Đổi Trả & Bảo Hành", "Returns & Warranty Policy"],
        ["Chính Sách Đổi Trả & Bảo Mật", "Returns & Privacy Policy"],
        ["Chính Sách Vận Chuyển & Giao Nhận", "Shipping & Delivery Policy"],
        ["Chính Sách Vận Chuyển", "Shipping Policy"],
        ["Nông Trại & Công Nghệ Rang", "Smart Farming & Roasting"],
        ["Gia Công OEM/ODM Xuất Khẩu", "Private Label OEM/ODM Export"],
        ["Chuyển Khoản", "Bank Transfer"],
        ["Giữ toàn quyền bản quyền.", "All rights reserved."],
        ["Số 35, Đường T8, Manhattan, Vinhomes Grand Park, P. Long Bình, TP. Thủ Đức, TP. Hồ Chí Minh", "No. 35, T8 Street, Manhattan, Vinhomes Grand Park, Long Binh Ward, Thu Duc City, Ho Chi Minh City"],
        ["Văn phòng: The Manhattan, Vinhomes Grand Park, Long Bình, TP. Thủ Đức, TP. Hồ Chí Minh", "Office: The Manhattan, Vinhomes Grand Park, Long Binh, Thu Duc City, Ho Chi Minh City"],
        ["Quán cafe: 54/3 Nguyễn Bình, Phú Xuân, Huyện Nhà Bè, TP. Hồ Chí Minh", "Cafe: 54/3 Nguyen Binh, Phu Xuan, Nha Be District, Ho Chi Minh City"],
        ["Hotline Hỗ Trợ: 0974.933.907 (Zalo)", "Hotline Support: (+84) 974.933.907 (Zalo)"],
        ["Gửi Thông Tin Liên Hệ", "Send Inquiry"],
        ["GỬI THÔNG TIN LIÊN HỆ", "SEND INQUIRY"],
        ["Tiêu Đề Tin Nhắn *", "Subject *"],
        ["Nội dung tin nhắn cần hỗ trợ hoặc thông tin hợp tác...", "Your inquiry message, feedback, or partnership request..."],
        ["Đang gửi tin nhắn...", "Sending message..."],
        ["Cảm ơn bạn đã liên hệ! S54 Coffee sẽ phản hồi trong vòng 24 giờ làm việc.", "Thank you for reaching out! S54 Coffee will get back to you within 24 business hours."],

        // 14. 404 PAGE
        ["Không Tìm Thấy Trang", "Page Not Found"],
        ["Trang bạn đang tìm kiếm có thể đã bị xóa, đổi tên hoặc tạm thời không khả dụng. Hãy để chúng tôi đưa bạn về đúng nơi thưởng thức cà phê.", "The page you are looking for might have been removed, had its name changed, or is temporarily unavailable. Let us help you find the right brew."],
        ["Khám Phá Danh Mục Cà Phê", "Explore Coffee Catalog"],
        // EXTRA COMPLETE UI PAIRS
        ["\"New Coffee, New Income\" — Tinh hoa cà phê Việt rang mộc thượng hạng từ năm 2012.", "\"New Coffee, New Income\" — Pure Vietnamese artisan coffee heritage since 2012."],
        ["“New Coffee, New Income” — Tinh hoa cà phê Việt rang mộc thượng hạng từ năm 2012.", "“New Coffee, New Income” — Pure Vietnamese artisan coffee heritage since 2012."],
        ["Đơn Hàng Của Bạn", "Your Order"],
        ["Thanh Toán Đơn Hàng", "Order Checkout"],
        ["XÁC NHẬN ĐẶT HÀNG", "CONFIRM ORDER"],
        ["Xác Nhận Đặt Hàng", "Confirm Order"],
        ["Địa chỉ nhận hàng chi tiết *", "Detailed shipping address *"],
        ["Sản phẩm", "Product"],
        ["Tổng tiền", "Total"],
        ["Số lượng", "Quantity"],
        ["✓ Free vận chuyển toàn quốc cho đơn từ 599.000₫", "✓ Free nationwide shipping on orders over 599,000₫"],
        ["Email Hỗ Trợ Khách Hàng", "Customer Support Email"],
        ["KẾT NỐI VỚI S54 COFFEE", "CONNECT WITH S54 COFFEE"],
        ["Kết Nối Với S54 Coffee", "Connect with S54 Coffee"],
        ["Hotline Tư Vấn 24/7", "24/7 Consultation Hotline"],
        ["Thứ 2 – Thứ 7: 08:00 – 18:00 (Chủ Nhật hỗ trợ qua Hotline/Zalo)", "Mon – Sat: 08:00 – 18:00 (Sunday support via Hotline/Zalo)"],
        ["CỘT MỐC 1 – KHỞI NGUỒN", "MILESTONE 1 – INCEPTION"],
        ["CỘT MỐC 2 – MỞ RỘNG", "MILESTONE 2 – EXPANSION"],
        ["CỘT MỐC 3 – SỐ HÓA", "MILESTONE 3 – DIGITAL TRANSFORMATION"],
        ["Mở Rộng Hệ Thống Phân Phối & Định Hình Thương Hiệu", "Expanding Distribution & Shaping the Brand"],
        ["Khám Phá", "Explore"],
        ["Triết Lý “NEW COFFEE, NEW INCOME” & Hơn Cả Cà Phê", "Philosophy “NEW COFFEE, NEW INCOME” & More Than Coffee"],
        ["Thông Số Chiết Xuất Chuẩn", "Standard Extraction Parameters"],
        ["Máy xay cầm tay chất lượng rất tốt", "Very high quality manual grinder"],
        ["Uống đen nguyên chất", "Enjoying pure black coffee"],
        ["Ý nghĩa đằng sau Logo của S54 Coffee", "The Meaning Behind S54 Coffee Logo"],
        ["Ý nghĩa của tên gọi S54 là gì?", "What is the Meaning of the Name S54?"],
        ["Robusta và Arabica: So sánh chi tiết", "Robusta vs Arabica: A Comprehensive Comparison"],
        ["Các vùng trồng cà phê trọng điểm của Việt Nam", "Key Coffee Growing Regions of Vietnam"],
        ["Thị Trường", "Market"],
        ["4 phút đọc", "4 min read"],
        ["3 phút đọc", "3 min read"],
        ["2 phút đọc", "2 min read"],
        ["Chuỗi Tiệm Bánh & Cà Phê Saigon Heritage", "Saigon Heritage Bakery & Coffee Chain"],
        ["nguồn hạt cà phê thượng hạng", "premium coffee bean supply"],
        ["Rất hân hạnh được đồng hành và hợp tác cùng Quý đối tác.", "We are honoured to accompany and partner with your business."],
        ["Chương trình đối tác bán sỉ và đại lý của S54 được thiết kế để mang lại nhiều hơn chỉ là", "The S54 wholesale and agency partnership program is designed to deliver more than just"],
        ["“S54 Coffee – Đổi mới trong từng tách cà phê Việt. Tuyển chọn khắt khe hạt Robusta và Arabica hảo hạng từ Tây Nguyên.”", "“S54 Coffee – Innovation in every cup of Vietnamese coffee. Rigorously selected Robusta & Arabica beans from the Central Highlands.”"]
    ];

    let currentLang = 'vi';

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

    function translatePage(targetLang) {
        if (targetLang !== 'vi' && targetLang !== 'en') return;
        const fromIdx = currentLang === 'vi' ? 0 : 1;
        const toIdx = targetLang === 'vi' ? 0 : 1;
        currentLang = targetLang;

        try {
            localStorage.setItem(STORAGE_KEY, targetLang);
        } catch (e) {}

        document.documentElement.lang = targetLang;

        // Sort pairs by search string length descending to prevent shorter substrings from corrupting longer phrases
        const sortedPairs = translationPairs.slice().sort((a, b) => {
            const strA = a[fromIdx] || '';
            const strB = b[fromIdx] || '';
            return strB.length - strA.length;
        });

        // Pre-compile safe regular expressions for performance
        const compiledRules = sortedPairs.map(pair => {
            const searchStr = pair[fromIdx];
            const replaceStr = pair[toIdx];
            return {
                searchStr: searchStr,
                replaceStr: replaceStr,
                regex: createSafeRegex(searchStr)
            };
        }).filter(r => r.regex !== null);

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
                if (rule.searchStr && rule.replaceStr && val.includes(rule.searchStr)) {
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
                if (ph && rule.searchStr && rule.replaceStr && ph.includes(rule.searchStr)) {
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
                if (alt && rule.searchStr && rule.replaceStr && alt.includes(rule.searchStr)) {
                    alt = alt.replace(rule.regex, rule.replaceStr);
                }
            });
            el.setAttribute('alt', alt);
        });

        // 4. Localize dynamic filters and collection UI elements
        localizeFilterPills();

        // 5. Update Switcher UI Buttons
        updateSwitcherUI();

        // 6. Dispatch Language Changed event for dynamic components (Cart Drawer, Toasts, etc.)
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
        translate: translatePage
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
                if (targetLang && targetLang !== currentLang) {
                    translatePage(targetLang);
                }
            }
        });

        if (currentLang === 'en') {
            translatePage('en');
        } else {
            updateSwitcherUI();
            localizeFilterPills();
        }
    });

    // Observe dynamic product and filter re-rendering (collections-coffee.html & index.html)
    let debounceTimer = null;
    const observerCallback = function () {
        if (debounceTimer) clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            localizeFilterPills();
            if (currentLang === 'en') {
                translatePage('en');
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
