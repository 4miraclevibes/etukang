<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MerchantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Jika user tidak memiliki merchant profile, redirect ke welcome page
        if (!$user || !$user->merchant) {
            return redirect()->route('welcome')->with('error', 'Anda tidak memiliki akses ke panel merchant');
        }

        return $next($request);
    }
}
