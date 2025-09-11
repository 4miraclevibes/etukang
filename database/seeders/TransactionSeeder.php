<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Cart;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $merchant = Merchant::first();
        $product = Product::first();

        if ($user && $merchant && $product) {
            // Create cart first
            $cart = Cart::create([
                'user_id' => $user->id,
                'merchant_id' => $merchant->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => 100000,
                'status' => 'inactive'
            ]);

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'merchant_id' => $merchant->id,
                'total_price' => 100000,
                'status' => 'completed'
            ]);

            // Create transaction detail
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => 100000,
                'status' => 'completed'
            ]);

            $this->command->info('Sample transaction created with ID: ' . $transaction->id);
        }
    }
}
