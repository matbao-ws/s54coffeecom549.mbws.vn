#!/usr/bin/env python3
"""
Update Hotline, Email, and Social links across all HTML and Blade templates:
Hotline: 0974933907
Email: infor@S54Coffee.com
Facebook: https://www.facebook.com/S54COFFEE
Zalo: https://zalo.me/0974933907
Youtube: https://www.youtube.com/@S54COFFEE
"""

import os, re, glob

BASE_DIR = '/home/binhphan/matbao-ws/clients/s54coffeecom549.mbws.vn'
os.chdir(BASE_DIR)

html_files = glob.glob('*.html') + glob.glob('theme/*.html') + glob.glob('resources/views/**/*.blade.php', recursive=True)
print(f"Found {len(html_files)} files to update contact & social info.")

for path in html_files:
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()

    orig = content

    # 1. Update Hotline numbers
    # Old hotlines: 0383707578, 0383.707.578, 0902873345, 0902.873.345
    content = re.sub(r'0383\.707\.578\s*–\s*0902\.873\.345', '0974.933.907', content)
    content = re.sub(r'0383\.707\.578\s*-\s*0902\.873\.345', '0974.933.907', content)
    content = re.sub(r'0383\.707\.578', '0974.933.907', content)
    content = re.sub(r'0383707578', '0974933907', content)
    content = re.sub(r'\(\+84\)\s*383\s*707\s*578', '(+84) 974 933 907', content)

    # 2. Update Email
    # Old emails: pm@goodsolutions.com.vn, info@s54coffee.com
    content = re.sub(r'pm@goodsolutions\.com\.vn', 'infor@S54Coffee.com', content, flags=re.IGNORECASE)
    content = re.sub(r'info@s54coffee\.com', 'infor@S54Coffee.com', content, flags=re.IGNORECASE)

    # 3. Update Social Links
    # Facebook
    content = re.sub(r'href=[\"\']https?://(?:www\.)?facebook\.com/[^\"\']*[\"\']', 'href="https://www.facebook.com/S54COFFEE"', content)
    # Zalo
    content = re.sub(r'href=[\"\']https?://zalo\.me/[^\"\']*[\"\']', 'href="https://zalo.me/0974933907"', content)
    # Youtube
    content = re.sub(r'href=[\"\']https?://(?:www\.)?youtube\.com/(?:channel|c|user|@)[^\"\']*[\"\']', 'href="https://www.youtube.com/@S54COFFEE"', content)
    # Also replace raw youtube watch or generic links in social icon if they had generic links
    content = re.sub(r'href=[\"\']https?://(?:www\.)?youtube\.com[\"\']', 'href="https://www.youtube.com/@S54COFFEE"', content)

    # If social links didn't have href or had '#' in footer:
    content = re.sub(r'href=\"#\"\s*class=\"s54-footer__social-btn\"\s*aria-label=\"Facebook\"', 'href="https://www.facebook.com/S54COFFEE" target="_blank" rel="noopener" class="s54-footer__social-btn" aria-label="Facebook"', content)
    content = re.sub(r'href=\"#\"\s*class=\"s54-footer__social-btn\"\s*aria-label=\"Zalo\"', 'href="https://zalo.me/0974933907" target="_blank" rel="noopener" class="s54-footer__social-btn" aria-label="Zalo"', content)
    content = re.sub(r'href=\"#\"\s*class=\"s54-footer__social-btn\"\s*aria-label=\"YouTube\"', 'href="https://www.youtube.com/@S54COFFEE" target="_blank" rel="noopener" class="s54-footer__social-btn" aria-label="YouTube"', content)

    if content != orig:
        with open(path, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"✓ Updated: {path}")

print("✅ Contact & Social links updated successfully!")
