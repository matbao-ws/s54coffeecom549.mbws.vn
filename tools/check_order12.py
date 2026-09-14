from remote_probe import run_remote_php

code = r"""
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$o = \App\Models\Order::find(12);
echo "Order 12 notes: " . ($o ? $o->notes : 'none') . "\n";
echo "Order 12 histories:\n";
foreach (\App\Models\OrderStatusHistory::where('order_id', 12)->get() as $h) {
    echo "  -> Note: {$h->note} | Created: {$h->created_at}\n";
}
"""

print(run_remote_php(code))
