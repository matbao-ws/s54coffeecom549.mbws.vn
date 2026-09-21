import sys
sys.path.append('tools')
sys.stdout.reconfigure(encoding='utf-8')
from remote_probe import run_remote_cli

code = """
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\\Contracts\\Console\\Kernel::class);
$kernel->bootstrap();

echo "=== POSTS ===" . PHP_EOL;
foreach (\\App\\Models\\Post::all() as $p) {
    echo "Post ID: {$p->id} | slug: {$p->slug}" . PHP_EOL;
    echo "  vi title: {$p->title}" . PHP_EOL;
    echo "  en title: " . ($p->getTranslation('title', 'en') ?: 'NULL') . PHP_EOL;
    echo "  vi summary len: " . strlen($p->summary ?? '') . PHP_EOL;
    echo "  en summary len: " . strlen($p->getTranslation('summary', 'en') ?? '') . PHP_EOL;
    echo "  vi content len: " . strlen($p->content ?? '') . PHP_EOL;
    echo "  en content len: " . strlen($p->getTranslation('content', 'en') ?? '') . PHP_EOL;
    echo "  en content raw: " . substr($p->getTranslation('content', 'en') ?? '', 0, 80) . PHP_EOL;
}

echo "=== PRODUCTS ===" . PHP_EOL;
foreach (\\App\\Models\\Product::all() as $prod) {
    echo "Prod ID: {$prod->id} | slug: {$prod->slug}" . PHP_EOL;
    echo "  vi name: {$prod->name}" . PHP_EOL;
    echo "  en name: " . ($prod->getTranslation('name', 'en') ?: 'NULL') . PHP_EOL;
    echo "  vi short_desc len: " . strlen($prod->short_description ?? '') . PHP_EOL;
    echo "  en short_desc len: " . strlen($prod->getTranslation('short_description', 'en') ?? '') . PHP_EOL;
    echo "  vi desc len: " . strlen($prod->description ?? '') . PHP_EOL;
    echo "  en desc len: " . strlen($prod->getTranslation('description', 'en') ?? '') . PHP_EOL;
    echo "  en desc raw: " . substr($prod->getTranslation('description', 'en') ?? '', 0, 80) . PHP_EOL;
}

echo "=== PAGES ===" . PHP_EOL;
foreach (\\App\\Models\\Page::all() as $page) {
    echo "Page ID: {$page->id} | slug: {$page->slug}" . PHP_EOL;
    echo "  vi title: {$page->title}" . PHP_EOL;
    echo "  en title: " . ($page->getTranslation('title', 'en') ?: 'NULL') . PHP_EOL;
    echo "  vi html len: " . strlen($page->published_html ?? '') . PHP_EOL;
    echo "  en html len: " . strlen($page->getTranslation('published_html', 'en') ?? '') . PHP_EOL;
}

echo "=== CATEGORIES ===" . PHP_EOL;
foreach (\\App\\Models\\Category::all() as $c) {
    echo "Cat ID: {$c->id} | slug: {$c->slug}" . PHP_EOL;
    echo "  vi name: {$c->name}" . PHP_EOL;
    echo "  en name: " . ($c->getTranslation('name', 'en') ?: 'NULL') . PHP_EOL;
}
"""

res = run_remote_cli(code)
print(res)
