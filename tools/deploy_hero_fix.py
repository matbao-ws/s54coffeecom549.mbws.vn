import os
import sys
from pathlib import Path

BASE_DIR = Path(__file__).resolve().parent.parent
sys.path.append(str(BASE_DIR / "tools"))

from deploy_files import upload_files
from remote_probe import run_remote_php

files = [
    "resources/views/client/pages/home.blade.php",
    "assets/css/custom.css",
    "public/client-assets/css/custom.css",
    "theme/assets/css/custom.css"
]

print("Deploying updated hero ratio and custom.css files...")
upload_files(files)

print("\nClearing compiled Blade view cache...")
clear_views_code = """
$viewsPath = __DIR__ . '/storage/framework/views';
if (is_dir($viewsPath)) {
    $files = glob($viewsPath . '/*');
    $count = 0;
    foreach ($files as $file) {
        if (is_file($file)) {
            @unlink($file);
            $count++;
        }
    }
    echo "Cleared $count compiled view cache files.\\n";
}
"""
res = run_remote_php(clear_views_code)
print("Remote result:", res)
