with open('resources/views/client/pages/home.blade.php', 'r', encoding='utf-8') as f:
    c = f.read()

m = {
    '200001': 'combo-12-goi-ca-phe-hoa-tan-s54-dung-thu',
    '200002': 'combo-12-goi-ca-phe-hoa-tan-s54-dung-thu',
    '200003': 'tui-ca-phe-hoa-tan-3in1-s54-coffee-456g',
    '200004': 'combo-2-tui-ca-phe-hoa-tan-3in1-s54',
    '200005': 'combo-2-tui-ca-phe-hoa-tan-3in1-s54',
    '200006': 'ca-phe-hat-rang-robusta-s54-250gr',
    '200007': 'ca-phe-hat-rang-robusta-s54-500gr',
    '200008': 'may-xay-ca-phe-cam-tay-vbz01-5',
    '200009': 'may-xay-ca-phe-cam-tay-vbz08-5',
    '200010': 'may-xay-ca-phe-cam-tay-vbz03-5',
    '200011': 'may-xay-ca-phe-cam-tay-vbs02-5',
    '200012': 'may-xay-ca-phe-cam-tay-kmdj-hc',
}

for k, slug in m.items():
    c = c.replace(f'href="product-detail.html?id={k}"', f'href="/{{{{ $locale }}}}/san-pham/{slug}"')

with open('resources/views/client/pages/home.blade.php', 'w', encoding='utf-8') as f:
    f.write(c)

print('Replaced hrefs in home.blade.php successfully.')
