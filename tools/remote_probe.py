import ftplib
import urllib.request
import ssl

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

FTP_HOST = "203.205.31.252"
FTP_USER = "u513776f0"
FTP_PASS = "1~dzR0hkLJ0~tlgm"

def run_remote_php(code_str, filename="runner.php"):
    wrapped_code = f"""<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/plain; charset=utf-8');
{code_str}
@unlink(__FILE__);
"""
    ftp = ftplib.FTP(FTP_HOST)
    ftp.login(FTP_USER, FTP_PASS)
    ftp.cwd("/httpdocs")
    import io
    ftp.storbinary(f"STOR {filename}", io.BytesIO(wrapped_code.encode("utf-8")))
    ftp.quit()

    url = f"https://s54coffeecom549.mbws.vn/{filename}"
    req = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"})
    try:
        with urllib.request.urlopen(req, context=ctx, timeout=15) as resp:
            return resp.read().decode("utf-8")
    except urllib.error.HTTPError as e:
        return f"HTTP {e.code}: {e.read().decode('utf-8', errors='ignore')}"
    except Exception as e:
        return f"Error: {e}"

def run_remote_cli(code_str):
    runner_code = f"""<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/plain; charset=utf-8');

$tmpScript = __DIR__ . '/cli_' . uniqid() . '.php';
file_put_contents($tmpScript, <?php\\n{code_str}\\n?>);
$cmd = '/opt/plesk/php/8.2/bin/php ' . escapeshellarg($tmpScript) . ' 2>&1';
$output = shell_exec($cmd);
@unlink($tmpScript);
@unlink(__FILE__);
echo $output;
"""
    # Wait, avoid raw string syntax issues in php code generation:
    runner_code = """<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/plain; charset=utf-8');

$tmpScript = __DIR__ . '/cli_' . uniqid() . '.php';
$code = base64_decode('""" + __import__("base64").b64encode(f"<?php\n{code_str}\n".encode("utf-8")).decode("ascii") + """');
file_put_contents($tmpScript, $code);
$cmd = '/opt/plesk/php/8.2/bin/php ' . escapeshellarg($tmpScript) . ' 2>&1';
$output = shell_exec($cmd);
@unlink($tmpScript);
@unlink(__FILE__);
echo $output;
"""
    ftp = ftplib.FTP(FTP_HOST)
    ftp.login(FTP_USER, FTP_PASS)
    ftp.cwd("/httpdocs")
    import io
    filename = "cli_runner.php"
    ftp.storbinary(f"STOR {filename}", io.BytesIO(runner_code.encode("utf-8")))
    ftp.quit()

    url = f"https://s54coffeecom549.mbws.vn/{filename}"
    req = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"})
    try:
        with urllib.request.urlopen(req, context=ctx, timeout=30) as resp:
            return resp.read().decode("utf-8")
    except urllib.error.HTTPError as e:
        return f"HTTP {e.code}: {e.read().decode('utf-8', errors='ignore')}"
    except Exception as e:
        return f"Error: {e}"


if __name__ == "__main__":
    test_code = """
echo "PHP CLI VERSIONS:" . PHP_EOL;
echo shell_exec('/opt/plesk/php/8.2/bin/php -v') . PHP_EOL;
echo shell_exec('/opt/plesk/php/8.3/bin/php -v') . PHP_EOL;
echo "TEST MYSQL CONNECTION:" . PHP_EOL;
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_c3c66f76;charset=utf8mb4', 'db_c3c66f76', 'oVkoa?B0p_t9ePk6');
    echo "MYSQL CONNECT SUCCESS!" . PHP_EOL;
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "TABLES (" . count($tables) . "): " . implode(', ', $tables) . PHP_EOL;
} catch (Exception $e) {
    echo "MYSQL CONNECT FAILED: " . $e->getMessage() . PHP_EOL;
}
"""
    output = run_remote_php(test_code)
    print(output)
