<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Etukang Merchant')</title>
    <meta name="description" content="Panel merchant Etukang - Kelola service dan transaksi">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#10B981">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Etukang Merchant">

    <!-- PWA Links -->
    <link rel="icon" type="image/svg+xml" href="/icons/icon.svg">
    <link rel="apple-touch-icon" href="/icons/icon.svg">
    <link rel="manifest" href="/manifest.json">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .mobile-container {
            max-width: 480px;
            margin: 0 auto;
            background: #f8fafc;
            min-height: 100vh;
        }
        .status-bar {
            height: 24px;
            background: #1f2937;
            color: white;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
        }
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 480px;
            background: white;
            border-top: 1px solid #e5e7eb;
            z-index: 50;
        }

        @media (max-width: 480px) {
            .bottom-nav {
                left: 0;
                transform: none;
                border-radius: 0;
            }
        }
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 4px;
            font-size: 12px;
            color: #6b7280;
        }
        .nav-item.active {
            color: #10B981;
        }
        .nav-item i {
            font-size: 20px;
            margin-bottom: 4px;
        }
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            display: none;
        }
        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background: white;
            border-radius: 16px;
            max-width: 90%;
            max-height: 90%;
            overflow-y: auto;
            margin: 20px;
        }

        /* Custom Alert Styles */
        .custom-alert {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
        }
        .custom-alert.show {
            display: flex;
        }
        .alert-content {
            background: white;
            border-radius: 16px;
            max-width: 90%;
            width: 320px;
            margin: 20px;
            overflow: hidden;
            animation: alertSlideIn 0.3s ease-out;
        }
        @keyframes alertSlideIn {
            from {
                opacity: 0;
                transform: scale(0.8) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        .alert-header {
            padding: 20px 20px 0 20px;
            text-align: center;
        }
        .alert-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .alert-icon.success {
            background: #10B981;
            color: white;
        }
        .alert-icon.error {
            background: #EF4444;
            color: white;
        }
        .alert-icon.warning {
            background: #F59E0B;
            color: white;
        }
        .alert-title {
            font-size: 18px;
            font-weight: 600;
            color: #1F2937;
            margin-bottom: 8px;
        }
        .alert-message {
            font-size: 14px;
            color: #6B7280;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .alert-buttons {
            display: flex;
            border-top: 1px solid #E5E7EB;
        }
        .alert-button {
            flex: 1;
            padding: 16px;
            border: none;
            background: none;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .alert-button:first-child {
            border-right: 1px solid #E5E7EB;
        }
        .alert-button.primary {
            color: #10B981;
        }
        .alert-button.secondary {
            color: #6B7280;
        }
        .alert-button:hover {
            background: #F9FAFB;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="mobile-container">
        <!-- Mobile-First Navbar -->
        <nav class="bg-white shadow-sm border-b border-gray-100">
            <!-- Status Bar (Mobile) -->
            <div class="bg-gray-800 text-white text-xs px-4 py-1 flex justify-between items-center">
                <span id="currentTime">--:--</span>
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
                    <i class="fas fa-store text-green-500 text-xl mr-2"></i>
                    <span class="font-bold text-lg text-gray-900">Etukang Merchant</span>
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
                                <a href="{{ route('merchant.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profil Merchant
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

        <!-- Main Content -->
        <main class="pb-20">
            @yield('content')
        </main>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <div class="grid grid-cols-5">
            <a href="{{ route('merchant.dashboard') }}" class="nav-item {{ request()->routeIs('merchant.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('merchant.products') }}" class="nav-item {{ request()->routeIs('merchant.products*') ? 'active' : '' }}">
                <i class="fas fa-tools"></i>
                <span>Service</span>
            </a>
            <a href="{{ route('merchant.transactions') }}" class="nav-item {{ request()->routeIs('merchant.transactions*') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i>
                <span>Transaksi</span>
            </a>
            <a href="{{ route('merchant.payments') }}" class="nav-item {{ request()->routeIs('merchant.payments*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i>
                <span>Bayar</span>
            </a>
            <a href="{{ route('merchant.profile') }}" class="nav-item {{ request()->routeIs('merchant.profile*') ? 'active' : '' }}">
                <i class="fas fa-user"></i>
                <span>Profil</span>
            </a>
        </div>
    </div>

    <!-- Custom Alert Modal -->
    <div id="customAlert" class="custom-alert">
        <div class="alert-content">
            <div class="alert-header">
                <div id="alertIcon" class="alert-icon">
                    <i id="alertIconClass"></i>
                </div>
                <div id="alertTitle" class="alert-title"></div>
                <div id="alertMessage" class="alert-message"></div>
            </div>
            <div class="alert-buttons">
                <button id="alertCancelBtn" class="alert-button secondary" style="display: none;">Batal</button>
                <button id="alertConfirmBtn" class="alert-button primary">OK</button>
            </div>
        </div>
    </div>

    @stack('scripts')

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

        // Custom Alert Functions
        function showCustomAlert(options) {
            const {
                title = 'Pesan',
                message = '',
                type = 'success',
                confirmText = 'OK',
                cancelText = null,
                onConfirm = null,
                onCancel = null
            } = options;

            const alert = document.getElementById('customAlert');
            const icon = document.getElementById('alertIcon');
            const iconClass = document.getElementById('alertIconClass');
            const titleEl = document.getElementById('alertTitle');
            const messageEl = document.getElementById('alertMessage');
            const confirmBtn = document.getElementById('alertConfirmBtn');
            const cancelBtn = document.getElementById('alertCancelBtn');

            icon.className = `alert-icon ${type}`;
            switch(type) {
                case 'success':
                    iconClass.className = 'fas fa-check';
                    break;
                case 'error':
                    iconClass.className = 'fas fa-times';
                    break;
                case 'warning':
                    iconClass.className = 'fas fa-exclamation-triangle';
                    break;
                case 'info':
                    iconClass.className = 'fas fa-info-circle';
                    break;
                default:
                    iconClass.className = 'fas fa-info-circle';
            }

            titleEl.textContent = title;
            messageEl.textContent = message;
            confirmBtn.textContent = confirmText;

            if (cancelText) {
                cancelBtn.textContent = cancelText;
                cancelBtn.style.display = 'block';
            } else {
                cancelBtn.style.display = 'none';
            }

            confirmBtn.onclick = () => {
                hideCustomAlert();
                if (onConfirm) onConfirm();
            };

            cancelBtn.onclick = () => {
                hideCustomAlert();
                if (onCancel) onCancel();
            };

            alert.classList.add('show');
        }

        function hideCustomAlert() {
            document.getElementById('customAlert').classList.remove('show');
        }

        // Global alert functions
        window.showSuccessAlert = function(message) {
            showCustomAlert({
                title: 'Berhasil!',
                message: message,
                type: 'success'
            });
        };

        window.showErrorAlert = function(message) {
            showCustomAlert({
                title: 'Terjadi Kesalahan',
                message: message,
                type: 'error'
            });
        };

        window.showConfirmAlert = function(message, onConfirm, onCancel) {
            showCustomAlert({
                title: 'Konfirmasi',
                message: message,
                type: 'warning',
                confirmText: 'Ya',
                cancelText: 'Tidak',
                onConfirm: onConfirm,
                onCancel: onCancel
            });
        };

        // Real-time Clock Function
        function updateClock() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const timeString = `${hours}:${minutes}`;

            const timeElement = document.getElementById('currentTime');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }

        // Update clock every second
        function startClock() {
            updateClock(); // Update immediately
            setInterval(updateClock, 1000); // Update every second
        }

        // Start clock when page loads
        document.addEventListener('DOMContentLoaded', function() {
            startClock();
        });

        // PWA Install Functions
        let deferredPrompt;

        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent Chrome 67 and earlier from automatically showing the prompt
            e.preventDefault();
            // Stash the event so it can be triggered later
            deferredPrompt = e;
            // Show the install button
            showInstallButton();
        });

        function showInstallButton() {
            const installButton = document.getElementById('pwaInstallButton');
            if (installButton) {
                installButton.classList.remove('hidden');
            }
        }

        function hideInstallButton() {
            const installButton = document.getElementById('pwaInstallButton');
            if (installButton) {
                installButton.classList.add('hidden');
            }
        }

        function installPWA() {
            if (deferredPrompt) {
                // Show the install prompt
                deferredPrompt.prompt();
                // Wait for the user to respond to the prompt
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the install prompt');
                        hideInstallButton();
                    } else {
                        console.log('User dismissed the install prompt');
                    }
                    deferredPrompt = null;
                });
            }
        }

        // Check if app is already installed
        window.addEventListener('appinstalled', (evt) => {
            console.log('App was installed');
            hideInstallButton();
        });

        // Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('SW registered: ', registration);
                    })
                    .catch((registrationError) => {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }
    </script>

    <!-- PWA Install Button -->
    <div id="pwaInstallButton" class="fixed bottom-20 left-4 z-50 hidden">
        <button onclick="installPWA()"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-full shadow-lg flex items-center space-x-2 transition-all duration-300 transform hover:scale-105">
            <i class="fab fa-android text-xl"></i>
            <span class="text-sm font-medium">Install App</span>
        </button>
    </div>
</body>
</html>
