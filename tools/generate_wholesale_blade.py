import re
import sys

sys.stdout.reconfigure(encoding='utf-8')

with open('scratch/original_wholesale_main.html', 'r', encoding='utf-8') as f:
    content = f.read()

# Exclude footer
footer_pos = content.find('id="shopify-section-footer"')
if footer_pos != -1:
    body_content = content[:footer_pos].strip()
    last_div = body_content.rfind('</div>')
    body_content = body_content[:last_div+6]
else:
    body_content = content.strip()

# Clean shopify cdn and tracking artifacts
body_content = re.sub(r'data-w="[^"]*"', '', body_content)

# Map of picture/image replacements to <x-client::editable-image>
# 1. Hero banner picture
hero_pic = r'<picture>\s*<source[^>]*>\s*<source[^>]*>\s*<img[^>]*src=["\']assets/images/785_1-wholesale-page-banner-desktop-2_2560x\.jpg["\'][^>]*>\s*<source[^>]*>\s*<img[^>]*src=["\']assets/images/666_1-wholesale-page-banner-mobile-3_1x\.jpg["\'][^>]*>\s*</picture>'
# In original, let's see how hero picture is structured:
hero_pic_exact = re.search(r'<picture>.*?src="assets/images/785_1-wholesale-page-banner-desktop-2_2560x\.jpg".*?</picture>', body_content, re.DOTALL)
if hero_pic_exact:
    body_content = body_content.replace(hero_pic_exact.group(0), '''<x-client::editable-image key="wholesale.hero.banner" src="{{ asset('assets/images/785_1-wholesale-page-banner-desktop-2_2560x.jpg') }}" alt="S54 Coffee B2B Wholesale Solutions" class="c-hero-banner__media o-media" style="width: 100%; height: 100%; object-fit: cover;" />''')

# 2. Section 1 Arch Image: 667_LA_V_92_RGB_1_1141x.jpg
arch_pic = re.search(r'<picture>.*?src="assets/images/667_LA_V_92_RGB_1_1141x\.jpg".*?</picture>', body_content, re.DOTALL)
if arch_pic:
    body_content = body_content.replace(arch_pic.group(0), '''<x-client::editable-image key="wholesale.intro.image" src="{{ asset('assets/images/667_LA_V_92_RGB_1_1141x.jpg') }}" alt="Chương Trình Đối Tác & Đại Lý Cà Phê S54" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" />''')

# 3. Section 2 Coffee Image: 604_3-wholesale-image-our-coffee-3_746x.png
coffee_pic = re.search(r'<picture>.*?src="assets/images/604_3-wholesale-image-our-coffee-3_746x\.png".*?</picture>', body_content, re.DOTALL)
if coffee_pic:
    body_content = body_content.replace(coffee_pic.group(0), '''<x-client::editable-image key="wholesale.coffee.image" src="{{ asset('assets/images/604_3-wholesale-image-our-coffee-3_746x.png') }}" alt="Nguồn Cà Phê Nguyên Chất S54" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" />''')

# 4. Section 5 Barista Training Image: 660_5-wholesale-page-image-barista-training-3_1528x.png
training_pic = re.search(r'<picture>.*?src="assets/images/660_5-wholesale-page-image-barista-training-3_1528x\.png".*?</picture>', body_content, re.DOTALL)
if training_pic:
    body_content = body_content.replace(training_pic.group(0), '''<x-client::editable-image key="wholesale.training.image" src="{{ asset('assets/images/660_5-wholesale-page-image-barista-training-3_1528x.png') }}" alt="Đào Tạo Barista Chuyên Nghiệp" class="c-custom-content2__media o-media" style="width: 100%; height: 100%; object-fit: cover;" />''')

# 5. Section 6 Equipment Image: 722_6-wholesale-page-image-equipment_1141x.png
equip_pic = re.search(r'<picture>.*?src="assets/images/722_6-wholesale-page-image-equipment_1141x\.png".*?</picture>', body_content, re.DOTALL)
if equip_pic:
    body_content = body_content.replace(equip_pic.group(0), '''<x-client::editable-image key="wholesale.equipment.image" src="{{ asset('assets/images/722_6-wholesale-page-image-equipment_1141x.png') }}" alt="Thiết Bị Máy Pha Cà Phê Chuyên Nghiệp" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" />''')

# 6. Section 7 Bespoke Signage Image: 711_7-wholesale-page-image-bespoke-signage_746x.png
signage_pic = re.search(r'<picture>.*?src="assets/images/711_7-wholesale-page-image-bespoke-signage_746x\.png".*?</picture>', body_content, re.DOTALL)
if signage_pic:
    body_content = body_content.replace(signage_pic.group(0), '''<x-client::editable-image key="wholesale.signage.image" src="{{ asset('assets/images/711_7-wholesale-page-image-bespoke-signage_746x.png') }}" alt="Thiết Kế Quầy Bar & Bộ Nhận Diện" class="c-custom-content2__media o-media" style="width: 100%; height: 100%; object-fit: cover;" />''')

# 7. Section 8 Community Image: 643_9-wholesale-page-image-community-brand-2_746x.png
comm_pic = re.search(r'<picture>.*?src="assets/images/643_9-wholesale-page-image-community-brand-2_746x\.png".*?</picture>', body_content, re.DOTALL)
if comm_pic:
    body_content = body_content.replace(comm_pic.group(0), '''<x-client::editable-image key="wholesale.community.image" src="{{ asset('assets/images/643_9-wholesale-page-image-community-brand-2_746x.png') }}" alt="Thương Hiệu Vì Cộng Đồng" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" />''')

# 8. Section 8 Family Business Image: 712_10-wholesale-page-image-family-business_1141x.png
family_pic = re.search(r'<picture>.*?src="assets/images/712_10-wholesale-page-image-family-business_1141x\.png".*?</picture>', body_content, re.DOTALL)
if family_pic:
    body_content = body_content.replace(family_pic.group(0), '''<x-client::editable-image key="wholesale.family.image" src="{{ asset('assets/images/712_10-wholesale-page-image-family-business_1141x.png') }}" alt="Doanh Nghiệp Uy Tín & Cam Kết Dài Lâu" class="c-text-and-image2__image o-media" style="width: 100%; height: 100%; object-fit: cover;" />''')

# 9. Contact banner: 747_11-wholesale-page-image-get-in-touch_1650x.jpg
contact_pic = re.search(r'<picture>.*?src="assets/images/747_11-wholesale-page-image-get-in-touch_1650x\.jpg".*?</picture>', body_content, re.DOTALL)
if contact_pic:
    body_content = body_content.replace(contact_pic.group(0), '''<x-client::editable-image key="wholesale.contact.banner" src="{{ asset('assets/images/747_11-wholesale-page-image-get-in-touch_1650x.jpg') }}" alt="Liên Hệ Hợp Tác S54 Coffee" class="c-contact__media o-media" style="width: 100%; height: 100%; object-fit: cover;" />''')

# Case study images:
cs1 = re.search(r'<picture>.*?src="assets/images/586_feb206e33c8cb0b0034447b6bcc44c75\.jpg".*?</picture>', body_content, re.DOTALL)
if cs1:
    body_content = body_content.replace(cs1.group(0), '''<x-client::editable-image key="wholesale.case.1.image" src="{{ asset('assets/images/586_feb206e33c8cb0b0034447b6bcc44c75.jpg') }}" alt="Đối Tác S54" class="o-article-thumbnail__image o-media" style="width: 100%; height: 100%; object-fit: cover;" />''')

cs2 = re.search(r'<picture>.*?src="assets/images/598_50f6f9f3160ce6aa271e4b01d03d3200\.jpg".*?</picture>', body_content, re.DOTALL)
if cs2:
    body_content = body_content.replace(cs2.group(0), '''<x-client::editable-image key="wholesale.case.2.image" src="{{ asset('assets/images/598_50f6f9f3160ce6aa271e4b01d03d3200.jpg') }}" alt="Đối Tác S54" class="o-article-thumbnail__image o-media" style="width: 100%; height: 100%; object-fit: cover;" />''')

cs3 = re.search(r'<picture>.*?src="assets/images/555_cafe-els-banner_3499b450-717a-4175-a177-9c64e9e9194d_1024x\.jpg".*?</picture>', body_content, re.DOTALL)
if cs3:
    body_content = body_content.replace(cs3.group(0), '''<x-client::editable-image key="wholesale.case.3.image" src="{{ asset('assets/images/555_cafe-els-banner_3499b450-717a-4175-a177-9c64e9e9194d_1024x.jpg') }}" alt="Đối Tác S54" class="o-article-thumbnail__image o-media" style="width: 100%; height: 100%; object-fit: cover;" />''')

# Replace remaining assets
body_content = re.sub(r'src=["\'](assets/[^"\']*)["\']', r'src="{{ asset(\'\1\') }}"', body_content)
body_content = re.sub(r'srcset=["\'](assets/[^"\']*)["\']', r'srcset="{{ asset(\'\1\') }}"', body_content)
body_content = re.sub(r'href=["\'](assets/[^"\']*)["\']', r'href="{{ asset(\'\1\') }}"', body_content)

# Replace navigation and links
body_content = body_content.replace('href="collections-coffee.html"', 'href="{{ route(\'client.catalog.index\', [\'locale\' => app()->getLocale()]) }}"')
body_content = body_content.replace('href="/collections/coffee-beans"', 'href="{{ route(\'client.catalog.index\', [\'locale\' => app()->getLocale()]) }}"')
body_content = body_content.replace('href="/collections/all-coffee-products"', 'href="{{ route(\'client.catalog.index\', [\'locale\' => app()->getLocale()]) }}"')
body_content = body_content.replace('href="https://www.s54coffee.com/collections/coffee-beans"', 'href="{{ route(\'client.catalog.index\', [\'locale\' => app()->getLocale()]) }}"')
body_content = body_content.replace('href="https://www.s54coffee.com/pages/help-desk?hcUrl=%2Fen-US%2Fcontact-us-1125876"', 'href="#b2b-contact-form"')
body_content = body_content.replace('href="/pages/help-desk?hcUrl=%2Fen-US%2Fcontact-us-1125876"', 'href="#b2b-contact-form"')

# Contact form target ID
body_content = body_content.replace('<section class="c-contact">', '<section class="c-contact" id="b2b-contact-form">')

# Editable headings:
# 1. Hero title
body_content = body_content.replace(
    '<h1 class="c-hero-banner__title o-heading--2">Tại Sao Chọn S54 Cho Giải Pháp Cà Phê Bán Sỉ & Doanh Nghiệp?</h1>',
    '''<x-client::editable key="wholesale.hero.title" tag="h1" class="c-hero-banner__title o-heading--2" style="color: #2F221A !important;">
          {{ app()->getLocale() === 'vi' ? 'Tại Sao Chọn S54 Cho Giải Pháp Cà Phê Bán Sỉ & Doanh Nghiệp?' : 'Why Partner With S54 For Wholesale & Enterprise Coffee Solutions?' }}
        </x-client::editable>'''
)
body_content = body_content.replace(
    '<p class="c-hero-banner__subtitle o-paragraph--1 is-size--small">We are more than just a coffee supplier, we are a partner that offers unmatched support.</p>',
    '''<x-client::editable key="wholesale.hero.subtitle" tag="p" class="c-hero-banner__subtitle o-paragraph--1 is-size--small" style="color: #4A3A2F !important;">
          {{ app()->getLocale() === 'vi' ? 'Chúng tôi không chỉ là nhà cung cấp cà phê đơn thuần, mà là đối tác chiến lược đồng hành cùng sự tăng trưởng bền vững của bạn.' : 'We are more than just a coffee supplier, we are a strategic partner offering unmatched support.' }}
        </x-client::editable>'''
)

# 2. Section 1: Chương trình đối tác
body_content = body_content.replace(
    '<h2 class="c-text-and-image2__title o-heading--3">Chương Trình Đối Tác & Đại Lý Cà Phê S54</h2>',
    '''<x-client::editable key="wholesale.intro.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Chương Trình Đối Tác & Đại Lý Cà Phê S54' : 'S54 Wholesale Partner & Franchise Program' }}
      </x-client::editable>'''
)

# 3. Section 2: Nguồn cà phê nguyên chất
body_content = body_content.replace(
    '<h2 class="c-text-and-image2__title o-heading--3">Nguồn Cà Phê Nguyên Chất S54</h2>',
    '''<x-client::editable key="wholesale.coffee.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Nguồn Cà Phê Nguyên Chất S54' : 'Pure Artisan Coffee Sourcing by S54' }}
      </x-client::editable>'''
)

# 4. Section 3: Đối tác tiêu biểu
body_content = body_content.replace(
    '<h2 class="c-case-studies__title o-heading--3">Đối Tác Tiêu Biểu</h2>',
    '''<x-client::editable key="wholesale.partners.title" tag="h2" class="c-case-studies__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Đối Tác Tiêu Biểu' : 'Featured HoReCa & Enterprise Partners' }}
      </x-client::editable>'''
)

# 5. Section 4: Đánh giá đối tác
body_content = body_content.replace(
    '<h2 class="c-testimonial__title o-heading--3">Khách Hàng & Đối Tác Nói Gì Về Chúng Tôi</h2>',
    '''<x-client::editable key="wholesale.testimonials.title" tag="h2" class="c-testimonial__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Khách Hàng & Đối Tác Nói Gì Về Chúng Tôi' : 'What Our Partners Say About S54' }}
      </x-client::editable>'''
)

# 6. Section 5: Đào tạo Barista
body_content = body_content.replace(
    'Đào Tạo Barista & Chuyển Giao Công Nghệ Pha Chế',
    '''<x-client::editable key="wholesale.training.title" tag="span">
        {{ app()->getLocale() === 'vi' ? 'Đào Tạo Barista & Chuyển Giao Công Nghệ Pha Chế' : 'Barista Training & Brewing Technology Transfer' }}
      </x-client::editable>'''
)

# 7. Section 6: Thiết bị máy pha
body_content = body_content.replace(
    '<h2 class="c-text-and-image2__title o-heading--3">Thiết Bị & Máy Pha Cà Phê Chuyên Nghiệp</h2>',
    '''<x-client::editable key="wholesale.equipment.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Thiết Bị & Máy Pha Cà Phê Chuyên Nghiệp' : 'Commercial Espresso Equipment & Machine Solutions' }}
      </x-client::editable>'''
)

# 8. Section 7: Thiết kế quầy bar
body_content = body_content.replace(
    '<h2 class="c-text-and-image2__title o-heading--3">Thiết Kế Quầy Bar & Bộ Nhận Diện Thương Hiệu</h2>',
    '''<x-client::editable key="wholesale.signage.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Thiết Kế Quầy Bar & Bộ Nhận Diện Thương Hiệu' : 'Bar Design & Bespoke Brand Identity Setup' }}
      </x-client::editable>'''
)

# 9. Section 8: Thương hiệu vì cộng đồng
body_content = body_content.replace(
    '<h2 class="c-text-and-image2__title o-heading--3">Thương Hiệu Vì Cộng Đồng & Nông Dân Việt</h2>',
    '''<x-client::editable key="wholesale.community.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Thương Hiệu Vì Cộng Đồng & Nông Dân Việt' : 'Sustainable Sourcing & Fair Trade Community' }}
      </x-client::editable>'''
)

# 10. Section 8: Cam kết
body_content = body_content.replace(
    '<h2 class="c-text-and-image2__title o-heading--3">Doanh Nghiệp Uy Tín & Cam Kết Dài Lâu</h2>',
    '''<x-client::editable key="wholesale.family.title" tag="h2" class="c-text-and-image2__title o-heading--3">
        {{ app()->getLocale() === 'vi' ? 'Doanh Nghiệp Uy Tín & Cam Kết Dài Lâu' : 'Reputable Enterprise & Long-Term Commitment' }}
      </x-client::editable>'''
)

# 11. Section 9: Form title
body_content = body_content.replace(
    '<h3 class="o-heading--3 c-contact__form-title">Liên Hệ Hợp Tác Ngay Hôm Nay</h3>',
    '''<x-client::editable key="wholesale.contact.title" tag="h3" class="o-heading--3 c-contact__form-title">
            {{ app()->getLocale() === 'vi' ? 'Liên Hệ Hợp Tác & Nhận Mẫu Thử Miễn Phí' : 'Contact Us & Receive Free Sample Kit' }}
          </x-client::editable>'''
)

blade_template = f'''@extends('client.layouts.app')

@section('title', app()->getLocale() === 'vi' ? 'Tại Sao Chọn S54 Cho Giải Pháp Cà Phê Bán Sỉ & Doanh Nghiệp' : 'B2B & Enterprise Coffee Solutions — S54 Coffee')

@section('content')
{body_content}
@endsection
'''

with open('resources/views/client/pages/wholesale.blade.php', 'w', encoding='utf-8') as f:
    f.write(blade_template)

print("SUCCESS: resources/views/client/pages/wholesale.blade.php generated with full editable components and images!")
