<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Pembayaran - Sportlodek</title>
    <meta name="description" content="Monitor pembayaran lapangan futsal">

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
        .payment-card {
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
        @include('layouts.merchant.navbar', ['headerTitle' => 'Monitor Pembayaran'])

        <!-- Content -->
        <div class="px-4 py-6 pb-20">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Pembayaran</h2>
                    <p class="text-sm text-gray-500">Monitor status pembayaran</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="filterPayments('all')"
                            class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-700">
                        Semua
                    </button>
                    <button onclick="filterPayments('success')"
                            class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-700">
                        Sukses
                    </button>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Pembayaran</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $payments->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-credit-card text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Sukses</p>
                            <p class="text-2xl font-bold text-green-600">{{ $payments->where('status', 'success')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payments List -->
            @if($payments->count() > 0)
                <div class="space-y-4">
                    @foreach($payments as $payment)
                    <div class="payment-card">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-credit-card text-purple-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $payment->user->name ?? 'User' }}</h3>
                                    <p class="text-sm text-gray-500">{{ $payment->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($payment->status === 'success') bg-green-100 text-green-800
                                @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($payment->status === 'failed') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>

                        <div class="space-y-2 mb-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Kode Pembayaran:</span>
                                <span class="font-mono font-medium text-gray-900">{{ $payment->code }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Total:</span>
                                <span class="font-bold text-green-600">{{ $payment->formatted_total }}</span>
                            </div>
                            @if($payment->transaction)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Jam Booking:</span>
                                <span class="font-medium">{{ $payment->transaction->formatted_start_time }} - {{ $payment->transaction->formatted_end_time }}</span>
                            </div>
                            @endif
                            @if($payment->paid_at)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Dibayar:</span>
                                <span class="font-medium">{{ $payment->paid_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <div class="flex space-x-2">
                                @if($payment->status === 'pending')
                                <button onclick="checkPaymentStatus({{ $payment->id }})"
                                        class="text-blue-600 text-sm font-medium">
                                    <i class="fas fa-sync mr-1"></i>
                                    Cek Status
                                </button>
                                @endif
                                <button onclick="viewPaymentDetails({{ $payment->id }})"
                                        class="text-gray-600 text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i>
                                    Detail
                                </button>
                            </div>
                            <div class="text-xs text-gray-500">
                                ID: #{{ $payment->id }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-credit-card text-4xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Pembayaran</h3>
                    <p class="text-gray-500">Belum ada pembayaran yang masuk</p>
                </div>
            @endif
        </div>

        @include('layouts.merchant.footer')
    </div>

    <script>
        function filterPayments(status) {
            showCustomAlert({
                title: 'Filter Pembayaran',
                message: 'Fitur filter akan segera hadir!',
                type: 'info'
            });
        }

        function checkPaymentStatus(paymentId) {
            showCustomAlert({
                title: 'Cek Status Pembayaran',
                message: 'Fitur cek status akan segera hadir!',
                type: 'info'
            });
        }

        function viewPaymentDetails(paymentId) {
            showCustomAlert({
                title: 'Detail Pembayaran',
                message: 'Fitur detail pembayaran akan segera hadir!',
                type: 'info'
            });
        }
    </script>
</body>
</html>
