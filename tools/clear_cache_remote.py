import sys
sys.path.append('tools')
sys.stdout.reconfigure(encoding='utf-8')
from remote_probe import run_remote_cli

code = """
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\\Contracts\\Console\\Kernel::class);
$kernel->bootstrap();
Illuminate\\Support\\Facades\\Artisan::call('view:clear');
echo 'View clear: ' . Illuminate\\Support\\Facades\\Artisan::output() . PHP_EOL;
Illuminate\\Support\\Facades\\Artisan::call('route:clear');
echo 'Route clear: ' . Illuminate\\Support\\Facades\\Artisan::output() . PHP_EOL;
Illuminate\\Support\\Facades\\Artisan::call('config:clear');
echo 'Config clear: ' . Illuminate\\Support\\Facades\\Artisan::output() . PHP_EOL;
"""
print(run_remote_cli(code))
