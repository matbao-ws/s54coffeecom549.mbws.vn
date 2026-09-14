from remote_probe import run_remote_php

code = r"""
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$bt = \App\Models\PaymentMethod::where('method_code', 'bank_transfer')->first();
if ($bt) {
    echo "BANK TRANSFER CONFIG:\n";
    print_r($bt->toArray());
}
"""

print(run_remote_php(code))
