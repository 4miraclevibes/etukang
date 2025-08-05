@extends('layouts.merchant.app')

@section('title', 'Dashboard Merchant')

@section('content')
<div class="px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Merchant</h1>
        <p class="text-gray-600 mt-1">Selamat datang di panel merchant Anda</p>
    </div>

    <!-- Merchant Status -->
    @if($merchant)
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ $merchant->name }}</h2>
                <p class="text-sm text-gray-600">{{ $merchant->phone }}</p>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 text-xs font-semibold rounded-full
                    {{ $merchant->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($merchant->status) }}
                </span>
                <button id="toggleStatusBtn" onclick="toggleMerchantStatus()" 
                    class="block mt-2 text-xs text-blue-600 hover:text-blue-700">
                    {{ $merchant->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics -->
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-calendar-check text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Booking</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $totalBookings }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-money-bill-wave text-green-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                    <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-tools text-purple-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Service</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Pending Booking</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $pendingBookings }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-3">Transaksi Terbaru</h2>
        <div class="space-y-3">
            @forelse($recentTransactions as $transaction)
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-gray-900">#{{ $transaction->id }}</p>
                    <p class="text-xs text-gray-600">{{ $transaction->user->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    <span class="text-xs px-2 py-1 rounded-full
                        {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' :
                           ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                           ($transaction->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500 text-center py-4">Belum ada transaksi</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-3">Pembayaran Terbaru</h2>
        <div class="space-y-3">
            @forelse($recentPayments as $payment)
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $payment->payment_code }}</p>
                    <p class="text-xs text-gray-600">{{ $payment->user->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($payment->total_price, 0, ',', '.') }}</p>
                    <span class="text-xs px-2 py-1 rounded-full
                        {{ $payment->payment_status === 'completed' ? 'bg-green-100 text-green-800' :
                           ($payment->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                           ($payment->payment_status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                        {{ ucfirst($payment->payment_status) }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500 text-center py-4">Belum ada pembayaran</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="modal">
    <div class="modal-content">
        <div class="p-6">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                </div>
                <h3 id="confirmTitle" class="text-lg font-semibold text-gray-900 mb-2">Konfirmasi</h3>
                <p id="confirmMessage" class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin melakukan aksi ini?</p>
                <div class="flex justify-center space-x-3">
                    <button id="confirmCancel" onclick="closeConfirmModal()" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <button id="confirmAction" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Ya, Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentAction = null;

// Close Confirm Modal
function closeConfirmModal() {
    document.getElementById('confirmModal').classList.remove('show');
}

// Show Confirm Modal
function showConfirmModal(title, message, action) {
    document.getElementById('confirmTitle').textContent = title;
    document.getElementById('confirmMessage').textContent = message;
    currentAction = action;
    document.getElementById('confirmModal').classList.add('show');
}

// Confirm Action
document.getElementById('confirmAction').addEventListener('click', function() {
    if (currentAction) {
        currentAction();
        closeConfirmModal();
    }
});

// Toggle Merchant Status
function toggleMerchantStatus() {
    const currentStatus = '{{ $merchant->status ?? "inactive" }}';
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const actionText = newStatus === 'active' ? 'mengaktifkan' : 'menonaktifkan';
    
    showConfirmModal(
        'Ubah Status Merchant',
        `Apakah Anda yakin ingin ${actionText} merchant Anda?`,
        function() {
            fetch('{{ route("merchant.dashboard.update-status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    showSuccessAlert(data.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorAlert('Terjadi kesalahan saat memperbarui status');
            });
        }
    );
}
</script>
@endsection
