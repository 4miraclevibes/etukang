<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return view('pages.merchant.profile', compact('merchant'));
        }

        return view('pages.merchant.profile', compact('merchant'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Check if user already has merchant profile
        if ($user->merchant) {
            return response()->json([
                'message' => 'Anda sudah memiliki merchant profile',
                'error' => 'MERCHANT_EXISTS'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ], [
            'name.required' => 'Nama merchant wajib diisi.',
            'name.string' => 'Nama merchant harus berupa teks.',
            'name.max' => 'Nama merchant maksimal 255 karakter.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.string' => 'Nomor telepon harus berupa teks.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat maksimal 500 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $merchant = Merchant::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 'active',
        ]);

        return response()->json([
            'message' => 'Merchant profile berhasil dibuat',
            'data' => $merchant
        ], 201);
    }

    public function update(Request $request)
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return response()->json([
                'message' => 'Anda belum memiliki merchant profile',
                'error' => 'MERCHANT_NOT_FOUND'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ], [
            'name.required' => 'Nama merchant wajib diisi.',
            'name.string' => 'Nama merchant harus berupa teks.',
            'name.max' => 'Nama merchant maksimal 255 karakter.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.string' => 'Nomor telepon harus berupa teks.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat maksimal 500 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $merchant->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json([
            'message' => 'Merchant profile berhasil diperbarui',
            'data' => $merchant
        ]);
    }
}
