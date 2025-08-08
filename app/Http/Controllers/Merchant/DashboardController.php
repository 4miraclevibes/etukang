<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return redirect()->route('merchant.profile')->with('error', 'Anda belum memiliki merchant profile');
        }

        // Get statistics
        $totalBookings = Transaction::where('merchant_id', $merchant->id)->count();
        $totalRevenue = Transaction::where('merchant_id', $merchant->id)
            ->where('status', '!=', 'cancelled')
            ->sum('total_price');
        $totalProducts = Product::where('merchant_id', $merchant->id)->count();
        $pendingBookings = Transaction::where('merchant_id', $merchant->id)
            ->where('status', 'pending')
            ->count();
        $completedPayments = Payment::where('merchant_id', $merchant->id)
            ->where('payment_status', 'completed')
            ->count();

        // Get recent transactions
        $recentTransactions = Transaction::where('merchant_id', $merchant->id)
            ->with(['user', 'merchant', 'transactionDetail.product', 'payment'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get recent payments
        $recentPayments = Payment::where('merchant_id', $merchant->id)
            ->with(['transaction', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('pages.merchant.dashboard', compact(
            'totalBookings',
            'totalRevenue',
            'totalProducts',
            'pendingBookings',
            'completedPayments',
            'recentTransactions',
            'recentPayments',
            'merchant'
        ));
    }

    public function updateStatus(Request $request)
    {
        $merchant = Auth::user()->merchant;

        if (!$merchant) {
            return response()->json([
                'message' => 'Anda belum memiliki merchant profile',
                'error' => 'MERCHANT_NOT_FOUND'
            ], 400);
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

        $merchant->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Status merchant berhasil diperbarui',
            'data' => $merchant
        ]);
    }
}
