from remote_probe import run_remote_php

code = r"""
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (\App\Models\Product::where('is_active', true)->get() as $p) {
    echo "ID: {$p->id} | Slug: {$p->slug} | Name: {$p->name}\n";
}
"""

print(run_remote_php(code))
