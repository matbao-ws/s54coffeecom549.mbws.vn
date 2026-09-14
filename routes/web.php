<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $defaultLocale = app(\App\Services\LanguageRegistry::class)->defaultLocale() ?: 'vi';
    return redirect('/' . $defaultLocale);
});

Route::get('index.html', function () {
    $defaultLocale = app(\App\Services\LanguageRegistry::class)->defaultLocale() ?: 'vi';
    return redirect('/' . $defaultLocale);
});

// Root-level aliases redirecting to localized client routes
Route::get('collections', fn () => redirect('/vi/san-pham', 301));
Route::get('collections/{any?}', fn () => redirect('/vi/san-pham', 301))->where('any', '.*');
Route::get('collections-coffee.html', fn () => redirect('/vi/san-pham', 301));
Route::get('products/{slug}', fn ($slug) => redirect('/vi/san-pham/' . $slug, 301));
Route::get('blogs/{any?}', fn () => redirect('/vi/tin-tuc', 301))->where('any', '.*');
Route::get('pages/{slug}', fn ($slug) => redirect('/vi/pages/' . $slug, 301));
Route::get('wholesale.html', fn () => redirect('/vi/pages/wholesale', 301));
Route::get('wholesale', fn () => redirect('/vi/pages/wholesale', 301));
Route::get('our-story.html', fn () => redirect('/vi/pages/our-story', 301));
Route::get('our-story', fn () => redirect('/vi/pages/our-story', 301));
Route::get('contact.html', fn () => redirect('/vi/pages/wholesale#contact', 301));

// Cart & Checkout Aliases
Route::get('cart', fn () => redirect('/vi/cart', 301));
Route::get('cart.html', fn () => redirect('/vi/cart', 301));
Route::get('checkout', fn () => redirect('/vi/checkout', 301));
Route::get('checkout.html', fn () => redirect('/vi/checkout', 301));
Route::get('{any}/checkout.html', fn () => redirect('/vi/checkout', 301))->where('any', '.*');
Route::get('{any}/cart.html', fn () => redirect('/vi/cart', 301))->where('any', '.*');

Route::get('/login', fn () => redirect('/' . app(\App\Services\LanguageRegistry::class)->defaultLocale() . '/admin/login'))->name('login');
Route::get('/api/docs', [\App\Http\Controllers\Api\PublicController::class, 'docs'])->name('api.docs');

Route::get('/customer/reset-password/{token}', [\App\Http\Controllers\Auth\CustomerResetPasswordController::class, 'create'])->name('customer.password.reset');
Route::post('/customer/reset-password', [\App\Http\Controllers\Auth\CustomerResetPasswordController::class, 'store'])
    ->middleware('throttle:public-auth')
    ->name('customer.password.update');

if (config('app.payment_mock_enabled') && app()->environment(['local', 'testing'])) {
    Route::get('/payment/vnpay/mock', [\App\Http\Controllers\Api\PublicController::class, 'vnpayMockPayment'])->name('vnpay.mock');
    Route::post('/payment/vnpay/mock/submit', [\App\Http\Controllers\Api\PublicController::class, 'vnpayMockSubmit'])
        ->middleware('throttle:10,1')
        ->name('vnpay.mock.submit');
}
