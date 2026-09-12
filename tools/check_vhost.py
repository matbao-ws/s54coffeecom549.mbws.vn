import sys, os
sys.path.insert(0, os.path.dirname(os.path.dirname(__file__)))
from tools.remote_probe import run_remote_php


code = """
echo "=== VHOST CONFIG CHECK ===" . PHP_EOL;
echo shell_exec('grep -rn "php" /var/www/vhosts/system/s54coffeecom549.mbws.vn/conf/ 2>&1') . PHP_EOL;
echo "=== PLESK PHP-FPM SOCKETS ===" . PHP_EOL;
echo shell_exec('ls -la /var/www/vhosts/system/s54coffeecom549.mbws.vn/ 2>&1') . PHP_EOL;
echo shell_exec('ls -la /run/plesk-php* 2>&1') . PHP_EOL;
"""
print(run_remote_php(code))
