@extends('layouts.landing.app')

@section('title', 'Keranjang - Etukang')

@section('content')
    <!-- Header -->
    <div class="px-4 py-3 border-b border-gray-200 bg-white">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-900">Keranjang</h1>
            <span class="text-sm text-gray-500">{{ $carts->count() }} item</span>
        </div>
    </div>

    <!-- Cart Content -->
    <div class="px-4 py-6 pb-20">
        @if($carts->count() > 0)
            <!-- Cart Items -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Item Pesanan ({{ $carts->count() }})</h2>

                @foreach($carts as $cart)
                <div class="cart-item" data-cart-id="{{ $cart->id }}">
                    <div class="p-4">
                        <!-- Merchant Info -->
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-tools text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm">{{ $cart->merchant->name }}</h3>
                                <p class="text-gray-500 text-xs">{{ $cart->product->name }}</p>
                            </div>
                            <button onclick="removeCartItem({{ $cart->id }})"
                                    class="text-red-500 hover:text-red-700 transition-colors">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>

                        <!-- Service Details -->
                        <div class="bg-gray-50 rounded-lg p-3 mb-3">
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="text-gray-500">Layanan:</span>
                                    <span class="font-medium text-gray-900">{{ $cart->product->name }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Jumlah:</span>
                                    <span class="font-medium text-gray-900">{{ $cart->quantity }} service</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Harga/Service:</span>
                                    <span class="font-medium text-gray-900">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Total:</span>
                                    <span class="font-bold text-green-600">Rp {{ number_format($cart->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity Control -->
                        <div class="flex items-center justify-between">
                            <div class="quantity-control">
                                <button onclick="updateQuantity({{ $cart->id }}, -1)"
                                        class="quantity-btn"
                                        {{ $cart->quantity <= 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="quantity-display">{{ $cart->quantity }}</span>
                                <button onclick="updateQuantity({{ $cart->id }}, 1)"
                                        class="quantity-btn">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-gray-500">Total</span>
                                <div class="font-bold text-green-600">Rp {{ number_format($cart->price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Summary -->
            <div class="bg-white rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-gray-900 mb-3">Ringkasan Pesanan</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Total Item:</span>
                        <span class="font-medium">{{ $carts->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Total Service:</span>
                        <span class="font-medium">{{ $carts->sum('quantity') }} service</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Subtotal:</span>
                        <span class="font-medium">Rp {{ number_format($carts->sum('price'), 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t pt-2">
                        <div class="flex justify-between">
                            <span class="font-semibold text-gray-900">Total Bayar:</span>
                            <span class="font-bold text-green-600 text-lg">Rp {{ number_format($carts->sum('price'), 0, ',', '.') }}</span>
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
                <p class="text-gray-500 mb-6">Belum ada item pesanan di keranjang Anda</p>
                <a href="{{ route('welcome') }}"
                   class="bg-green-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-600 transition-colors inline-flex items-center">
                    <i class="fas fa-tools mr-2"></i>
                    Cari Teknisi
                </a>
            </div>
        @endif
    </div>

    @include('layouts.landing.footer')
@endsection

<style>
    .cart-item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 12px;
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

    // Cart Functions - Perbaikan endpoint dan realtime update
    function updateQuantity(cartId, change) {
        const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
        const quantityDisplay = cartItem.querySelector('.quantity-display');
        const newQuantity = parseInt(quantityDisplay.textContent) + change;

        if (newQuantity < 1) return;

        fetch(`/api/carts/${cartId}`, {
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
            // Cek apakah response berhasil
            if (data.success) {
                // Update UI tanpa reload jika ada data
                if (data.data) {
                    updateCartItemUI(cartId, data.data);
                    updateCartSummary();
                }

                showCustomAlert({
                    title: 'Berhasil!',
                    message: data.message || 'Quantity berhasil diperbarui',
                    type: 'success'
                });
            } else {
                // Jika tidak berhasil, tampilkan pesan error
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
                fetch(`/api/carts/${cartId}`, {
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
                        // Remove item dari UI tanpa reload
                        const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
                        cartItem.remove();
                        updateCartSummary();

                        // Check if cart is empty
                        const remainingItems = document.querySelectorAll('.cart-item');
                        if (remainingItems.length === 0) {
                            showEmptyCart();
                        }

                        showCustomAlert({
                            title: 'Berhasil!',
                            message: 'Item berhasil dihapus dari keranjang',
                            type: 'success'
                        });
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
                fetch('/api/carts', {
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
                    // Clear cart UI tanpa reload
                    const cartItems = document.querySelectorAll('.cart-item');
                    cartItems.forEach(item => item.remove());
                    showEmptyCart();

                    showCustomAlert({
                        title: 'Berhasil!',
                        message: 'Keranjang berhasil dikosongkan',
                        type: 'success'
                    });
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

    // Helper functions untuk update UI
    function updateCartItemUI(cartId, cartData) {
        const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
        if (!cartItem || !cartData) {
            return;
        }

        // Update quantity display
        const quantityDisplay = cartItem.querySelector('.quantity-display');
        if (quantityDisplay) {
            quantityDisplay.textContent = cartData.quantity;
        }

        // Update price per service (cari berdasarkan text content)
        const priceElements = cartItem.querySelectorAll('.text-gray-900');
        priceElements.forEach(element => {
            if (element.textContent.includes('Rp') && element.textContent.includes('service')) {
                element.textContent = `Rp ${formatNumber(cartData.product?.price || 0)}`;
            }
        });

        // Update total price di bagian kanan
        const rightTotal = cartItem.querySelector('.text-right .text-green-600');
        if (rightTotal) {
            rightTotal.textContent = `Rp ${formatNumber(cartData.price)}`;
        }

        // Update total price di service details
        const serviceDetails = cartItem.querySelectorAll('.text-green-600');
        serviceDetails.forEach(element => {
            if (element.textContent.includes('Rp') && !element.closest('.text-right')) {
                element.textContent = `Rp ${formatNumber(cartData.price)}`;
            }
        });

        // Update minus button disabled state
        const minusBtn = cartItem.querySelector('.quantity-btn');
        if (minusBtn) {
            minusBtn.disabled = cartData.quantity <= 1;
        }
    }

    function updateCartSummary() {
        const cartItems = document.querySelectorAll('.cart-item');
        const totalItems = cartItems.length;

        let totalQuantity = 0;
        let totalPrice = 0;

        cartItems.forEach(item => {
            const quantityDisplay = item.querySelector('.quantity-display');
            const priceElement = item.querySelector('.text-right .text-green-600');

            if (quantityDisplay) {
                totalQuantity += parseInt(quantityDisplay.textContent) || 0;
            }

            if (priceElement) {
                const priceText = priceElement.textContent;
                const price = parseInt(priceText.replace(/[^\d]/g, '')) || 0;
                totalPrice += price;
            }
        });

        // Update summary
        const summaryItems = document.querySelectorAll('.space-y-2 .flex.justify-between');
        if (summaryItems.length >= 4) {
            summaryItems[0].querySelector('.font-medium').textContent = totalItems;
            summaryItems[1].querySelector('.font-medium').textContent = `${totalQuantity} service`;
            summaryItems[2].querySelector('.font-medium').textContent = `Rp ${formatNumber(totalPrice)}`;
            summaryItems[3].querySelector('.text-green-600').textContent = `Rp ${formatNumber(totalPrice)}`;
        }

        // Update header count
        const headerCount = document.querySelector('.text-sm.text-gray-500');
        if (headerCount) {
            headerCount.textContent = `${totalItems} item`;
        }
    }

    function showEmptyCart() {
        const cartContent = document.querySelector('.px-4.py-6.pb-20');
        cartContent.innerHTML = `
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shopping-cart text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Keranjang Kosong</h3>
                <p class="text-gray-500 mb-6">Belum ada item pesanan di keranjang Anda</p>
                <a href="{{ route('welcome') }}"
                   class="bg-green-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-600 transition-colors inline-flex items-center">
                    <i class="fas fa-tools mr-2"></i>
                    Cari Teknisi
                </a>
            </div>
        `;
    }

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function proceedToCheckout() {
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
        if (method === 'ewallet') {
            showCustomAlert({
                title: 'Fitur Dalam Pengembangan',
                message: 'Pembayaran via E-Wallet sedang dalam pengembangan. Silakan pilih metode pembayaran lainnya.',
                type: 'info'
            });
            return;
        }

        closePaymentMethodModal();

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
        showCustomAlert({
            title: 'Memproses Checkout...',
            message: 'Mohon tunggu sebentar, sedang memproses pesanan Anda.',
            type: 'info'
        });

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

            // Perbaikan: cek response yang benar
            if (data.success && data.message) {
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

        let transactionsHtml = '';
        if (data.data && data.data.length > 0) {
            transactionsHtml = data.data.map(transaction => `
                <div class="bg-gray-50 rounded-lg p-3 mb-3">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-medium text-gray-900">${transaction.merchant?.name || 'N/A'}</span>
                        <span class="text-sm ${getStatusClass(transaction.status)}">${getStatusText(transaction.status)}</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <div>Layanan: ${transaction.transaction_detail?.[0]?.product?.name || 'N/A'}</div>
                        <div>Total: Rp ${formatNumber(transaction.total_price)}</div>
                        ${transaction.payment ? `<div>Payment: ${transaction.payment.payment_code}</div>` : ''}
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
                        Pesanan Anda berhasil dibuat. Berikut adalah detail pesanan Anda:
                    </div>
                </div>

                <div class="p-4">
                    ${transactionsHtml}

                    <div class="bg-green-50 rounded-lg p-3 mt-3">
                        <div class="text-sm text-green-800">
                            <div class="font-medium mb-1">Total Transaksi: ${data.data?.length || 0}</div>
                            <div>Total Pembayaran: Rp ${formatNumber(data.data?.reduce((sum, t) => sum + t.total_price, 0) || 0)}</div>
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

            sessionStorage.removeItem('cartMessage');
            sessionStorage.removeItem('cartMessageType');
        }
    });
</script>

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

<style>
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
