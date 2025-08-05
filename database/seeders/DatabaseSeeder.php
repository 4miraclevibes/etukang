<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Merchant;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Users
        $this->createUsers();

        // Create Merchants
        $this->createMerchants();

        // Create Products
        $this->createProducts();
    }

    /**
     * Create users (3 teknisi + 3 customer)
     */
    private function createUsers(): void
    {
        // Teknisi Users
        User::create([
            'name' => 'Ahmad Teknisi',
            'email' => 'ahmad@teknisi.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Budi Jasa',
            'email' => 'budi@jasa.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Citra Service',
            'email' => 'citra@service.com',
            'password' => Hash::make('password123'),
        ]);

        // Customer Users
        User::create([
            'name' => 'John Customer',
            'email' => 'john@customer.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Jane Customer',
            'email' => 'jane@customer.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Mike Customer',
            'email' => 'mike@customer.com',
            'password' => Hash::make('password123'),
        ]);

        $this->command->info('✅ 6 users created successfully!');
    }

    /**
     * Create merchants (teknisi/jasa)
     */
    private function createMerchants(): void
    {
        // Merchant 1: Ahmad Teknisi
        Merchant::create([
            'user_id' => 1,
            'name' => 'Ahmad Teknisi',
            'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
            'phone' => '0812-3456-7890',
            'status' => 'active',
        ]);

        // Merchant 2: Budi Jasa
        Merchant::create([
            'user_id' => 2,
            'name' => 'Budi Jasa',
            'address' => 'Jl. Thamrin No. 456, Jakarta Pusat',
            'phone' => '0813-4567-8901',
            'status' => 'active',
        ]);

        // Merchant 3: Citra Service
        Merchant::create([
            'user_id' => 3,
            'name' => 'Citra Service',
            'address' => 'Jl. Gatot Subroto No. 789, Jakarta Selatan',
            'phone' => '0814-5678-9012',
            'status' => 'active',
        ]);

        $this->command->info('✅ 3 merchants created successfully!');
    }

    /**
     * Create products (layanan jasa) for each merchant
     */
    private function createProducts(): void
    {
        // Products for Ahmad Teknisi (Merchant ID: 1)
        Product::create([
            'merchant_id' => 1,
            'name' => 'Servis AC',
            'description' => 'Servis dan maintenance AC split, cassette, dan standing',
            'price' => 150000,
            'status' => 'active',
        ]);

        Product::create([
            'merchant_id' => 1,
            'name' => 'Instalasi Listrik',
            'description' => 'Instalasi listrik rumah, toko, dan kantor',
            'price' => 200000,
            'status' => 'active',
        ]);

        Product::create([
            'merchant_id' => 1,
            'name' => 'Perbaikan Plumbing',
            'description' => 'Perbaikan pipa air, saluran pembuangan, dan keran',
            'price' => 120000,
            'status' => 'active',
        ]);

        // Products for Budi Jasa (Merchant ID: 2)
        Product::create([
            'merchant_id' => 2,
            'name' => 'Cleaning Service',
            'description' => 'Jasa kebersihan rumah, kantor, dan gedung',
            'price' => 100000,
            'status' => 'active',
        ]);

        Product::create([
            'merchant_id' => 2,
            'name' => 'Tukang Kayu',
            'description' => 'Perbaikan dan pembuatan furniture kayu',
            'price' => 180000,
            'status' => 'active',
        ]);

        Product::create([
            'merchant_id' => 2,
            'name' => 'Tukang Cat',
            'description' => 'Jasa pengecatan dinding, plafon, dan furniture',
            'price' => 120000,
            'status' => 'active',
        ]);

        // Products for Citra Service (Merchant ID: 3)
        Product::create([
            'merchant_id' => 3,
            'name' => 'Servis Kulkas',
            'description' => 'Servis dan perbaikan kulkas, freezer, dan chiller',
            'price' => 130000,
            'status' => 'active',
        ]);

        Product::create([
            'merchant_id' => 3,
            'name' => 'Servis Mesin Cuci',
            'description' => 'Servis dan perbaikan mesin cuci front loading dan top loading',
            'price' => 140000,
            'status' => 'active',
        ]);

        Product::create([
            'merchant_id' => 3,
            'name' => 'Tukang Las',
            'description' => 'Jasa las besi, pagar, dan konstruksi logam',
            'price' => 160000,
            'status' => 'active',
        ]);

        $this->command->info('✅ 9 products created successfully!');
    }
}
