import sys
import os

sys.path.insert(0, os.path.dirname(os.path.dirname(__file__)))
from tools.remote_probe import run_remote_php, FTP_HOST, FTP_USER, FTP_PASS

import ftplib

ftp = ftplib.FTP(FTP_HOST)
ftp.login(FTP_USER, FTP_PASS)
ftp.cwd("/httpdocs")
try:
    print("FTP SITE CHMOD 0777 storage/app/htmlpurifier:", ftp.sendcmd("SITE CHMOD 0777 storage/app/htmlpurifier"))
except Exception as e:
    print("FTP CHMOD error:", e)
try:
    print("FTP SITE CHMOD 0777 storage/app:", ftp.sendcmd("SITE CHMOD 0777 storage/app"))
except Exception as e:
    print("FTP CHMOD storage/app error:", e)
ftp.quit()

code = """
$dir = 'storage/app/htmlpurifier';
echo "is_writable now: " . (is_writable($dir) ? "yes" : "no") . PHP_EOL;
echo "perms: " . substr(sprintf('%o', fileperms($dir)), -4) . PHP_EOL;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\\Contracts\\Console\\Kernel::class);
$kernel->bootstrap();

try {
    $sanitizer = new \\App\\Support\\HtmlSanitizer();
    echo "HtmlSanitizer test: " . $sanitizer->clean('<p>Test <strong>clean</strong></p>') . PHP_EOL;
} catch (Throwable $e) {
    echo "HtmlSanitizer error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
}
"""

print(run_remote_php(code, "test_sanitizer.php"))

