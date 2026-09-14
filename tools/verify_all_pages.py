import urllib.request
import ssl

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

urls = [
    "https://s54coffeecom549.mbws.vn/vi",
    "https://s54coffeecom549.mbws.vn/vi/san-pham",
    "https://s54coffeecom549.mbws.vn/vi/san-pham/tui-ca-phe-hoa-tan-3in1-s54-coffee-456g",
    "https://s54coffeecom549.mbws.vn/vi/cart",
    "https://s54coffeecom549.mbws.vn/vi/checkout",
    "https://s54coffeecom549.mbws.vn/en/cart",
    "https://s54coffeecom549.mbws.vn/en/checkout",
]

for u in urls:
    req = urllib.request.Request(u, headers={"User-Agent": "Mozilla/5.0"})
    try:
        with urllib.request.urlopen(req, context=ctx, timeout=10) as r:
            print(f"[{r.status}] {u}")
    except urllib.error.HTTPError as e:
        print(f"[{e.code}] {u}")
    except Exception as e:
        print(f"[ERR] {e} {u}")
