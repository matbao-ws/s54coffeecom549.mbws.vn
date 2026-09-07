#!/usr/bin/env python3
"""
Replace all Vittoria mock products on index.html with authentic S54 products from products.json
"""

import json, re

# Load S54 products
with open('drive_data/products.json', 'r', encoding='utf-8') as f:
    products = json.load(f)

print(f"Loaded {len(products)} authentic S54 products.")

# Ensure images exist
for p in products:
    # Ensure image points to existing file
    img = p['image']
    if 'combo_5goi.jpg' in img:
        p['image'] = 'assets/images/s54/products/combo_5goi_dung_thu.jpg'
    elif 'combo_12goi.jpg' in img:
        p['image'] = 'assets/images/s54/products/combo_12goi_dung_thu.jpg'

def generate_product_card(p, index):
    pid = p['id']
    name = p['name']
    cat = p['category']
    img = p['image']
    sale_price = p['sale_price'].replace('VND', '₫').replace(' ', '').replace('đ', '₫')
    if not sale_price.endswith('₫'):
        sale_price += '₫'
    reg_price = p['regular_price'].replace('VND', '₫').replace(' ', '').replace('đ', '₫')
    if not reg_price.endswith('₫'):
        reg_price += '₫'
    
    desc = p.get('short_desc') or 'Cà phê nguyên chất S54 Coffee đậm đà chuẩn vị Tây Nguyên'
    badge = 'BÁN CHẠY NHẤT' if index < 3 else cat

    return f'''
        <div class="o-product-thumbnail s54-product-card" data-category="{cat}" style="background: #FFFFFF; border-radius: 8px; border: 1px solid #EBE7E1; padding: 16px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s ease; box-shadow: 0 4px 14px rgba(0,0,0,0.03);">
          <div>
            <div style="position: relative; aspect-ratio: 1/1; overflow: hidden; border-radius: 6px; background: #FAF8F5; margin-bottom: 14px;">
              <span style="position: absolute; top: 10px; left: 10px; z-index: 2; background: #D68E1D; color: #FFFFFF; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 3px; text-transform: uppercase; letter-spacing: 0.5px;">{badge}</span>
              <a href="product-detail.html?id={pid}" style="display: block; width: 100%; height: 100%;">
                <img src="{img}" alt="{name}" loading="lazy" style="width: 100%; height: 100%; object-fit: contain; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" />
              </a>
            </div>
            <div style="color: #D68E1D; font-size: 13px; margin-bottom: 4px;">★★★★★ <span style="color: #8A7B70; font-size: 12px;">(4.9)</span></div>
            <h3 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 700; line-height: 1.4; margin: 0 0 8px 0;">
              <a href="product-detail.html?id={pid}" style="color: #2F221A; text-decoration: none;">{name}</a>
            </h3>
            <p style="font-size: 12.5px; color: #6E6259; line-height: 1.5; margin: 0 0 14px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{desc}</p>
          </div>
          <div>
            <div style="display: flex; align-items: baseline; gap: 8px; margin-bottom: 12px;">
              <span class="o-product-thumbnail__price" style="font-size: 17px; font-weight: 700; color: #D68E1D;">{sale_price}</span>
              <span style="font-size: 13px; color: #A89F91; text-decoration: line-through;">{reg_price}</span>
            </div>
            <button type="button" class="o-btn is-primary is-dark is-smaller" data-add-to-cart style="width: 100%; background: #2F221A; color: #FAF6F1; border: none; padding: 10px 16px; border-radius: 4px; font-size: 12px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; cursor: pointer; transition: background 0.2s ease;">
              THÊM VÀO GIỎ
            </button>
          </div>
        </div>
    '''

# Generate complete new c-featured-collections HTML
cards_html = "".join([generate_product_card(p, i) for i, p in enumerate(products)])

new_featured_collections_html = f'''
<section class="c-featured-collections s54-featured-section" style="background-color: #FAF8F5; padding: 80px 20px;">
  <div class="o-wrapper" style="max-width: 1280px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 40px;">
      <span style="color: #D68E1D; font-size: 12px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 10px;">DANH MỤC TUYỂN CHỌN</span>
      <h2 style="font-family: 'Cormorant Garamond', Georgia, serif; font-size: clamp(32px, 4.5vw, 48px); font-weight: 700; color: #2F221A; margin: 0 0 16px 0;">Sản Phẩm Bán Chạy Nhất</h2>
      <p style="font-size: 15px; color: #6E6259; max-width: 650px; margin: 0 auto 28px;">Khám phá các dòng cà phê hòa tan 3in1 tiện lợi, cà phê hạt rang Robusta nguyên chất và máy xay cà phê thủ công cao cấp của S54 Coffee.</p>
      
      <!-- Filter Tabs -->
      <div class="s54-filter-tabs" style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
        <button type="button" class="s54-filter-btn is-active" onclick="filterS54Prods(this, 'all')" style="background: #2F221A; color: #FFFFFF; border: 1px solid #2F221A; padding: 8px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer;">Tất Cả Sản Phẩm</button>
        <button type="button" class="s54-filter-btn" onclick="filterS54Prods(this, 'Cà phê hòa tan')" style="background: #FFFFFF; color: #2F221A; border: 1px solid #D8CEBE; padding: 8px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer;">☕ Cà Phê Hòa Tan 3in1</button>
        <button type="button" class="s54-filter-btn" onclick="filterS54Prods(this, 'Cà phê hạt rang')" style="background: #FFFFFF; color: #2F221A; border: 1px solid #D8CEBE; padding: 8px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer;">🌱 Cà Phê Hạt Rang Mộc</button>
        <button type="button" class="s54-filter-btn" onclick="filterS54Prods(this, 'Máy xay cà phê cầm tay')" style="background: #FFFFFF; color: #2F221A; border: 1px solid #D8CEBE; padding: 8px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer;">⚙️ Máy Xay Cà Phê Cầm Tay</button>
      </div>
    </div>

    <!-- Product Grid: 4 columns on desktop, 2 on mobile -->
    <div id="s54-home-products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 24px; margin-bottom: 48px;">
      {cards_html}
    </div>

    <div style="text-align: center;">
      <a href="collections-coffee.html" style="display: inline-flex; align-items: center; gap: 8px; background: #2F221A; color: #FAF6F1; padding: 14px 36px; border-radius: 4px; font-size: 13px; font-weight: 700; text-transform: uppercase; text-decoration: none; letter-spacing: 1px; transition: background 0.2s ease;">
        XEM TẤT CẢ SẢN PHẨM →
      </a>
    </div>
  </div>
  
  <script>
  function filterS54Prods(btn, cat) {{
    document.querySelectorAll('.s54-filter-btn').forEach(b => {{
      b.style.background = '#FFFFFF';
      b.style.color = '#2F221A';
      b.style.borderColor = '#D8CEBE';
    }});
    btn.style.background = '#2F221A';
    btn.style.color = '#FFFFFF';
    btn.style.borderColor = '#2F221A';

    const cards = document.querySelectorAll('.s54-product-card');
    cards.forEach(card => {{
      if (cat === 'all' || card.getAttribute('data-category') === cat) {{
        card.style.display = 'flex';
      }} else {{
        card.style.display = 'none';
      }}
    }});
  }}
  </script>
</section>
'''

for target_file in ['index.html', 'theme/index.html']:
    with open(target_file, 'r', encoding='utf-8') as f:
        html = f.read()

    # Replace <section class="c-featured-collections ... </section>
    new_html = re.sub(
        r'<section class=[\"\']c-featured-collections[\s\S]*?</section>',
        new_featured_collections_html.strip(),
        html
    )

    if new_html != html:
        with open(target_file, 'w', encoding='utf-8') as f:
            f.write(new_html)
        print(f"✓ Replaced mock products in {target_file} with 12 authentic S54 products!")
    else:
        print(f"⚠️ Warning: Could not match c-featured-collections in {target_file}")

print("✅ Homepage mock products replacement complete!")
