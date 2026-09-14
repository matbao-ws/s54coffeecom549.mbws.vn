from remote_probe import run_remote_php

code = r"""
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$o = \App\Models\Order::find(12);
if ($o) {
    echo "ORDER #12 ATTRIBUTES:\n";
    print_r($o->toArray());
    echo "\nORDER #12 ITEMS:\n";
    print_r($o->items->toArray());
} else {
    echo "Order 12 not found\n";
}
"""

print(run_remote_php(code))
