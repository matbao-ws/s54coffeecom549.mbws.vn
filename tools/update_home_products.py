import re

home_path = r'resources/views/client/pages/home.blade.php'
with open(home_path, 'r', encoding='utf-8') as f:
    content = f.read()

products_info = [
    ('Combo 5 gói cà phê hòa tan S54 dùng thử', '23', 'combo-12-goi-ca-phe-hoa-tan-s54-dung-thu', '15.000₫'),
    ('Combo 12 gói cà phê hòa tan S54 dùng thử', '23', 'combo-12-goi-ca-phe-hoa-tan-s54-dung-thu', '35.000₫'),
    ('Túi cà phê hòa tan 3in1 S54 Coffee 456g', '22', 'tui-ca-phe-hoa-tan-3in1-s54-coffee-456g', '65.000₫'),
    ('Combo 2 túi cà phê hòa tan 3in1 S54', '10', 'combo-2-tui-ca-phe-hoa-tan-3in1-s54', '119.000₫'),
    ('Combo 3 túi cà phê hòa tan 3in1 S54', '10', 'combo-2-tui-ca-phe-hoa-tan-3in1-s54', '199.000₫'),
    ('Cà phê hạt rang Robusta S54 250gr', '12', 'ca-phe-hat-rang-robusta-s54-250gr', '150.000₫'),
    ('Cà phê hạt rang Robusta S54 500gr', '13', 'ca-phe-hat-rang-robusta-s54-500gr', '225.000₫'),
    ('Máy Xay Cà Phê Cầm Tay VBZ01-5', '14', 'may-xay-ca-phe-cam-tay-vbz01-5', '646.000₫'),
    ('Máy Xay Cà Phê Cầm Tay VBZ08-5', '15', 'may-xay-ca-phe-cam-tay-vbz08-5', '720.000₫'),
    ('Máy Xay Cà Phê Cầm Tay VBZ03-5', '16', 'may-xay-ca-phe-cam-tay-vbz03-5', '805.000₫'),
    ('MÁY XAY CÀ PHÊ CẦM TAY VBS02-5', '17', 'may-xay-ca-phe-cam-tay-vbs02-5', '702.000₫'),
    ('Máy Xay Cà Phê Cầm Tay KMDJ-HC', '18', 'may-xay-ca-phe-cam-tay-kmdj-hc', '350.000₫'),
]

for title, pid, slug, price in products_info:
    # Match card containing this title and inject data-product-id
    pattern = rf'(<div class="o-product-thumbnail s54-product-card"[^>]*>)([\s\S]*?{re.escape(title)}[\s\S]*?data-add-to-cart)'
    
    def repl(m):
        card_start = m.group(1)
        if 'data-product-id' not in card_start:
            card_start = card_start.replace('class="o-product-thumbnail', f'data-product-id="{pid}" class="o-product-thumbnail')
        
        inner = m.group(2)
        # Update button to have data-product-id
        inner = re.sub(r'data-add-to-cart(?!\s*data-product-id)', f'data-add-to-cart data-product-id="{pid}"', inner)
        return card_start + inner

    content = re.sub(pattern, repl, content)

with open(home_path, 'w', encoding='utf-8') as f:
    f.write(content)

print("Updated home.blade.php with data-product-id successfully.")
