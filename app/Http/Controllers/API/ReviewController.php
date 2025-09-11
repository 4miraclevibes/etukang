<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store reviews for transaction details
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|exists:transactions,id',
            'reviews' => 'required|array|min:1',
            'reviews.*.transaction_detail_id' => 'required|exists:transaction_details,id',
            'reviews.*.rating' => 'nullable|integer|min:1|max:5',
            'reviews.*.review' => 'nullable|string|max:1000',
        ], [
            'transaction_id.required' => 'ID transaksi wajib diisi.',
            'transaction_id.exists' => 'Transaksi tidak ditemukan.',
            'reviews.required' => 'Ulasan wajib diisi.',
            'reviews.array' => 'Format ulasan tidak valid.',
            'reviews.min' => 'Minimal satu ulasan harus diisi.',
            'reviews.*.transaction_detail_id.required' => 'ID detail transaksi wajib diisi.',
            'reviews.*.transaction_detail_id.exists' => 'Detail transaksi tidak ditemukan.',
            'reviews.*.rating.integer' => 'Rating harus berupa angka.',
            'reviews.*.rating.min' => 'Rating minimal 1.',
            'reviews.*.rating.max' => 'Rating maksimal 5.',
            'reviews.*.review.string' => 'Ulasan harus berupa teks.',
            'reviews.*.review.max' => 'Ulasan maksimal 1000 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        // Check if transaction belongs to authenticated user
        $transaction = Transaction::where('id', $request->transaction_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan atau tidak memiliki akses',
            ], 404);
        }

        // Check if transaction is completed
        if ($transaction->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Ulasan hanya dapat diberikan untuk transaksi yang sudah selesai',
            ], 400);
        }

        $updatedReviews = [];

        foreach ($request->reviews as $reviewData) {
            $transactionDetail = TransactionDetail::where('id', $reviewData['transaction_detail_id'])
                ->where('transaction_id', $request->transaction_id)
                ->first();

            if (!$transactionDetail) {
                continue; // Skip invalid transaction detail
            }

            // Update transaction detail with review
            $transactionDetail->update([
                'rating' => $reviewData['rating'] ?? null,
                'ulasan' => $reviewData['review'] ?? null,
            ]);

            $updatedReviews[] = $transactionDetail;
        }

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil disimpan',
            'data' => $updatedReviews
        ], 201);
    }

    /**
     * Get reviews for a transaction
     */
    public function getTransactionReviews($transactionId): JsonResponse
    {
        try {
            // Check if transaction belongs to authenticated user
            $transaction = Transaction::where('id', $transactionId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan atau tidak memiliki akses',
                ], 404);
            }

            $reviews = TransactionDetail::where('transaction_id', $transactionId)
                ->with('product')
                ->where(function($query) {
                    $query->whereNotNull('rating')
                          ->orWhereNotNull('ulasan');
                })
                ->get();

            \Log::info('Reviews found:', ['count' => $reviews->count(), 'reviews' => $reviews->toArray()]);

            return response()->json([
                'success' => true,
                'data' => $reviews
            ]);
        } catch (\Exception $e) {
            \Log::error('Get transaction reviews error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get reviews for a specific product
     */
    public function getProductReviews($productId): JsonResponse
    {
        try {
            $reviews = TransactionDetail::where('product_id', $productId)
                ->with(['user', 'product'])
                ->where(function($query) {
                    $query->whereNotNull('rating')
                          ->orWhereNotNull('ulasan');
                })
                ->orderBy('created_at', 'desc')
                ->get();

            \Log::info('Product reviews found:', ['product_id' => $productId, 'count' => $reviews->count()]);

            return response()->json([
                'success' => true,
                'data' => $reviews
            ]);
        } catch (\Exception $e) {
            \Log::error('Get product reviews error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
