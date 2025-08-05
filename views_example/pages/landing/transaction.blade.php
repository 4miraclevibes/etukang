<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking - Sportlodek</title>
    <meta name="description" content="Riwayat booking lapangan futsal">

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
        .install-banner {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
        }
        .category-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 12px 8px;
            border-radius: 12px;
            transition: all 0.2s;
        }
        .category-item.active {
            background: #10B981;
            color: white;
        }
        .transaction-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 12px;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-pending {
            background: #fef3c7;
            color: #d97706;
        }
        .status-confirmed {
            background: #d1fae5;
            color: #059669;
        }
        .status-cancelled {
            background: #fee2e2;
            color: #dc2626;
        }
        .status-completed {
            background: #dbeafe;
            color: #2563eb;
        }
        .payment-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
        }
        .payment-cash {
            background: #f3f4f6;
            color: #374151;
        }
        .payment-transfer {
            background: #dbeafe;
            color: #2563eb;
        }
        .payment-ewallet {
            background: #fef3c7;
            color: #d97706;
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
        .hour-slot {
            display: inline-block;
            padding: 8px 12px;
            margin: 4px;
            border-radius: 8px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .hour-slot.available {
            background: #10B981;
            color: white;
        }
        .hour-slot.booked {
            background: #ef4444;
            color: white;
            cursor: not-allowed;
        }
        .hour-slot.selected {
            background: #059669;
            color: white;
            transform: scale(1.05);
        }
        .hour-slot:not(.available):not(.booked) {
            display: none;
        }
        .availability-modal {
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .availability-modal .modal-content {
            animation: scaleIn 0.3s ease-out;
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
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
        @include('layouts.landing.navbar', ['headerTitle' => 'Riwayat Booking', 'headerIcon' => 'receipt'])

        <!-- Transaction Content -->
        <div class="px-4 py-6 pb-20">
            @if($transactions->count() > 0)
                <!-- Transaction Items -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Riwayat Booking ({{ $transactions->count() }})</h2>

                    @foreach($transactions as $transaction)
                    <div class="transaction-card">
                        <div class="p-4">
                            <!-- Merchant Info -->
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-futbol text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 text-sm">{{ $transaction->merchant->name }}</h3>
                                    <p class="text-gray-500 text-xs">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="{{ getStatusClass($transaction->status) }} status-badge">{{ getStatusText($transaction->status) }}</div>
                                    <div class="{{ getPaymentClass($transaction->payment_method) }} payment-badge mt-1">{{ getPaymentText($transaction->payment_method) }}</div>
                                </div>
                            </div>

                            <!-- Booking Details -->
                            <div class="bg-gray-50 rounded-lg p-3 mb-3">
                                <div class="grid grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <span class="text-gray-500">Jam Mulai:</span>
                                        <span class="font-medium text-gray-900">{{ $transaction->formatted_start_time }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Jam Selesai:</span>
                                        <span class="font-medium text-gray-900">{{ $transaction->formatted_end_time }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Durasi:</span>
                                        <span class="font-medium text-gray-900">{{ $transaction->total_quantity }} jam</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Total Bayar:</span>
                                        <span class="font-bold text-green-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($transaction->transactionDetails->count() > 0)
                            <!-- Lapangan Details -->
                            <div class="mb-3">
                                <p class="text-xs text-gray-500 mb-2">Lapangan yang Dibooking:</p>
                                @foreach($transaction->transactionDetails->groupBy('product_id') as $productId => $details)
                                    @php
                                        $product = $details->first()->product;
                                        $hours = $details->map(function($detail) {
                                            return sprintf('%02d:00', $detail->hour);
                                        })->toArray();
                                    @endphp
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium">{{ $product->name }}</span>
                                        <span class="text-xs text-gray-500">{{ implode(', ', $hours) }}</span>
                                    </div>
                                @endforeach
                            </div>
                            @endif

                            @if($transaction->payment)
                            <!-- Payment Status -->
                            <div class="border-t pt-3 mb-3">
                                <div class="bg-blue-50 rounded-lg p-3 mb-2">
                                    <h4 class="text-sm font-semibold text-blue-900 mb-2 flex items-center">
                                        <i class="fas fa-credit-card mr-2"></i>
                                        Informasi Pembayaran
                                    </h4>
                                    <div class="space-y-1 text-xs">
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">Kode Pembayaran:</span>
                                            <span class="font-mono font-medium text-blue-900">{{ $transaction->payment->code }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">Total Pembayaran:</span>
                                            <span class="font-bold text-blue-900">{{ $transaction->payment->formatted_total }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">Status:</span>
                                            <span class="text-sm {{ getPaymentStatusClass($transaction->payment->status) }} font-medium">{{ getPaymentStatusText($transaction->payment->status) }}</span>
                                        </div>
                                        @if($transaction->payment->paid_at)
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">Dibayar:</span>
                                            <span class="text-blue-900">{{ $transaction->payment->paid_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Payment Status Badge -->
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">Status Pembayaran:</span>
                                    <span class="text-sm {{ getPaymentStatusClass($transaction->payment->status) }} font-medium">{{ getPaymentStatusText($transaction->payment->status) }}</span>
                                </div>
                                @if($transaction->payment->paid_at)
                                <p class="text-xs text-gray-500 mt-1">Dibayar: {{ $transaction->payment->paid_at->format('d/m/Y H:i') }}</p>
                                @endif
                            </div>
                            @endif

                            @if($transaction->status === 'pending')
                            <!-- Cancel Button -->
                            <div class="border-t pt-3">
                                <button onclick="cancelTransaction({{ $transaction->id }})"
                                        class="w-full bg-red-500 text-white py-2 rounded-lg text-sm font-medium hover:bg-red-600 transition-colors">
                                    <i class="fas fa-times mr-2"></i>
                                    Batalkan Booking
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Summary -->
                <div class="bg-white rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Ringkasan Booking</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Total Booking:</span>
                            <span class="font-medium">{{ $transactions->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Pending:</span>
                            <span class="font-medium text-yellow-600">{{ $transactions->where('status', 'pending')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Confirmed:</span>
                            <span class="font-medium text-green-600">{{ $transactions->where('status', 'confirmed')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Completed:</span>
                            <span class="font-medium text-blue-600">{{ $transactions->where('status', 'completed')->count() }}</span>
                        </div>
                        <div class="border-t pt-2">
                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-900">Total Spent:</span>
                                <span class="font-bold text-green-600 text-lg">Rp {{ number_format($transactions->where('status', '!=', 'cancelled')->sum('total_price'), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-times text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Booking</h3>
                    <p class="text-gray-500 mb-6">Anda belum memiliki riwayat booking. Mulai booking lapangan sekarang!</p>
                    <a href="{{ route('welcome') }}"
                       class="bg-green-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-600 transition-colors inline-flex items-center">
                        <i class="fas fa-futbol mr-2"></i>
                        Booking Sekarang
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

        function cancelTransaction(transactionId) {
            console.log('Cancel transaction:', transactionId); // Debug

            showCustomAlert({
                title: 'Batalkan Booking',
                message: 'Apakah Anda yakin ingin membatalkan booking ini?',
                type: 'warning',
                confirmText: 'Ya, Batalkan',
                cancelText: 'Tidak',
                onConfirm: () => {
                    console.log('Proceeding with cancel...'); // Debug

                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                                     document.querySelector('input[name="_token"]')?.value ||
                                     '{{ csrf_token() }}';

                    console.log('CSRF Token:', csrfToken); // Debug

                    fetch(`/api/transactions/${transactionId}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'Authorization': 'Bearer {{ Auth::user() ? Auth::user()->createToken("web-token")->plainTextToken : "" }}'
                        },
                        body: JSON.stringify({
                            status: 'cancelled'
                        })
                    })
                    .then(response => {
                        console.log('Response status:', response.status); // Debug
                        console.log('Response ok:', response.ok); // Debug

                        if (!response.ok) {
                            return response.json().then(errorData => {
                                console.log('Error response:', errorData); // Debug
                                throw new Error(`HTTP error! status: ${response.status}, message: ${JSON.stringify(errorData)}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Success response:', data); // Debug

                        if (data.message) {
                            showCustomAlert({
                                title: 'Berhasil!',
                                message: data.message,
                                type: 'success'
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showCustomAlert({
                                title: 'Error',
                                message: 'Gagal membatalkan booking',
                                type: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showCustomAlert({
                            title: 'Error',
                            message: 'Gagal membatalkan booking: ' + error.message,
                            type: 'error'
                        });
                    });
                }
            });
        }
    </script>
</body>
</html>

@php
function getStatusClass($status) {
    switch($status) {
        case 'pending': return 'status-pending';
        case 'confirmed': return 'status-confirmed';
        case 'cancelled': return 'status-cancelled';
        case 'completed': return 'status-completed';
        default: return 'status-pending';
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

function getPaymentClass($method) {
    switch($method) {
        case 'cash': return 'payment-cash';
        case 'transfer': return 'payment-transfer';
        case 'ewallet': return 'payment-ewallet';
        default: return 'payment-cash';
    }
}

function getPaymentText($method) {
    switch($method) {
        case 'cash': return 'Tunai';
        case 'transfer': return 'Transfer';
        case 'ewallet': return 'E-Wallet';
        default: return 'Tunai';
    }
}

function getPaymentStatusClass($status) {
    switch($status) {
        case 'pending': return 'text-yellow-600';
        case 'success': return 'text-green-600';
        case 'failed': return 'text-red-600';
        case 'expired': return 'text-gray-600';
        default: return 'text-gray-600';
    }
}

function getPaymentStatusText($status) {
    switch($status) {
        case 'pending': return 'Menunggu Pembayaran';
        case 'success': return 'Lunas';
        case 'failed': return 'Gagal';
        case 'expired': return 'Kadaluarsa';
        default: return 'Menunggu';
    }
}
@endphp
