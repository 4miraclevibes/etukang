<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['merchant', 'transactionDetail.product', 'payment'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages.landing.transaction.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with(['merchant', 'transactionDetail.product', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        return view('pages.landing.transaction.show', compact('transaction'));
    }
}
