#!/usr/bin/env python3
"""
Add mobile language switcher inside .c-main-menu across all HTML files
"""

import os
import re

MOBILE_SWITCHER_HTML = '''        <div class="c-main-menu__footer is-mobile-only" style="padding: 24px 20px; border-top: 1px solid rgba(250,246,241,0.12); margin-top: 20px;">
          <div style="font-size: 11px; font-weight: 700; color: #D68E1D; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 12px;">Ngôn ngữ / Language</div>
          <div class="c-lang-switcher c-lang-switcher--mobile" data-lang-switcher style="display: flex; gap: 8px;">
            <button type="button" class="c-lang-btn is-active" data-lang="vi" style="padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; border: 1px solid rgba(250,246,241,0.2); background: rgba(250,246,241,0.08); color: #FAF6F1; cursor: pointer;">🇻🇳 Tiếng Việt</button>
            <button type="button" class="c-lang-btn" data-lang="en" style="padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; border: 1px solid rgba(250,246,241,0.2); background: rgba(250,246,241,0.08); color: #FAF6F1; cursor: pointer;">🇬🇧 English</button>
          </div>
        </div>
'''

TARGET_FILES = [
    'index.html',
    'collections-coffee.html',
    'product-detail.html',
    'cart.html',
    'checkout.html',
    'contact.html',
    'our-story.html',
    'wholesale.html',
    'blogs-news.html',
    'blog-detail.html',
    'policy-privacy.html',
    'policy-returns.html',
    'policy-shipping.html',
    'theme/index.html',
    'theme/collections-coffee.html',
    'theme/product-detail.html',
    'theme/our-story.html',
    'theme/wholesale.html',
    'theme/blogs-news.html',
    'theme/blog-detail.html'
]

def update_file(file_path):
    if not os.path.exists(file_path):
        return
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    if 'c-lang-switcher--mobile' in content:
        print(f"Already present in {file_path}")
        return

    # Look for </nav> that closes .c-main-menu
    pattern = r'(<nav[^>]*class="[^"]*c-main-menu[^"]*"[^>]*>.*?)(</nav>)'
    match = re.search(pattern, content, re.DOTALL)
    if match:
        menu_body = match.group(1)
        new_content = content[:match.start()] + menu_body + MOBILE_SWITCHER_HTML + '      </nav>' + content[match.end():]
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"Updated {file_path}")
    else:
        print(f"No c-main-menu match in {file_path}")

def main():
    base_dir = '/home/binhphan/matbao-ws/clients/s54coffeecom549.mbws.vn'
    for rel in TARGET_FILES:
        update_file(os.path.join(base_dir, rel))

if __name__ == '__main__':
    main()
