@extends('client.layouts.app')

@section('title', 'S54 COFFEE — Tinh Hoa Cà Phê Việt | New Coffee, New Income')

@section('content')
{{-- 1. Hero Banner Section --}}
<section class="s54-page-hero" style="background: radial-gradient(circle at center, rgba(47,34,26,0.82) 0%, rgba(26,18,13,0.96) 100%), url('{{ asset('client-assets/images/s54/story_hero_heritage.jpg') }}') center/cover no-repeat; padding: clamp(80px, 10vw, 130px) 20px clamp(60px, 8vw, 90px); text-align: center; color: #FFFFFF; position: relative;">
    <div class="o-wrapper" style="max-width: 960px; margin: 0 auto; position: relative; z-index: 2;">
        <span style="display: inline-block; background: rgba(214,142,29,0.2); border: 1px solid #D68E1D; color: #F7D08A; padding: 6px 18px; border-radius: 30px; font-size: 11.5px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 24px;">
            {{ app()->getLocale() === 'vi' ? 'CÔNG NGHỆ RANG HOT-AIR ĐỨC • 100% NGUYÊN CHẤT' : 'GERMAN HOT-AIR ROASTING • 100% ARTISAN' }}
        </span>
        <h1 style="font-family: 'Cormorant Garamond', Georgia, serif; font-size: clamp(34px, 5.5vw, 58px); font-weight: 700; line-height: 1.15; margin-bottom: 20px; color: #FFFFFF !important; text-shadow: 0 4px 24px rgba(0,0,0,0.5);">
            {{ app()->getLocale() === 'vi' ? 'Tinh Hoa Cà Phê Việt Nam Thượng Hạng' : 'The Pinnacle of Vietnamese Artisan Coffee' }}
        </h1>
        <p style="font-size: clamp(15px, 1.8vw, 18px); line-height: 1.6; color: #E5DDD5 !important; max-width: 720px; margin: 0 auto 36px; font-weight: 400;">
            {{ app()->getLocale() === 'vi' ? 'Khám phá hương vị Robusta đậm đà từ Đắk Lắk & Arabica thanh nhã Cầu Đất, được rang xay thủ công với độ chuẩn xác tuyệt đối.' : 'Discover rich Robusta from Dak Lak and elegant Arabica from Cau Dat, precision roasted for exquisite taste.' }}
        </p>
        <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
            <a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" style="display: inline-flex; align-items: center; justify-content: center; background-color: #D68E1D; color: #FFFFFF; padding: 14px 34px; border-radius: 4px; font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; transition: transform 0.2s, background 0.2s; box-shadow: 0 4px 16px rgba(214,142,29,0.35);">
                {{ app()->getLocale() === 'vi' ? 'Khám Phá Sản Phẩm' : 'Explore Products' }}
            </a>
            <a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'our-story']) }}" style="display: inline-flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.06); color: #FAF6F1; border: 1.5px solid rgba(255,255,255,0.4); padding: 14px 34px; border-radius: 4px; font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; transition: all 0.2s;">
                {{ app()->getLocale() === 'vi' ? 'Câu Chuyện S54' : 'Our Heritage' }}
            </a>
        </div>
    </div>
</section>

{{-- 2. Value Proposition Pillars --}}
<section style="background-color: #FFFFFF; padding: 50px 20px; border-bottom: 1px solid #EDE6DD;">
    <div class="o-wrapper" style="max-width: 1320px; margin: 0 auto;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 28px;">
            <div style="display: flex; align-items: flex-start; gap: 16px; padding: 12px;">
                <div style="width: 48px; height: 48px; border-radius: 10px; background-color: #FAF5EE; color: #D68E1D; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">☕</div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #2F221A; margin: 0 0 6px 0;">{{ app()->getLocale() === 'vi' ? '100% Nguyên Chất' : '100% Pure Coffee' }}</h3>
                    <p style="font-size: 13px; color: #6E5F55; line-height: 1.5; margin: 0;">{{ app()->getLocale() === 'vi' ? 'Không pha tạp, không hương liệu hay hóa chất bảo quản.' : 'No artificial flavors, preservatives, or chemical additives.' }}</p>
                </div>
            </div>
            <div style="display: flex; align-items: flex-start; gap: 16px; padding: 12px;">
                <div style="width: 48px; height: 48px; border-radius: 10px; background-color: #FAF5EE; color: #D68E1D; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">🔥</div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #2F221A; margin: 0 0 6px 0;">{{ app()->getLocale() === 'vi' ? 'Công Nghệ Hot-Air Đức' : 'German Hot-Air Roasting' }}</h3>
                    <p style="font-size: 13px; color: #6E5F55; line-height: 1.5; margin: 0;">{{ app()->getLocale() === 'vi' ? 'Hạt chín đều từ trong ra ngoài, giữ trọn hương thơm tự nhiên.' : 'Even heat distribution locking in delicate origin aroma.' }}</p>
                </div>
            </div>
            <div style="display: flex; align-items: flex-start; gap: 16px; padding: 12px;">
                <div style="width: 48px; height: 48px; border-radius: 10px; background-color: #FAF5EE; color: #D68E1D; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">🌱</div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #2F221A; margin: 0 0 6px 0;">{{ app()->getLocale() === 'vi' ? 'Vùng Trồng Chọn Lọc' : 'Single Origin Terroir' }}</h3>
                    <p style="font-size: 13px; color: #6E5F55; line-height: 1.5; margin: 0;">{{ app()->getLocale() === 'vi' ? 'Thu hoạch hạt chín mọng từ Đắk Lắk và Cầu Đất (Đà Lạt).' : 'Hand-picked ripe cherries from premium high-altitude farms.' }}</p>
                </div>
            </div>
            <div style="display: flex; align-items: flex-start; gap: 16px; padding: 12px;">
                <div style="width: 48px; height: 48px; border-radius: 10px; background-color: #FAF5EE; color: #D68E1D; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">🚚</div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #2F221A; margin: 0 0 6px 0;">{{ app()->getLocale() === 'vi' ? 'Giao Hàng Toàn Quốc' : 'Nationwide Delivery' }}</h3>
                    <p style="font-size: 13px; color: #6E5F55; line-height: 1.5; margin: 0;">{{ app()->getLocale() === 'vi' ? 'Đóng gói van một chiều bảo quản độ tươi mới tuyệt đối.' : 'One-way degassing valve pouches ensuring maximum freshness.' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 3. Featured Products Section --}}
<section class="c-featured-collections" style="background-color: #FAF8F5; padding: 72px 0 64px;">
    <div class="c-featured-collections__header" style="text-align: center; margin-bottom: 40px; padding: 0 20px;">
        <span style="font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #D68E1D; display: block; margin-bottom: 8px;">
            {{ app()->getLocale() === 'vi' ? 'BỘ SƯU TẬP TUYỂN CHỌN' : 'CURATED COLLECTION' }}
        </span>
        <h2 class="c-featured-collections__header-title" style="font-family: 'Cormorant Garamond', Georgia, serif; font-size: clamp(30px, 4vw, 42px); font-weight: 700; color: #2F221A; margin: 0 0 12px 0;">
            {{ app()->getLocale() === 'vi' ? 'Dòng Sản Phẩm Cà Phê Nổi Bật' : 'Featured Artisan Coffee' }}
        </h2>
        <div style="width: 50px; height: 2px; background-color: #D68E1D; margin: 0 auto 16px auto;"></div>
        <p style="color: #6E5F55; max-width: 600px; margin: 0 auto; font-size: 14.5px;">
            {{ app()->getLocale() === 'vi' ? 'Mỗi dòng sản phẩm mang một phong vị độc đáo, đáp ứng hoàn hảo cho gu thưởng thức từ truyền thống đến hiện đại.' : 'Each blend delivers a signature flavor profile tailored for authentic espresso, phin drip, or instant convenience.' }}
        </p>
    </div>

    <div class="c-featured-collections__products-list is-active">
        @forelse($featuredProducts as $prod)
            <x-client.product-card :product="$prod" />
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #8A7B70;">
                {{ app()->getLocale() === 'vi' ? 'Chưa có sản phẩm nào được hiển thị.' : 'No products available.' }}
            </div>
        @endforelse
    </div>

    <div style="text-align: center; margin-top: 48px;">
        <a href="{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}" style="display: inline-flex; align-items: center; gap: 8px; background-color: #2F221A; color: #FAF6F1; padding: 14px 38px; border-radius: 4px; font-size: 12.5px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; text-decoration: none; transition: background 0.2s;">
            <span>{{ app()->getLocale() === 'vi' ? 'Xem Tất Cả 12 Sản Phẩm S54' : 'View All S54 Products' }}</span>
            <span>&rarr;</span>
        </a>
    </div>
</section>

{{-- 4. Philosophy Quote Section --}}
<section style="background-color: #1F150F; color: #FAF6F1; padding: 70px 20px; text-align: center; border-top: 1px solid rgba(214,142,29,0.15); border-bottom: 1px solid rgba(214,142,29,0.15);">
    <div class="o-wrapper" style="max-width: 860px; margin: 0 auto;">
        <span style="color: #D68E1D; font-size: 48px; font-family: 'Cormorant Garamond', serif; display: block; line-height: 1; margin-bottom: 8px;">“</span>
        <blockquote style="font-family: 'Cormorant Garamond', Georgia, serif; font-size: clamp(22px, 3.5vw, 32px); font-style: italic; line-height: 1.45; color: #FAF6F1 !important; margin: 0 0 20px 0;">
            {{ app()->getLocale() === 'vi' ? 'Thiết lập các giải pháp tốt trong việc cung cấp Cà phê Chất lượng với mức độ dịch vụ không ai sánh kịp.' : 'Establishing premier solutions in delivering Quality Coffee with unparalleled standards of service.' }}
        </blockquote>
        <cite style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #D68E1D; font-style: normal;">
            — {{ app()->getLocale() === 'vi' ? 'Triết lý Good Solutions & S54 Coffee' : 'Philosophy of Good Solutions & S54 Coffee' }}
        </cite>
    </div>
</section>

{{-- 5. Brand Heritage Highlight --}}
<section style="background-color: #FAF6F1; padding: 80px 20px;">
    <div class="o-wrapper" style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: clamp(32px, 5vw, 64px); align-items: center;">
        <div style="border-radius: 8px; overflow: hidden; box-shadow: 0 12px 36px rgba(47,34,26,0.12);">
            <img src="{{ asset('client-assets/images/s54/story_roasting_mastery.jpg') }}" alt="S54 Coffee Roasting Mastery" style="width: 100%; height: auto; display: block; object-fit: cover;" loading="lazy">
        </div>
        <div>
            <span style="font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #D68E1D; display: block; margin-bottom: 10px;">
                {{ app()->getLocale() === 'vi' ? 'CÂU CHUYỆN S54' : 'OUR STORY' }}
            </span>
            <h2 style="font-family: 'Cormorant Garamond', Georgia, serif; font-size: clamp(28px, 4vw, 38px); font-weight: 700; color: #2F221A; margin: 0 0 20px 0; line-height: 1.25;">
                {{ app()->getLocale() === 'vi' ? 'Tâm Huyết Người Làm Cà Phê Việt' : 'The Passion Behind Vietnamese Coffee' }}
            </h2>
            <p style="font-size: 15px; line-height: 1.7; color: #5C4D42; margin-bottom: 18px;">
                {{ app()->getLocale() === 'vi' ? 'Xuất phát từ niềm tự hào với những đồi cà phê bạt ngàn tại Đắk Lắk và Lâm Đồng, S54 Coffee ra đời với sứ mệnh tôn vinh phẩm vị cà phê Việt Nam nguyên chất chuẩn mực.' : 'Rooted in pride for Vietnam’s iconic coffee plateaus in Dak Lak and Lam Dong, S54 Coffee was born to champion pure Vietnamese coffee excellence.' }}
            </p>
            <p style="font-size: 15px; line-height: 1.7; color: #5C4D42; margin-bottom: 28px;">
                {{ app()->getLocale() === 'vi' ? 'Áp dụng công nghệ rang Hot-Air hồi khí của Đức, từng mẻ rang được kiểm soát profile nghiêm ngặt, bung tỏa tối đa nốt hương sô-cô-la đen, hạt dẻ và mật ong tự nhiên.' : 'Utilizing state-of-the-art German Hot-Air technology, each batch profile is rigorously managed to release luscious notes of dark chocolate, toasted hazelnut, and natural honey.' }}
            </p>
            <a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'our-story']) }}" style="display: inline-flex; align-items: center; gap: 8px; color: #D68E1D; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; text-decoration: none;">
                <span>{{ app()->getLocale() === 'vi' ? 'Đọc Thêm Về Chúng Tôi' : 'Read Our Full Story' }}</span>
                <span>&rarr;</span>
            </a>
        </div>
    </div>
</section>

{{-- 6. Latest News & Brewing Guides Feed --}}
@if(isset($latestPosts) && $latestPosts->count() > 0)
<section style="background-color: #FFFFFF; padding: 80px 20px; border-top: 1px solid #EDE6DD;">
    <div class="o-wrapper" style="max-width: 1280px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 48px;">
            <span style="font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #D68E1D; display: block; margin-bottom: 8px;">
                {{ app()->getLocale() === 'vi' ? 'CẨM NANG & TIN TỨC' : 'JOURNAL & BREWING' }}
            </span>
            <h2 style="font-family: 'Cormorant Garamond', Georgia, serif; font-size: clamp(28px, 4vw, 38px); font-weight: 700; color: #2F221A; margin: 0 0 12px 0;">
                {{ app()->getLocale() === 'vi' ? 'Bí Quyết Thưởng Thức Cà Phê Chuẩn Vị' : 'Latest Coffee Guides & Insights' }}
            </h2>
            <div style="width: 44px; height: 2px; background-color: #D68E1D; margin: 0 auto;"></div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px;">
            @foreach($latestPosts as $post)
                <article style="background: #FAF8F5; border-radius: 8px; overflow: hidden; border: 1px solid #EAE2D8; transition: transform 0.2s, box-shadow 0.2s;">
                    @if($post->featured_image)
                        <a href="{{ route('client.blog.show', ['locale' => app()->getLocale(), 'slug' => $post->slug]) }}" style="display: block; overflow: hidden; aspect-ratio: 16/10;">
                            <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" loading="lazy">
                        </a>
                    @endif
                    <div style="padding: 24px;">
                        <span style="font-size: 12px; color: #8C7D73; display: block; margin-bottom: 8px;">
                            📅 {{ $post->published_at ? $post->published_at->format('d/m/Y') : '' }}
                        </span>
                        <h3 style="font-family: 'Cormorant Garamond', Georgia, serif; font-size: 20px; font-weight: 700; color: #2F221A; margin: 0 0 10px 0; line-height: 1.35;">
                            <a href="{{ route('client.blog.show', ['locale' => app()->getLocale(), 'slug' => $post->slug]) }}" style="color: #2F221A; text-decoration: none;">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p style="font-size: 13.5px; color: #6E5F55; line-height: 1.6; margin-bottom: 16px;">
                            {{ Str::limit(strip_tags($post->excerpt ?: $post->content), 100) }}
                        </p>
                        <a href="{{ route('client.blog.show', ['locale' => app()->getLocale(), 'slug' => $post->slug]) }}" style="font-size: 12.5px; font-weight: 700; color: #D68E1D; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px;">
                            {{ app()->getLocale() === 'vi' ? 'Đọc Tiếp' : 'Read Article' }} &rarr;
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- 7. B2B & Wholesale Callout Banner --}}
<section style="background: linear-gradient(135deg, #241A14 0%, #3A291E 100%); color: #FAF6F1; padding: 60px 20px; border-top: 1px solid rgba(214,142,29,0.2);">
    <div class="o-wrapper" style="max-width: 1100px; margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 24px;">
        <div>
            <span style="color: #D68E1D; font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; display: block; margin-bottom: 6px;">
                {{ app()->getLocale() === 'vi' ? 'DÀNH CHO QUÁN CÀ PHÊ & ĐỐI TÁC' : 'FOR CAFES & BUSINESS PARTNERS' }}
            </span>
            <h3 style="font-family: 'Cormorant Garamond', Georgia, serif; font-size: clamp(24px, 3.5vw, 34px); font-weight: 700; color: #FFFFFF !important; margin: 0 0 8px 0;">
                {{ app()->getLocale() === 'vi' ? 'Cung Cấp Cà Phê Giá Sỉ & Giải Pháp Máy Pha Chế' : 'Wholesale Coffee Beans & Commercial Equipment' }}
            </h3>
            <p style="color: #BAADA1 !important; margin: 0; font-size: 14px; max-width: 600px;">
                {{ app()->getLocale() === 'vi' ? 'Chiết khấu hấp dẫn lên tới 40%, hỗ trợ mẫu thử miễn phí và chuyển giao công thức pha chế tối ưu lợi nhuận.' : 'Attractive wholesale tiers up to 40% margin, complimentary sample packs, and customized cafe barista training.' }}
            </p>
        </div>
        <div style="display: flex; gap: 14px; flex-wrap: wrap;">
            <a href="tel:0974933907" style="display: inline-flex; align-items: center; gap: 8px; background-color: #D68E1D; color: #FFFFFF; padding: 13px 26px; border-radius: 4px; font-size: 13px; font-weight: 700; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px;">
                <span>📞 Hotline: 0974.933.907</span>
            </a>
            <a href="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'wholesale']) }}" style="display: inline-flex; align-items: center; background: rgba(255,255,255,0.08); color: #FAF6F1; border: 1px solid rgba(255,255,255,0.3); padding: 13px 26px; border-radius: 4px; font-size: 13px; font-weight: 700; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px;">
                {{ app()->getLocale() === 'vi' ? 'Xem Bảng Giá Sỉ' : 'Wholesale Catalog' }}
            </a>
        </div>
    </div>
</section>
@endsection
