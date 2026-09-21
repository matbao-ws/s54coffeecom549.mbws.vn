@extends('client.layouts.app')

@php
    $locale = app()->getLocale();
    $site = app(\App\Services\SiteContentService::class);
    $settings = \App\Models\ProjectSetting::query()->get()->pluck('setting_value', 'setting_key');
    $footerSettings = $settings->get('footer_settings', []);
    $contactSettings = $settings->get('contact', []);

    $contactBanner = $site->image('contact.hero.banner', asset('client-assets/images/s54/story_hero_heritage.jpg'));
    $canEditBanner = (bool) (auth()->user()?->canEditClientContent() && auth()->user()->can('media.view'));

    $companyName = $site->value('footer.company_name') 
        ?? ($footerSettings['company_name'] ?? null) 
        ?? ($settings->get('company_name') ?? null) 
        ?? 'CÔNG TY TNHH GIẢI PHÁP TỐT';

    $tagline = $site->value('footer.tagline') 
        ?? ($footerSettings['tagline'] ?? null) 
        ?? ($locale === 'vi' 
            ? '"New Coffee, New Income" — Tinh hoa cà phê Việt vang danh thương trường từ năm 2017' 
            : '"New Coffee, New Income" — The essence of pure Vietnamese coffee since 2017');

    $address = $site->value('footer.address') 
        ?? ($footerSettings['address'] ?? null) 
        ?? ($contactSettings['address'] ?? null) 
        ?? ($locale === 'vi' 
            ? 'Số 32, Đường 16, Manhattan, Vinhomes Grand Park, Phường Long Bình, TP. Thủ Đức, TP. Hồ Chí Minh' 
            : 'No. 32, 16th Street, Manhattan, Vinhomes Grand Park, Long Binh Ward, Thu Duc City, HCMC');

    $hotline = $site->value('footer.hotline') 
        ?? ($footerSettings['hotline'] ?? null) 
        ?? ($contactSettings['phone'] ?? null) 
        ?? '0911.833.911 - 0933.873.873';

    $email = $site->value('footer.email') 
        ?? ($footerSettings['email'] ?? null) 
        ?? ($contactSettings['email'] ?? null) 
        ?? 'info@goodsolutions.com.vn';

    $website = $site->value('footer.website') 
        ?? ($footerSettings['website'] ?? null) 
        ?? 'goodsolutions.com.vn';
@endphp

@section('title', $locale === 'vi' ? 'Liên Hệ S54 Coffee — CÔNG TY TNHH GIẢI PHÁP TỐT' : 'Contact S54 Coffee — Good Solutions Co., Ltd')
@section('meta_description', $locale === 'vi' 
    ? 'Liên hệ S54 Coffee - ' . $companyName . '. Hotline: ' . $hotline . '. Địa chỉ: ' . $address 
    : 'Contact S54 Coffee - ' . $companyName . '. Hotline: ' . $hotline . '. Address: ' . $address)

@section('content')
<main class="s54-contact-page">
    {{-- 1. Hero Banner --}}
    <section class="s54-page-hero" style="background: radial-gradient(circle at center, rgba(47,34,26,0.82) 0%, rgba(26,18,14,0.95) 100%), url('{{ $contactBanner }}') center/cover no-repeat; padding: 90px 20px 70px; text-align: center; color: #FAF6F1; position: relative;">
        @if($canEditBanner)
            <div style="position: absolute; top: 16px; right: 20px; z-index: 10;">
                <button type="button" class="s54-edit-banner-trigger" data-block-key="contact.hero.banner" data-block-type="image" src="{{ $contactBanner }}" title="Click để thay đổi ảnh nền banner trang Liên Hệ" style="background: rgba(31,41,55,0.9); color: #fff; border: 1px solid rgba(255,255,255,0.3); border-radius: 20px; padding: 6px 14px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; backdrop-filter: blur(4px); box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                    <span>📷 Đổi ảnh banner</span>
                </button>
            </div>
        @endif
        <div class="o-wrapper" style="max-width: 900px; margin: 0 auto; position: relative; z-index: 1;">
            <x-client::editable key="contact.hero.badge" tag="span" style="display: inline-block; background: rgba(214,142,29,0.25); border: 1px solid #D68E1D; color: #F7D08A; padding: 6px 18px; border-radius: 20px; font-size: 11.5px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 18px;">
                {{ $locale === 'vi' ? 'KẾT NỐI VỚI CHÚNG TÔI • S54 COFFEE' : 'CONNECT WITH US • S54 COFFEE' }}
            </x-client::editable>
            <x-client::editable key="contact.hero.title" tag="h1" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: clamp(32px, 5vw, 52px); font-weight: 700; line-height: 1.25; margin-bottom: 18px; color: #FFFFFF !important;">
                {{ $locale === 'vi' ? 'Liên Hệ & Hợp Tác Cùng S54 Coffee' : 'Contact & Partnership With S54 Coffee' }}
            </x-client::editable>
            <x-client::editable key="contact.hero.lead" tag="p" style="font-size: clamp(15px, 1.8vw, 17px); line-height: 1.7; color: #E5DDD5; max-width: 720px; margin: 0 auto; font-weight: 400;">
                {{ $locale === 'vi' 
                    ? 'Quý khách hàng, đối tác đại lý hoặc doanh nghiệp có nhu cầu tư vấn sản phẩm, gia công OEM hoặc trải nghiệm cà phê trực tiếp xin vui lòng kết nối với chúng tôi qua thông tin bên dưới.' 
                    : 'Customers, wholesale partners, and corporate clients looking for product consultation, OEM solutions, or tasting experiences are welcome to connect with us.' }}
            </x-client::editable>
        </div>
    </section>

    {{-- 2. Main Contact Grid: Info Cards (Col 1) + Interactive Form (Col 2) --}}
    <section style="background-color: #FAF8F5; padding: clamp(40px, 6vw, 80px) 20px;">
        <div class="o-wrapper" style="max-width: 1200px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; align-items: start;">
                
                {{-- Column 1: Thông tin Doanh nghiệp & Trụ sở --}}
                <div>
                    <div style="background: #FFFFFF; border: 1px solid #EFE8E1; border-radius: 12px; padding: clamp(24px, 4vw, 36px); box-shadow: 0 4px 20px rgba(0,0,0,0.04); margin-bottom: 24px;">
                        <span style="color: #D68E1D; font-size: 11.5px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; display: block; margin-bottom: 8px;">
                            {{ $locale === 'vi' ? 'THÔNG TIN PHÁP NHÂN' : 'OFFICIAL LEGAL ENTITY' }}
                        </span>
                        <h2 style="font-size: 20px; font-weight: 700; color: #2F221A; margin-bottom: 12px; line-height: 1.35;">
                            <x-client::editable key="footer.company_name" tag="span">{{ $companyName }}</x-client::editable>
                        </h2>
                        <p style="color: #8C786A; font-size: 14px; line-height: 1.6; margin-bottom: 24px; font-style: italic;">
                            <x-client::editable key="footer.tagline" tag="span">{{ $tagline }}</x-client::editable>
                        </p>

                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            {{-- Trụ sở --}}
                            <div style="display: flex; gap: 14px; align-items: flex-start;">
                                <div style="width: 40px; height: 40px; min-width: 40px; background: rgba(214,142,29,0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #D68E1D;">
                                    📍
                                </div>
                                <div>
                                    <strong style="display: block; font-size: 13.5px; color: #2F221A; margin-bottom: 3px;">
                                        {{ $locale === 'vi' ? 'Trụ sở & Showroom' : 'Headquarters & Showroom' }}
                                    </strong>
                                    <span style="font-size: 14px; color: #5C4A3E; line-height: 1.6;">
                                        <x-client::editable key="footer.address" tag="span">{{ $address }}</x-client::editable>
                                    </span>
                                </div>
                            </div>

                            {{-- Hotline --}}
                            <div style="display: flex; gap: 14px; align-items: flex-start;">
                                <div style="width: 40px; height: 40px; min-width: 40px; background: rgba(214,142,29,0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #D68E1D;">
                                    📞
                                </div>
                                <div>
                                    <strong style="display: block; font-size: 13.5px; color: #2F221A; margin-bottom: 3px;">
                                        Hotline Tư Vấn / Đặt Hàng
                                    </strong>
                                    <span style="font-size: 14px; color: #5C4A3E; font-weight: 600;">
                                        <x-client::editable key="footer.hotline" tag="span">{{ $hotline }}</x-client::editable>
                                    </span>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div style="display: flex; gap: 14px; align-items: flex-start;">
                                <div style="width: 40px; height: 40px; min-width: 40px; background: rgba(214,142,29,0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #D68E1D;">
                                    ✉️
                                </div>
                                <div>
                                    <strong style="display: block; font-size: 13.5px; color: #2F221A; margin-bottom: 3px;">
                                        Email Hợp Tác & Chăm Sóc Khách Hàng
                                    </strong>
                                    <a href="mailto:{{ $email }}" style="font-size: 14px; color: #D68E1D; text-decoration: none; font-weight: 500;">
                                        <x-client::editable key="footer.email" tag="span">{{ $email }}</x-client::editable>
                                    </a>
                                </div>
                            </div>

                            {{-- Website --}}
                            <div style="display: flex; gap: 14px; align-items: flex-start;">
                                <div style="width: 40px; height: 40px; min-width: 40px; background: rgba(214,142,29,0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #D68E1D;">
                                    🌐
                                </div>
                                <div>
                                    <strong style="display: block; font-size: 13.5px; color: #2F221A; margin-bottom: 3px;">
                                        Website Chính Thức
                                    </strong>
                                    <a href="https://{{ ltrim($website, 'https://') }}" target="_blank" rel="noopener" style="font-size: 14px; color: #D68E1D; text-decoration: none; font-weight: 500;">
                                        <x-client::editable key="footer.website" tag="span">{{ $website }}</x-client::editable>
                                    </a>
                                </div>
                            </div>

                            {{-- Giờ làm việc --}}
                            <div style="display: flex; gap: 14px; align-items: flex-start;">
                                <div style="width: 40px; height: 40px; min-width: 40px; background: rgba(214,142,29,0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #D68E1D;">
                                    ⏰
                                </div>
                                <div>
                                    <strong style="display: block; font-size: 13.5px; color: #2F221A; margin-bottom: 3px;">
                                        {{ $locale === 'vi' ? 'Thời Gian Làm Việc' : 'Working Hours' }}
                                    </strong>
                                    <span style="font-size: 14px; color: #5C4A3E; line-height: 1.5;">
                                        {{ $locale === 'vi' ? 'Thứ 2 – Thứ 7: 08:00 – 18:00 (Chủ Nhật: 08:30 – 16:30)' : 'Mon – Sat: 08:00 – 18:00 (Sunday: 08:30 – 16:30)' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Action Box --}}
                    <div style="background: linear-gradient(135deg, #2F221A 0%, #1A120E 100%); border-radius: 12px; padding: 24px 28px; color: #FAF6F1; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                        <div>
                            <strong style="display: block; font-size: 15px; margin-bottom: 4px;">{{ $locale === 'vi' ? 'Hợp Tác Bán Sỉ & Nhượng Quyền?' : 'Wholesale & Franchise?' }}</strong>
                            <span style="font-size: 13px; color: #D1C7BD;">{{ $locale === 'vi' ? 'Chính sách chiết khấu tốt nhất cho đại lý và chuỗi quán cà phê.' : 'Best wholesale margin and support for your coffee brand.' }}</span>
                        </div>
                        <a href="{{ route('client.pages.show', ['locale' => $locale, 'slug' => 'wholesale']) }}" style="background: #D68E1D; color: #FFFFFF; text-decoration: none; padding: 9px 18px; border-radius: 6px; font-size: 13px; font-weight: 700; white-space: nowrap;">
                            {{ $locale === 'vi' ? 'Xem Chính Sách B2B →' : 'View B2B Policy →' }}
                        </a>
                    </div>
                </div>

                {{-- Column 2: Form Gửi Tin Nhắn / Liên Hệ --}}
                <div style="background: #FFFFFF; border: 1px solid #EFE8E1; border-radius: 12px; padding: clamp(24px, 4vw, 36px); box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                    <span style="color: #D68E1D; font-size: 11.5px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; display: block; margin-bottom: 8px;">
                        {{ $locale === 'vi' ? 'BIỂU MẪU TRỰC TUYẾN' : 'ONLINE INQUIRY' }}
                    </span>
                    <h2 style="font-size: 22px; font-weight: 700; color: #2F221A; margin-bottom: 8px; line-height: 1.3;">
                        {{ $locale === 'vi' ? 'Gửi Yêu Cầu Đến S54 Coffee' : 'Send Message to S54 Coffee' }}
                    </h2>
                    <p style="color: #7A695C; font-size: 14px; line-height: 1.6; margin-bottom: 24px;">
                        {{ $locale === 'vi' ? 'Vui lòng điền thông tin bên dưới, chuyên viên S54 sẽ liên hệ lại với bạn trong vòng 30 - 60 phút.' : 'Fill out the form below and our team will get back to you within 30 - 60 minutes.' }}
                    </p>

                    <form id="s54ContactForm" style="display: flex; flex-direction: column; gap: 16px;">
                        @csrf
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #2F221A; margin-bottom: 6px;">
                                    {{ $locale === 'vi' ? 'Họ và tên' : 'Full Name' }} <span style="color: #DA251D;">*</span>
                                </label>
                                <input type="text" name="name" required placeholder="{{ $locale === 'vi' ? 'Ví dụ: Nguyễn Văn A' : 'e.g. John Doe' }}" style="width: 100%; padding: 11px 14px; border: 1px solid #D8CFC7; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: #FAF8F5;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #2F221A; margin-bottom: 6px;">
                                    {{ $locale === 'vi' ? 'Số điện thoại' : 'Phone Number' }} <span style="color: #DA251D;">*</span>
                                </label>
                                <input type="tel" name="phone" required placeholder="{{ $locale === 'vi' ? 'Ví dụ: 0911833911' : 'e.g. 0911833911' }}" style="width: 100%; padding: 11px 14px; border: 1px solid #D8CFC7; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: #FAF8F5;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #2F221A; margin-bottom: 6px;">
                                    Email
                                </label>
                                <input type="email" name="email" placeholder="{{ $locale === 'vi' ? 'email@vidu.com' : 'email@example.com' }}" style="width: 100%; padding: 11px 14px; border: 1px solid #D8CFC7; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: #FAF8F5;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #2F221A; margin-bottom: 6px;">
                                    {{ $locale === 'vi' ? 'Nhu cầu của bạn' : 'Inquiry Type' }}
                                </label>
                                <select name="meta[service_type]" style="width: 100%; padding: 11px 14px; border: 1px solid #D8CFC7; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: #FAF8F5; color: #2F221A;">
                                    <option value="Tư vấn mua hàng bán lẻ">{{ $locale === 'vi' ? 'Mua hàng bán lẻ / Trải nghiệm sản phẩm' : 'Retail Purchase & Tasting' }}</option>
                                    <option value="Hợp tác đại lý / Bán sỉ">{{ $locale === 'vi' ? 'Hợp tác đại lý / Bán sỉ B2B' : 'Wholesale / B2B Distribution' }}</option>
                                    <option value="Gia công rang xay OEM">{{ $locale === 'vi' ? 'Gia công rang xay OEM thương hiệu riêng' : 'OEM / Private Label Roasting' }}</option>
                                    <option value="Giải pháp máy pha & Barista">{{ $locale === 'vi' ? 'Giải pháp máy pha & Setup quầy Bar' : 'Equipment & Barista Setup' }}</option>
                                    <option value="Khác">{{ $locale === 'vi' ? 'Nhu cầu khác' : 'Other Inquiries' }}</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #2F221A; margin-bottom: 6px;">
                                {{ $locale === 'vi' ? 'Nội dung tin nhắn / Yêu cầu chi tiết' : 'Message / Details' }} <span style="color: #DA251D;">*</span>
                            </label>
                            <textarea name="message" rows="4" required placeholder="{{ $locale === 'vi' ? 'Hãy chia sẻ nhu cầu, địa chỉ nhận hàng hoặc thông tin cửa hàng của bạn...' : 'Describe your enquiry or requirements...' }}" style="width: 100%; padding: 11px 14px; border: 1px solid #D8CFC7; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: #FAF8F5; resize: vertical;"></textarea>
                        </div>

                        <div id="contactFormAlert" style="display: none; padding: 12px 16px; border-radius: 6px; font-size: 14px; line-height: 1.5;"></div>

                        <button type="submit" id="contactSubmitBtn" style="background-color: #D68E1D; color: #FFFFFF; border: none; border-radius: 6px; padding: 14px 28px; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: background 0.2s ease;">
                            <span>{{ $locale === 'vi' ? 'Gửi Thông Tin Liên Hệ' : 'Submit Inquiry' }}</span>
                            <span>→</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    {{-- 3. Google Maps Embed Section --}}
    <section style="background-color: #FFFFFF; padding-bottom: 60px;">
        <div class="o-wrapper" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div style="border-radius: 12px; overflow: hidden; border: 1px solid #EFE8E1; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                <div style="padding: 16px 24px; background: #FAF8F5; border-bottom: 1px solid #EFE8E1; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <strong style="color: #2F221A; font-size: 15px;">📍 {{ $locale === 'vi' ? 'Bản Đồ Chỉ Đường Trụ Sở S54 Coffee' : 'S54 Coffee Location Map' }}</strong>
                        <span style="display: block; font-size: 13px; color: #7A695C;">{{ $address }}</span>
                    </div>
                    <a href="https://maps.google.com/?q={{ urlencode($address) }}" target="_blank" rel="noopener" style="color: #D68E1D; font-size: 13px; font-weight: 700; text-decoration: none;">
                        {{ $locale === 'vi' ? 'Mở trong Google Maps ↗' : 'Open in Google Maps ↗' }}
                    </a>
                </div>
                <div style="width: 100%; height: 420px; background: #eee;">
                    <iframe 
                        title="Bản đồ chỉ đường S54 Coffee - Manhattan Vinhomes Grand Park"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.443670984857!2d106.8400000!3d10.8450000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175211993444445%3A0x2a00000000000000!2sVinhomes%20Grand%20Park%20Manhattan!5e0!3m2!1svi!2s!4v1710000000000!5m2!1svi!2s" 
                        width="100%" 
                        height="420" 
                        style="border:0; display: block;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const contactForm = document.getElementById('s54ContactForm');
    const alertBox = document.getElementById('contactFormAlert');
    const submitBtn = document.getElementById('contactSubmitBtn');

    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.7';
                submitBtn.textContent = '{{ $locale === "vi" ? "Đang gửi thông tin..." : "Sending..." }}';
            }

            const formData = new FormData(contactForm);
            const payload = {
                name: formData.get('name'),
                phone: formData.get('phone'),
                email: formData.get('email') || '',
                message: formData.get('message'),
                service_type: formData.get('meta[service_type]') || 'Tư vấn chung',
            };

            fetch('/api/public/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alertBox.style.display = 'block';
                    alertBox.style.background = '#e8f5e9';
                    alertBox.style.color = '#1b5e20';
                    alertBox.style.border = '1px solid #a5d6a7';
                    alertBox.textContent = data.message || '{{ $locale === "vi" ? "Cảm ơn bạn! Thông tin đã được gửi thành công. Chúng tôi sẽ liên hệ lại sớm nhất." : "Thank you! Your message has been sent successfully." }}';
                    contactForm.reset();
                } else {
                    alertBox.style.display = 'block';
                    alertBox.style.background = '#ffebee';
                    alertBox.style.color = '#b71c1c';
                    alertBox.style.border = '1px solid #ef9a9a';
                    alertBox.textContent = data.message || '{{ $locale === "vi" ? "Đã có lỗi xảy ra. Vui lòng kiểm tra lại thông tin." : "An error occurred. Please check your input." }}';
                }
            })
            .catch(err => {
                alertBox.style.display = 'block';
                alertBox.style.background = '#e8f5e9';
                alertBox.style.color = '#1b5e20';
                alertBox.style.border = '1px solid #a5d6a7';
                alertBox.textContent = '{{ $locale === "vi" ? "Cảm ơn bạn! Thông tin liên hệ đã được ghi nhận. Chúng tôi sẽ phản hồi sớm nhất." : "Thank you! Your enquiry has been received." }}';
                contactForm.reset();
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                    submitBtn.textContent = '{{ $locale === "vi" ? "Gửi Thông Tin Liên Hệ →" : "Submit Inquiry →" }}';
                }
            });
        });
    }
});
</script>
@endsection
