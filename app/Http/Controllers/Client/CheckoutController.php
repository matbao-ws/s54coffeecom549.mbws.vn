<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(Request $request, string $locale): View
    {
        $paymentMethods = PaymentMethod::query()
            ->where('status', 'active')
            ->orderBy('id')
            ->get(['id', 'name', 'method_code', 'type', 'settings']);

        $shipping = app(ShippingService::class)->getSettings();
        $shippingFee = data_get($shipping, 'flat_rate.enabled')
            ? (float) data_get($shipping, 'flat_rate.fee', 0)
            : 0.0;

        return view('client.checkout.index', [
            'locale' => $locale,
            'paymentMethods' => $paymentMethods,
            'shippingFee' => $shippingFee,
        ]);
    }
}
