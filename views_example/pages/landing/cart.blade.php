<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Sportlodek</title>
    <meta name="description" content="Keranjang booking lapangan futsal">

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#10B981">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Sportlodek">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/svg+xml" href="/icons/icon.svg">

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
        .cart-item {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 12px;
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
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .quantity-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid #e5e7eb;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .quantity-btn:hover {
            background: #f3f4f6;
        }
        .quantity-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .quantity-display {
            min-width: 40px;
            text-align: center;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="mobile-container">
        @include('layouts.landing.navbar')

        <!-- Cart Content -->
        <div class="px-4 py-6 pb-20">
            @if($cartItems->count() > 0)
                <!-- Cart Items -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Item Booking ({{ $cartItems->count() }})</h2>

                    @foreach($cartItems as $item)
                    <div class="cart-item" data-cart-id="{{ $item->id }}">
                        <div class="p-4">
                            <!-- Merchant Info -->
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-futbol text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 text-sm">{{ $item->merchant->name }}</h3>
                                    <p class="text-gray-500 text-xs">{{ $item->product->name }}</p>
                                </div>
                                <button onclick="removeCartItem({{ $item->id }})"
                                        class="text-red-500 hover:text-red-700 transition-colors">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>

                            <!-- Booking Details -->
                            <div class="bg-gray-50 rounded-lg p-3 mb-3">
                                <div class="grid grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <span class="text-gray-500">Jam Mulai:</span>
                                        <span class="font-medium text-gray-900">{{ $item->start }}:00</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Durasi:</span>
                                        <span class="font-medium text-gray-900">{{ $item->quantity }} jam</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Harga/Jam:</span>
                                        <span class="font-medium text-gray-900">Rp {{ number_format($item->price_per_hour, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Total:</span>
                                        <span class="font-bold text-green-600">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Quantity Control -->
                            <div class="flex items-center justify-between">
                                <div class="quantity-control">
                                    <button onclick="updateQuantity({{ $item->id }}, -1)"
                                            class="quantity-btn"
                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    <span class="quantity-display">{{ $item->quantity }}</span>
                                    <button onclick="updateQuantity({{ $item->id }}, 1)"
                                            class="quantity-btn">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs text-gray-500">Total</span>
                                    <div class="font-bold text-green-600">Rp {{ number_format($item->total_price, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Summary -->
                <div class="bg-white rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Ringkasan Booking</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Total Item:</span>
                            <span class="font-medium">{{ $cartItems->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Total Jam:</span>
                            <span class="font-medium">{{ $cartItems->sum('quantity') }} jam</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal:</span>
                            <span class="font-medium">Rp {{ number_format($cartItems->sum('total_price'), 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t pt-2">
                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-900">Total Bayar:</span>
                                <span class="font-bold text-green-600 text-lg">Rp {{ number_format($cartItems->sum('total_price'), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button onclick="clearCart()"
                            class="w-full bg-gray-200 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                        <i class="fas fa-trash mr-2"></i>
                        Kosongkan Keranjang
                    </button>
                    <button onclick="proceedToCheckout()"
                            class="w-full bg-green-500 text-white py-3 rounded-lg font-medium hover:bg-green-600 transition-colors">
                        <i class="fas fa-credit-card mr-2"></i>
                        Lanjutkan ke Pembayaran
                    </button>
                </div>

            @else
                <!-- Empty Cart -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-cart text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Keranjang Kosong</h3>
                    <p class="text-gray-500 mb-6">Belum ada item booking di keranjang Anda</p>
                    <a href="{{ route('welcome') }}"
                       class="bg-green-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-600 transition-colors inline-flex items-center">
                        <i class="fas fa-futbol mr-2"></i>
                        Cari Lapangan
                    </a>
                </div>
            @endif
        </div>

        @include('layouts.landing.footer')
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

    <script>
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

        // Cart Functions
        function updateQuantity(cartId, change) {
            const newQuantity = parseInt(document.querySelector(`[data-cart-id="${cartId}"] .quantity-display`).textContent) + change;

            if (newQuantity < 1) return;

            fetch(`/api/cart/${cartId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer {{ Auth::user() ? Auth::user()->createToken("web-token")->plainTextToken : "" }}'
                },
                body: JSON.stringify({ quantity: newQuantity })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Reload page dan tampilkan alert
                if (data.success || data.message) {
                    // Simpan pesan success ke session storage
                    sessionStorage.setItem('cartMessage', 'Quantity berhasil diperbarui');
                    sessionStorage.setItem('cartMessageType', 'success');
                    location.reload();
                } else {
                    showCustomAlert({
                        title: 'Error',
                        message: data.message || 'Gagal mengupdate quantity',
                        type: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomAlert({
                    title: 'Error',
                    message: 'Terjadi kesalahan saat mengupdate quantity',
                    type: 'error'
                });
            });
        }

        function removeCartItem(cartId) {
            showCustomAlert({
                title: 'Hapus Item',
                message: 'Apakah Anda yakin ingin menghapus item ini dari keranjang?',
                type: 'warning',
                confirmText: 'Ya, Hapus',
                cancelText: 'Batal',
                onConfirm: () => {
                    fetch(`/api/cart/${cartId}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer {{ Auth::user() ? Auth::user()->createToken("web-token")->plainTextToken : "" }}'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            sessionStorage.setItem('cartMessage', 'Item berhasil dihapus dari keranjang');
                            sessionStorage.setItem('cartMessageType', 'success');
                            location.reload();
                        } else {
                            showCustomAlert({
                                title: 'Error',
                                message: data.message || 'Gagal menghapus item',
                                type: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showCustomAlert({
                            title: 'Error',
                            message: 'Terjadi kesalahan saat menghapus item',
                            type: 'error'
                        });
                    });
                }
            });
        }

        function clearCart() {
            showCustomAlert({
                title: 'Kosongkan Keranjang',
                message: 'Apakah Anda yakin ingin mengosongkan seluruh keranjang?',
                type: 'warning',
                confirmText: 'Ya, Kosongkan',
                cancelText: 'Batal',
                onConfirm: () => {
                    fetch('/api/cart', {  // Ganti dari /api/cart/clear ke /api/cart
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': 'Bearer {{ Auth::user() ? Auth::user()->createToken("web-token")->plainTextToken : "" }}'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Jika response OK, langsung reload dengan pesan success
                        sessionStorage.setItem('cartMessage', 'Keranjang berhasil dikosongkan');
                        sessionStorage.setItem('cartMessageType', 'success');
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showCustomAlert({
                            title: 'Error',
                            message: 'Terjadi kesalahan saat mengosongkan keranjang',
                            type: 'error'
                        });
                    });
                }
            });
        }

        function proceedToCheckout() {
            // Tampilkan modal untuk memilih payment method
            showPaymentMethodModal();
        }

        function showPaymentMethodModal() {
            const modal = document.createElement('div');
            modal.className = 'custom-alert show';
            modal.innerHTML = `
                <div class="alert-content" style="width: 90%; max-width: 400px;">
                    <div class="alert-header">
                        <div class="alert-icon warning">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="alert-title">Pilih Metode Pembayaran</div>
                        <div class="alert-message">
                            Silakan pilih metode pembayaran yang Anda inginkan untuk melanjutkan checkout.
                        </div>
                    </div>

                    <div class="p-4 space-y-3">
                        <button onclick="selectPaymentMethod('transfer')"
                                class="w-full p-3 border border-gray-200 rounded-lg text-left hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-university text-blue-500 mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-900">Transfer Bank</div>
                                    <div class="text-sm text-gray-500">Transfer via EduPay</div>
                                </div>
                            </div>
                        </button>

                        <button onclick="selectPaymentMethod('cash')"
                                class="w-full p-3 border border-gray-200 rounded-lg text-left hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-money-bill text-green-500 mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-900">Tunai</div>
                                    <div class="text-sm text-gray-500">Bayar di tempat</div>
                                </div>
                            </div>
                        </button>

                        <button onclick="selectPaymentMethod('ewallet')"
                                class="w-full p-3 border border-gray-200 rounded-lg text-left hover:bg-gray-50 transition-colors opacity-50 cursor-not-allowed"
                                disabled>
                            <div class="flex items-center">
                                <i class="fas fa-wallet text-orange-500 mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-900">E-Wallet</div>
                                    <div class="text-sm text-gray-500">DANA, OVO, GoPay</div>
                                    <div class="text-xs text-orange-600 font-medium mt-1">Dalam Pengembangan</div>
                                </div>
                            </div>
                        </button>
                    </div>

                    <div class="alert-buttons">
                        <button onclick="closePaymentMethodModal()" class="alert-button secondary">Batal</button>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);
        }

        function closePaymentMethodModal() {
            const modal = document.querySelector('.custom-alert.show');
            if (modal) {
                modal.remove();
            }
        }

        function selectPaymentMethod(method) {
            // Jika e-wallet dipilih, tampilkan pesan dalam pengembangan
            if (method === 'ewallet') {
                showCustomAlert({
                    title: 'Fitur Dalam Pengembangan',
                    message: 'Pembayaran via E-Wallet sedang dalam pengembangan. Silakan pilih metode pembayaran lainnya.',
                    type: 'info'
                });
                return;
            }

            closePaymentMethodModal();

            // Tampilkan konfirmasi checkout
            showCustomAlert({
                title: 'Konfirmasi Checkout',
                message: `Anda akan melakukan checkout dengan metode pembayaran ${getPaymentMethodText(method)}. Lanjutkan?`,
                type: 'warning',
                confirmText: 'Ya, Checkout',
                cancelText: 'Batal',
                onConfirm: () => {
                    performCheckout(method);
                }
            });
        }

        function getPaymentMethodText(method) {
            switch(method) {
                case 'transfer': return 'Transfer Bank';
                case 'cash': return 'Tunai';
                case 'ewallet': return 'E-Wallet';
                default: return method;
            }
        }

        function performCheckout(paymentMethod) {
            // Tampilkan loading
            showCustomAlert({
                title: 'Memproses Checkout...',
                message: 'Mohon tunggu sebentar, sedang memproses booking Anda.',
                type: 'info'
            });

            // Kirim request checkout ke API
            fetch('/api/transactions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer {{ Auth::user() ? Auth::user()->createToken("web-token")->plainTextToken : "" }}'
                },
                body: JSON.stringify({
                    payment_method: paymentMethod
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                hideCustomAlert();

                if (data.message && data.transactions) {
                    // Checkout berhasil
                    showCheckoutSuccess(data);
                } else {
                    showCustomAlert({
                        title: 'Error',
                        message: data.message || 'Gagal melakukan checkout',
                        type: 'error'
                    });
                }
            })
                        .catch(error => {
                console.error('Error:', error);
                hideCustomAlert();

                // Handle specific error responses
                if (error.message && error.message.includes('500')) {
                    showCustomAlert({
                        title: 'Payment Gateway Error',
                        message: 'Gagal menghubungi payment gateway. Silakan coba lagi dalam beberapa saat.',
                        type: 'error'
                    });
                } else {
                    showCustomAlert({
                        title: 'Error',
                        message: 'Terjadi kesalahan saat melakukan checkout. Silakan coba lagi.',
                        type: 'error'
                    });
                }
            });
        }

        function showCheckoutSuccess(data) {
            const modal = document.createElement('div');
            modal.className = 'custom-alert show';

            // Buat ringkasan checkout
            let transactionsHtml = '';
            if (data.transactions && data.transactions.length > 0) {
                transactionsHtml = data.transactions.map(transaction => `
                    <div class="bg-gray-50 rounded-lg p-3 mb-3">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-medium text-gray-900">${transaction.merchant.name}</span>
                            <span class="text-sm ${getStatusClass(transaction.status)}">${getStatusText(transaction.status)}</span>
                        </div>
                        <div class="text-sm text-gray-600">
                            <div>Jam: ${transaction.start}:00 - ${transaction.start + transaction.transaction_details.length}:00</div>
                            <div>Total: ${transaction.payment.formatted_total}</div>
                            ${transaction.payment ? `<div>Payment: ${transaction.payment.code}</div>` : ''}
                        </div>
                    </div>
                `).join('');
            }

            modal.innerHTML = `
                <div class="alert-content" style="width: 95%; max-width: 450px; max-height: 80vh; overflow-y: auto;">
                    <div class="alert-header">
                        <div class="alert-icon success">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="alert-title">Checkout Berhasil!</div>
                        <div class="alert-message">
                            Booking Anda berhasil dibuat. Berikut adalah detail booking Anda:
                        </div>
                    </div>

                    <div class="p-4">
                        ${transactionsHtml}

                        <div class="bg-green-50 rounded-lg p-3 mt-3">
                            <div class="text-sm text-green-800">
                                <div class="font-medium mb-1">Total Transaksi: ${data.total_transactions || 0}</div>
                                <div>Total Pembayaran: ${data.payment_info?.total_amount || 'Rp 0'}</div>
                            </div>
                        </div>
                    </div>

                    <div class="alert-buttons">
                        <button onclick="goToTransactionHistory()" class="alert-button primary">Lihat Riwayat</button>
                        <button onclick="goToWelcome()" class="alert-button secondary">Kembali ke Beranda</button>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);
        }

        function getStatusClass(status) {
            switch(status) {
                case 'pending': return 'text-yellow-600';
                case 'confirmed': return 'text-green-600';
                case 'cancelled': return 'text-red-600';
                case 'completed': return 'text-blue-600';
                default: return 'text-gray-600';
            }
        }

        function getStatusText(status) {
            switch(status) {
                case 'pending': return 'Menunggu';
                case 'confirmed': return 'Dikonfirmasi';
                case 'cancelled': return 'Dibatalkan';
                case 'completed': return 'Selesai';
                default: return 'Menunggu';
            }
        }

        function goToTransactionHistory() {
            window.location.href = '{{ route("transaction") }}';
        }

        function goToWelcome() {
            window.location.href = '{{ route("welcome") }}';
        }

        // Check for success message on page load
        document.addEventListener('DOMContentLoaded', function() {
            const message = sessionStorage.getItem('cartMessage');
            const messageType = sessionStorage.getItem('cartMessageType');

            if (message) {
                showCustomAlert({
                    title: messageType === 'success' ? 'Berhasil!' : 'Error',
                    message: message,
                    type: messageType || 'success'
                });

                // Clear the message
                sessionStorage.removeItem('cartMessage');
                sessionStorage.removeItem('cartMessageType');
            }
        });
    </script>
</body>
</html>
