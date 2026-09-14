from remote_probe import run_remote_php

code = r"""
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$o = \App\Models\Order::where('order_number', 'ORD-LMOAOXGESW')->first();
if ($o) {
    echo "CONFIRMED IN DB! ID: {$o->id} | Number: {$o->order_number} | GrandTotal: {$o->grand_total} | Cust: {$o->customer_name} | Phone: {$o->customer_phone} | Method: {$o->payment_method} | Status: {$o->status}\n";
    foreach ($o->items as $it) {
        echo "  - Item: {$it->product_name} | Qty: {$it->quantity} | Unit: {$it->price} | Total: {$it->total}\n";
    }
} else {
    echo "Order not found in DB!\n";
}
"""

print(run_remote_php(code))
