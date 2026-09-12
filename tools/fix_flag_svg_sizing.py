import os
from pathlib import Path

BASE_DIR = Path(__file__).resolve().parent.parent

html_files = [
    'index.html',
    'theme/index.html',
    'collections-coffee.html',
    'theme/collections-coffee.html',
    'wholesale.html',
    'theme/wholesale.html',
    'our-story.html',
    'theme/our-story.html',
    'product-detail.html',
    'theme/product-detail.html',
    'blogs-news.html',
    'theme/blogs-news.html',
    'blog-detail.html',
    'theme/blog-detail.html',
    'contact.html',
    'theme/contact.html',
    'cart.html',
    'theme/cart.html',
    'checkout.html',
    'theme/checkout.html',
    'policy-shipping.html',
    'policy-refund.html',
    'policy-privacy.html',
    'policy-terms.html',
    'policy-returns.html'
]

old_vn_footer = 'style="border-radius: 1.5px; flex-shrink: 0; display: inline-block; vertical-align: -1px; margin-right: 5px;"'
new_vn_footer = 'style="width: 16px !important; height: 11px !important; min-width: 16px !important; max-width: 16px !important; min-height: 11px !important; max-height: 11px !important; border-radius: 1.5px; flex-shrink: 0; display: inline-block; vertical-align: middle; margin-right: 6px !important;"'

old_uk_footer = 'style="border-radius: 1.5px; flex-shrink: 0; display: inline-block; vertical-align: -1px; margin-right: 5px; overflow: hidden;"'
new_uk_footer = 'style="width: 16px !important; height: 11px !important; min-width: 16px !important; max-width: 16px !important; min-height: 11px !important; max-height: 11px !important; border-radius: 1.5px; flex-shrink: 0; display: inline-block; vertical-align: middle; overflow: hidden; margin-right: 6px !important;"'

old_vn_header = 'style="border-radius: 1.5px; flex-shrink: 0; display: inline-block;"'
new_vn_header = 'style="width: 15px !important; height: 10px !important; min-width: 15px !important; max-width: 15px !important; min-height: 10px !important; max-height: 10px !important; border-radius: 1.5px; flex-shrink: 0; display: inline-block; vertical-align: middle;"'

old_uk_header = 'style="border-radius: 1.5px; flex-shrink: 0; display: inline-block; overflow: hidden;"'
new_uk_header = 'style="width: 15px !important; height: 10px !important; min-width: 15px !important; max-width: 15px !important; min-height: 10px !important; max-height: 10px !important; border-radius: 1.5px; flex-shrink: 0; display: inline-block; vertical-align: middle; overflow: hidden;"'

updated_count = 0
for rel in html_files:
    p = BASE_DIR / rel
    if not p.exists():
        continue
    content = p.read_text(encoding='utf-8')
    orig = content
    content = content.replace(old_vn_footer, new_vn_footer)
    content = content.replace(old_uk_footer, new_uk_footer)
    content = content.replace(old_vn_header, new_vn_header)
    content = content.replace(old_uk_header, new_uk_header)

    if content != orig:
        p.write_text(content, encoding='utf-8')
        updated_count += 1
        print(f"Updated: {rel}")

print(f"Complete. Updated {updated_count} files.")
