import re
import os
import sys

sys.stdout.reconfigure(encoding='utf-8')

FILTER_NAV_HTML = '''<nav class="c-collection-template__faceted-nav c-faceted-nav" data-filters data-faceted-nav data-filter-inner-draw data-collection-template-featured-filter="Type">

  <div class="c-collection-template__faceted-nav__header is-all-products" data-collection-header>
    <button class="c-collection-template__faceted-nav__open-btn o-btn is-secondary" data-open-filters-button type="button">
      <svg fill="none" class="c-collection-template__faceted-nav__open-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <g stroke="#ac8a62" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
          <path d="m6 12h12"/>
          <path d="m2.25 7.5h19.5"/>
          <path d="m9.75 16.5h4.5"/>
        </g>
      </svg>
      Bộ Lọc (<span data-active-filters-count>0</span>)
    </button>

    <div class="c-faceted-nav__filters-featured is-all-products" data-filters-featured>
      <div class="c-collection-template__faceted-nav__group has-options">
        <ul class="o-ul c-collection-template__facet-featured" data-facet-carousel>
          <li class="c-collection-template__facet-btn-container">
            <button type="button" class="c-collection-template__facet-btn o-btn is-secondary is-selected" data-top-filter="all">Tất Cả (12)</button>
          </li>
          <li class="c-collection-template__facet-btn-container">
            <button type="button" class="c-collection-template__facet-btn o-btn is-secondary is-ice" data-top-filter="instant">Cà Phê Hòa Tan (5)</button>
          </li>
          <li class="c-collection-template__facet-btn-container">
            <button type="button" class="c-collection-template__facet-btn o-btn is-secondary is-ice" data-top-filter="beans">Cà Phê Hạt Rang (2)</button>
          </li>
          <li class="c-collection-template__facet-btn-container">
            <button type="button" class="c-collection-template__facet-btn o-btn is-secondary is-ice" data-top-filter="combo">Combo Dùng Thử (4)</button>
          </li>
          <li class="c-collection-template__facet-btn-container">
            <button type="button" class="c-collection-template__facet-btn o-btn is-secondary is-ice" data-top-filter="grinder">Máy Xay Cà Phê (5)</button>
          </li>
        </ul>
      </div>
    </div>

    <div class="c-collection-template__faceted-nav__sort-container o-btn is-smaller is-secondary">
      <label class="c-collection-template__faceted-nav__sort-label" for="faceted-nav-sort">Sắp xếp theo:</label>
      <select class="c-collection-template__faceted-nav__sort o-input is-select" id="faceted-nav-sort" data-sort>
        <option value="manual">Sắp xếp: Mặc định</option>
        <option value="price-ascending">Giá: Thấp đến Cao</option>
        <option value="price-descending">Giá: Cao đến Thấp</option>
        <option value="title-ascending">Tên: A - Z</option>
        <option value="title-descending">Tên: Z - A</option>
        <option value="best-selling">Bán chạy nhất</option>
      </select>
    </div>
  </div>

  <div class="c-collection-template__faceted-nav__drawer c-faceted-nav__drawer">
    <div class="c-collection-template__faceted-nav__facets" data-faceted-wrapper>
      <div class="c-collection-template__faceted-nav__facets-header" style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem 1.5rem 1rem; border-bottom: 1px solid rgba(172,138,98,0.25);">
        <h4 class="o-heading--5" style="margin: 0; color: #2F221A; font-weight: 700; letter-spacing: 0.05rem;">BỘ LỌC SẢN PHẨM</h4>
        <button class="c-collection-template__faceted-nav__close-btn" data-close-filters-button type="button" aria-label="Đóng bộ lọc">
          <svg fill="none" class="c-collection-template__close-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <g clip-rule="evenodd" fill="#2f221a" fill-rule="evenodd">
              <path d="m21.3536 2.64645c.1952.19526.1952.51184 0 .7071l-18.00005 18.00005c-.19526.1952-.51184.1952-.7071 0-.19527-.1953-.19527-.5119 0-.7072l17.99995-17.99995c.1953-.19527.5119-.19527.7072 0z"/>
              <path d="m2.64645 2.64645c.19526-.19527.51184-.19527.7071 0l18.00005 17.99995c.1952.1953.1952.5119 0 .7072-.1953.1952-.5119.1952-.7072 0l-17.99995-18.00005c-.19527-.19526-.19527-.51184 0-.7071z"/>
            </g>
          </svg>
        </button>
      </div>

      <div class="c-collection-template__faceted-nav__facets-wrapper" data-swatches>
        
        <!-- Nhóm 1: Loại Sản Phẩm -->
        <div class="c-collection-template__faceted-nav__group has-options is-expanded" data-faceted-nav-group data-filter-group="category">
          <h6 class="c-collection-template__faceted-nav-title o-subtitle" data-facet-title>
            <span>Loại Sản Phẩm <span class="s54-filter-selected-badge" data-group-count="category" style="display: none; font-size: 0.75rem; background: #2F221A; color: #FAF6F1; border-radius: 1rem; padding: 0.1rem 0.5rem; margin-left: 0.5rem;"></span></span>
            <svg fill="none" class="c-collection-template__faceted-nav__plus-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g stroke="#2f221a" stroke-linecap="round" stroke-linejoin="round"><path d="m3 12h18"/><path d="m12 3v18"/></g></svg>
            <svg fill="none" class="c-collection-template__faceted-nav__minus-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m3 12h18" stroke="#2f221a" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </h6>
          <div class="c-collection-template__faceted-nav-filters" data-facet-accordion-slide>
            <ul class="o-ul c-collection-template__facet-accordion-body">
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="category" data-filter-value="instant">
                  Cà Phê Hòa Tan 3in1 <span style="opacity: 0.6; font-size: 0.75rem;">(5)</span>
                </button>
              </li>
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="category" data-filter-value="beans">
                  Cà Phê Hạt Rang Mộc <span style="opacity: 0.6; font-size: 0.75rem;">(2)</span>
                </button>
              </li>
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="category" data-filter-value="combo">
                  Combo Tiết Kiệm <span style="opacity: 0.6; font-size: 0.75rem;">(4)</span>
                </button>
              </li>
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="category" data-filter-value="grinder">
                  Máy Xay Cà Phê Cầm Tay <span style="opacity: 0.6; font-size: 0.75rem;">(5)</span>
                </button>
              </li>
            </ul>
          </div>
        </div>

        <!-- Nhóm 2: Khoảng Giá -->
        <div class="c-collection-template__faceted-nav__group has-options is-expanded" data-faceted-nav-group data-filter-group="price">
          <h6 class="c-collection-template__faceted-nav-title o-subtitle" data-facet-title>
            <span>Khoảng Giá <span class="s54-filter-selected-badge" data-group-count="price" style="display: none; font-size: 0.75rem; background: #2F221A; color: #FAF6F1; border-radius: 1rem; padding: 0.1rem 0.5rem; margin-left: 0.5rem;"></span></span>
            <svg fill="none" class="c-collection-template__faceted-nav__plus-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g stroke="#2f221a" stroke-linecap="round" stroke-linejoin="round"><path d="m3 12h18"/><path d="m12 3v18"/></g></svg>
            <svg fill="none" class="c-collection-template__faceted-nav__minus-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m3 12h18" stroke="#2f221a" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </h6>
          <div class="c-collection-template__faceted-nav-filters" data-facet-accordion-slide>
            <ul class="o-ul c-collection-template__facet-accordion-body">
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="price" data-filter-value="under-50">
                  Dưới 50.000₫ <span style="opacity: 0.6; font-size: 0.75rem;">(2)</span>
                </button>
              </li>
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="price" data-filter-value="50-150">
                  50.000₫ – 150.000₫ <span style="opacity: 0.6; font-size: 0.75rem;">(3)</span>
                </button>
              </li>
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="price" data-filter-value="150-300">
                  150.000₫ – 300.000₫ <span style="opacity: 0.6; font-size: 0.75rem;">(2)</span>
                </button>
              </li>
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="price" data-filter-value="over-300">
                  Trên 300.000₫ <span style="opacity: 0.6; font-size: 0.75rem;">(5)</span>
                </button>
              </li>
            </ul>
          </div>
        </div>

        <!-- Nhóm 3: Mức Độ Rang -->
        <div class="c-collection-template__faceted-nav__group has-options is-expanded" data-faceted-nav-group data-filter-group="roast">
          <h6 class="c-collection-template__faceted-nav-title o-subtitle" data-facet-title>
            <span>Mức Độ Rang <span class="s54-filter-selected-badge" data-group-count="roast" style="display: none; font-size: 0.75rem; background: #2F221A; color: #FAF6F1; border-radius: 1rem; padding: 0.1rem 0.5rem; margin-left: 0.5rem;"></span></span>
            <svg fill="none" class="c-collection-template__faceted-nav__plus-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g stroke="#2f221a" stroke-linecap="round" stroke-linejoin="round"><path d="m3 12h18"/><path d="m12 3v18"/></g></svg>
            <svg fill="none" class="c-collection-template__faceted-nav__minus-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m3 12h18" stroke="#2f221a" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </h6>
          <div class="c-collection-template__faceted-nav-filters" data-facet-accordion-slide>
            <ul class="o-ul c-collection-template__facet-accordion-body">
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="roast" data-filter-value="medium">
                  Rang Vừa (Medium Roast) <span style="opacity: 0.6; font-size: 0.75rem;">(5)</span>
                </button>
              </li>
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="roast" data-filter-value="dark">
                  Rang Đậm (Dark Roast Mộc) <span style="opacity: 0.6; font-size: 0.75rem;">(2)</span>
                </button>
              </li>
            </ul>
          </div>
        </div>

        <!-- Nhóm 4: Phương Pháp Pha Chế -->
        <div class="c-collection-template__faceted-nav__group has-options is-expanded" data-faceted-nav-group data-filter-group="brew">
          <h6 class="c-collection-template__faceted-nav-title o-subtitle" data-facet-title>
            <span>Phương Pháp Pha Chế <span class="s54-filter-selected-badge" data-group-count="brew" style="display: none; font-size: 0.75rem; background: #2F221A; color: #FAF6F1; border-radius: 1rem; padding: 0.1rem 0.5rem; margin-left: 0.5rem;"></span></span>
            <svg fill="none" class="c-collection-template__faceted-nav__plus-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g stroke="#2f221a" stroke-linecap="round" stroke-linejoin="round"><path d="m3 12h18"/><path d="m12 3v18"/></g></svg>
            <svg fill="none" class="c-collection-template__faceted-nav__minus-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m3 12h18" stroke="#2f221a" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </h6>
          <div class="c-collection-template__faceted-nav-filters" data-facet-accordion-slide>
            <ul class="o-ul c-collection-template__facet-accordion-body">
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="brew" data-filter-value="instant">
                  Hòa Tan Nhanh 3in1 <span style="opacity: 0.6; font-size: 0.75rem;">(5)</span>
                </button>
              </li>
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="brew" data-filter-value="phin">
                  Pha Phin Truyền Thống <span style="opacity: 0.6; font-size: 0.75rem;">(2)</span>
                </button>
              </li>
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="brew" data-filter-value="espresso">
                  Pha Máy Espresso <span style="opacity: 0.6; font-size: 0.75rem;">(2)</span>
                </button>
              </li>
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="brew" data-filter-value="manual">
                  Cối Xay Cầm Tay Thủ Công <span style="opacity: 0.6; font-size: 0.75rem;">(5)</span>
                </button>
              </li>
            </ul>
          </div>
        </div>

        <!-- Nhóm 5: Quy Cách Đóng Gói -->
        <div class="c-collection-template__faceted-nav__group has-options is-expanded" data-faceted-nav-group data-filter-group="pack">
          <h6 class="c-collection-template__faceted-nav-title o-subtitle" data-facet-title>
            <span>Quy Cách Đóng Gói <span class="s54-filter-selected-badge" data-group-count="pack" style="display: none; font-size: 0.75rem; background: #2F221A; color: #FAF6F1; border-radius: 1rem; padding: 0.1rem 0.5rem; margin-left: 0.5rem;"></span></span>
            <svg fill="none" class="c-collection-template__faceted-nav__plus-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g stroke="#2f221a" stroke-linecap="round" stroke-linejoin="round"><path d="m3 12h18"/><path d="m12 3v18"/></g></svg>
            <svg fill="none" class="c-collection-template__faceted-nav__minus-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m3 12h18" stroke="#2f221a" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </h6>
          <div class="c-collection-template__faceted-nav-filters" data-facet-accordion-slide>
            <ul class="o-ul c-collection-template__facet-accordion-body">
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="pack" data-filter-value="sample">
                  Gói Dùng Thử (5 - 12 gói) <span style="opacity: 0.6; font-size: 0.75rem;">(2)</span>
                </button>
              </li>
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="pack" data-filter-value="bag-456g">
                  Túi 456g (24 gói x 19g) <span style="opacity: 0.6; font-size: 0.75rem;">(1)</span>
                </button>
              </li>
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="pack" data-filter-value="combo-family">
                  Combo Tiết Kiệm (2 - 3 túi) <span style="opacity: 0.6; font-size: 0.75rem;">(2)</span>
                </button>
              </li>
              <li class="c-collection-template__facet-btn-container">
                <button type="button" class="c-collection-template__facet-btn-main o-btn is-smaller o-subtitle" data-filter-group="pack" data-filter-value="bag-beans">
                  Túi Zip Van 1 Chiều (250g - 500g) <span style="opacity: 0.6; font-size: 0.75rem;">(2)</span>
                </button>
              </li>
            </ul>
          </div>
        </div>

      </div>

      <div class="c-collection-template__faceted-nav__footer">
        <button class="c-collection-template__faceted-nav__btn-clear is-main o-btn is-primary is-transparent" data-clear-filters-button type="button">Xóa tất cả bộ lọc</button>
        <button class="c-collection-template__faceted-nav__btn-filter o-btn is-primary is-dark" data-close-filters-button type="button">
          Áp dụng bộ lọc ( <span data-collection-template-product-count>12</span> )
        </button>
      </div>
    </div>
  </div>
</nav>
<div class="c-faceted-nav__drawer-background" data-close-drawer-button></div>'''

PRODUCT_CARD_ATTRS = {
    "100000": 'data-s54-product data-category="instant combo" data-price="15000" data-roast="medium" data-brew="instant" data-pack="sample" data-title="Combo 5 Gói Cà Phê Hòa Tan S54 Dùng Thử" data-sales="990"',
    "100001": 'data-s54-product data-category="instant combo" data-price="35000" data-roast="medium" data-brew="instant" data-pack="sample" data-title="Combo 12 Gói Cà Phê Hòa Tan S54 Dùng Thử" data-sales="950"',
    "100002": 'data-s54-product data-category="instant" data-price="65000" data-roast="medium" data-brew="instant" data-pack="bag-456g" data-title="Túi Cà Phê Hòa Tan 3in1 S54 Coffee 456g" data-sales="900"',
    "100003": 'data-s54-product data-category="instant combo" data-price="119000" data-roast="medium" data-brew="instant" data-pack="combo-family" data-title="Combo 2 Túi Cà Phê Hòa Tan 3in1 S54" data-sales="850"',
    "100004": 'data-s54-product data-category="instant combo" data-price="199000" data-roast="medium" data-brew="instant" data-pack="combo-family" data-title="Combo 3 Túi Cà Phê Hòa Tan 3in1 S54" data-sales="800"',
    "100005": 'data-s54-product data-category="beans" data-price="150000" data-roast="dark" data-brew="phin espresso" data-pack="bag-beans" data-title="Cà Phê Hạt Rang Robusta S54 250gr" data-sales="750"',
    "100006": 'data-s54-product data-category="beans" data-price="225000" data-roast="dark" data-brew="phin espresso" data-pack="bag-beans" data-title="Cà Phê Hạt Rang Robusta S54 500gr" data-sales="700"',
    "100007": 'data-s54-product data-category="grinder" data-price="646000" data-roast="none" data-brew="manual" data-pack="equipment" data-title="Máy Xay Cà Phê Cầm Tay VBZ01-5" data-sales="650"',
    "100008": 'data-s54-product data-category="grinder" data-price="720000" data-roast="none" data-brew="manual" data-pack="equipment" data-title="Máy Xay Cà Phê Cầm Tay VBZ08-5" data-sales="600"',
    "100009": 'data-s54-product data-category="grinder" data-price="805000" data-roast="none" data-brew="manual" data-pack="equipment" data-title="Máy Xay Cà Phê Cầm Tay VBZ03-5" data-sales="550"',
    "100010": 'data-s54-product data-category="grinder" data-price="702000" data-roast="none" data-brew="manual" data-pack="equipment" data-title="Máy Xay Cà Phê Cầm Tay VBS02-5" data-sales="500"',
    "100011": 'data-s54-product data-category="grinder" data-price="350000" data-roast="none" data-brew="manual" data-pack="equipment" data-title="Máy Xay Cà Phê Cầm Tay KMDJ-HC" data-sales="450"',
}

NO_RESULTS_HTML = '''<div class="s54-collection-no-results" data-collection-no-results style="display: none; grid-column: 1 / -1; text-align: center; padding: 5rem 1rem;">
  <div style="font-size: 3.5rem; margin-bottom: 1rem;">☕</div>
  <h3 class="o-heading--4" style="margin-bottom: 0.5rem; color: #2F221A; font-weight: 700;">Không tìm thấy sản phẩm phù hợp</h3>
  <p class="o-paragraph--1" style="color: #6e645e; margin-bottom: 1.5rem; max-width: 400px; margin-left: auto; margin-right: auto;">Hãy thử chọn bộ lọc khác hoặc bỏ bớt tiêu chí để khám phá trọn bộ sưu tập S54 Coffee.</p>
  <button type="button" class="o-btn is-primary is-dark" data-clear-filters-button style="margin: 0 auto; display: inline-flex;">Xóa tất cả bộ lọc</button>
</div>'''

def process_file(file_path):
    print(f"Processing {file_path}...")
    with open(file_path, 'r', encoding='utf-8') as f:
        html = f.read()

    # 1. Mark data-collection-template with data-initialized="true"
    html = re.sub(r'(<section[^>]*class="[^"]*c-collection-template[^"]*"[^>]*data-collection-template)([^>]*)>', 
                  r'\1 data-initialized="true"\2>', html)

    # 2. Replace the entire <nav class="c-collection-template__faceted-nav ... </nav><div class="c-faceted-nav__drawer-background ... </div>
    pattern = r'<nav class="c-collection-template__faceted-nav c-faceted-nav".*?</nav>\s*<div class="c-faceted-nav__drawer-background\s*"\s*data-close-drawer-button>\s*</div>'
    if re.search(pattern, html, re.DOTALL):
        html = re.sub(pattern, FILTER_NAV_HTML, html, count=1, flags=re.DOTALL)
        print("  -> Replaced filter nav and drawer HTML successfully!")
    else:
        print("  -> WARNING: Could not find exact filter nav pattern, attempting fallback match...")
        pattern_fallback = r'<nav class="c-collection-template__faceted-nav c-faceted-nav".*?</nav>\s*<div class="c-faceted-nav__drawer-background[^>]*>\s*</div>'
        html = re.sub(pattern_fallback, FILTER_NAV_HTML, html, count=1, flags=re.DOTALL)

    # 3. Add data attributes to each product card
    for vid, attrs in PRODUCT_CARD_ATTRS.items():
        card_pattern = r'(<div\s+class=\"o-product-thumbnail\s+o-products-list__product-thumbnail\s+has-quickadd\"\s+data-product-thumbnail\s+data-variant-id=\"' + vid + r'\")([^>]*)>'
        def repl(m):
            header = m.group(1)
            rest = m.group(2)
            if 'data-s54-product' in rest:
                return m.group(0)
            return f"{header} {attrs}{rest}>"
        html = re.sub(card_pattern, repl, html)

    # 4. Insert NO_RESULTS_HTML inside <div class="c-collection-template__products-list o-products-list" data-collection-template-products>
    if 'data-collection-no-results' not in html:
        products_list_tag = '<div class="c-collection-template__products-list o-products-list" data-collection-template-products>'
        html = html.replace(products_list_tag, products_list_tag + '\n' + NO_RESULTS_HTML)
        print("  -> Added empty results container!")

    # 5. Link s54-collection-filter.js before </body> if not already there
    if 's54-collection-filter.js' not in html:
        script_tag = '<script src="assets/js/s54-collection-filter.js" type="text/javascript"></script>\n</body>'
        html = html.replace('</body>', script_tag)
        print("  -> Linked s54-collection-filter.js!")

    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(html)
    print(f"  -> Saved {file_path} successfully!\n")

if __name__ == '__main__':
    process_file('collections-coffee.html')
    process_file('theme/collections-coffee.html')
