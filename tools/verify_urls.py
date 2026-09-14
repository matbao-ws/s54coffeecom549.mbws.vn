import urllib.request
import ssl

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

class NoRedirectHandler(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, req, fp, code, msg, headers, newurl):
        return None

opener = urllib.request.build_opener(urllib.request.HTTPSHandler(context=ctx), NoRedirectHandler)

urls = [
    "https://s54coffeecom549.mbws.vn/vi/cart",
    "https://s54coffeecom549.mbws.vn/vi/checkout",
    "https://s54coffeecom549.mbws.vn/vi/san-pham/cart.html",
    "https://s54coffeecom549.mbws.vn/vi/san-pham/checkout.html",
    "https://s54coffeecom549.mbws.vn/cart.html",
    "https://s54coffeecom549.mbws.vn/checkout.html",
    "https://s54coffeecom549.mbws.vn/cart",
    "https://s54coffeecom549.mbws.vn/checkout",
]

for u in urls:
    req = urllib.request.Request(u, headers={"User-Agent": "Mozilla/5.0"})
    try:
        resp = opener.open(req)
        print(f"[{resp.status}] {u}")
    except urllib.error.HTTPError as e:
        if e.code in (301, 302, 303, 307, 308):
            loc = e.headers.get("Location")
            print(f"[{e.code} -> {loc}] {u}")
        else:
            print(f"[{e.code}] {u}")
    except Exception as e:
        print(f"[Error: {e}] {u}")
