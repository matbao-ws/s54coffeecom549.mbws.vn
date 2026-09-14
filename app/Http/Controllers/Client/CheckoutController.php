<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(Request $request, string $locale): View
    {
        $paymentMethods = PaymentMethod::query()
            ->where('status', 'active')
            ->orderBy('id')
            ->get(['id', 'name', 'method_code', 'type']);

        return view('client.checkout.index', [
            'locale' => $locale,
            'paymentMethods' => $paymentMethods,
        ]);
    }
}
