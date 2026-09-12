import re
import os
from pathlib import Path

BASE_DIR = Path(__file__).resolve().parent.parent

# 1. New Clean Balanced YouTube SVG
YOUTUBE_SVG_OLD_REGEX = re.compile(
    r'<a\s+href="https://(?:www\.)?youtube\.com/@S54COFFEE"[^>]*class="s54-footer__social-btn"[^>]*>[\s\S]*?</a>',
    re.IGNORECASE
)

YOUTUBE_REPLACEMENT = '''<a href="https://www.youtube.com/@S54COFFEE" target="_blank" rel="noopener" class="s54-footer__social-btn" aria-label="YouTube">
  <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24" style="display: block;">
    <path d="M21.58 7.19a2.51 2.51 0 0 0-1.77-1.78C18.25 5 12 5 12 5s-6.25 0-7.81.41A2.51 2.51 0 0 0 2.42 7.19C2 8.76 2 12 2 12s0 3.24.42 4.81a2.51 2.51 0 0 0 1.77 1.78C5.75 19 12 19 12 19s6.25 0 7.81-.41a2.51 2.51 0 0 0 1.77-1.78C22 15.24 22 12 22 12s0-3.24-.42-4.81zM10 15V9l5.2 3-5.2 3z"/>
  </svg>
</a>'''

# 2. Flag SVGs
VN_FLAG_SVG = '<svg class="s54-flag-icon" width="16" height="11" viewBox="0 0 30 20" style="width: 16px !important; height: 11px !important; min-width: 16px !important; max-width: 16px !important; min-height: 11px !important; max-height: 11px !important; border-radius: 1.5px; flex-shrink: 0; display: inline-block; vertical-align: middle;"><rect width="30" height="20" fill="#DA251D"/><polygon points="15,4 16.35,8.15 20.71,8.15 17.18,10.71 18.53,14.85 15,12.29 11.47,14.85 12.82,10.71 9.29,8.15 13.65,8.15" fill="#FFFF00"/></svg>'

UK_FLAG_SVG = '<svg class="s54-flag-icon" width="16" height="11" viewBox="0 0 60 40" style="width: 16px !important; height: 11px !important; min-width: 16px !important; max-width: 16px !important; min-height: 11px !important; max-height: 11px !important; border-radius: 1.5px; flex-shrink: 0; display: inline-block; vertical-align: middle; overflow: hidden;"><rect width="60" height="40" fill="#012169"/><path d="M0 0 L60 40 M60 0 L0 40" stroke="#FFFFFF" stroke-width="8"/><path d="M0 0 L60 40 M60 0 L0 40" stroke="#C8102E" stroke-width="4"/><path d="M30 0 v40 M0 20 h60" stroke="#FFFFFF" stroke-width="12"/><path d="M30 0 v40 M0 20 h60" stroke="#C8102E" stroke-width="6"/></svg>'

# Header small flag
VN_FLAG_SM = '<svg class="s54-flag-icon" width="15" height="10" viewBox="0 0 30 20" style="width: 15px !important; height: 10px !important; min-width: 15px !important; max-width: 15px !important; min-height: 10px !important; max-height: 10px !important; border-radius: 1.5px; flex-shrink: 0; display: inline-block; vertical-align: middle;"><rect width="30" height="20" fill="#DA251D"/><polygon points="15,4 16.35,8.15 20.71,8.15 17.18,10.71 18.53,14.85 15,12.29 11.47,14.85 12.82,10.71 9.29,8.15 13.65,8.15" fill="#FFFF00"/></svg>'

UK_FLAG_SM = '<svg class="s54-flag-icon" width="15" height="10" viewBox="0 0 60 40" style="width: 15px !important; height: 10px !important; min-width: 15px !important; max-width: 15px !important; min-height: 10px !important; max-height: 10px !important; border-radius: 1.5px; flex-shrink: 0; display: inline-block; vertical-align: middle; overflow: hidden;"><rect width="60" height="40" fill="#012169"/><path d="M0 0 L60 40 M60 0 L0 40" stroke="#FFFFFF" stroke-width="8"/><path d="M0 0 L60 40 M60 0 L0 40" stroke="#C8102E" stroke-width="4"/><path d="M30 0 v40 M0 20 h60" stroke="#FFFFFF" stroke-width="12"/><path d="M30 0 v40 M0 20 h60" stroke="#C8102E" stroke-width="6"/></svg>'

# 3. Luxury Back-To-Top Component
BACK_TO_TOP_HTML = '''
<!-- S54 Luxury Back-To-Top Floating Button -->
<button type="button" class="s54-back-to-top" id="s54-back-to-top" aria-label="Cuộn về đầu trang">
  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    <path d="M18 15l-6-6-6 6"/>
  </svg>
</button>
<script>
(function() {
  var btn = document.getElementById('s54-back-to-top');
  if (!btn) return;
  function toggleBTT() {
    if (window.pageYOffset > 320) {
      btn.classList.add('is-visible');
    } else {
      btn.classList.remove('is-visible');
    }
  }
  window.addEventListener('scroll', toggleBTT, { passive: true });
  btn.addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
  toggleBTT();
})();
</script>
'''

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
    'policy-terms.html'
]

updated_count = 0
for rel_path in html_files:
    file_path = BASE_DIR / rel_path
    if not file_path.exists():
        continue

    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    orig_content = content

    # Replace YouTube button
    content = YOUTUBE_SVG_OLD_REGEX.sub(YOUTUBE_REPLACEMENT, content)

    # Replace footer language switcher buttons
    # Pattern 1: <button ...>🇻🇳 Tiếng Việt</button>
    content = re.sub(
        r'<button([^>]*data-lang="vi"[^>]*)>[\s\S]*?Tiếng Việt<\/button>',
        f'<button\\1>{VN_FLAG_SVG}<span>Tiếng Việt</span></button>',
        content
    )
    # Pattern 2: <button ...>🇬🇧 English</button>
    content = re.sub(
        r'<button([^>]*data-lang="en"[^>]*)>[\s\S]*?English<\/button>',
        f'<button\\1>{UK_FLAG_SVG}<span>English</span></button>',
        content
    )

    # Pattern 3: Header buttons <button ...>🇻🇳 VI</button>
    content = re.sub(
        r'<button([^>]*data-lang="vi"[^>]*)>[\s\S]*?VI<\/button>',
        f'<button\\1 style="display:inline-flex;align-items:center;gap:4px;">{VN_FLAG_SM}<span>VI</span></button>',
        content
    )
    # Pattern 4: Header buttons <button ...>🇬🇧 EN</button>
    content = re.sub(
        r'<button([^>]*data-lang="en"[^>]*)>[\s\S]*?EN<\/button>',
        f'<button\\1 style="display:inline-flex;align-items:center;gap:4px;">{UK_FLAG_SM}<span>EN</span></button>',
        content
    )

    # Remove old c-scroll-top / scrollTopBtn if present
    content = re.sub(r'<button class="c-scroll-top" id="scrollTopBtn"[\s\S]*?<\/button>', '', content)

    # Add s54-back-to-top before </body> if not present
    if 'id="s54-back-to-top"' not in content:
        content = content.replace('</body>', f'{BACK_TO_TOP_HTML}\n</body>')

    if content != orig_content:
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(content)
        updated_count += 1
        print(f"Updated: {rel_path}")

print(f"Done. Updated {updated_count} files.")
