import os
import re

with open('theme/wholesale.html', 'r', encoding='utf-8') as f:
    html = f.read()

# Lines 968 to 2149 contains the exact main wholesale content
start_marker = '<wlm class="wlm-content">'
end_marker = '</wlm>'

start_idx = html.find(start_marker)
end_idx = html.find(end_marker, start_idx)

if start_idx == -1 or end_idx == -1:
    raise Exception("Could not find wholesale content markers in theme/wholesale.html")

raw_body = html[start_idx:end_idx + len(end_marker)]

print(f"Extracted wholesale raw content: {len(raw_body):,} characters, {raw_body.count(chr(10))} lines")

# Transform raw_body:
# 1. Asset paths for CSS
css_files = [
    'sections.hero-banner.css',
    'sections.text-and-image2.css',
    'sections.case-studies.css',
    'sections.testimonial.css',
    'sections.custom-content2.css',
    'sections.contact-form.css'
]
for css in css_files:
    raw_body = raw_body.replace(
        f'href="assets/css/{css}"',
        f'href="{{{{ asset(\'assets/css/{css}\') }}}}?v={{{{ @filemtime(base_path(\'assets/css/{css}\')) ?: 1789299999 }}}}"'
    )

# 2. Asset paths for JS
js_files = [
    '773_sections.case-studies.js',
    '732_sections.testimonial.js',
    '605_sections.contact-form.js'
]
for js in js_files:
    raw_body = raw_body.replace(
        f'src="assets/images/{js}"',
        f'src="{{{{ asset(\'assets/images/{js}\') }}}}?v=1789299999"'
    )

# 3. Video assets in testimonial
raw_body = raw_body.replace(
    'poster="assets/images/590_9082be5215a852be1026974487789ffc_2000x.png"',
    'poster="{{ asset(\'assets/images/590_9082be5215a852be1026974487789ffc_2000x.png\') }}"'
)
raw_body = raw_body.replace(
    'poster="assets/images/784_9082be5215a852be1026974487789ffc_750x.png"',
    'poster="{{ asset(\'assets/images/784_9082be5215a852be1026974487789ffc_750x.png\') }}"'
)
raw_body = raw_body.replace(
    '<source src="assets/images/695_1616455d94684594acbf7eb51378dc5c.HD-720p-1.6Mbps-11675358.mp4" type="video/mp4">',
    '<source src="{{ asset(\'assets/images/695_1616455d94684594acbf7eb51378dc5c.HD-720p-1.6Mbps-11675358.mp4\') }}" type="video/mp4">'
)
raw_body = raw_body.replace(
    '<source src="assets/images/587_5f62561f2b974655a55d5d351833f56e.HD-1080p-3.3Mbps-27388133.mp4" type="video/mp4">',
    '<source src="{{ asset(\'assets/images/587_5f62561f2b974655a55d5d351833f56e.HD-1080p-3.3Mbps-27388133.mp4\') }}" type="video/mp4">'
)

# 4. Replace each picture carefully
# Hero Banner pictures (desktop & mobile)
hero_pic_pattern = re.compile(
    r'<picture>.*?assets/images/785_1-wholesale-page-banner-desktop-2_2560x\.jpg.*?</picture>\s*<picture>.*?assets/images/666_1-wholesale-page-banner-mobile-3_1x\.jpg.*?</picture>',
    re.DOTALL
)
hero_replacement = '''<x-client::editable-image key="wholesale.hero.banner" src="{{ asset('assets/images/785_1-wholesale-page-banner-desktop-2_2560x.jpg') }}" alt="S54 Coffee B2B Wholesale Solutions" class="c-hero-banner__media o-media" style="width: 100%; height: 100%; object-fit: cover;" />'''
raw_body, count = hero_pic_pattern.subn(hero_replacement, raw_body, count=1)
print(f"Hero banner replacement: {count}")

# Arch picture (LA_V_92)
arch_pic_pattern = re.compile(r'<picture>.*?assets/images/667_LA_V_92_RGB_1_1141x\.jpg.*?</picture>', re.DOTALL)
arch_replacement = '''<x-client::editable-image key="wholesale.intro.image" src="{{ asset('assets/images/667_LA_V_92_RGB_1_1141x.jpg') }}" alt="Chương Trình Đối Tác & Đại Lý Cà Phê S54" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" />'''
raw_body, count = arch_pic_pattern.subn(arch_replacement, raw_body, count=1)
print(f"Arch image replacement: {count}")

# Coffee picture (our-coffee-3)
coffee_pic_pattern = re.compile(r'<picture>.*?assets/images/604_3-wholesale-image-our-coffee-3_746x\.png.*?</picture>', re.DOTALL)
coffee_replacement = '''<x-client::editable-image key="wholesale.coffee.image" src="{{ asset('assets/images/604_3-wholesale-image-our-coffee-3_746x.png') }}" alt="Nguồn Cà Phê Nguyên Chất S54" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" />'''
raw_body, count = coffee_pic_pattern.subn(coffee_replacement, raw_body, count=1)
print(f"Coffee image replacement: {count}")

# Case studies pictures:
# Case 1: L'Americano
case1_pic_pattern = re.compile(r'<picture>.*?assets/images/586_feb206e33c8cb0b0034447b6bcc44c75\.jpg.*?</picture>', re.DOTALL)
case1_replacement = '''<x-client::editable-image key="wholesale.case1.image" src="{{ asset('assets/images/586_feb206e33c8cb0b0034447b6bcc44c75.jpg') }}" alt="L'Americano Espresso Bar" class="o-article-tile__image" style="width: 100%; height: 100%; object-fit: cover;" />'''
raw_body, count = case1_pic_pattern.subn(case1_replacement, raw_body, count=1)
print(f"Case 1 replacement: {count}")

# Case 2: Bobbin Head Bakery
case2_pic_pattern = re.compile(r'<picture>.*?assets/images/598_50f6f9f3160ce6aa271e4b01d03d3200\.jpg.*?</picture>', re.DOTALL)
case2_replacement = '''<x-client::editable-image key="wholesale.case2.image" src="{{ asset('assets/images/598_50f6f9f3160ce6aa271e4b01d03d3200.jpg') }}" alt="Bobbin Head Bakery" class="o-article-tile__image" style="width: 100%; height: 100%; object-fit: cover;" />'''
raw_body, count = case2_pic_pattern.subn(case2_replacement, raw_body, count=1)
print(f"Case 2 replacement: {count}")

# Case 3: ELS Cafe
case3_pic_pattern = re.compile(r'<picture>.*?assets/images/555_cafe-els-banner_3499b450-717a-4175-a177-9c64e9e9194d_1024x\.jpg.*?</picture>', re.DOTALL)
case3_replacement = '''<x-client::editable-image key="wholesale.case3.image" src="{{ asset('assets/images/555_cafe-els-banner_3499b450-717a-4175-a177-9c64e9e9194d_1024x.jpg') }}" alt="ELS Cafe & Bar" class="o-article-tile__image" style="width: 100%; height: 100%; object-fit: cover;" />'''
raw_body, count = case3_pic_pattern.subn(case3_replacement, raw_body, count=1)
print(f"Case 3 replacement: {count}")

# Barista Training pictures (desktop & mobile)
training_pic_pattern = re.compile(
    r'<picture>.*?assets/images/660_5-wholesale-page-image-barista-training-3_1528x\.png.*?</picture>\s*<picture>.*?assets/images/787_5-wholesale-page-image-barista-training-mobile_702x\.jpg.*?</picture>',
    re.DOTALL
)
training_replacement = '''<x-client::editable-image key="wholesale.training.image" src="{{ asset('assets/images/660_5-wholesale-page-image-barista-training-3_1528x.png') }}" alt="Đào Tạo Barista Chuyên Nghiệp" class="c-custom-content2__image o-media" style="width: 100%; height: auto; object-fit: cover;" />'''
raw_body, count = training_pic_pattern.subn(training_replacement, raw_body, count=1)
print(f"Training image replacement: {count}")

# Equipment pictures (desktop & mobile)
equip_pic_pattern = re.compile(
    r'<picture>.*?assets/images/722_6-wholesale-page-image-equipment_1141x\.png.*?</picture>\s*<picture>.*?assets/images/627_6-wholesale-page-image-equipment-mobile_702x\.png.*?</picture>',
    re.DOTALL
)
equip_replacement = '''<x-client::editable-image key="wholesale.equipment.image" src="{{ asset('assets/images/722_6-wholesale-page-image-equipment_1141x.png') }}" alt="Thiết Bị & Máy Pha Cà Phê Chuyên Nghiệp" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" />'''
raw_body, count = equip_pic_pattern.subn(equip_replacement, raw_body, count=1)
print(f"Equipment image replacement: {count}")

# Bespoke Signage pictures (desktop & mobile)
signage_pic_pattern = re.compile(
    r'<picture>.*?assets/images/711_7-wholesale-page-image-bespoke-signage_746x\.png.*?</picture>\s*<picture>.*?assets/images/781_Frame_3891_702x\.png.*?</picture>',
    re.DOTALL
)
signage_replacement = '''<x-client::editable-image key="wholesale.signage.image" src="{{ asset('assets/images/711_7-wholesale-page-image-bespoke-signage_746x.png') }}" alt="Thiết Kế Quầy Bar & Bộ Nhận Diện Thương Hiệu" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" />'''
raw_body, count = signage_pic_pattern.subn(signage_replacement, raw_body, count=1)
print(f"Signage image replacement: {count}")

# 4 Marketing images:
m1_pat = re.compile(r'<picture>.*?assets/images/675_31b815765f2a5ae0f271cfe5c81376c8_601x\.png.*?</picture>', re.DOTALL)
m1_rep = '''<x-client::editable-image key="wholesale.marketing.img1" src="{{ asset('assets/images/675_31b815765f2a5ae0f271cfe5c81376c8_601x.png') }}" alt="Marketing F&B" class="c-custom-content2__image o-media" style="width: 100%; height: auto;" />'''
raw_body, count = m1_pat.subn(m1_rep, raw_body, count=1)
print(f"Marketing 1 replacement: {count}")

m2_pat = re.compile(r'<picture>.*?assets/images/634_ec3348801f419324b007358ae6a705ec_374x\.png.*?</picture>', re.DOTALL)
m2_rep = '''<x-client::editable-image key="wholesale.marketing.img2" src="{{ asset('assets/images/634_ec3348801f419324b007358ae6a705ec_374x.png') }}" alt="Marketing F&B" class="c-custom-content2__image o-media" style="width: 100%; height: auto;" />'''
raw_body, count = m2_pat.subn(m2_rep, raw_body, count=1)
print(f"Marketing 2 replacement: {count}")

m3_pat = re.compile(r'<picture>.*?assets/images/729_LL-VITTORIA-CAFES-13_601x\.jpg.*?</picture>', re.DOTALL)
m3_rep = '''<x-client::editable-image key="wholesale.marketing.img3" src="{{ asset('assets/images/729_LL-VITTORIA-CAFES-13_601x.jpg') }}" alt="Marketing F&B" class="c-custom-content2__image o-media" style="width: 100%; height: auto;" />'''
raw_body, count = m3_pat.subn(m3_rep, raw_body, count=1)
print(f"Marketing 3 replacement: {count}")

m4_pat = re.compile(r'<picture>.*?assets/images/754_450738cd7d6780bf6a0c9ddcd4bb3487_374x\.png.*?</picture>', re.DOTALL)
m4_rep = '''<x-client::editable-image key="wholesale.marketing.img4" src="{{ asset('assets/images/754_450738cd7d6780bf6a0c9ddcd4bb3487_374x.png') }}" alt="Marketing F&B" class="c-custom-content2__image o-media" style="width: 100%; height: auto;" />'''
raw_body, count = m4_pat.subn(m4_rep, raw_body, count=1)
print(f"Marketing 4 replacement: {count}")

# Community image
comm_pic_pat = re.compile(r'<picture>.*?assets/images/643_9-wholesale-page-image-community-brand-2_746x\.png.*?</picture>', re.DOTALL)
comm_replacement = '''<x-client::editable-image key="wholesale.community.image" src="{{ asset('assets/images/643_9-wholesale-page-image-community-brand-2_746x.png') }}" alt="Thương Hiệu Vì Cộng Đồng & Nông Dân Việt" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" />'''
raw_body, count = comm_pic_pat.subn(comm_replacement, raw_body, count=1)
print(f"Community image replacement: {count}")

# Family Business pictures (desktop & mobile)
fam_pic_pat = re.compile(
    r'<picture>.*?assets/images/712_10-wholesale-page-image-family-business_1141x\.png.*?</picture>\s*<picture>.*?assets/images/563_story-page-image-family_702x\.jpg.*?</picture>',
    re.DOTALL
)
fam_replacement = '''<x-client::editable-image key="wholesale.family.image" src="{{ asset('assets/images/712_10-wholesale-page-image-family-business_1141x.png') }}" alt="Doanh Nghiệp Uy Tín & Cam Kết Dài Lâu" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" />'''
raw_body, count = fam_pic_pat.subn(fam_replacement, raw_body, count=1)
print(f"Family image replacement: {count}")

# Contact Banner pictures (desktop & mobile)
contact_pic_pat = re.compile(
    r'<picture>.*?assets/images/747_11-wholesale-page-image-get-in-touch_1650x\.jpg.*?</picture>\s*<picture>.*?assets/images/665_11-wholesale-page-image-get-in-touch_1x\.jpg.*?</picture>',
    re.DOTALL
)
contact_replacement = '''<x-client::editable-image key="wholesale.contact.banner" src="{{ asset('assets/images/747_11-wholesale-page-image-get-in-touch_1650x.jpg') }}" alt="Liên Hệ Hợp Tác S54 Coffee" class="c-contact__media o-media" style="width: 100%; height: 100%; object-fit: cover;" />'''
raw_body, count = contact_pic_pat.subn(contact_replacement, raw_body, count=1)
print(f"Contact banner replacement: {count}")

# Text editable headings
raw_body = raw_body.replace(
    '<h1 class="c-hero-banner__title o-heading--2">Tại Sao Chọn S54 Cho Giải Pháp Cà Phê Bán Sỉ & Doanh Nghiệp?</h1>',
    '''<x-client::editable key="wholesale.hero.title" tag="h1" class="c-hero-banner__title o-heading--2">
        {{ app()->getLocale() === 'vi' ? 'Tại Sao Chọn S54 Cho Giải Pháp Cà Phê Bán Sỉ & Doanh Nghiệp?' : 'Why Partner with S54 for Wholesale & Enterprise Coffee Solutions?' }}
      </x-client::editable>'''
)

raw_body = raw_body.replace(
    '<p class="c-hero-banner__subtitle o-paragraph--1 is-size--small">We are more than just a coffee supplier, we are a partner that offers unmatched support.</p>',
    '''<x-client::editable key="wholesale.hero.subtitle" tag="p" class="c-hero-banner__subtitle o-paragraph--1 is-size--small">
        {{ app()->getLocale() === 'vi' ? 'Chúng tôi không chỉ là nhà cung cấp cà phê, chúng tôi là đối tác chiến lược mang đến giải pháp toàn diện và hỗ trợ vượt trội cho doanh nghiệp của bạn.' : 'We are more than just a coffee supplier, we are a partner that offers unmatched support.' }}
      </x-client::editable>'''
)

raw_body = raw_body.replace(
    'href="https://www.s54coffee.com/pages/help-desk?hcUrl=%2Fen-US%2Fcontact-us-1125876" class="c-hero-banner__button  o-btn is-primary \n    is-dark has-arrow has-no-border">Liên Hệ Hợp Tác B2B',
    'href="#contact" class="c-hero-banner__button o-btn is-primary is-dark has-arrow has-no-border"><x-client::editable key="wholesale.hero.button" tag="span">{{ app()->getLocale() === \'vi\' ? \'Liên Hệ Hợp Tác B2B\' : \'Contact B2B Partnership\' }}</x-client::editable>'
)

raw_body = raw_body.replace(
    '<h2 class="c-text-and-image2__title o-heading--3">Chương Trình Đối Tác & Đại Lý Cà Phê S54</h2>',
    '''<x-client::editable key="wholesale.intro.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Chương Trình Đối Tác & Đại Lý Cà Phê S54' : 'S54 Wholesale Partner & Franchise Program' }}
      </x-client::editable>'''
)

raw_body = raw_body.replace(
    '<h2 class="c-text-and-image2__title o-heading--3">Nguồn Cà Phê Nguyên Chất S54</h2>',
    '''<x-client::editable key="wholesale.coffee.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Nguồn Cà Phê Nguyên Chất S54' : 'Pure Artisan Coffee Sourcing by S54' }}
      </x-client::editable>'''
)

raw_body = raw_body.replace(
    '<h2 class="c-case-studies__title o-heading--3">Đối Tác Tiêu Biểu</h2>',
    '''<x-client::editable key="wholesale.partners.title" tag="h2" class="c-case-studies__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Đối Tác Tiêu Biểu' : 'Featured HoReCa & Enterprise Partners' }}
      </x-client::editable>'''
)

raw_body = raw_body.replace(
    '<h2 class="c-testimonial__title o-heading--3">Khách Hàng & Đối Tác Nói Gì Về Chúng Tôi</h2>',
    '''<x-client::editable key="wholesale.testimonials.title" tag="h2" class="c-testimonial__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Khách Hàng & Đối Tác Nói Gì Về Chúng Tôi' : 'What Our Partners Say About Us' }}
      </x-client::editable>'''
)

raw_body = raw_body.replace(
    '>Đào Tạo Barista & Chuyển Giao Công Nghệ Pha Chế</h2>',
    '''>{{ app()->getLocale() === 'vi' ? 'Đào Tạo Barista & Chuyển Giao Công Nghệ Pha Chế' : 'Barista Training & Tech Transfer' }}</h2>'''
)

raw_body = raw_body.replace(
    '<h2 class="c-text-and-image2__title o-heading--3">Thiết Bị & Máy Pha Cà Phê Chuyên Nghiệp</h2>',
    '''<x-client::editable key="wholesale.equipment.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Thiết Bị & Máy Pha Cà Phê Chuyên Nghiệp' : 'Commercial Espresso Machines & Equipment' }}
      </x-client::editable>'''
)

raw_body = raw_body.replace(
    '<h2 class="c-text-and-image2__title o-heading--3">Thiết Kế Quầy Bar & Bộ Nhận Diện Thương Hiệu</h2>',
    '''<x-client::editable key="wholesale.signage.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Thiết Kế Quầy Bar & Bộ Nhận Diện Thương Hiệu' : 'Bespoke Bar Design & Brand Identity Signage' }}
      </x-client::editable>'''
)

raw_body = raw_body.replace(
    '<h2 class="c-text-and-image2__title o-heading--3">Thương Hiệu Vì Cộng Đồng & Nông Dân Việt</h2>',
    '''<x-client::editable key="wholesale.community.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Thương Hiệu Vì Cộng Đồng & Nông Dân Việt' : 'Community Brand & Vietnamese Coffee Farmers' }}
      </x-client::editable>'''
)

raw_body = raw_body.replace(
    '<h2 class="c-text-and-image2__title o-heading--3">Doanh Nghiệp Uy Tín & Cam Kết Dài Lâu</h2>',
    '''<x-client::editable key="wholesale.family.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Doanh Nghiệp Uy Tín & Cam Kết Dài Lâu' : 'Trusted Enterprise & Long-term Partnership' }}
      </x-client::editable>'''
)

raw_body = raw_body.replace(
    '<h3 class="o-heading--3 c-contact__form-title">Liên Hệ Hợp Tác Ngay Hôm Nay</h3>',
    '''<x-client::editable key="wholesale.contact.title" tag="h3" class="o-heading--3 c-contact__form-title">
        {{ app()->getLocale() === 'vi' ? 'Liên Hệ Hợp Tác Ngay Hôm Nay' : 'Get in Touch with S54 Today' }}
      </x-client::editable>'''
)

# Convert contact form to proper form with csrf and action
raw_body = raw_body.replace(
    '<form method="post" action="/contact#contact" id="contact" accept-charset="UTF-8" class="c-contact__form">',
    '''<form method="post" action="{{ route('client.pages.show', ['locale' => app()->getLocale(), 'slug' => 'wholesale']) }}#contact" id="contact" accept-charset="UTF-8" class="c-contact__form">
      @csrf'''
)

# Fix links
raw_body = raw_body.replace('https://www.s54coffee.com/collections/coffee-beans', "{{ route('client.catalog.index', ['locale' => app()->getLocale()]) }}")
raw_body = raw_body.replace('blog-detail.html', "{{ route('client.blog.index', ['locale' => app()->getLocale()]) }}")

# Compose final blade
final_blade = f"""@extends('client.layouts.app')

@section('title', app()->getLocale() === 'vi' ? 'Tại Sao Chọn S54 Cho Giải Pháp Cà Phê Bán Sỉ & Doanh Nghiệp' : 'B2B & Enterprise Coffee Solutions — S54 Coffee')
@section('meta_description', app()->getLocale() === 'vi' ? 'Giải pháp cung ứng cà phê bán sỉ, rang xay theo yêu cầu OEM, thiết bị máy pha chuyên nghiệp và đào tạo barista chuẩn quốc tế từ S54 Coffee.' : 'Wholesale coffee supplier, OEM roasting, commercial espresso equipment and certified barista training from S54 Coffee.')

@section('content')
{raw_body}
@endsection
"""

with open('resources/views/client/pages/wholesale.blade.php', 'w', encoding='utf-8') as f:
    f.write(final_blade)

print("Saved resources/views/client/pages/wholesale.blade.php successfully!")
