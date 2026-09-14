import urllib.request
import ssl
import re

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

def get_prods(url):
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    html = urllib.request.urlopen(req, context=ctx, timeout=10).read().decode('utf-8')
    cards = re.findall(r'<div[^>]*data-product-id="(\d+)"[^>]*data-category="([^"]*)"[^>]*>.*?<img[^>]*src="([^"]+)"[^>]*alt="([^"]*)"', html, re.DOTALL)
    results = []
    for pid, cat, src, alt in cards:
        results.append({
            'id': pid,
            'cat': cat,
            'title': alt,
            'image': src.split('/')[-1]
        })
    return results

home_prods = get_prods('https://s54coffeecom549.mbws.vn/vi')
catalog_prods = get_prods('https://s54coffeecom549.mbws.vn/vi/san-pham')

import sys
out = []
out.append(f"=== HOME PAGE PRODUCTS ({len(home_prods)}) ===")
for p in home_prods:
    out.append(f"ID: {p['id']} | {p['title']} | Image: {p['image']} | Cat: {p['cat']}")

out.append(f"\n=== CATALOG PAGE PRODUCTS ({len(catalog_prods)}) ===")
for p in catalog_prods:
    out.append(f"ID: {p['id']} | {p['title']} | Image: {p['image']} | Cat: {p['cat']}")

sys.stdout.buffer.write("\n".join(out).encode('utf-8'))
