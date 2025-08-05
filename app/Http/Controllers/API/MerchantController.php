<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    public function index(): JsonResponse
    {
        $merchants = Merchant::all();

        return response()->json([
            'success' => true,
            'data' => $merchants
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|min:8',
            'status' => 'required|in:active,inactive,pending',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray(),
                'hint' => 'Periksa kembali data yang dikirim'
            ], 422);
        }

        // Cek apakah user sudah memiliki merchant
        if (Auth::user()->merchant) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah terdaftar sebagai merchant',
            ], 422);
        }

        $merchant = Merchant::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Merchant berhasil dibuat',
            'data' => $merchant
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|min:8',
            'status' => 'required|in:active,inactive,pending',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray(),
                'hint' => 'Periksa kembali data yang dikirim'
            ], 422);
        }

        $merchant = Merchant::find($id);

        if (!$merchant) {
            return response()->json([
                'success' => false,
                'message' => 'Merchant tidak ditemukan',
            ], 404);
        }

        $merchant->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Merchant berhasil diubah',
            'data' => $merchant
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $merchant = Merchant::find($id);

        if (!$merchant) {
            return response()->json([
                'success' => false,
                'message' => 'Merchant tidak ditemukan',
            ], 404);
        }

        $merchant->update([
            'status' => 'deleted'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Merchant berhasil dihapus',
        ], 200);
    }
}
