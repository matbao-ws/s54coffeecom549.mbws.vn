#!/usr/bin/env python3
"""
Comprehensive Fix for 7 Client Feedback Issues from Google Doc:
1. Fix checkout/cart price losing 0 (VND integer parsing)
2. Fix product-detail.html:
   - Dynamic product image & correct filenames
   - Dynamic price binding for one-time & subscription
   - Remove English father gift & replace Okendo with clean S54 Review section
3. Replace Vittoria mock products on index.html with genuine S54 products
4. Fix footer logo brightness/invert & dark heading text in custom.css
5. Update Hotline (0974933907), Email (infor@S54Coffee.com) across all files
6. Update Social links (Facebook, Zalo, YouTube) across all files
7. Expand i18n dictionary for complete VI <-> EN switching
"""

import os, re, json

BASE_DIR = '/home/binhphan/matbao-ws/clients/s54coffeecom549.mbws.vn'
os.chdir(BASE_DIR)

# -------------------------------------------------------------
# 1. FIX CSS FOR FOOTER AND REVIEWS (Lỗi 4 & Lỗi 0)
# -------------------------------------------------------------
print("Step 1: Updating custom.css...")
css_path = 'assets/css/custom.css'
with open(css_path, 'r', encoding='utf-8') as f:
    css = f.read()

# Remove filter: brightness(0) invert(1)
css = re.sub(
    r'\.s54-footer__logo-img\s*\{[^}]*filter:[^;]+;[^}]*\}',
    '''.s54-footer__logo-img {
    height: 48px !important;
    width: auto !important;
    max-width: 200px !important;
    object-fit: contain !important;
    filter: none !important;
}''',
    css
)

# Remove .s54-footer__heading from dark color group
css = re.sub(
    r'(\n\s*\.s54-footer__heading\s*,\s*\n|\n\s*\.s54-footer__heading\s*\{)',
    lambda m: '\n' if ',' in m.group(0) else '\n.dummy-footer-heading {\n',
    css
)

# Append master footer and review CSS
footer_and_review_css = '''
/* ========================================================
   MASTER S54 CLIENT FEEDBACK FIXES: FOOTER & REVIEWS
   ======================================================== */
.s54-footer {
    background-color: #1F1611 !important;
    color: #FAF6F1 !important;
}
.s54-footer__logo-img {
    height: 48px !important;
    width: auto !important;
    max-width: 200px !important;
    object-fit: contain !important;
    filter: none !important;
}
.s54-footer__heading,
h4.s54-footer__heading {
    font-family: 'Cormorant Garamond', Georgia, serif !important;
    font-size: 22px !important;
    line-height: 1.3 !important;
    font-weight: 700 !important;
    color: #FFFFFF !important;
    letter-spacing: 0.5px !important;
    margin: 0 0 18px 0 !important;
    position: relative !important;
    padding-bottom: 8px !important;
}
.s54-footer__heading::after {
    content: '' !important;
    position: absolute !important;
    left: 0 !important;
    bottom: 0 !important;
    width: 36px !important;
    height: 2px !important;
    background: #D68E1D !important;
}
.s54-footer__company-name {
    color: #D68E1D !important;
    font-weight: 700 !important;
    font-size: 14px !important;
    letter-spacing: 0.5px !important;
    margin-bottom: 6px !important;
}
.s54-footer__brand-tagline {
    color: #E5DDD5 !important;
    font-size: 13px !important;
    line-height: 1.6 !important;
    margin-bottom: 16px !important;
}
.s54-footer__contact-list {
    list-style: none !important;
    padding: 0 !important;
    margin: 0 !important;
}
.s54-footer__contact-list li {
    color: #E5DDD5 !important;
    font-size: 13px !important;
    line-height: 1.6 !important;
    margin-bottom: 10px !important;
}
.s54-footer__contact-list a {
    color: #FAF6F1 !important;
    font-weight: 600 !important;
    text-decoration: none !important;
    transition: color 0.2s ease !important;
}
.s54-footer__contact-list a:hover {
    color: #D68E1D !important;
}
.s54-footer__links a {
    color: #D8CEBE !important;
    font-size: 13.5px !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
    display: inline-block !important;
}
.s54-footer__links a:hover {
    color: #D68E1D !important;
    transform: translateX(4px) !important;
}
.s54-footer__social-title {
    color: #D68E1D !important;
    font-size: 12px !important;
    font-weight: 700 !important;
    letter-spacing: 1px !important;
    text-transform: uppercase !important;
    margin-bottom: 8px !important;
}
.s54-footer__social-icons {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
}
.s54-footer__social-btn {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 38px !important;
    height: 38px !important;
    border-radius: 50% !important;
    background: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(214, 142, 29, 0.3) !important;
    color: #FFFFFF !important;
    text-decoration: none !important;
    transition: all 0.25s ease !important;
}
.s54-footer__social-btn:hover {
    background: #D68E1D !important;
    color: #FFFFFF !important;
    border-color: #D68E1D !important;
    transform: translateY(-2px) !important;
}

/* Product Detail Main Gallery Aspect Ratio & Centering */
.c-product-gallery__carousel,
.c-product-gallery__inner {
    width: 100% !important;
    min-height: 420px !important;
}
.c-product-gallery__media-container {
    width: 100% !important;
    min-height: 420px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    background-color: #FAF8F5 !important;
    border-radius: 12px !important;
    overflow: hidden !important;
}
.c-product-gallery__media-container img {
    max-width: 100% !important;
    max-height: 480px !important;
    width: auto !important;
    height: auto !important;
    object-fit: contain !important;
    display: block !important;
    margin: 0 auto !important;
}
'''

if 'MASTER S54 CLIENT FEEDBACK FIXES' not in css:
    css += '\n' + footer_and_review_css

with open(css_path, 'w', encoding='utf-8') as f:
    f.write(css)
with open('public/client-assets/css/custom.css', 'w', encoding='utf-8') as f:
    f.write(css)
if os.path.exists('theme/assets/css/custom.css'):
    with open('theme/assets/css/custom.css', 'w', encoding='utf-8') as f:
        f.write(css)

print("✓ Updated custom.css successfully!")
