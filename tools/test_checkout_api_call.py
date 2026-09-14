import urllib.request
import json
import ssl

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

url = "https://s54coffeecom549.mbws.vn/api/public/orders/checkout"

def test_payload(name, payload):
    data = json.dumps(payload).encode('utf-8')
    req = urllib.request.Request(url, data=data, headers={
        "Content-Type": "application/json",
        "Accept": "application/json",
        "User-Agent": "Mozilla/5.0"
    })
    try:
        with urllib.request.urlopen(req, context=ctx, timeout=15) as resp:
            body = resp.read().decode('utf-8')
            print(f"[{name}] SUCCESS {resp.status}: {body[:200]}")
    except urllib.error.HTTPError as e:
        print(f"[{name}] HTTP {e.code}: {e.read().decode('utf-8')}")
    except Exception as e:
        print(f"[{name}] ERROR: {e}")

# Test 1: with variant_id = 22
test_payload("With variant_id=22", {
    "customer_name": "Test User",
    "customer_email": "test@example.com",
    "customer_phone": "0912345678",
    "shipping_address": "123 Test St, Dist 1, HCMC",
    "payment_method": "cod",
    "notes": "Testing",
    "items": [
        {"product_id": 22, "variant_id": 22, "quantity": 1}
    ]
})

# Test 2: without variant_id (or variant_id=null)
test_payload("Without variant_id", {
    "customer_name": "Test User",
    "customer_email": "test@example.com",
    "customer_phone": "0912345678",
    "shipping_address": "123 Test St, Dist 1, HCMC",
    "payment_method": "cod",
    "notes": "Testing",
    "items": [
        {"product_id": 22, "quantity": 1}
    ]
})
