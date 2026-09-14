import urllib.request
import ssl

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

urls = [
    "https://s54coffeecom549.mbws.vn/collections-coffee.html",
    "https://s54coffeecom549.mbws.vn/collections/all-coffee-products",
    "https://s54coffeecom549.mbws.vn/product-detail.html?id=200003",
    "https://s54coffeecom549.mbws.vn/product-detail.html?id=200007",
    "https://s54coffeecom549.mbws.vn/our-story.html"
]

for u in urls:
    req = urllib.request.Request(u, headers={"User-Agent": "Mozilla/5.0"})
    try:
        with urllib.request.urlopen(req, context=ctx, timeout=10) as r:
            print(f"[{r.status}] -> {r.geturl()} for {u}")
    except urllib.error.HTTPError as e:
        print(f"[{e.code}] for {u}")
    except Exception as e:
        print(f"[ERR] {e} for {u}")
