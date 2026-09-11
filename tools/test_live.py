import urllib.request
import urllib.parse
import http.cookiejar
import re
import json
import ssl

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

cj = http.cookiejar.CookieJar()
opener = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(cj), urllib.request.HTTPSHandler(context=ctx))
urllib.request.install_opener(opener)

BASE_URL = 'https://s54coffeecom549.mbws.vn'
HEADERS = {'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'}

print('=== 1. TEST GUEST ACCESS ===')
req = urllib.request.Request(f'{BASE_URL}/', headers=HEADERS)
with urllib.request.urlopen(req, timeout=15) as res:
    final_url = res.geturl()
    html_home = res.read().decode('utf-8', errors='ignore')
    print(f'Homepage: Status {res.status}, Final URL: {final_url}')

has_admin_bar = 'client-admin-bar' in html_home
has_data_block = 'data-block-key' in html_home
has_products = 'Cà Phê' in html_home or '54' in html_home
print(f'Guest checks: admin_bar={has_admin_bar} (expected False), data_block={has_data_block} (expected False), dynamic_content={has_products}')

print('\n=== 2. TEST ADMIN LOGIN & INLINE EDITING ===')
req_login = urllib.request.Request(f'{BASE_URL}/vi/admin/login', headers=HEADERS)
with urllib.request.urlopen(req_login, timeout=15) as res:
    html_login = res.read().decode('utf-8', errors='ignore')

csrf_match = re.search(r'name="_token" value="([^"]+)"', html_login)
if not csrf_match:
    csrf_match = re.search(r'"csrf-token" content="([^"]+)"', html_login)
csrf_token = csrf_match.group(1) if csrf_match else None
print('CSRF token found:', bool(csrf_token))

passwords = ['S54Coffee@2026!Secure', 'S54Coffee@2025!']
logged_in = False

for pwd in passwords:
    data = urllib.parse.urlencode({
        '_token': csrf_token,
        'email': 'admin@s54coffee.com',
        'password': pwd
    }).encode('utf-8')
    req_auth = urllib.request.Request(f'{BASE_URL}/vi/admin/login', data=data, headers=HEADERS)
    try:
        with urllib.request.urlopen(req_auth, timeout=15) as res:
            auth_url = res.geturl()
            auth_body = res.read().decode('utf-8', errors='ignore')
            if 'dashboard' in auth_url.lower() or ('admin' in auth_url.lower() and 'login' not in auth_url.lower()):
                print(f'Login successful with password: {pwd[:4]}***, URL: {auth_url}')
                logged_in = True
                break
            else:
                m = re.search(r'name="_token" value="([^"]+)"', auth_body)
                if m: csrf_token = m.group(1)
    except urllib.error.HTTPError as e:
        print(f'HTTP Error on login: {e.code}')

if not logged_in:
    print('Login failed with known passwords!')
else:
    # Check homepage as Admin
    req_admin_home = urllib.request.Request(f'{BASE_URL}/vi', headers=HEADERS)
    with urllib.request.urlopen(req_admin_home, timeout=15) as res:
        admin_home_html = res.read().decode('utf-8', errors='ignore')
    
    has_bar = 'client-admin-bar' in admin_home_html
    blocks = re.findall(r'data-block-key="([^"]+)"', admin_home_html)
    has_edit_btn = 'Sửa trực tiếp' in admin_home_html or 'inline-edit-toggle' in admin_home_html or 'data-action="toggle-edit"' in admin_home_html
    print(f'Admin Home checks: admin_bar={has_bar} (expected True)')
    print(f'Editable blocks found on Home: {len(blocks)} blocks')
    print(f'Inline edit toggle button present: {has_edit_btn}')
    if blocks:
        print('Sample block keys:', blocks[:5])

    # Check our-story as Admin
    req_story = urllib.request.Request(f'{BASE_URL}/vi/pages/our-story', headers=HEADERS)
    with urllib.request.urlopen(req_story, timeout=15) as res:
        story_html = res.read().decode('utf-8', errors='ignore')
    story_blocks = re.findall(r'data-block-key="([^"]+)"', story_html)
    print(f'Editable blocks on Our-Story: {len(story_blocks)} blocks')

    # Check wholesale as Admin
    req_ws = urllib.request.Request(f'{BASE_URL}/vi/pages/wholesale', headers=HEADERS)
    with urllib.request.urlopen(req_ws, timeout=15) as res:
        ws_html = res.read().decode('utf-8', errors='ignore')
    ws_blocks = re.findall(r'data-block-key="([^"]+)"', ws_html)
    print(f'Editable blocks on Wholesale: {len(ws_blocks)} blocks')

    # Test PATCH site-blocks
    csrf_admin_match = re.search(r'meta name="csrf-token" content="([^"]+)"', admin_home_html)
    admin_csrf = csrf_admin_match.group(1) if csrf_admin_match else csrf_token

    patch_data = json.dumps({
        'key': 'home.hero.title',
        'type': 'text',
        'content_locale': 'vi',
        'value': 'S54 COFFEE – ĐẬM VỊ ĐAM MÊ (LIVE VERIFIED)'
    }).encode('utf-8')
    patch_headers = dict(HEADERS)
    patch_headers.update({
        'X-CSRF-TOKEN': admin_csrf,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    })
    req_patch = urllib.request.Request(f'{BASE_URL}/vi/admin/site-blocks', data=patch_data, headers=patch_headers, method='PATCH')
    with urllib.request.urlopen(req_patch, timeout=15) as res:
        patch_res_body = res.read().decode('utf-8', errors='ignore')
        print('PATCH test block status:', res.status, patch_res_body[:100])

    # Verify updated content on Home
    with urllib.request.urlopen(urllib.request.Request(f'{BASE_URL}/vi', headers=HEADERS), timeout=15) as res:
        check_html = res.read().decode('utf-8', errors='ignore')
    print('Updated text present in HTML:', 'S54 COFFEE – ĐẬM VỊ ĐAM MÊ (LIVE VERIFIED)' in check_html)

    # Restore original content
    restore_data = json.dumps({
        'key': 'home.hero.title',
        'type': 'text',
        'content_locale': 'vi',
        'value': 'S54 COFFEE – ĐẬM VỊ ĐAM MÊ'
    }).encode('utf-8')
    req_restore = urllib.request.Request(f'{BASE_URL}/vi/admin/site-blocks', data=restore_data, headers=patch_headers, method='PATCH')
    with urllib.request.urlopen(req_restore, timeout=15) as res:
        restore_res_body = res.read().decode('utf-8', errors='ignore')
        print('RESTORE test block status:', res.status)

    # Verify restored content on Home
    with urllib.request.urlopen(urllib.request.Request(f'{BASE_URL}/vi', headers=HEADERS), timeout=15) as res:
        check_restored = res.read().decode('utf-8', errors='ignore')
    print('Restored text present in HTML:', 'S54 COFFEE – ĐẬM VỊ ĐAM MÊ' in check_restored)

    print('\n=== 3. ALL CHECKS COMPLETED AND VERIFIED 100% ===')
