@extends('layouts.landing.app')

@section('title', 'Riwayat Pesanan - Etukang')

@section('content')
    <!-- Header -->
    <div class="px-4 py-3 border-b border-gray-200 bg-white">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-900">Riwayat Pesanan</h1>
            <span class="text-sm text-gray-500">{{ $transactions->count() }} pesanan</span>
        </div>
    </div>

    <!-- Transaction List -->
    <div class="px-4 py-4">
        @forelse($transactions as $transaction)
        <div class="transaction-item" data-transaction-id="{{ $transaction->id }}">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-4 overflow-hidden">
                <div class="p-4">
                    <!-- Transaction Header -->
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-tools text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm">{{ $transaction->merchant->name }}</h3>
                                <p class="text-gray-500 text-xs">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ getStatusClass($transaction->status) }}">
                            {{ getStatusText($transaction->status) }}
                        </span>
                    </div>

                    <!-- Transaction Details -->
                    <div class="space-y-2 text-sm">
                        @foreach($transaction->transactionDetail as $detail)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">{{ $detail->product->name }}</span>
                            <span class="font-medium">Rp {{ number_format($detail->price, 0, ',', '.') }}</span>
                        </div>
                        @endforeach

                        <div class="border-t pt-2 mt-2">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-900">Total</span>
                                <span class="font-bold text-green-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    @if($transaction->payment)
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-500">Payment Code:</span>
                            <span class="font-medium">{{ $transaction->payment->payment_code }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-4 flex space-x-2">
                        <button onclick="viewTransactionDetail({{ $transaction->id }})"
                                class="flex-1 bg-gray-100 text-gray-700 py-2 px-3 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                            <i class="fas fa-eye mr-1"></i>
                            Detail
                        </button>
                        @if($transaction->status === 'pending')
                        <button onclick="cancelTransaction({{ $transaction->id }})"
                                class="flex-1 bg-red-100 text-red-700 py-2 px-3 rounded-lg text-sm font-medium hover:bg-red-200 transition-colors">
                            <i class="fas fa-times mr-1"></i>
                            Batal
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-receipt text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Pesanan</h3>
            <p class="text-gray-500 mb-6">Anda belum memiliki riwayat pesanan</p>
            <a href="{{ route('welcome') }}"
               class="bg-green-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-600 transition-colors inline-flex items-center">
                <i class="fas fa-tools mr-2"></i>
                Pesan Teknisi
            </a>
        </div>
        @endforelse
    </div>

    @include('layouts.landing.footer')
@endsection

@php
function getStatusClass($status) {
    switch($status) {
        case 'pending': return 'bg-yellow-100 text-yellow-800';
        case 'confirmed': return 'bg-green-100 text-green-800';
        case 'cancelled': return 'bg-red-100 text-red-800';
        case 'completed': return 'bg-blue-100 text-blue-800';
        default: return 'bg-gray-100 text-gray-800';
    }
}

function getStatusText($status) {
    switch($status) {
        case 'pending': return 'Menunggu';
        case 'confirmed': return 'Dikonfirmasi';
        case 'cancelled': return 'Dibatalkan';
        case 'completed': return 'Selesai';
        default: return 'Menunggu';
    }
}
@endphp

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

    // Transaction Functions - Client-side detail
    function viewTransactionDetail(transactionId) {
        // Cari transaction element berdasarkan ID
        const transactionElement = document.querySelector(`[data-transaction-id="${transactionId}"]`);
        if (!transactionElement) {
            showCustomAlert({
                title: 'Error',
                message: 'Data transaksi tidak ditemukan',
                type: 'error'
            });
            return;
        }

        // Ambil data dari DOM
        const merchantName = transactionElement.querySelector('.font-semibold').textContent;
        const date = transactionElement.querySelector('.text-gray-500').textContent;
        const status = transactionElement.querySelector('.rounded-full').textContent;
        const totalPrice = transactionElement.querySelector('.text-green-600').textContent;

        // Ambil detail layanan
        const serviceDetails = [];
        const serviceElements = transactionElement.querySelectorAll('.space-y-2 .flex.justify-between');
        serviceElements.forEach(element => {
            const serviceName = element.querySelector('.text-gray-600');
            const servicePrice = element.querySelector('.font-medium');
            if (serviceName && servicePrice) {
                serviceDetails.push({
                    name: serviceName.textContent,
                    price: servicePrice.textContent
                });
            }
        });

        showTransactionDetailModal({
            merchant: merchantName,
            date: date,
            status: status,
            total: totalPrice,
            services: serviceDetails
        });
    }

    function showTransactionDetailModal(transactionData) {
        const modal = document.createElement('div');
        modal.className = 'custom-alert show';

        let servicesHtml = '';
        if (transactionData.services && transactionData.services.length > 0) {
            servicesHtml = transactionData.services.map(service => `
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">${service.name}</span>
                    <span class="font-medium">${service.price}</span>
                </div>
            `).join('');
        }

        modal.innerHTML = `
            <div class="alert-content" style="width: 95%; max-width: 450px; max-height: 80vh; overflow-y: auto;">
                <div class="alert-header">
                    <div class="alert-icon info">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="alert-title">Detail Transaksi</div>
                    <div class="alert-message">
                        Detail lengkap transaksi Anda
                    </div>
                </div>

                <div class="p-4">
                    <div class="bg-gray-50 rounded-lg p-3 mb-3">
                        <h4 class="font-medium text-gray-900 mb-2">Informasi Transaksi</h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <div>Merchant: ${transactionData.merchant}</div>
                            <div>Tanggal: ${transactionData.date}</div>
                            <div>Status: ${transactionData.status}</div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-3 mb-3">
                        <h4 class="font-medium text-gray-900 mb-2">Detail Layanan</h4>
                        <div class="space-y-1">
                            ${servicesHtml}
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-lg p-3">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-900">Total Pembayaran</span>
                            <span class="font-bold text-green-600 text-lg">${transactionData.total}</span>
                        </div>
                    </div>
                </div>

                <div class="alert-buttons">
                    <button onclick="closeTransactionDetailModal()" class="alert-button primary">Tutup</button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
    }

    function closeTransactionDetailModal() {
        const modal = document.querySelector('.custom-alert.show');
        if (modal) {
            modal.remove();
        }
    }

    function cancelTransaction(transactionId) {
        showCustomAlert({
            title: 'Batalkan Transaksi',
            message: 'Apakah Anda yakin ingin membatalkan transaksi ini? Tindakan ini tidak dapat dibatalkan.',
            type: 'warning',
            confirmText: 'Ya, Batalkan',
            cancelText: 'Tidak',
            onConfirm: () => {
                performCancelTransaction(transactionId);
            }
        });
    }

    function performCancelTransaction(transactionId) {
        showCustomAlert({
            title: 'Memproses Pembatalan...',
            message: 'Mohon tunggu sebentar',
            type: 'info'
        });

        fetch(`/api/transactions/${transactionId}`, {
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
            hideCustomAlert();

            // Copy pattern dari cart/index.blade.php - cek data.success saja
            if (data.success) {
                showCustomAlert({
                    title: 'Berhasil!',
                    message: data.message || 'Transaksi berhasil dibatalkan',
                    type: 'success',
                    onConfirm: () => {
                        // Reload halaman setelah tekan OK
                        location.reload();
                    }
                });
            } else {
                showCustomAlert({
                    title: 'Error',
                    message: data.message || 'Gagal membatalkan transaksi',
                    type: 'error'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            hideCustomAlert();
            showCustomAlert({
                title: 'Error',
                message: 'Terjadi kesalahan saat membatalkan transaksi',
                type: 'error'
            });
        });
    }
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
    .alert-icon.info {
        background: #3B82F6;
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
