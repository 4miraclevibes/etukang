<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return redirect()->route('merchant.profile')->with('error', 'Anda belum memiliki merchant profile');
        }

        $query = Payment::where('merchant_id', $merchant->id)
            ->with(['transaction', 'user']);

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status !== '') {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by payment method
        if ($request->has('payment_method') && $request->payment_method !== '') {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date !== '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date !== '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $payments = $query->orderBy('created_at', 'desc')->get();

        return view('pages.merchant.payments', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return response()->json([
                'message' => 'Anda belum memiliki merchant profile',
                'error' => 'MERCHANT_NOT_FOUND'
            ], 400);
        }

        // Check if payment belongs to this merchant
        if ($payment->merchant_id !== $merchant->id) {
            return response()->json([
                'message' => 'Pembayaran tidak ditemukan',
                'error' => 'PAYMENT_NOT_FOUND'
            ], 404);
        }

        $payment->load(['transaction', 'user']);

        return response()->json([
            'data' => $payment
        ]);
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return response()->json([
                'message' => 'Anda belum memiliki merchant profile',
                'error' => 'MERCHANT_NOT_FOUND'
            ], 400);
        }

        // Check if payment belongs to this merchant
        if ($payment->merchant_id !== $merchant->id) {
            return response()->json([
                'message' => 'Pembayaran tidak ditemukan',
                'error' => 'PAYMENT_NOT_FOUND'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'payment_status' => 'required|in:pending,completed,failed,cancelled',
        ], [
            'payment_status.required' => 'Status pembayaran wajib diisi.',
            'payment_status.in' => 'Status pembayaran harus pending, completed, failed, atau cancelled.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $payment->update([
            'payment_status' => $request->payment_status,
        ]);

        return response()->json([
            'message' => 'Status pembayaran berhasil diperbarui',
            'data' => $payment
        ]);
    }
}
