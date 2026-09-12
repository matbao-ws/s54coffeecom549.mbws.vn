import sys
import os
import ftplib

sys.stdout.reconfigure(encoding='utf-8')

sys.path.insert(0, os.path.dirname(os.path.dirname(__file__)))
from tools.remote_probe import run_remote_php, FTP_HOST, FTP_USER, FTP_PASS

print("Ensuring storage directories have 0777 permissions...")
ftp = ftplib.FTP(FTP_HOST)
ftp.login(FTP_USER, FTP_PASS)
ftp.cwd("/httpdocs")

storage_dirs = [
    "storage",
    "storage/app",
    "storage/app/public",
    "storage/app/htmlpurifier",
    "storage/framework",
    "storage/framework/cache",
    "storage/framework/cache/data",
    "storage/framework/sessions",
    "storage/framework/views",
    "storage/logs"
]

for s_dir in storage_dirs:
    try:
        res = ftp.sendcmd(f"SITE CHMOD 0777 {s_dir}")
        print(f"CHMOD 0777 {s_dir}: {res}")
    except Exception as e:
        print(f"CHMOD {s_dir} error: {e}")

ftp.quit()

verify_code = """
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\\Contracts\\Console\\Kernel::class);
$kernel->bootstrap();

app()->setLocale('vi');
\\Illuminate\\Support\\Facades\\URL::defaults(['locale' => 'vi']);
view()->share('errors', new \\Illuminate\\Support\\ViewErrorBag());
$admin = \\App\\Models\\User::first();
auth()->login($admin);

// Run view:clear
echo "--- CLEAR VIEW CACHE ---" . PHP_EOL;
\\Illuminate\\Support\\Facades\\Artisan::call('view:clear');
echo \\Illuminate\\Support\\Facades\\Artisan::output() . PHP_EOL;

// 1. Test HtmlSanitizer
echo "--- TEST HTML SANITIZER ---" . PHP_EOL;
$sanitizer = app(\\App\\Support\\HtmlSanitizer::class);
$cleaned = $sanitizer->clean('<p>Test <strong>Bold</strong> <script>alert(1)</script></p>');
echo "Cleaned result: " . $cleaned . PHP_EOL;

// 2. Test Admin Product Create View
echo "--- TEST PRODUCT CREATE VIEW ---" . PHP_EOL;
try {
    $productController = app(\\App\\Http\\Controllers\\Admin\\Catalog\\ProductController::class);
    $view = $productController->create();
    $rendered = $view->render();
    echo "Product Create View rendered successfully! Length: " . strlen($rendered) . " bytes" . PHP_EOL;
} catch (Throwable $e) {
    echo "Product Create View FAILED: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}

// 3. Test Admin Product Edit View
echo "--- TEST PRODUCT EDIT VIEW ---" . PHP_EOL;
try {
    $product = \\App\\Models\\Product::first();
    if ($product) {
        $productController = app(\\App\\Http\\Controllers\\Admin\\Catalog\\ProductController::class);
        $view = $productController->edit('vi', $product);
        $rendered = $view->render();
        echo "Product Edit View (id {$product->id}) rendered successfully! Length: " . strlen($rendered) . " bytes" . PHP_EOL;
    }
} catch (Throwable $e) {
    echo "Product Edit View FAILED: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
}

// 4. Test Admin Post Edit View (post 5)
echo "--- TEST POST EDIT VIEW ---" . PHP_EOL;
try {
    $post = \\App\\Models\\Post::find(5) ?? \\App\\Models\\Post::first();
    if ($post) {
        $postController = app(\\App\\Http\\Controllers\\Admin\\PostController::class);
        $view = $postController->edit('vi', $post);
        $rendered = $view->render();
        echo "Post Edit View (id {$post->id}) rendered successfully! Length: " . strlen($rendered) . " bytes" . PHP_EOL;
    } else {
        echo "No post found to test edit." . PHP_EOL;
    }
} catch (Throwable $e) {
    echo "Post Edit View FAILED: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}

// 5. Test Admin Post Create View
echo "--- TEST POST CREATE VIEW ---" . PHP_EOL;
try {
    $postController = app(\\App\\Http\\Controllers\\Admin\\PostController::class);
    $view = $postController->create('vi');
    $rendered = $view->render();
    echo "Post Create View rendered successfully! Length: " . strlen($rendered) . " bytes" . PHP_EOL;
} catch (Throwable $e) {
    echo "Post Create View FAILED: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}

// 6. Test Admin Category Create View
echo "--- TEST CATEGORY CREATE VIEW ---" . PHP_EOL;
try {
    $categoryController = app(\\App\\Http\\Controllers\\Admin\\Catalog\\CategoryController::class);
    $view = $categoryController->create();
    $rendered = $view->render();
    echo "Category Create View rendered successfully! Length: " . strlen($rendered) . " bytes" . PHP_EOL;
} catch (Throwable $e) {
    echo "Category Create View FAILED: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
}

// 8. Test Post sanitization flow
echo "--- TEST POST CONTENT SANITIZATION FLOW ---" . PHP_EOL;
try {
    $sanitizer = app(\\App\\Support\\HtmlSanitizer::class);
    $dirtyContent = '<p>Thử nghiệm bài viết <strong>S54 Coffee</strong> với thẻ lạ <script>alert("hack")</script> và <img src="/uploads/test.jpg" alt="test"></p>';
    $cleanContent = $sanitizer->clean($dirtyContent);
    echo "Sanitized Content: " . $cleanContent . PHP_EOL;
    if (str_contains($cleanContent, '<script>')) {
        echo "FAIL: Script not stripped!" . PHP_EOL;
    } else {
        echo "PASS: Script stripped safely and HTML correctly sanitized." . PHP_EOL;
    }
} catch (Throwable $e) {
    echo "Sanitization test FAILED: " . $e->getMessage() . PHP_EOL;
}

// 7. Test Admin Brand Create View
echo "--- TEST BRAND CREATE VIEW ---" . PHP_EOL;
try {
    $brandController = app(\\App\\Http\\Controllers\\Admin\\Catalog\\BrandController::class);
    $view = $brandController->create();
    $rendered = $view->render();
    echo "Brand Create View rendered successfully! Length: " . strlen($rendered) . " bytes" . PHP_EOL;
} catch (Throwable $e) {
    echo "Brand Create View FAILED: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
}
"""

print("Running remote verification...")
output = run_remote_php(verify_code, "verify_crud_fix.php")
print(output)
