<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Merchant - Sportlodek</title>
    <meta name="description" content="Pengaturan profil merchant">

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#10B981">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Sportlodek Merchant">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/svg+xml" href="/icons/icon.svg">
    <link rel="apple-touch-icon" href="/icons/icon.svg">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        .profile-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
        @include('layouts.merchant.navbar', ['headerTitle' => 'Pengaturan'])

        <!-- Content -->
        <div class="px-4 py-6 pb-20">
            <!-- Header Section -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Pengaturan Merchant</h2>
                <p class="text-sm text-gray-500">Kelola profil dan pengaturan merchant</p>
            </div>

            <!-- Merchant Profile -->
            @if($merchant)
            <div class="profile-card mb-6">
                <div class="flex items-center mb-4">
                    <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-store text-2xl text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $merchant->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $merchant->status }}</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Nama Merchant</span>
                        <span class="font-medium">{{ $merchant->name }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Alamat</span>
                        <span class="font-medium text-right">{{ $merchant->address }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Telepon</span>
                        <span class="font-medium">{{ $merchant->phone }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Jam Operasional</span>
                        <span class="font-medium">{{ $merchant->open }}:00 - {{ $merchant->close }}:00</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Status</span>
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($merchant->status === 'active') bg-green-100 text-green-800
                            @elseif($merchant->status === 'inactive') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($merchant->status) }}
                        </span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <button onclick="editMerchantProfile()"
                            class="w-full bg-green-500 text-white py-2 rounded-lg font-medium">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Profil
                    </button>
                </div>
            </div>
            @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-store text-4xl text-gray-300"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Profil Merchant</h3>
                <p class="text-gray-500 mb-6">Anda belum memiliki profil merchant</p>
                <button onclick="createMerchantProfile()"
                        class="bg-green-500 text-white px-6 py-3 rounded-lg font-medium">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Profil Merchant
                </button>
            </div>
            @endif

            <!-- Settings Menu -->
            <div class="space-y-4">
                <div class="profile-card">
                    <h3 class="font-semibold text-gray-900 mb-4">Pengaturan</h3>
                    <div class="space-y-3">
                        <button onclick="showChangePassword()"
                                class="w-full flex items-center justify-between py-3 text-left">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-lock text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Ubah Password</p>
                                    <p class="text-sm text-gray-500">Keamanan akun</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>

                        <button onclick="showNotificationSettings()"
                                class="w-full flex items-center justify-between py-3 text-left">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-bell text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Notifikasi</p>
                                    <p class="text-sm text-gray-500">Pengaturan notifikasi</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>

                        <button onclick="showPrivacySettings()"
                                class="w-full flex items-center justify-between py-3 text-left">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-shield-alt text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Privasi</p>
                                    <p class="text-sm text-gray-500">Pengaturan privasi</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>
                    </div>
                </div>

                <div class="profile-card">
                    <h3 class="font-semibold text-gray-900 mb-4">Akun</h3>
                    <div class="space-y-3">
                        <button onclick="showUserProfile()"
                                class="w-full flex items-center justify-between py-3 text-left">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-gray-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Profil User</p>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->name }}</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>

                        <button onclick="logout()"
                                class="w-full flex items-center justify-between py-3 text-left">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-sign-out-alt text-red-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-red-600">Logout</p>
                                    <p class="text-sm text-gray-500">Keluar dari aplikasi</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.merchant.footer')
    </div>

    <script>
        function editMerchantProfile() {
            showCustomAlert({
                title: 'Edit Profil Merchant',
                message: 'Fitur edit profil akan segera hadir!',
                type: 'info'
            });
        }

        function createMerchantProfile() {
            showCustomAlert({
                title: 'Buat Profil Merchant',
                message: 'Fitur buat profil akan segera hadir!',
                type: 'info'
            });
        }

        function showChangePassword() {
            showCustomAlert({
                title: 'Ubah Password',
                message: 'Fitur ubah password akan segera hadir!',
                type: 'info'
            });
        }

        function showNotificationSettings() {
            showCustomAlert({
                title: 'Pengaturan Notifikasi',
                message: 'Fitur pengaturan notifikasi akan segera hadir!',
                type: 'info'
            });
        }

        function showPrivacySettings() {
            showCustomAlert({
                title: 'Pengaturan Privasi',
                message: 'Fitur pengaturan privasi akan segera hadir!',
                type: 'info'
            });
        }

        function showUserProfile() {
            window.location.href = '{{ route("profile.mobile") }}';
        }

        function logout() {
            showCustomAlert({
                title: 'Logout',
                message: 'Apakah Anda yakin ingin keluar?',
                type: 'warning',
                confirmText: 'Ya, Logout',
                cancelText: 'Batal',
                onConfirm: () => {
                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch('/api/logout', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'Authorization': 'Bearer ' + localStorage.getItem('user_token')
                        }
                    })
                    .then(() => {
                        localStorage.removeItem('user_token');
                        window.location.href = '/';
                    })
                    .catch(error => {
                        showCustomAlert({
                            title: 'Error',
                            message: 'Gagal logout: ' + error.message,
                            type: 'error'
                        });
                    });
                }
            });
        }
    </script>
</body>
</html>
