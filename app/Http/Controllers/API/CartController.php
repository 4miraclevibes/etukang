<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CartController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray(),
                'hint' => 'Periksa kembali data yang dikirim'
            ], 422);
        }

        $merchant = Product::find($request->product_id)->merchant;

        if (!$merchant) {
            return response()->json([
                'success' => false,
                'message' => 'Merchant tidak ditemukan',
            ], 404);
        }

        $cart = Cart::create([
            'user_id' => Auth::user()->id,
            'merchant_id' => $merchant->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price * $request->quantity,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dibuat',
            'data' => $cart
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray(),
                'hint' => 'Periksa kembali data yang dikirim'
            ], 422);
        }

        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang tidak ditemukan',
            ], 404);
        }

        $cart->update([
            'quantity' => $request->quantity,
            'price' => $cart->product->price * $request->quantity,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diubah',
            'data' => $cart
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $cart = Cart::find($id);


        if (!$cart) {
            return response()->json([
                    'success' => false,
                    'message' => 'Keranjang tidak ditemukan',
                ], 404);
        }

        $cart->update([
            'status' => 'deleted'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dihapus',
            'data' => $cart
        ], 200);
    }
}
