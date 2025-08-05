<!-- Status Bar -->
<div class="status-bar">
    <span>Sportlodek</span>
            <span id="currentTime">--:--</span>
</div>

<!-- App Header -->
<div class="bg-white px-4 py-3 flex items-center justify-between">
    <div class="flex items-center">
        @if(request()->routeIs('welcome'))
            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-2">
                <i class="fas fa-futbol text-white text-sm"></i>
            </div>
            <span class="text-green-500 font-semibold text-lg">Sportlodek</span>
        @else
            <a href="{{ route('welcome') }}" class="mr-3">
                <i class="fas fa-arrow-left text-gray-600 text-lg"></i>
            </a>
            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-2">
                <i class="fas fa-{{ $headerIcon ?? 'shopping-cart' }} text-white text-sm"></i>
            </div>
            <span class="text-green-500 font-semibold text-lg">{{ $headerTitle ?? 'Keranjang' }}</span>
        @endif
    </div>

    @auth
        <!-- Header untuk user yang sudah login -->
        <div class="flex items-center space-x-3">
            <a href="{{ route('dashboard') }}" class="text-gray-600 text-sm flex items-center">
                <i class="fas fa-user-circle mr-1"></i>
                {{ Auth::user()->name }}
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-600 transition-colors">
                    <i class="fas fa-sign-out-alt mr-1"></i>
                    Keluar
                </button>
            </form>
        </div>
    @else
        <!-- Header untuk user yang belum login -->
        <div class="flex items-center space-x-2">
            <a href="{{ route('login') }}" class="text-gray-600 text-sm hover:text-green-500 transition-colors">
                <i class="fas fa-sign-in-alt mr-1"></i>
                Masuk
            </a>
            <a href="{{ route('register') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-600 transition-colors">
                <i class="fas fa-user-plus mr-1"></i>
                Daftar
            </a>
        </div>
    @endauth
</div>

@if(request()->routeIs('welcome'))
<!-- Promotional Banner -->
<div class="install-banner">
    <div class="flex items-center">
        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
            <i class="fas fa-futbol text-white text-sm"></i>
        </div>
        <div>
            <div class="text-sm">Booking Lapangan Futsal</div>
            <div class="font-bold text-lg">GRATIS BOOKING</div>
            <div class="text-xs opacity-80">SETIAP HARI*</div>
        </div>
    </div>
    <div class="text-right">
        <i class="fas fa-futbol text-4xl opacity-60"></i>
    </div>
</div>
@endif
