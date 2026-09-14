<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request, string $locale): View
    {
        return view('client.cart.index', [
            'locale' => $locale,
        ]);
    }
}
