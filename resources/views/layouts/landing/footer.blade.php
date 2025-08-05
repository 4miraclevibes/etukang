<!-- Bottom Navigation -->
<div class="bottom-nav">
    <div class="grid grid-cols-4">
        <a href="{{ route('welcome') }}" class="nav-item {{ request()->routeIs('welcome') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('cart') }}" class="nav-item {{ request()->routeIs('cart') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Keranjang</span>
        </a>
        <a href="{{ route('transaction') }}" class="nav-item {{ request()->routeIs('transaction') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i>
            <span>Pesanan</span>
        </a>
        <a href="{{ route('profile.mobile') }}" class="nav-item {{ request()->routeIs('profile.mobile') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            <span>Profil</span>
        </a>
    </div>
</div>
