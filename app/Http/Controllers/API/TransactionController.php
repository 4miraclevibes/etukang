<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionDetail;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $carts = Cart::where('user_id', Auth::user()->id)->where('status', 'active')->get();

        if ($carts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang tidak ditemukan',
            ], 404);
        }

        return DB::transaction(function () use ($carts) {
            // Update status cart menjadi inactive - PERBAIKAN
            $carts->each(function($cart) {
                $cart->update(['status' => 'inactive']);
            });

            // Kelompokkan cart berdasarkan merchant_id
            $cartsByMerchant = $carts->groupBy('merchant_id');

            $transactions = [];

            foreach ($cartsByMerchant as $merchantId => $merchantCarts) {
                // Buat transaksi untuk setiap merchant
                $transaction = Transaction::create([
                    'user_id' => Auth::user()->id,
                    'merchant_id' => $merchantId,
                    'total_price' => $merchantCarts->sum('price'),
                    'status' => 'pending'
                ]);

                $payment = Payment::create([
                    'transaction_id' => $transaction->id,
                    'user_id' => Auth::user()->id,
                    'merchant_id' => $merchantId,
                    'payment_code' => 'EDUPAY-'.rand(100000, 999999),
                    'payment_method' => 'cash',
                    'payment_status' => 'pending',
                    'total_price' => $merchantCarts->sum('price'),
                ]);

                // Hit EduPay API untuk semua payment method
                // Load transaction dengan merchant dan user relationship
                $transactionWithRelations = $transaction->load(['merchant.user']);

                $edupayResponse = $this->edupayCreatePayment(
                    $payment->payment_code,
                    $payment->total_price,
                    $payment->merchant->user->email
                );

                if (!$edupayResponse) {
                    // Jika EduPay API gagal, rollback database transaction
                    throw new \Exception('Gagal membuat payment di EduPay');
                }

                // Buat transaction detail untuk setiap cart dalam merchant ini
                foreach ($merchantCarts as $cart) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'cart_id' => $cart->id,
                        'product_id' => $cart->product_id,
                        'quantity' => $cart->quantity,
                        'price' => $cart->price,
                        'status' => 'pending'
                    ]);
                }

                $transactions[] = $transaction->load('transactionDetail', 'payment');
            }

            $this->sendWhatsappNotification($transaction);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dibuat',
                'data' => $transactions
            ], 201);
        });
    }

    public function show($id): JsonResponse
    {
        try {
            $transaction = Transaction::where('user_id', Auth::user()->id)
                ->with(['transactionDetail.product', 'merchant', 'payment'])
                ->find($id);

            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $transaction
            ]);
        } catch (\Exception $e) {
            Log::error('Transaction show error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::where('user_id', Auth::user()->id)->with('transactionDetail', 'payment')->find($id);
        $payment = Payment::where('transaction_id', $id)->first();
        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan',
            ], 404);
        }

        $transaction->update([
            'status' => $request->status,
        ]);
        $payment->update([
            'payment_status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil diupdate',
            'data' => $transaction->load('transactionDetail', 'payment')
        ], 200);
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('user_id', Auth::user()->id)->with('transactionDetail', 'payment')->find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan',
            ], 404);
        }

        // Update transaction status
        $transaction->update([
            'status' => 'cancelled'
        ]);

        // Update transaction details - PERBAIKAN: pakai each() bukan update() collection
        $transaction->transactionDetail->each(function($detail) {
            $detail->update(['status' => 'cancelled']);
        });

        // Update payment status
        if ($transaction->payment) {
            $transaction->payment->update([
                'payment_status' => 'cancelled'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dibatalkan',
        ], 200);
    }

    private function edupayCreatePayment($code, $total, $email)
    {
        try {
            $response = Http::post('https://edupay.justputoff.com/api/service/storePayment', [
                'service_id' => 1, // Service ID untuk edepot
                'total' => $total,
                'code' => $code,
                'email' => $email,
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('EduPay API Error', [
                    'status' => $response->status(),
                    'response' => $response->json(),
                    'request' => [
                        'service_id' => 1,
                        'total' => $total,
                        'code' => $code,
                        'email' => $email,
                    ]
                ]);

                return null;
            }
        } catch (\Exception $e) {
            Log::error('EduPay API Exception', [
                'message' => $e->getMessage(),
                'request' => [
                    'service_id' => 11,
                    'total' => $total,
                    'code' => $code,
                    'email' => $email,
                ]
            ]);

            return null;
        }
    }

    private function sendWhatsappNotification($transaction)
    {

        // Kata-kata intro
        $intro = [
            "Ada order baru nih",
            "Pesanan layanan masuk",
            "Ada job baru",
            "Layanan baru nih",
            "Ada order teknisi"
        ];

        // Pilih secara random
        $selectedIntro = $intro[array_rand($intro)];
        $selectedMerchant = $transaction->merchant->name;

        // Load transaction dengan relasi yang diperlukan
        $transaction = $transaction->load(['user', 'merchant', 'transactionDetail.product', 'payment']);

        // Format pesan WhatsApp
        $message = "🔧 *ORDER LAYANAN BARU!*\n\n"
            . "*{$selectedIntro}!*\n\n"
            . "Kode Transaksi: *{$transaction->payment->payment_code}*\n"
            . "Merchant: *{$selectedMerchant}*\n"
            . "Customer: *{$transaction->user->name}*\n"
            . "Total Pembayaran: *Rp " . number_format($transaction->total_price, 0, ',', '.') . "*\n"
            . "Status: *{$transaction->status}*\n\n"
            . "*Detail Layanan:*\n";

        // Tambahkan detail layanan
        foreach ($transaction->transactionDetail as $detail) {
            $message .= "- {$detail->product->name}\n"
                . "  Jumlah: {$detail->quantity} x Rp " . number_format($detail->price, 0, ',', '.') . "\n"
                . "  Total: Rp " . number_format($detail->price * $detail->quantity, 0, ',', '.') . "\n\n";
        }

        $message .= "*Informasi Pembayaran:*\n"
            . "Metode: *{$transaction->payment->payment_method}*\n"
            . "Status Pembayaran: *{$transaction->payment->payment_status}*\n\n"
            . "⏰ *Segera proses pesanan ini!*\n"
            . "📞 Hubungi customer untuk konfirmasi jadwal layanan.";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => '6281261686210',
                'target' => '6282288513102',
                'target' => $transaction->merchant->phone,
                'message' => $message
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: BehwfEMKPuLsQByWe138'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
