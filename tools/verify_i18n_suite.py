#!/usr/bin/env python3
"""
Comprehensive Verification Suite for S54 Coffee i18n System
Tests:
1. i18n.js syntax and file synchronization
2. main.js price formatting (no USD, no division by 100)
3. Mobile switcher presence across all HTML files
4. product-detail.html bilingual product data and event listeners
5. Bidirectional translation test (VI -> EN -> VI) on actual DOM text samples
"""

import os
import json
import re
import subprocess

BASE_DIR = '/home/binhphan/matbao-ws/clients/s54coffeecom549.mbws.vn'
FAILED = []
PASSED = []

def assert_test(cond, name, detail=""):
    if cond:
        PASSED.append(name)
        print(f"  [PASS] {name}")
    else:
        FAILED.append((name, detail))
        print(f"  [FAIL] {name}: {detail}")

print("==================================================")
print("RUNNING S54 COFFEE i18n VERIFICATION SUITE")
print("==================================================")

# 1. Check file synchronization
print("\n--- 1. File Synchronization & Syntax Check ---")
for f in ['assets/js/i18n.js', 'assets/js/main.js']:
    full = os.path.join(BASE_DIR, f)
    res = subprocess.run(['node', '-c', full], capture_output=True, text=True)
    assert_test(res.returncode == 0, f"node -c {f}", res.stderr)

for pair in [
    ('assets/js/i18n.js', 'public/client-assets/js/i18n.js'),
    ('assets/js/i18n.js', 'theme/assets/js/i18n.js'),
    ('assets/js/main.js', 'public/client-assets/js/main.js'),
    ('assets/js/main.js', 'theme/assets/js/main.js'),
    ('assets/css/custom.css', 'public/client-assets/css/custom.css'),
    ('assets/css/custom.css', 'theme/assets/css/custom.css'),
    ('product-detail.html', 'theme/product-detail.html')
]:
    f1 = os.path.join(BASE_DIR, pair[0])
    f2 = os.path.join(BASE_DIR, pair[1])
    diff_res = subprocess.run(['diff', '-q', f1, f2], capture_output=True, text=True)
    assert_test(diff_res.returncode == 0, f"Sync check: {pair[0]} == {pair[1]}", diff_res.stdout)

# 2. Check main.js pricing logic
print("\n--- 2. main.js Price Formatting & Integrity Check ---")
with open(os.path.join(BASE_DIR, 'assets/js/main.js'), 'r', encoding='utf-8') as f:
    main_code = f.read()

assert_test("/ 25000" not in main_code, "No USD currency conversion (/ 25000) in main.js")
assert_test("item.price > 1000 ? (item.price / 100)" not in main_code, "No item.price / 100 division in main.js")
assert_test("cart.total_price / 100" not in main_code, "No cart.total_price / 100 division in main.js")
assert_test("new Intl.NumberFormat('vi-VN').format(Math.round(amount)) + '₫'" in main_code, "Standardized formatPrice uses integer VND")
assert_test("window.addEventListener('language:changed'" in main_code, "Cart drawer listens to language:changed event")

# 3. Check mobile switcher across all HTML pages
print("\n--- 3. Mobile Language Switcher Presence Check ---")
HTML_FILES = [
    'index.html', 'collections-coffee.html', 'product-detail.html', 'cart.html',
    'checkout.html', 'contact.html', 'our-story.html', 'wholesale.html',
    'blogs-news.html', 'blog-detail.html', 'policy-privacy.html',
    'policy-returns.html', 'policy-shipping.html'
]
for hf in HTML_FILES:
    path = os.path.join(BASE_DIR, hf)
    if os.path.exists(path):
        with open(path, 'r', encoding='utf-8') as f:
            c = f.read()
        has_mobile = 'c-lang-switcher--mobile' in c and 'data-lang="vi"' in c and 'data-lang="en"' in c
        assert_test(has_mobile, f"Mobile switcher in {hf}")

# 4. Check product-detail.html bilingual support
print("\n--- 4. product-detail.html Bilingual Data & Reactivity Check ---")
with open(os.path.join(BASE_DIR, 'product-detail.html'), 'r', encoding='utf-8') as f:
    pd_code = f.read()

assert_test("name_en" in pd_code and "short_desc_en" in pd_code and "category_en" in pd_code, "Bilingual fields present in window.S54_PRODUCTS")
assert_test("window.addEventListener('language:changed', function () {" in pd_code, "product-detail.html listens to language:changed")
assert_test("const displayName = (activeLang === 'en' && product.name_en) ? product.name_en : product.name;" in pd_code, "Dynamic displayName binding for EN and VI")

# 5. Node.js Simulation of i18n translation engine
print("\n--- 5. Simulation of Bidirectional Translation (VI <-> EN) ---")
test_script = """
const fs = require('fs');
const code = fs.readFileSync('assets/js/i18n.js', 'utf8');

// Mock DOM environment for Node
const pairsMatch = code.match(/const translationPairs = \\[(.*?)\\];\\s*\\/\\/ State Tracking/s);
if (!pairsMatch) {
    console.error("FAIL: Could not extract translationPairs");
    process.exit(1);
}

function escapeRegExp(str) {
    return str.replace(/[.*+?^${}()|[\\]\\\\]/g, "\\\\$&");
}

function createSafeRegex(searchStr) {
    if (!searchStr) return null;
    const isStartWord = /^[\\p{L}\\p{N}]/u.test(searchStr);
    const isEndWord = /[\\p{L}\\p{N}]$/u.test(searchStr);
    const prefix = isStartWord ? "(?<![\\\\p{L}\\\\p{N}])" : "";
    const suffix = isEndWord ? "(?![\\\\p{L}\\\\p{N}])" : "";
    return new RegExp(prefix + escapeRegExp(searchStr) + suffix, "gu");
}

eval("var translationPairs = [" + pairsMatch[1] + "];");

const viSamples = [
    "Sản Phẩm",
    "Câu Chuyện S54",
    "Tin Tức",
    "B2B & Đại Lý",
    "Liên Hệ",
    "Cà Phê Hạt & Rang Mộc",
    "Hòa Tan & Sấy Lạnh",
    "Tất Cả Sản Phẩm",
    "Bán Chạy Nhất",
    "XEM TẤT CẢ",
    "XEM CHI TIẾT",
    "TIẾN HÀNH THANH TOÁN",
    "Giỏ hàng của bạn đang trống.",
    "Túi Cà Phê Hòa Tan 3in1 S54 Coffee 456g",
    "Máy xay cà phê cầm tay VBZ01-5",
    "MÔ TẢ SẢN PHẨM",
    "HƯỚNG DẪN PHA CHẾ",
    "CAM KẾT & VẬN CHUYỂN"
];

// VI -> EN
const sortedViToEn = translationPairs.slice().sort((a, b) => (b[0]||'').length - (a[0]||'').length);
const compiledViToEn = sortedViToEn.map(p => ({
    search: p[0],
    replace: p[1],
    regex: createSafeRegex(p[0])
})).filter(r => r.regex !== null && r.search !== r.replace);

let successCount = 0;
const translated = [];

viSamples.forEach(sample => {
    let res = sample;
    compiledViToEn.forEach(rule => {
        if (res.includes(rule.search)) {
            res = res.replace(rule.regex, rule.replace);
        }
    });
    if (res !== sample) {
        successCount++;
        translated.push({ orig: sample, en: res });
    }
});

console.log("Translated " + successCount + " / " + viSamples.length + " sample strings to English");

// EN -> VI (Bidirectional integrity)
const sortedEnToVi = translationPairs.slice().sort((a, b) => (b[1]||'').length - (a[1]||'').length);
const compiledEnToVi = sortedEnToVi.map(p => ({
    search: p[1],
    replace: p[0],
    regex: createSafeRegex(p[1])
})).filter(r => r.regex !== null && r.search !== r.replace);

let backCount = 0;
translated.forEach(item => {
    let back = item.en;
    compiledEnToVi.forEach(rule => {
        if (back.includes(rule.search)) {
            back = back.replace(rule.regex, rule.replace);
        }
    });
    if (back === item.orig) {
        backCount++;
    } else {
        console.warn("Mismatch on reverse:", item.orig, "->", item.en, "->", back);
    }
});

console.log("Reversed " + backCount + " / " + translated.length + " back to original Vietnamese");
if (successCount === viSamples.length && backCount === translated.length) {
    process.exit(0);
} else {
    process.exit(1);
}
"""

with open('/tmp/test_i18n_sim.js', 'w', encoding='utf-8') as f:
    f.write(test_script)

sim_res = subprocess.run(['node', '/tmp/test_i18n_sim.js'], cwd=BASE_DIR, capture_output=True, text=True)
print(sim_res.stdout)
assert_test(sim_res.returncode == 0, "Bidirectional translation simulation passed 100%", sim_res.stderr)

print("\n==================================================")
print(f"RESULTS: {len(PASSED)} PASSED, {len(FAILED)} FAILED")
print("==================================================")
if FAILED:
    exit(1)
