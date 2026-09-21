import sys
sys.path.append('tools')
sys.stdout.reconfigure(encoding='utf-8')
from remote_probe import run_remote_cli

code = """
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\\Contracts\\Console\\Kernel::class);
$kernel->bootstrap();

// 1. Post 7
$p7 = \\App\\Models\\Post::find(7);
if ($p7) {
    $p7->setTranslation('content', 'en', '<p>A fresh cup of <strong>pure artisan coffee</strong> every morning not only invigorates your spirit but is also a deeply rooted lifestyle ritual in Vietnam. However, distinguishing genuinely clean, unadulterated roasted coffee from commercial blends loaded with corn, burnt soybeans, and artificial flavorings can be challenging.</p><p>At <strong>S54 Coffee</strong>, every batch is carefully crafted to preserve the original, pure terroir and natural aromatics of Central Highlands coffee beans. Here are straightforward, practical tips to help you identify and savor authentic artisan coffee with absolute confidence.</p><p><br /></p><p><strong>1. Signs of 100% Pure Roasted Whole Bean & Ground Coffee</strong></p><p>Clean, additive-free coffee possesses distinctive physical traits that set it completely apart from adulterated mixtures:</p><ul><li><strong>Color and Texture:</strong> Pure ground coffee boasts a natural amber or deep chestnut brown shade. It is fluffy, loose, and never clumps or feels sticky from caramelized sugar or artificial oils.</li><li><strong>Aroma:</strong> Genuine coffee exudes a gentle, nuanced aroma with hints of floral, fruity, or cedar notes—never an overwhelming, pungent synthetic butter perfume.</li><li><strong>Reaction to Boiling Water:</strong> Pure coffee grounds immediately expand and bloom vigorously with bubbling CO2 gas upon contact with hot water. Heavy filler grains sink flat and dense without blooming.</li><li><strong>Extraction Color & Clarity:</strong> Brewed coffee displays an elegant transparent amber to rich brown hue, free from artificial syrupy thickness or opaque black dye.</li></ul><p><strong>2. Choosing the Perfect S54 Roast for Your Taste</strong></p><p>Whether your palate leans toward traditional boldness or modern aromatic finesse, S54 offers dedicated roasts for every preference:</p><ul><li><strong>Bold Robusta:</strong> Higher natural caffeine, rich dark chocolate notes, gentle bitterness, and a lingering sweet aftertaste—the quintessential choice for traditional Vietnamese Phin iced coffee or café au lait.</li><li><strong>Elegant Arabica:</strong> Bright natural acidity, floral and stone fruit bouquets, and moderate caffeine—ideal for Pour-over, Aeropress, or Cold Brew methods.</li><li><strong>Signature Blend:</strong> A harmonious union of Robusta body and Arabica fragrance, delivering a refined, well-rounded cup for discerning coffee lovers.</li></ul><p><strong>3. Storage Secrets for Peak Freshness</strong></p><ul><li>Store coffee beans or grounds in airtight containers or premium zipper bags fitted with one-way degassing valves.</li><li>Keep in a cool, dry place away from direct sunlight, moisture, and high temperatures.</li><li>Best consumed within 30 to 45 days after opening to enjoy the vibrant aroma and peak crema quality.</li></ul><p>Explore our premium <strong>pure roasted coffee</strong> collection at <a href="https://s54coffee.com/en/san-pham">S54 Coffee</a> to start every morning inspired and recharged!</p>');
    $p7->save();
    echo "Updated Post 7 EN content successfully." . PHP_EOL;
}

// 2. Post 4, 5, 6
$p4 = \\App\\Models\\Post::find(4);
if ($p4) {
    $p4->setTranslation('content', 'en', '<p>The name \\'S54\\' is proudly inspired by the S-shaped map of Vietnam and the unified spirit of 54 ethnic brothers and sisters. S54 was founded with the aspiration to share Vietnamese heritage through every bold cup.</p><div class=\\'s54-article-quote\\'>\\'S stands for our resilient S-shaped homeland; 54 symbolizes our 54 united ethnic communities.\\'</div><h2>Aspirations to Elevate Vietnamese Agricultural Heritage</h2><p>We believe that when national identity and cultural traditions unite with modern roasting and quality standards, Vietnamese coffee can proudly captivate connoisseurs across the globe.</p>');
    $p4->save();
    echo "Updated Post 4 EN content successfully." . PHP_EOL;
}

$p5 = \\App\\Models\\Post::find(5);
if ($p5) {
    $p5->setTranslation('content', 'en', '<p>The unmistakable distinction of Vietnamese coffee originates from bold Robusta body, meticulous artisan roasting, and the iconic Phin drip ritual. It is this dedication to authenticity that creates an intense, unforgettable tasting experience for every coffee lover.</p><div class=\\'s54-article-quote\\'>\\'Natural bold body, thick golden crema, and a deeply lingering sweet finish are the exclusive hallmarks of Central Highlands beans.\\'</div><h2>Precision German Hot-Air Roasting Technology</h2><p>S54 Coffee employs convection Hot-Air roasting technology, roasting each bean uniformly from core to surface without scorching, preserving the clean, pristine artisan terroir.</p>');
    $p5->save();
    echo "Updated Post 5 EN content successfully." . PHP_EOL;
}

$p6 = \\App\\Models\\Post::find(6);
if ($p6) {
    $p6->setTranslation('content', 'en', '<p>S54 Coffee is an innovative Vietnamese brand offering premium roasted whole beans and 3in1 instant coffee. Driven by a passion to elevate Vietnamese agricultural value, we provide authentic coffee solutions that energize every new day.</p><div class=\\'s54-article-quote\\'>\\'New Coffee, New Income: Building a thriving, sustainable future alongside Vietnamese coffee farming communities.\\'</div><h2>Closed-Loop Farm-to-Cup Supply Chain</h2><p>From prime harvest regions in Dak Lak and Gia Lai to our modern roasting facility, S54 Coffee rigorously controls 100% of quality from the farm to the cup in your hand.</p>');
    $p6->save();
    echo "Updated Post 6 EN content successfully." . PHP_EOL;
}

// 3. Product 22
$prod22 = \\App\\Models\\Product::find(22);
if ($prod22) {
    $prod22->setTranslation('description', 'en', '<p>Product Information</p><p><br /></p><p>S54 Coffee 3in1 Instant Coffee is the ideal choice for those who love convenient yet deeply satisfying coffee. Crafted in Vietnam, it blends instant coffee, non-dairy creamer, and fine sugar to deliver a delicious cup with a balanced creamy, sweet, and boldly roasted flavor profile, suitable for any moment of your day.</p><p><br /></p><p>Each bag contains 24 convenient sachets (19g each), compact and easy to brew, meeting your need for a quick coffee break at home, in the office, or while traveling.</p><p><br /></p><p>Ingredients</p><ul><li>Non-Dairy Creamer (NDC): Creates a smooth, creamy texture for easy drinking.</li><li>Sugar: Provides balanced sweetness and quick energy.</li><li>Instant Coffee (14%): Delivers rich coffee flavor and revitalizing focus.</li><li>Maltodextrin: Ensures even dissolution and stable flavor harmony.</li><li>Salt: Softens bitterness and enriches coffee depth.</li><li>Synthetic Coffee Aroma: Enhances fragrance and retains rich roast notes upon brewing.</li></ul><p><br /></p><p>Directions for Use</p><ul><li>Hot Coffee: Dissolve 1 sachet in 70ml hot water (85°C – 90°C), stir thoroughly and enjoy.</li><li>Iced Coffee: Dissolve 2 sachets in 50ml hot water, stir well, add ice cubes to fill and enjoy.</li></ul><p><br /></p><p>Key Benefits</p><ul><li>Quickly brews a delicious cup of coffee, convenient for everyday enjoyment.</li><li>Perfect for morning routines, office breaks, or whenever you need an energy boost.</li><li>Easy to brew and portable for flexible use at home, workplace, or on trips.</li></ul>');
    $prod22->save();
    echo "Updated Product 22 EN description successfully." . PHP_EOL;
}

// 4. Product 23 (both VI and EN)
$prod23 = \\App\\Models\\Product::find(23);
if ($prod23) {
    $prod23->description = '<p>Thông tin sản phẩm</p><p><br /></p><p>Combo dùng thử 12 gói cà phê hòa tan 3in1 S54 Coffee là lựa chọn trải nghiệm hoàn hảo dành cho khách hàng mới muốn cảm nhận trọn vẹn vị cà phê Việt thơm ngon, đậm đà và tiện lợi. Từng gói nhỏ được đóng gói tiện dụng theo tiêu chuẩn chất lượng cao của S54.</p><p><br /></p><p>Thành phần</p><ul><li>Cà phê hòa tan nguyên chất (14%)</li><li>Bột kem không sữa (NDC) cao cấp</li><li>Đường tinh luyện bổ sung năng lượng</li><li>Maltodextrine, muối khoáng điều vị, hương cà phê tự nhiên</li></ul><p><br /></p><p>Hướng dẫn sử dụng</p><ul><li>Uống nóng: Hòa tan 1 gói (19g) với 70ml nước sôi, khuấy đều và thưởng thức.</li><li>Uống đá: Hòa tan 2 gói với 60ml nước nóng, khuấy đều rồi thêm đá viên.</li></ul><p><br /></p><p>Bảo quản</p><p>Bảo quản nơi khô ráo, thoáng mát, tránh ánh nắng trực tiếp và nhiệt độ cao.</p>';
    $prod23->setTranslation('description', 'vi', $prod23->description);
    $prod23->setTranslation('description', 'en', '<p>Product Information</p><p><br /></p><p>The S54 3in1 Instant Coffee 12-Sachet Trial Pack is the perfect discovery choice for coffee enthusiasts wanting to experience Vietnam\\'s authentic rich, creamy, and convenient coffee. Each sachet is individually packaged to preserve aroma and flavor freshness.</p><p><br /></p><p>Ingredients</p><ul><li>Pure Instant Coffee (14%)</li><li>Premium Non-Dairy Creamer (NDC)</li><li>Refined sugar for balanced sweetness</li><li>Maltodextrin, mineral salt, and natural coffee flavor notes</li></ul><p><br /></p><p>Directions for Use</p><ul><li>Hot Coffee: Dissolve 1 sachet (19g) in 70ml hot water, stir well and savor.</li><li>Iced Coffee: Dissolve 2 sachets in 60ml hot water, stir thoroughly, then add ice cubes.</li></ul><p><br /></p><p>Storage</p><p>Store in a cool, dry place away from direct sunlight and high temperatures.</p>');
    $prod23->save();
    echo "Updated Product 23 VI & EN description successfully." . PHP_EOL;
}

// 5. Product 10 (enrich EN)
$prod10 = \\App\\Models\\Product::find(10);
if ($prod10) {
    $prod10->setTranslation('description', 'en', '<p>Product Information</p><p><br /></p><p>The S54 3in1 Instant Coffee 2-Bag Savings Combo (48 sachets total) is crafted for daily coffee drinkers who demand consistency, premium quality, and optimal value. Made in Vietnam with a harmonious balance of pure instant coffee, velvety non-dairy creamer, and balanced sweetness.</p><p><br /></p><p>Specifications</p><ul><li>Package: 2 Bags x 24 sachets x 19g (Total net weight 912g / 48 sachets)</li><li>Ideal for home pantries, office teams, or gifting</li></ul><p><br /></p><p>Ingredients</p><ul><li>Non-Dairy Creamer (NDC): Velvety, smooth mouthfeel</li><li>Sugar: Balanced energy and gentle sweetness</li><li>Instant Coffee (14%): Bold coffee character and mental alertness</li><li>Maltodextrin, sea salt, and roasted coffee aroma</li></ul><p><br /></p><p>Directions for Use</p><ul><li>Hot Coffee: Dissolve 1 sachet in 70ml – 80ml hot water, stir well.</li><li>Iced Coffee: Dissolve 2 sachets in 50ml – 60ml hot water, stir well, add ice cubes.</li></ul>');
    $prod10->save();
    echo "Updated Product 10 EN description successfully." . PHP_EOL;
}
"""

res = run_remote_cli(code)
print(res)
