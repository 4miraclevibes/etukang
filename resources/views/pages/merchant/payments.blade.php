@extends('layouts.merchant.app')

@section('title', 'Pembayaran')

@section('content')
<div class="px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Pembayaran</h1>
        <p class="text-gray-600 mt-1">Kelola pembayaran dari customer</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-3">Filter Pembayaran</h2>
        <form method="GET" class="space-y-3">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="payment_status" name="payment_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('payment_status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="cancelled" {{ request('payment_status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Metode</label>
                    <select id="payment_method" name="payment_method" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Semua Metode</option>
                        <option value="cash" {{ request('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="transfer" {{ request('payment_method') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="edc" {{ request('payment_method') === 'edc' ? 'selected' : '' }}>EDC</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-filter mr-1"></i>Filter
            </button>
        </form>
    </div>

    <!-- Payments List -->
    <div class="space-y-4">
        @forelse($payments as $payment)
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $payment->payment_code }}</h3>
                    <p class="text-sm text-gray-600">{{ $payment->user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $payment->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-green-600">Rp {{ number_format($payment->total_price, 0, ',', '.') }}</p>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                        {{ $payment->payment_status === 'completed' ? 'bg-green-100 text-green-800' :
                           ($payment->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                           ($payment->payment_status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                        {{ ucfirst($payment->payment_status) }}
                    </span>
                </div>
            </div>
            
            <div class="mb-3">
                <p class="text-sm text-gray-600">Metode: <span class="text-gray-900">{{ ucfirst($payment->payment_method) }}</span></p>
            </div>

            <div class="flex justify-end space-x-2">
                <button onclick="viewPayment({{ $payment->id }})" class="text-blue-600 hover:text-blue-700 text-sm">
                    <i class="fas fa-eye mr-1"></i>Detail
                </button>
                @if($payment->payment_status === 'pending')
                <button onclick="updatePaymentStatus({{ $payment->id }}, 'completed')" class="text-green-600 hover:text-green-700 text-sm">
                    <i class="fas fa-check mr-1"></i>Selesai
                </button>
                <button onclick="updatePaymentStatus({{ $payment->id }}, 'failed')" class="text-red-600 hover:text-red-700 text-sm">
                    <i class="fas fa-times mr-1"></i>Gagal
                </button>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <i class="fas fa-credit-card text-gray-400 text-4xl mb-4"></i>
            <p class="text-gray-500">Belum ada pembayaran</p>
            <p class="text-sm text-gray-400 mt-1">Pembayaran akan muncul di sini setelah customer melakukan pembayaran</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Payment Detail Modal -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Detail Pembayaran</h3>
                <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="paymentDetail" class="space-y-4">
                <!-- Payment details will be loaded here -->
            </div>
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

// View Payment Detail
function viewPayment(paymentId) {
    fetch(`/merchant/payments/${paymentId}`)
        .then(response => response.json())
        .then(data => {
            const payment = data.data;
            let detailHtml = `
                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Kode Pembayaran</p>
                        <p class="text-sm text-gray-900">${payment.payment_code}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Customer</p>
                        <p class="text-sm text-gray-900">${payment.user.name}</p>
                        <p class="text-sm text-gray-500">${payment.user.email}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Metode Pembayaran</p>
                        <p class="text-sm text-gray-900">${payment.payment_method}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pembayaran</p>
                        <p class="text-sm text-gray-900">Rp ${new Intl.NumberFormat('id-ID').format(payment.total_price)}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status Pembayaran</p>
                        <p class="text-sm text-gray-900">${payment.payment_status}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tanggal</p>
                        <p class="text-sm text-gray-900">${new Date(payment.created_at).toLocaleDateString('id-ID')}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">ID Transaksi</p>
                        <p class="text-sm text-gray-900">#${payment.transaction.id}</p>
                    </div>
                </div>
            `;
            document.getElementById('paymentDetail').innerHTML = detailHtml;
            document.getElementById('paymentModal').classList.add('show');
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorAlert('Terjadi kesalahan saat mengambil detail pembayaran');
        });
}

// Close Payment Modal
function closePaymentModal() {
    document.getElementById('paymentModal').classList.remove('show');
}

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

// Update Payment Status
function updatePaymentStatus(paymentId, newStatus) {
    const statusText = {
        'completed': 'menyelesaikan',
        'failed': 'menggagalkan',
        'cancelled': 'membatalkan'
    };
    
    showConfirmModal(
        'Update Status Pembayaran',
        `Apakah Anda yakin ingin ${statusText[newStatus]} pembayaran ini?`,
        function() {
            fetch(`/merchant/payments/${paymentId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    payment_status: newStatus
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
                showErrorAlert('Terjadi kesalahan saat memperbarui status pembayaran');
            });
        }
    );
}
</script>
@endsection
