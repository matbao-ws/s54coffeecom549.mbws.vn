import glob, re
from pathlib import Path

pill_html = '''        <li class="c-header__additional-item is-mobile-only">
          <div class="s54-mobile-lang-pill" data-lang-switcher>
            <button type="button" class="c-lang-btn is-active" data-lang="vi" aria-label="Tiếng Việt">VI</button>
            <span class="s54-lang-sep">|</span>
            <button type="button" class="c-lang-btn" data-lang="en" aria-label="English">EN</button>
          </div>
        </li>
'''

files = glob.glob('*.html') + glob.glob('theme/*.html')
count = 0
for fpath in files:
    content = Path(fpath).read_text(encoding='utf-8')
    if 's54-mobile-lang-pill' in content:
        print(f'Already has pill: {fpath}')
        continue
    if 'c-header__additional' not in content:
        continue
    
    # Match the cart <li> item inside c-header__additional
    pattern = re.compile(r'(\s*<li class="c-header__additional-item"[^>]*>\s*<button[^>]*?(?:data-cart-drawer-toggle|class="c-header__link is-cart")[^>]*>)')
    match = pattern.search(content)
    if match:
        idx = match.start(1)
        new_content = content[:idx] + '\n' + pill_html + content[idx:]
        Path(fpath).write_text(new_content, encoding='utf-8')
        count += 1
        print(f'Updated: {fpath}')
    else:
        print(f'No match for cart item in: {fpath}')

print(f'Total updated: {count}')
