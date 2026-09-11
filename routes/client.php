<?php

use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\CatalogController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PageController;
use App\Http\Controllers\Client\PostCategoryController;
use Illuminate\Support\Facades\Route;

// Storefront Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

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

// Sandbox for inline editing
if (app()->environment(['local', 'testing'])) {
    Route::view('sandbox/inline-editor', 'client.dev.toolbar-sandbox')
        ->name('dev.toolbar-sandbox');
    Route::view('sandbox/inline-editor-stress', 'client.dev.toolbar-stress')
        ->name('dev.toolbar-stress');
}
