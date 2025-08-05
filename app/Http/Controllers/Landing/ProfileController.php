<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages.landing.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('pages.landing.profile.edit', compact('user'));
    }
}
