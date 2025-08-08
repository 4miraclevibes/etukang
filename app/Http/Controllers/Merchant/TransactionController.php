<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return redirect()->route('merchant.profile')->with('error', 'Anda belum memiliki merchant profile');
        }

        $query = Transaction::where('merchant_id', $merchant->id)
            ->with(['user', 'merchant', 'transactionDetail.product', 'payment']);

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date !== '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date !== '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        return view('pages.merchant.transactions', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return response()->json([
                'message' => 'Anda belum memiliki merchant profile',
                'error' => 'MERCHANT_NOT_FOUND'
            ], 400);
        }

        // Check if transaction belongs to this merchant
        if ($transaction->merchant_id !== $merchant->id) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan',
                'error' => 'TRANSACTION_NOT_FOUND'
            ], 404);
        }

        $transaction->load(['user', 'merchant', 'transactionDetail.product', 'payment']);

        return response()->json([
            'data' => $transaction
        ]);
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return response()->json([
                'message' => 'Anda belum memiliki merchant profile',
                'error' => 'MERCHANT_NOT_FOUND'
            ], 400);
        }

        // Check if transaction belongs to this merchant
        if ($transaction->merchant_id !== $merchant->id) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan',
                'error' => 'TRANSACTION_NOT_FOUND'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ], [
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus pending, confirmed, completed, atau cancelled.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $transaction->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Status transaksi berhasil diperbarui',
            'data' => $transaction
        ]);
    }
}
