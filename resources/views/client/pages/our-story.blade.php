@extends('client.layouts.app')

@php
    $locale = app()->getLocale();
    $site = app(\App\Services\SiteContentService::class);
    $storyBanner = $site->image('story.hero.banner', asset('client-assets/images/s54/story_hero_heritage.jpg'));
    $canEdit = (bool) (auth()->user()?->canEditClientContent() && auth()->user()->can('media.view'));
@endphp

@section('title', ($locale === 'vi' ? 'Câu Chuyện S54 Coffee — Tinh Hoa Cà Phê Việt & Hành Trình Vươn Tầm' : 'Our Story — S54 Coffee Heritage & Vision'))

@section('content')
{{-- Hero Banner --}}
<section class="s54-page-hero" style="background: radial-gradient(circle at center, rgba(47,34,26,0.85) 0%, rgba(26,18,14,0.96) 100%), url('{{ $storyBanner }}') center/cover no-repeat; padding: 100px 20px 80px; text-align: center; color: #FAF6F1; position: relative;">
    @if($canEdit)
        <div style="position: absolute; top: 16px; right: 20px; z-index: 10;">
            <button type="button" class="s54-edit-banner-trigger" data-block-key="story.hero.banner" data-block-type="image" src="{{ $storyBanner }}" title="Click để thay đổi ảnh nền banner trang Giới thiệu" style="background: rgba(31,41,55,0.9); color: #fff; border: 1px solid rgba(255,255,255,0.3); border-radius: 20px; padding: 6px 14px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; backdrop-filter: blur(4px); box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                <span>📷 Đổi ảnh banner</span>
            </button>
        </div>
    @endif
    <div class="o-wrapper" style="max-width: 960px; margin: 0 auto; position: relative; z-index: 1;">
        <x-client::editable key="story.hero.badge" tag="span" style="display: inline-block; background: rgba(214,142,29,0.25); border: 1px solid #D68E1D; color: #F7D08A; padding: 6px 18px; border-radius: 20px; font-size: 11.5px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 20px;">
            {{ $locale === 'vi' ? 'S54 COFFEE • VIETNAMESE COFFEE. MADE FOR THE WORLD.' : 'S54 COFFEE • VIETNAMESE COFFEE. MADE FOR THE WORLD.' }}
        </x-client::editable>
        <x-client::editable key="story.hero.title" tag="h1" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: clamp(36px, 5.5vw, 56px); font-weight: 700; line-height: 1.2; margin-bottom: 22px; color: #FFFFFF !important;">
            {{ $locale === 'vi' ? 'Hành Trình Tinh Hoa Cà Phê Việt & Sứ Mệnh 54 Dân Tộc' : 'The Vietnamese Coffee Heritage & 54 Ethnic Unity' }}
        </x-client::editable>
        <x-client::editable key="story.hero.lead" tag="p" style="font-size: clamp(15px, 2vw, 17.5px); line-height: 1.7; color: #E5DDD5; max-width: 780px; margin: 0 auto; font-weight: 400;">
            {{ $locale === 'vi' 
                ? 'Tự hào mang tên gọi kết hợp giữa hình ảnh dải đất hình chữ S và 54 dân tộc anh em, S54 Coffee ra đời với sứ mệnh nâng tầm hạt cà phê Robusta và Arabica từ thủ phủ Tây Nguyên vươn tầm quốc tế theo phương châm "New Coffee, New Income".' 
                : 'Named after the S-shaped Vietnamese land and 54 brotherly ethnic groups, S54 Coffee elevates Central Highlands Robusta & Arabica globally under the motto "New Coffee, New Income".' }}
        </x-client::editable>
    </div>
</section>

{{-- Brand Introduction & Official Video --}}
<section style="background-color: #FAF8F5; padding: 80px 20px;">
    <div class="o-wrapper" style="max-width: 1200px; margin: 0 auto;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 48px; align-items: center;">
            <div>
                <x-client::editable key="story.intro.subtitle" tag="span" style="color: #D68E1D; font-size: 12px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; display: block; margin-bottom: 10px;">
                    {{ $locale === 'vi' ? 'GIỚI THIỆU CHUNG' : 'ABOUT S54 COFFEE' }}
                </x-client::editable>
                <x-client::editable key="story.intro.title" tag="h2" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: clamp(28px, 4vw, 38px); font-weight: 700; color: #2F221A; margin-bottom: 20px; line-height: 1.25;">
                    {{ $locale === 'vi' ? 'Cà Phê Nguyên Bản Cho Năng Lượng & Giá Trị Bền Vững' : 'Pure Vietnamese Coffee For Energy & Sustainable Growth' }}
                </x-client::editable>
                <x-client::editable key="story.intro.p1" tag="p" style="color: #5C4A3E; font-size: 15.5px; line-height: 1.8; margin-bottom: 18px;">
                    {{ $locale === 'vi' 
                        ? 'S54 Coffee mang đến những trải nghiệm cà phê nguyên bản, đậm đà—từ các dòng cà phê hòa tan 3in1 tiện lợi đến cà phê hạt rang chất lượng cao, lưu giữ trọn vẹn hương vị mộc mạc của đất trời Tây Nguyên.' 
                        : 'S54 Coffee delivers authentic, rich coffee experiences—from convenient 3-in-1 instant blends to premium roasted whole beans that preserve the true spirit of Central Highlands.' }}
                </x-client::editable>
                <x-client::editable key="story.intro.p2" tag="p" style="color: #5C4A3E; font-size: 15.5px; line-height: 1.8; margin-bottom: 28px;">
                    {{ $locale === 'vi' 
                        ? 'Với phương châm "New Coffee, New Income", S54 Coffee không chỉ cung cấp nguồn năng lượng tỉnh táo, sáng tạo mỗi ngày mà còn hướng tới xây dựng giá trị phát triển bền vững và cơ hội thu nhập cho cộng đồng.' 
                        : 'With our core motto "New Coffee, New Income", S54 Coffee empowers daily creative energy while creating sustainable economic opportunities for our farming community.' }}
                </x-client::editable>
                <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                    <a href="{{ route('client.catalog.index', ['locale' => $locale]) }}" style="background-color: #2F221A; color: #FAF6F1; padding: 12px 28px; border-radius: 4px; font-size: 12.5px; font-weight: 700; text-transform: uppercase; text-decoration: none; letter-spacing: 1px;">
                        {{ $locale === 'vi' ? 'Khám Phá Sản Phẩm' : 'Explore Products' }}
                    </a>
                </div>
            </div>

            {{-- Video Frame --}}
            <div style="background: #FFFFFF; padding: 12px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
                <x-client::editable-video
                    key="story.intro.video"
                    title="Video Giới Thiệu S54 Coffee"
                    default-url="https://www.youtube.com/embed/7PB6Tn2pyE8"
                    aspect-ratio="56.25%"
                    border-radius="8px"
                />
            </div>
        </div>
    </div>
</section>

{{-- Vision, Mission, Core Values Section --}}
<section style="background-color: #241A14; color: #FAF6F1; padding: 90px 20px;">
    <div class="o-wrapper" style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 60px;">
            <x-client::editable key="story.pillars.subtitle" tag="span" style="color: #D68E1D !important; font-size: 12px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 12px;">
                {{ $locale === 'vi' ? 'ĐỊNH HƯỚNG CHIẾN LƯỢC' : 'STRATEGIC PILLARS' }}
            </x-client::editable>
            <x-client::editable key="story.pillars.title" tag="h2" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: clamp(32px, 4.5vw, 44px); font-weight: 700; color: #FFFFFF !important;">
                {{ $locale === 'vi' ? 'Tầm Nhìn • Sứ Mệnh • Giá Trị Cốt Lõi' : 'Vision • Mission • Core Values' }}
            </x-client::editable>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 32px;">
            {{-- Vision Card --}}
            <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(214,142,29,0.3); border-radius: 12px; padding: 36px 28px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="width: 50px; height: 50px; background: rgba(214,142,29,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #D68E1D; font-size: 22px; margin-bottom: 20px;">
                        👁️
                    </div>
                    <x-client::editable key="story.vision.title" tag="h3" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 26px; font-weight: 700; color: #FAF6F1 !important; margin-bottom: 14px;">
                        {{ $locale === 'vi' ? 'Tầm Nhìn' : 'Our Vision' }}
                    </x-client::editable>
                    <x-client::editable key="story.vision.desc" tag="p" style="color: #D6C7BC !important; font-size: 15px; line-height: 1.7; margin-bottom: 24px;">
                        {{ $locale === 'vi' 
                            ? 'Trở thành thương hiệu cà phê Việt uy tín, vươn tầm quốc tế với các dòng sản phẩm chất lượng cao và sáng tạo.' 
                            : 'To become a globally prestigious Vietnamese coffee brand renowned for quality and innovation.' }}
                    </x-client::editable>
                </div>
                <x-client::editable-video
                    key="story.vision.video"
                    title="Video Tầm Nhìn Chiến Lược"
                    default-url="https://www.youtube.com/embed/8nVnuZSauE8"
                    aspect-ratio="56.25%"
                    border-radius="8px"
                />
            </div>

            {{-- Mission Card --}}
            <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(214,142,29,0.3); border-radius: 12px; padding: 36px 28px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="width: 50px; height: 50px; background: rgba(214,142,29,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #D68E1D; font-size: 22px; margin-bottom: 20px;">
                        🚀
                    </div>
                    <x-client::editable key="story.mission.title" tag="h3" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 26px; font-weight: 700; color: #FAF6F1 !important; margin-bottom: 14px;">
                        {{ $locale === 'vi' ? 'Sứ Mệnh' : 'Our Mission' }}
                    </x-client::editable>
                    <x-client::editable key="story.mission.desc" tag="p" style="color: #D6C7BC !important; font-size: 15px; line-height: 1.7; margin-bottom: 24px;">
                        {{ $locale === 'vi' 
                            ? 'Mang đến tách cà phê chuẩn vị, truyền năng lượng tích cực và tạo dựng thu nhập bền vững cho cộng đồng (New Coffee, New Income).' 
                            : 'Delivering authentic coffee, inspiring positive energy, and creating sustainable incomes.' }}
                    </x-client::editable>
                </div>
                <x-client::editable-video
                    key="story.mission.video"
                    title="Video Sứ Mệnh S54 Coffee"
                    default-url="https://www.youtube.com/embed/bIC2_Dko3xk"
                    aspect-ratio="56.25%"
                    border-radius="8px"
                />
            </div>

            {{-- Core Values Card --}}
            <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(214,142,29,0.3); border-radius: 12px; padding: 36px 28px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="width: 50px; height: 50px; background: rgba(214,142,29,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #D68E1D; font-size: 22px; margin-bottom: 20px;">
                        💎
                    </div>
                    <x-client::editable key="story.values.title" tag="h3" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 26px; font-weight: 700; color: #FAF6F1 !important; margin-bottom: 14px;">
                        {{ $locale === 'vi' ? 'Giá Trị Cốt Lõi' : 'Core Values' }}
                    </x-client::editable>
                    <x-client::editable key="story.values.desc" tag="div" style="color: #D6C7BC !important; font-size: 15px; line-height: 1.8; margin-bottom: 24px;" html>
                        <strong style="color: #F7D08A;">• Trung thực:</strong> {{ $locale === 'vi' ? 'Minh bạch nguồn gốc và chất lượng.' : 'Transparent origin & quality.' }}<br>
                        <strong style="color: #F7D08A;">• Chất lượng:</strong> {{ $locale === 'vi' ? 'Chuẩn vị nguyên bản từng mẻ rang.' : 'Authentic taste in every batch.' }}<br>
                        <strong style="color: #F7D08A;">• Cải tiến:</strong> {{ $locale === 'vi' ? 'Ứng dụng công nghệ hiện đại.' : 'Continuous product innovation.' }}<br>
                        <strong style="color: #F7D08A;">• Đồng hành:</strong> {{ $locale === 'vi' ? 'Cùng phát triển bền vững.' : 'Growing together with community.' }}
                    </x-client::editable>
                </div>
                <x-client::editable-video
                    key="story.values.video"
                    title="Video Giá Trị Cốt Lõi"
                    default-url="https://www.youtube.com/embed/T8MfqRZlsFo"
                    aspect-ratio="56.25%"
                    border-radius="8px"
                />
            </div>
        </div>
    </div>
</section>

{{-- Milestones Journey Section --}}
<section class="c-stories" style="background-color: #FAF8F5; padding: 90px 20px;">
    <div class="o-wrapper" style="max-width: 1100px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 60px;">
            <span style="color: #D68E1D; font-size: 12px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 12px;">
                {{ $locale === 'vi' ? 'HÀNH TRÌNH PHÁT TRIỂN' : 'OUR DEVELOPMENT MILESTONES' }}
            </span>
            <h2 style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: clamp(32px, 4.5vw, 44px); font-weight: 700; color: #2F221A;">
                {{ $locale === 'vi' ? 'Các Cột Mốc Đột Phá Của S54 Coffee' : 'Key Breakthrough Milestones' }}
            </h2>
        </div>

        <div class="c-stories__story">
            {{-- Milestone 1 --}}
            <div class="c-stories__story-block">
                <div class="c-stories__story-block-image">
                    <x-client::editable-image key="story.milestone.1.image" src="{{ asset('client-assets/images/s54/story_farm_origin.jpg') }}" alt="Nghiên cứu & phát triển cà phê S54" loading="lazy" style="border-radius: 8px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); width: 100%; height: auto;" />
                </div>
                <div class="c-stories__story-block-text">
                    <div class="c-stories__story-block-year">Cột Mốc 1</div>
                    <h3 class="c-stories__story-block-title">
                        {{ $locale === 'vi' ? 'Nghiên Cứu & Phát Triển Chuẩn Vị Tây Nguyên' : 'R&D and Authentic Taste Formulation' }}
                    </h3>
                    <p class="c-stories__story-block-body">
                        {{ $locale === 'vi' 
                            ? 'Nghiên cứu và phát triển thành công dòng sản phẩm cà phê hòa tan 3in1 tiện lợi & cà phê hạt rang chất lượng cao chuẩn vị thủ phủ Tây Nguyên.' 
                            : 'Successfully formulated authentic instant 3-in-1 and premium roasted whole beans from Central Highlands.' }}
                    </p>
                </div>
            </div>

            {{-- Milestone 2 --}}
            <div class="c-stories__story-block is-reversed">
                <div class="c-stories__story-block-image">
                    <x-client::editable-image key="story.milestone.2.image" src="{{ asset('client-assets/images/s54/s54_cafe_nhabe_1.jpg') }}" alt="Mở rộng hệ thống phân phối S54 Coffee" loading="lazy" style="border-radius: 8px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); width: 100%; height: auto;" />
                </div>
                <div class="c-stories__story-block-text">
                    <div class="c-stories__story-block-year">Cột Mốc 2</div>
                    <h3 class="c-stories__story-block-title">
                        {{ $locale === 'vi' ? 'Mở Rộng Hệ Thống Phân Phối & Lan Tỏa Thương Hiệu' : 'Expanding Distribution & Brand Outreach' }}
                    </h3>
                    <p class="c-stories__story-block-body">
                        {{ $locale === 'vi' 
                            ? 'Mở rộng hệ thống phân phối, phát triển chuỗi cửa hàng trải nghiệm và định hình thông điệp thương hiệu S54 Coffee "New Coffee, New Income".' 
                            : 'Expanded commercial distribution networks and established the brand message "New Coffee, New Income".' }}
                    </p>
                </div>
            </div>

            {{-- Milestone 3 --}}
            <div class="c-stories__story-block">
                <div class="c-stories__story-block-image">
                    <x-client::editable-image key="story.milestone.3.image" src="{{ asset('client-assets/images/s54/s54_office_vinhome_2.jpg') }}" alt="Số hóa thương hiệu S54 Coffee" loading="lazy" style="border-radius: 8px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); width: 100%; height: auto;" />
                </div>
                <div class="c-stories__story-block-text">
                    <div class="c-stories__story-block-year">Cột Mốc 3</div>
                    <h3 class="c-stories__story-block-title">
                        {{ $locale === 'vi' ? 'Số Hóa Thương Hiệu & Nền Tảng Đa Kênh Hiện Đại' : 'Digital Transformation & Omnichannel Commerce' }}
                    </h3>
                    <p class="c-stories__story-block-body">
                        {{ $locale === 'vi' 
                            ? 'Số hóa toàn diện thương hiệu, hoàn thiện website bán hàng chuyên nghiệp, tích hợp Core Admin quản trị hiện đại và mở rộng kết nối đối tác quốc tế.' 
                            : 'Fully digitized brand operations with a professional e-commerce platform and modern Core Admin backend.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Real Office & Coffee Shop Gallery --}}
<section style="background-color: #F3EEE8; padding: 80px 20px;">
    <div class="o-wrapper" style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 48px;">
            <span style="color: #D68E1D; font-size: 12px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 10px;">
                {{ $locale === 'vi' ? 'HỆ THỐNG VĂN PHÒNG & CỬA HÀNG THỰC TẾ' : 'OUR OFFICES & COFFEE SHOPS' }}
            </span>
            <h2 style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: clamp(28px, 4vw, 38px); font-weight: 700; color: #2F221A;">
                {{ $locale === 'vi' ? 'Không Gian Trải Nghiệm S54 Coffee' : 'Experience S54 Coffee Spaces' }}
            </h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
            <div style="background: #FFFFFF; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06);">
                <x-client::editable-image key="story.gallery.1.image" src="{{ asset('client-assets/images/s54/s54_office_vinhome_1.jpg') }}" alt="Văn phòng S54 Coffee Vinhomes Grand Park" style="width: 100%; height: 240px; object-fit: cover;" />
                <div style="padding: 16px 20px;">
                    <strong style="color: #2F221A; font-size: 14.5px; display: block; margin-bottom: 4px;">Văn Phòng S54 Coffee</strong>
                    <span style="color: #8A7B70; font-size: 13px;">The Manhattan, Vinhomes Grand Park, TP. Thủ Đức</span>
                </div>
            </div>

            <div style="background: #FFFFFF; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06);">
                <x-client::editable-image key="story.gallery.2.image" src="{{ asset('client-assets/images/s54/s54_office_vinhome_3.jpg') }}" alt="Khu làm việc S54 Coffee" style="width: 100%; height: 240px; object-fit: cover;" />
                <div style="padding: 16px 20px;">
                    <strong style="color: #2F221A; font-size: 14.5px; display: block; margin-bottom: 4px;">Trụ Sở Điều Hành</strong>
                    <span style="color: #8A7B70; font-size: 13px;">Không gian làm việc sáng tạo & đào tạo barista</span>
                </div>
            </div>

            <div style="background: #FFFFFF; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06);">
                <x-client::editable-image key="story.gallery.3.image" src="{{ asset('client-assets/images/s54/s54_cafe_nhabe_2.jpg') }}" alt="Quán Cafe S54 tại Nhà Bè" style="width: 100%; height: 240px; object-fit: cover;" />
                <div style="padding: 16px 20px;">
                    <strong style="color: #2F221A; font-size: 14.5px; display: block; margin-bottom: 4px;">Quán Cafe S54 Coffee</strong>
                    <span style="color: #8A7B70; font-size: 13px;">Điểm trải nghiệm cà phê nguyên bản tại Nhà Bè, TP.HCM</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Final Quote & CTA --}}
<section style="background-color: #241A14; color: #FAF6F1; padding: 80px 20px; text-align: center;">
    <div class="o-wrapper" style="max-width: 860px; margin: 0 auto;">
        <span style="color: #D68E1D; font-size: 42px; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; display: block; line-height: 1;">“</span>
        <blockquote style="margin: 0 0 20px 0;">
            <x-client::editable key="story.quote.text" tag="p" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: clamp(22px, 3.5vw, 32px); font-style: italic; line-height: 1.4; color: #FAF6F1 !important; margin: 0;">
                {{ $locale === 'vi' 
                    ? 'Thiết lập các giải pháp tốt trong việc cung cấp Cà phê Chất lượng với mức độ dịch vụ không ai sánh kịp.' 
                    : 'Establishing premier solutions in delivering Quality Coffee with unparalleled standards of service.' }}
            </x-client::editable>
        </blockquote>
        <cite style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #D68E1D; font-style: normal; display: block; margin-bottom: 36px;">
            — <x-client::editable key="story.quote.author" tag="span">{{ $locale === 'vi' ? 'Triết lý Good Solutions & S54 Coffee' : 'Good Solutions & S54 Coffee Philosophy' }}</x-client::editable>
        </cite>
        <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
            <a href="{{ route('client.catalog.index', ['locale' => $locale]) }}" style="background-color: #D68E1D; color: #FFFFFF; padding: 14px 32px; border-radius: 4px; font-size: 13px; font-weight: 700; text-transform: uppercase; text-decoration: none; letter-spacing: 1px;">
                {{ $locale === 'vi' ? 'Mua Cà Phê Ngay' : 'Shop Coffee' }}
            </a>
            <a href="{{ route('client.pages.show', ['locale' => $locale, 'slug' => 'wholesale']) }}" style="background: transparent; color: #FAF6F1; border: 1.5px solid #FAF6F1; padding: 14px 32px; border-radius: 4px; font-size: 13px; font-weight: 700; text-transform: uppercase; text-decoration: none; letter-spacing: 1px;">
                {{ $locale === 'vi' ? 'Hợp Tác Doanh Nghiệp' : 'Wholesale Inquiry' }}
            </a>
        </div>
    </div>
</section>
@endsection
