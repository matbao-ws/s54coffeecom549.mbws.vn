import urllib.request
import ssl
import re
import sys

sys.stdout.reconfigure(encoding='utf-8')

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

req = urllib.request.Request('https://s54coffeecom549.mbws.vn/vi', headers={'User-Agent': 'Mozilla/5.0'})
with urllib.request.urlopen(req, context=ctx, timeout=15) as res:
    html = res.read().decode('utf-8', errors='ignore')

print("Status: 200 OK")
print("Total occurrences of s54_logo.png:", html.count('s54_logo.png'))

# Find image tags with s54_logo.png
matches = re.findall(r'<img[^>]*s54_logo\.png[^>]*>', html)
for i, m in enumerate(matches):
    print(f"Match {i+1}: {m}")

# Check footer headings
headings = re.findall(r'<h4[^>]*class="s54-footer__heading"[^>]*>(.*?)</h4>', html)
print("Footer headings:", headings)

# Check company name
comp = re.findall(r'<p[^>]*class="s54-footer__company-name"[^>]*>(.*?)</p>', html)
print("Footer company name:", comp)

# Check old raw text spans
print("Has old plain text header span:", "S54 COFFEE</span>" in html)
print("Has old 26px heading in footer:", "font-size: 26px" in html)
