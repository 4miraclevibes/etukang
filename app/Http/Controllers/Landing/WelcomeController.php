<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $featuredMerchants = Merchant::with('products')->where('status', 'active')->get();
        // $stats bisa diisi sesuai kebutuhan
        $stats = [
            'total_technicians' => 0,
            'total_services' => 0,
            'total_customers' => 1500,
            'satisfaction_rate' => 98,
        ];
        return view('pages.landing.welcome', compact('featuredMerchants', 'stats'));
    }
}
