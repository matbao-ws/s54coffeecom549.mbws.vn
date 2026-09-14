from remote_probe import run_remote_php

code = r"""
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "PRODUCT VARIANTS COUNT: " . \App\Models\ProductVariant::count() . "\n";
foreach (\App\Models\ProductVariant::all() as $pv) {
    echo "PV ID: {$pv->id} | Product ID: {$pv->product_id} | SKU: {$pv->sku}\n";
}
"""

print(run_remote_php(code))
