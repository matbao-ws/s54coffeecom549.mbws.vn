<?php

use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\CatalogController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PageController;
use App\Http\Controllers\Client\PostCategoryController;
use Illuminate\Support\Facades\Route;

// Storefront Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shopping Cart & Checkout
Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');

// Legacy & Relative URL redirects to ensure no 404s
Route::get('cart.html', fn (string $locale) => redirect()->route('client.cart', ['locale' => $locale], 301));
Route::get('checkout.html', fn (string $locale) => redirect()->route('client.checkout', ['locale' => $locale], 301));
Route::get('gio-hang', fn (string $locale) => redirect()->route('client.cart', ['locale' => $locale], 301));
Route::get('thanh-toan', fn (string $locale) => redirect()->route('client.checkout', ['locale' => $locale], 301));
Route::get('san-pham/cart.html', fn (string $locale) => redirect()->route('client.cart', ['locale' => $locale], 301));
Route::get('san-pham/checkout.html', fn (string $locale) => redirect()->route('client.checkout', ['locale' => $locale], 301));
Route::get('wholesale', fn (string $locale) => redirect()->route('client.pages.show', ['locale' => $locale, 'slug' => 'wholesale'], 301));
Route::get('wholesale.html', fn (string $locale) => redirect()->route('client.pages.show', ['locale' => $locale, 'slug' => 'wholesale'], 301));
Route::get('our-story', fn (string $locale) => redirect()->route('client.pages.show', ['locale' => $locale, 'slug' => 'our-story'], 301));
Route::get('our-story.html', fn (string $locale) => redirect()->route('client.pages.show', ['locale' => $locale, 'slug' => 'our-story'], 301));
Route::get('contact', fn (string $locale) => redirect()->route('client.contact', ['locale' => $locale], 301));
Route::get('contact.html', fn (string $locale) => redirect()->route('client.contact', ['locale' => $locale], 301));
Route::get('lien-he.html', fn (string $locale) => redirect()->route('client.contact', ['locale' => $locale], 301));
Route::get('policy-privacy.html', fn (string $locale) => redirect()->route('client.pages.show', ['locale' => $locale, 'slug' => 'chinh-sach-bao-mat'], 301));
Route::get('policy-shipping.html', fn (string $locale) => redirect()->route('client.pages.show', ['locale' => $locale, 'slug' => 'chinh-sach-van-chuyen'], 301));
Route::get('policy-returns.html', fn (string $locale) => redirect()->route('client.pages.show', ['locale' => $locale, 'slug' => 'chinh-sach-doi-tra'], 301));
Route::get('blogs-news.html', fn (string $locale) => redirect()->route('client.blog.index', ['locale' => $locale], 301));
Route::get('blog-detail.html', fn (string $locale) => redirect()->route('client.blog.index', ['locale' => $locale], 301));
Route::get('collections-coffee.html', fn (string $locale) => redirect()->route('client.catalog.index', ['locale' => $locale], 301));
Route::get('order-tracking.html', fn (string $locale) => redirect()->route('client.cart', ['locale' => $locale], 301));
Route::get('order-success.html', fn (string $locale) => redirect()->route('client.cart', ['locale' => $locale], 301));
Route::get('product-detail.html', function (\Illuminate\Http\Request $request, string $locale) {
    $id = (string) $request->query('id');
    $map = [
        '200003' => 'tui-ca-phe-hoa-tan-3in1-s54-coffee-456g',
        '200007' => 'ca-phe-hat-rang-robusta-s54-500gr',
        '200002' => 'combo-12-goi-ca-phe-hoa-tan-s54-dung-thu',
        '200008' => 'may-xay-ca-phe-cam-tay-vbz01-5',
    ];
    $slug = $map[$id] ?? null;
    return $slug
        ? redirect()->route('client.products.show', ['locale' => $locale, 'slug' => $slug], 301)
        : redirect()->route('client.catalog.index', ['locale' => $locale], 301);
});

// Contact Page
Route::get('lien-he', [PageController::class, 'contact'])->name('contact');


// Catalog / Products
Route::get('san-pham', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('san-pham/{slug}', [CatalogController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-_]+')
    ->name('products.show');

// CMS Pages (Our Story, Wholesale, etc.)
Route::get('pages/{slug}', [PageController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-_]+')
    ->name('pages.show');

// Blog / Cẩm nang
Route::get('tin-tuc', [BlogController::class, 'index'])->name('blog.index');
Route::get('tin-tuc/{slug}', [BlogController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-_]+')
    ->name('blog.show');

// Categories & Post Categories
Route::get('danh-muc/{slug}', [CategoryController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-_]+')
    ->name('categories.show');

Route::get('chuyen-muc/{slug}', [PostCategoryController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-_]+')
    ->name('post-categories.show');

// Theme/legacy URL aliases
Route::get('collections', fn (string $locale) => redirect()->route('client.catalog.index', ['locale' => $locale]));
Route::get('collections/{any?}', fn (string $locale) => redirect()->route('client.catalog.index', ['locale' => $locale]))->where('any', '.*');
Route::get('products/{slug}', fn (string $locale, string $slug) => redirect()->route('client.products.show', ['locale' => $locale, 'slug' => $slug]));
Route::get('blogs/{any?}', fn (string $locale) => redirect()->route('client.blog.index', ['locale' => $locale]))->where('any', '.*');
Route::get('blog', fn (string $locale) => redirect()->route('client.blog.index', ['locale' => $locale]));
Route::get('blog/{any?}', fn (string $locale) => redirect()->route('client.blog.index', ['locale' => $locale]))->where('any', '.*');

// Sandbox for inline editing
if (app()->environment(['local', 'testing'])) {
    Route::view('sandbox/inline-editor', 'client.dev.toolbar-sandbox')
        ->name('dev.toolbar-sandbox');
    Route::view('sandbox/inline-editor-stress', 'client.dev.toolbar-stress')
        ->name('dev.toolbar-stress');
}
