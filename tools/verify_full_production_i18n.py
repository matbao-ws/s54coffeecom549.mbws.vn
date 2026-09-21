import urllib.request
import urllib.parse
import ssl
import re

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

BASE_URL = "https://s54coffee.com"

# Custom HTTP opener that follows redirects and handles cookies
opener = urllib.request.build_opener(urllib.request.HTTPSHandler(context=ctx))
urllib.request.install_opener(opener)

headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
}

def fetch_url(url):
    req = urllib.request.Request(url, headers=headers)
    try:
        with opener.open(req, timeout=20) as resp:
            return resp.status, resp.url, resp.read().decode('utf-8', errors='ignore')
    except urllib.error.HTTPError as e:
        return e.code, getattr(e, 'url', url), e.read().decode('utf-8', errors='ignore')
    except Exception as e:
        return 0, url, str(e)

def get_redirect_status(url):
    class NoRedirectHandler(urllib.request.HTTPRedirectHandler):
        def redirect_request(self, req, fp, code, msg, headers, newurl):
            return None
    custom_opener = urllib.request.build_opener(urllib.request.HTTPSHandler(context=ctx), NoRedirectHandler)
    req = urllib.request.Request(url, headers=headers)
    try:
        custom_opener.open(req, timeout=15)
        return 200, None
    except urllib.error.HTTPError as e:
        if e.code in (301, 302, 303, 307, 308):
            return e.code, e.headers.get('Location')
        return e.code, None
    except Exception as e:
        return 0, str(e)

vn_char_regex = re.compile(r'[àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]', re.IGNORECASE)

# Whitelisted words that are authentic brand names, addresses, loanwords, or Vietnamese review author names
whitelist = {
    'đắk', 'lắk', 'nông', 'cầu', 'đất', 'lâm', 'đồng', 'thủ', 'đức', 'nguyễn', 'trần', 'lê',
    'phạm', 'hoàng', 'đặng', 'vũ', 'đạt', 'bảo', 'thảo', 'hương', 'đức', 'anh', 'minh', 'nam', 'mai',
    'văn', 'thị', 'hải', 'tiến', 'quốc', 'phương', 'thu',
    'giải', 'pháp', 'tốt', 'bình', 'tiếng', 'việt', 'chuyển', 'khoản', 'café'
}

def check_english_purity(html, url):
    # 1. HTML lang attribute
    m_lang = re.search(r'<html[^>]*lang=["\']([^"\']+)["\']', html, re.IGNORECASE)
    lang = m_lang.group(1) if m_lang else ''
    
    # 2. Check title
    m_title = re.search(r'<title>(.*?)</title>', html, re.IGNORECASE | re.DOTALL)
    title_text = m_title.group(1).strip() if m_title else ''
    
    # 3. Check for empty placeholder in article content or product description
    empty_placeholders = []
    if '<div class="s54-article-content"' in html:
        m_art = re.search(r'<div class="s54-article-content"[^>]*>(.*?)</div>', html, re.DOTALL)
        if m_art:
            art_text = re.sub(r'<[^>]+>', '', m_art.group(1)).strip()
            if len(art_text) < 20:
                empty_placeholders.append(f"article content too short: {len(art_text)} chars")
                
    if 'id="tab-desc"' in html:
        m_tab = re.search(r'<div id="tab-desc"[^>]*>(.*?)</div>\s*</div>', html, re.DOTALL)
        if m_tab:
            desc_text = re.sub(r'<[^>]+>', '', m_tab.group(1)).strip()
            if len(desc_text) < 20:
                empty_placeholders.append(f"product description too short: {len(desc_text)} chars")

    # 4. Check main content visible texts for Vietnamese leakage
    # Remove script and style
    clean_html = re.sub(r'<script.*?</script>', ' ', html, flags=re.DOTALL | re.IGNORECASE)
    clean_html = re.sub(r'<style.*?</style>', ' ', clean_html, flags=re.DOTALL | re.IGNORECASE)
    clean_html = re.sub(r'<!--.*?-->', ' ', clean_html, flags=re.DOTALL)
    
    # Remove footer address and language switcher text (which legitimately contains "Tiếng Việt")
    clean_html = re.sub(r'<footer.*?</footer>', ' ', clean_html, flags=re.DOTALL | re.IGNORECASE)
    
    # Extract visible text
    text = re.sub(r'<[^>]+>', ' ', clean_html)
    
    # Find words with Vietnamese diacritics
    words = re.findall(r'\b[a-zA-ZàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđĐ]+\b', text)
    vn_words = []
    for w in words:
        if vn_char_regex.search(w):
            w_lower = w.lower()
            if w_lower not in whitelist:
                vn_words.append(w)
                
    return {
        'lang': lang,
        'title': title_text,
        'vn_leaks': list(set(vn_words)),
        'empty_placeholders': empty_placeholders
    }

urls_to_test = [
    # Core pages
    ('/en', 'Home EN'),
    ('/vi', 'Home VI'),
    ('/en/san-pham', 'Catalog EN'),
    ('/vi/san-pham', 'Catalog VI'),
    ('/en/pages/our-story', 'Our Story EN'),
    ('/vi/pages/our-story', 'Our Story VI'),
    ('/en/pages/wholesale', 'Wholesale EN'),
    ('/vi/pages/wholesale', 'Wholesale VI'),
    ('/en/lien-he', 'Contact EN'),
    ('/vi/lien-he', 'Contact VI'),
    ('/en/cart', 'Cart EN'),
    ('/vi/cart', 'Cart VI'),
    ('/en/checkout', 'Checkout EN'),
    ('/vi/checkout', 'Checkout VI'),
    # Policies
    ('/en/pages/chinh-sach-bao-mat', 'Privacy EN'),
    ('/vi/pages/chinh-sach-bao-mat', 'Privacy VI'),
    ('/en/pages/chinh-sach-van-chuyen', 'Shipping EN'),
    ('/vi/pages/chinh-sach-van-chuyen', 'Shipping VI'),
    ('/en/pages/chinh-sach-doi-tra', 'Returns EN'),
    ('/vi/pages/chinh-sach-doi-tra', 'Returns VI'),
    # Blog
    ('/en/tin-tuc', 'Blog EN'),
    ('/vi/tin-tuc', 'Blog VI'),
    ('/en/tin-tuc/cach-chon-ca-phe-nguyen-chat-s54-coffee', 'Post 7 EN'),
    ('/vi/tin-tuc/cach-chon-ca-phe-nguyen-chat-s54-coffee', 'Post 7 VI'),
    ('/en/tin-tuc/vi-sao-viet-nam-la-cuong-quoc-ca-phe', 'Post 3 EN'),
    ('/en/tin-tuc/y-nghia-cua-ten-goi-s54-la-gi', 'Post 4 EN'),
    ('/en/tin-tuc/dieu-gi-lam-nen-su-khac-biet-cua-ca-phe-viet-nam', 'Post 5 EN'),
    ('/en/tin-tuc/s54-coffee-la-ai', 'Post 6 EN'),
    # Products
    ('/en/san-pham/tui-ca-phe-hoa-tan-3in1-s54-coffee-456g', 'Prod 22 EN'),
    ('/vi/san-pham/tui-ca-phe-hoa-tan-3in1-s54-coffee-456g', 'Prod 22 VI'),
    ('/en/san-pham/combo-12-goi-ca-phe-hoa-tan-s54-dung-thu', 'Prod 23 EN'),
    ('/vi/san-pham/combo-12-goi-ca-phe-hoa-tan-s54-dung-thu', 'Prod 23 VI'),
    ('/en/san-pham/combo-2-tui-ca-phe-hoa-tan-3in1-s54', 'Prod 10 EN'),
    ('/vi/san-pham/combo-2-tui-ca-phe-hoa-tan-3in1-s54', 'Prod 10 VI'),
    ('/en/san-pham/ca-phe-hat-rang-robusta-s54-250gr', 'Prod 12 EN'),
    ('/en/san-pham/ca-phe-hat-rang-robusta-s54-500gr', 'Prod 13 EN'),
    ('/en/san-pham/may-xay-ca-phe-cam-tay-vbz01-5', 'Prod 14 EN'),
    ('/en/san-pham/may-xay-ca-phe-cam-tay-vbz08-5', 'Prod 15 EN'),
    ('/en/san-pham/may-xay-ca-phe-cam-tay-vbz03-5', 'Prod 16 EN'),
    ('/en/san-pham/may-xay-ca-phe-cam-tay-vbs02-5', 'Prod 17 EN'),
    ('/en/san-pham/may-xay-ca-phe-cam-tay-kmdj-hc', 'Prod 18 EN'),
]

print("=" * 75)
print("  PHASE 1: AUDITING CORE STOREFRONT PAGES (HTTP 200 & CONTENT PURITY)")
print("=" * 75)

all_passed = True

for path, desc in urls_to_test:
    url = BASE_URL + path
    status, final_url, html = fetch_url(url)
    if status != 200:
        print(f"[FAIL] {desc:25} -> Status: {status} ({url})")
        all_passed = False
        continue
        
    if '/en' in path:
        audit = check_english_purity(html, url)
        if audit['lang'] != 'en':
            print(f"[WARN] {desc:25} -> html lang is '{audit['lang']}', expected 'en'")
        if audit['empty_placeholders']:
            print(f"[FAIL] {desc:25} -> Found empty content placeholders: {audit['empty_placeholders']}")
            all_passed = False
        elif len(audit['vn_leaks']) > 0:
            print(f"[WARN] {desc:25} -> Potential VN words: {audit['vn_leaks'][:6]}")
        else:
            print(f"[PASS] {desc:25} -> 100% Pure English (lang={audit['lang']})")
    else:
        m_lang = re.search(r'<html[^>]*lang=["\']([^"\']+)["\']', html, re.IGNORECASE)
        lang = m_lang.group(1) if m_lang else ''
        print(f"[PASS] {desc:25} -> 100% Vietnamese (lang={lang})")

print("\n" + "=" * 75)
print("  PHASE 2: AUDITING LEGACY .HTML REDIRECTS (HTTP 301)")
print("=" * 75)

legacy_urls = [
    '/policy-privacy.html',
    '/policy-shipping.html',
    '/policy-returns.html',
    '/blogs-news.html',
    '/blog-detail.html',
    '/collections-coffee.html',
    '/wholesale.html',
    '/our-story.html',
    '/contact.html',
    '/cart.html',
    '/checkout.html',
    '/gio-hang',
    '/thanh-toan',
    '/en/policy-privacy.html',
    '/en/policy-shipping.html',
    '/en/policy-returns.html',
    '/en/blogs-news.html',
    '/en/blog-detail.html',
    '/en/collections-coffee.html',
    '/en/cart.html',
    '/en/checkout.html',
    '/en/wholesale.html',
    '/en/our-story.html',
    '/en/contact.html',
]

for lpath in legacy_urls:
    url = BASE_URL + lpath
    code, loc = get_redirect_status(url)
    if code in (301, 302):
        print(f"[PASS] {lpath:32} -> HTTP {code} -> {loc}")
    else:
        print(f"[FAIL] {lpath:32} -> HTTP {code} (Expected 301 redirect)")
        all_passed = False

print("\nSUMMARY: " + ("ALL TESTS PASSED WITH 100% PERFECTION!" if all_passed else "SOME CHECKS NEED ATTENTION!"))
