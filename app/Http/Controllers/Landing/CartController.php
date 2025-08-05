<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with(['product', 'merchant'])
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->get();
        $total = $carts->sum('price');
        return view('pages.landing.cart.index', compact('carts', 'total'));
    }

    public function show($id)
    {
        $cart = Cart::with(['product', 'merchant'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        return view('pages.landing.cart.show', compact('cart'));
    }
}
