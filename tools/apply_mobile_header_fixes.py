import glob, re
from pathlib import Path

STYLE_BLOCK = '''<style id="s54-mobile-header-fix">
@media (max-width: 767px) {
    /* Announcement Bar: Perfectly centered, clean luxury styling */
    .c-header__topbar {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        padding: 8px 16px !important;
        min-height: 36px !important;
        background-color: #241A14 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    .c-header__topbar-messages {
        flex: 1 1 100% !important;
        width: 100% !important;
        text-align: center !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin: 0 auto !important;
    }
    .c-header__topbar-message {
        font-size: 11.5px !important;
        font-weight: 600 !important;
        letter-spacing: 0.4px !important;
        color: #FAF6F1 !important;
        text-align: center !important;
        white-space: normal !important;
        overflow: visible !important;
        text-overflow: clip !important;
        display: inline-block !important;
        line-height: 1.35 !important;
        text-decoration: none !important;
        margin: 0 auto !important;
    }
    /* Hide topbar language switcher on mobile - use mobile pill in header and mobile drawer instead */
    .c-header__topbar .c-lang-switcher,
    .c-lang-switcher--header {
        display: none !important;
    }
    .c-header__phone-link {
        display: none !important;
    }

    /* Main Header: Symmetrical, elegant, luxury coffee theme */
    .c-header__inner {
        padding: 10px 16px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        background-color: #2F221A !important;
    }
    .c-header__logo img {
        height: 32px !important;
        width: auto !important;
        max-width: 140px !important;
        object-fit: contain !important;
    }
    .c-header__additional {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        margin: 0 !important;
        padding: 0 !important;
        list-style: none !important;
    }
    .s54-mobile-lang-pill {
        display: inline-flex !important;
        align-items: center !important;
        gap: 2px !important;
        padding: 3px 8px !important;
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.16) !important;
        border-radius: 12px !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        line-height: 1 !important;
    }
    .s54-mobile-lang-pill .c-lang-btn {
        padding: 2px 4px !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        color: rgba(250, 246, 241, 0.65) !important;
        background: none !important;
        border: none !important;
        box-shadow: none !important;
        cursor: pointer !important;
        line-height: 1 !important;
        border-radius: 2px !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }
    .s54-mobile-lang-pill .c-lang-btn.is-active {
        color: #D68E1D !important;
        background: none !important;
        box-shadow: none !important;
        font-weight: 800 !important;
    }
    .s54-lang-sep {
        color: rgba(255, 255, 255, 0.25) !important;
        font-size: 10px !important;
        user-select: none !important;
    }

    /* Mobile Slide-Out Drawer Fixes: Rich Coffee Theme with No Cream Box */
    .c-main-menu {
        background-color: #1F1611 !important;
        padding: 24px 20px !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: flex-start !important;
        height: 100vh !important;
        max-height: 100vh !important;
        overflow-y: auto !important;
        box-sizing: border-box !important;
    }
    .c-main-menu__header {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding-bottom: 20px !important;
        border-bottom: 1px solid rgba(250, 246, 241, 0.1) !important;
        margin-bottom: 20px !important;
    }
    .c-main-menu__list.is-level-1 {
        display: flex !important;
        flex-direction: column !important;
        gap: 14px !important;
        margin: 0 !important;
        padding: 0 !important;
        list-style: none !important;
        flex: 1 1 auto !important;
    }
    .c-main-menu__link.is-level-1 {
        font-size: 16px !important;
        font-weight: 600 !important;
        color: #FAF6F1 !important;
        text-decoration: none !important;
        display: flex !important;
        align-items: center !important;
        padding: 6px 0 !important;
        transition: color 0.2s ease !important;
    }
    .c-main-menu__link.is-level-1:hover {
        color: #D68E1D !important;
    }
    .c-main-menu__footer {
        background-color: transparent !important;
        border-top: 1px solid rgba(250, 246, 241, 0.12) !important;
        padding: 20px 0 10px 0 !important;
        margin-top: auto !important;
        width: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 10px !important;
    }
    .c-lang-switcher--mobile {
        display: flex !important;
        gap: 8px !important;
        width: 100% !important;
    }
    .c-lang-switcher--mobile .c-lang-btn {
        flex: 1 1 50% !important;
        padding: 8px 12px !important;
        border-radius: 8px !important;
        font-size: 12.5px !important;
        font-weight: 700 !important;
        border: 1px solid rgba(250, 246, 241, 0.18) !important;
        background: rgba(250, 246, 241, 0.08) !important;
        color: #FAF6F1 !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        text-align: center !important;
        justify-content: center !important;
        display: inline-flex !important;
        align-items: center !important;
    }
    .c-lang-switcher--mobile .c-lang-btn.is-active {
        background: #D68E1D !important;
        border-color: #D68E1D !important;
        color: #1F1611 !important;
        box-shadow: 0 2px 8px rgba(214, 142, 29, 0.35) !important;
    }
}
@media (min-width: 768px) {
    .s54-mobile-lang-pill {
        display: none !important;
    }
    .c-lang-switcher--header {
        display: inline-flex !important;
    }
}
</style>
'''

files = glob.glob('*.html') + glob.glob('theme/*.html')
count = 0

for fpath in files:
    content = Path(fpath).read_text(encoding='utf-8')
    orig = content
    
    # 1. Add is-desktop-only to c-lang-switcher--header
    content = re.sub(
        r'class="c-lang-switcher c-lang-switcher--header(?!\s+is-desktop-only)"',
        'class="c-lang-switcher c-lang-switcher--header is-desktop-only"',
        content
    )
    
    # 2. Add or update STYLE_BLOCK in <head>
    if 's54-mobile-header-fix' in content:
        content = re.sub(r'<style id="s54-mobile-header-fix">[\s\S]*?</style>\n?', STYLE_BLOCK, content)
    else:
        content = content.replace('</head>', f'{STYLE_BLOCK}\n</head>')
        
    # 3. Update custom.css version buster
    content = re.sub(r'custom\.css\?v=\d+', 'custom.css?v=1789111200', content)
    
    if content != orig:
        Path(fpath).write_text(content, encoding='utf-8')
        count += 1
        print(f'Updated: {fpath}')

print(f'Done! Updated {count} files.')
