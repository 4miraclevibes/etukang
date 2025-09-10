<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Product;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Ambil semua product dengan merchant
        $products = Product::with('merchant')
            ->where('status', 'active')
            ->get();
        // Hitung stats
        $totalTechnicians = Merchant::where('status', 'active')->count();
        $totalServices = Product::where('status', 'active')->count();

        $stats = [
            'total_technicians' => $totalTechnicians,
            'total_services' => $totalServices,
            'total_customers' => 1500,
            'satisfaction_rate' => 98,
        ];

        return view('pages.landing.welcome', compact('products', 'stats'));
    }
}
