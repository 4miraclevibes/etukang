<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'sertifikasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray(),
                'hint' => 'Periksa kembali data yang dikirim'
            ], 422);
        }

        // Handle file upload
        $sertifikasiPath = null;
        if ($request->hasFile('sertifikasi')) {
            $file = $request->file('sertifikasi');
            $sertifikasiPath = $file->store('sertifikasi', 'public');
        }

        $product = Product::create([
            'merchant_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'sertifikasi' => $sertifikasiPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dibuat',
            'data' => $product
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'sertifikasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray(),
                'hint' => 'Periksa kembali data yang dikirim'
            ], 422);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        // Handle file upload
        $updateData = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ];

        if ($request->hasFile('sertifikasi')) {
            // Delete old file if exists
            if ($product->sertifikasi) {
                Storage::disk('public')->delete($product->sertifikasi);
            }

            $file = $request->file('sertifikasi');
            $sertifikasiPath = $file->store('sertifikasi', 'public');
            $updateData['sertifikasi'] = $sertifikasiPath;
        }

        $product->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diubah',
            'data' => $product
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        $product->update([
            'status' => 'deleted'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus',
            'data' => $product
        ], 200);
    }
}
