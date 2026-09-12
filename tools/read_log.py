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
    print("FTP SITE CHMOD 0777 public:", ftp.sendcmd("SITE CHMOD 0777 public"))
except Exception as e:
    print("FTP CHMOD public error:", e)
ftp.quit()


code = """
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\\Contracts\\Console\\Kernel::class);
$kernel->bootstrap();

\\Illuminate\\Support\\Facades\\Storage::disk('public')->delete([
    'general/test-banner-4a6e1f.png',
    'general/test-banner-a68669.png'
]);
echo "Test files deleted successfully." . PHP_EOL;
"""

print(run_remote_php(code, "delete_tests.php"))






print(run_remote_php(code, "tail_log.php"))
