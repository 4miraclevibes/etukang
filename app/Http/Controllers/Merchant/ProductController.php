<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return redirect()->route('merchant.profile')->with('error', 'Anda belum memiliki profile merchant');
        }

        $products = Product::where('merchant_id', $merchant->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.merchant.products', compact('products'));
    }

    /**
     * Store a new product
     */
    public function store(Request $request)
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
            'description' => 'nullable|string|max:1000',
            'price' => 'required|integer|min:0',
            'status' => 'nullable|in:active,inactive',
            'sertifikasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'name.required' => 'Nama service wajib diisi.',
            'name.string' => 'Nama service harus berupa teks.',
            'name.max' => 'Nama service maksimal 255 karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
            'price.required' => 'Harga wajib diisi.',
            'price.integer' => 'Harga harus berupa angka.',
            'price.min' => 'Harga minimal 0.',
            'status.in' => 'Status harus active atau inactive.',
            'sertifikasi.file' => 'File sertifikasi harus berupa file.',
            'sertifikasi.mimes' => 'File sertifikasi harus berupa JPG, PNG, atau PDF.',
            'sertifikasi.max' => 'File sertifikasi maksimal 5MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        // Handle file upload
        $sertifikasiPath = null;
        if ($request->hasFile('sertifikasi')) {
            $file = $request->file('sertifikasi');
            $sertifikasiPath = $file->store('sertifikasi', 'public');
        }

        $product = Product::create([
            'merchant_id' => $merchant->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status ?? 'active',
            'sertifikasi' => $sertifikasiPath,
        ]);

        return response()->json([
            'message' => 'Service berhasil ditambahkan',
            'data' => $product
        ], 201);
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product)
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return response()->json([
                'message' => 'Anda belum memiliki merchant profile',
                'error' => 'MERCHANT_NOT_FOUND'
            ], 400);
        }

        // Check if product belongs to this merchant
        if ($product->merchant_id !== $merchant->id) {
            return response()->json([
                'message' => 'Service tidak ditemukan',
                'error' => 'PRODUCT_NOT_FOUND'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|integer|min:0',
            'status' => 'nullable|in:active,inactive',
            'sertifikasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'name.required' => 'Nama service wajib diisi.',
            'name.string' => 'Nama service harus berupa teks.',
            'name.max' => 'Nama service maksimal 255 karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
            'price.required' => 'Harga wajib diisi.',
            'price.integer' => 'Harga harus berupa angka.',
            'price.min' => 'Harga minimal 0.',
            'status.in' => 'Status harus active atau inactive.',
            'sertifikasi.file' => 'File sertifikasi harus berupa file.',
            'sertifikasi.mimes' => 'File sertifikasi harus berupa JPG, PNG, atau PDF.',
            'sertifikasi.max' => 'File sertifikasi maksimal 5MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        // Handle file upload
        $updateData = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status ?? $product->status,
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
            'message' => 'Service berhasil diperbarui',
            'data' => $product
        ]);
    }

    /**
     * Delete the specified product
     */
    public function destroy(Product $product)
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return response()->json([
                'message' => 'Anda belum memiliki merchant profile',
                'error' => 'MERCHANT_NOT_FOUND'
            ], 400);
        }

        // Check if product belongs to this merchant
        if ($product->merchant_id !== $merchant->id) {
            return response()->json([
                'message' => 'Service tidak ditemukan',
                'error' => 'PRODUCT_NOT_FOUND'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Service berhasil dihapus'
        ]);
    }

    /**
     * Get product details for editing
     */
    public function show(Product $product)
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return response()->json([
                'message' => 'Anda belum memiliki merchant profile',
                'error' => 'MERCHANT_NOT_FOUND'
            ], 400);
        }

        // Check if product belongs to this merchant
        if ($product->merchant_id !== $merchant->id) {
            return response()->json([
                'message' => 'Service tidak ditemukan',
                'error' => 'PRODUCT_NOT_FOUND'
            ], 404);
        }

        return response()->json([
            'data' => $product
        ]);
    }

    /**
     * Update product status
     */
    public function updateStatus(Request $request, Product $product)
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return response()->json([
                'message' => 'Anda belum memiliki merchant profile',
                'error' => 'MERCHANT_NOT_FOUND'
            ], 400);
        }

        // Check if product belongs to this merchant
        if ($product->merchant_id !== $merchant->id) {
            return response()->json([
                'message' => 'Service tidak ditemukan',
                'error' => 'PRODUCT_NOT_FOUND'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,inactive',
        ], [
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus active atau inactive.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $product->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Status service berhasil diperbarui',
            'data' => $product
        ]);
    }
}
