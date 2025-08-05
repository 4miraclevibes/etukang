<!-- Mobile-First Navbar -->
<nav class="bg-white shadow-sm border-b border-gray-100">
    <!-- Status Bar (Mobile) -->
    <div class="bg-gray-800 text-white text-xs px-4 py-1 flex justify-between items-center">
        <span>9:41</span>
        <div class="flex items-center space-x-1">
            <div class="w-4 h-2 bg-white rounded-sm"></div>
            <div class="w-4 h-2 bg-white rounded-sm"></div>
            <div class="w-4 h-2 bg-white rounded-sm"></div>
        </div>
    </div>

    <!-- Main Navbar -->
    <div class="px-4 py-3 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center">
            <i class="fas fa-tools text-green-500 text-xl mr-2"></i>
            <span class="font-bold text-lg text-gray-900">Etukang</span>
        </div>

        <!-- User Menu -->
        @auth
            <div class="relative">
                <button onclick="toggleUserMenu()" class="flex items-center space-x-2 text-gray-700 hover:text-green-500 transition-colors">
                    <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>

                <!-- User Dropdown -->
                <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                    <div class="py-2">
                        <a href="{{ route('profile.mobile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i>Profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="flex items-center space-x-3">
                <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-green-500">Masuk</a>
                <a href="{{ route('register') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-600 transition-colors">Daftar</a>
            </div>
        @endauth
    </div>
</nav>

<script>
    function toggleUserMenu() {
        const menu = document.getElementById('userMenu');
        menu.classList.toggle('hidden');
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('userMenu');
        const button = event.target.closest('button');

        if (!menu.contains(event.target) && !button) {
            menu.classList.add('hidden');
        }
    });
</script>
