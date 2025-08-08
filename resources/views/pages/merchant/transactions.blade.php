@extends('layouts.merchant.app')

@section('title', 'Transaksi')

@section('content')
<div class="px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Transaksi</h1>
        <p class="text-gray-600 mt-1">Kelola transaksi booking service</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-3">Filter Transaksi</h2>
        <form method="GET" class="space-y-3">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
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

    <!-- Transactions List -->
    <div class="space-y-4">
        @forelse($transactions as $transaction)
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">#{{ $transaction->id }}</h3>
                    <p class="text-sm text-gray-600">{{ $transaction->user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-green-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                        {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' :
                           ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                           ($transaction->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </div>
            </div>

            <div class="mb-3">
                <p class="text-sm text-gray-600">Service:</p>
                @forelse($transaction->transactionDetail as $detail)
                    <p class="text-sm text-gray-900">{{ $detail->product->name ?? 'Service tidak ditemukan' }} ({{ $detail->quantity }}x)</p>
                @empty
                    <p class="text-sm text-gray-500">Tidak ada detail</p>
                @endforelse
            </div>

            <div class="flex justify-end space-x-2">
                <button onclick="viewTransaction({{ $transaction->id }})" class="text-blue-600 hover:text-blue-700 text-sm">
                    <i class="fas fa-eye mr-1"></i>Detail
                </button>
                @if($transaction->status === 'pending')
                <button onclick="updateTransactionStatus({{ $transaction->id }}, 'confirmed')" class="text-green-600 hover:text-green-700 text-sm">
                    <i class="fas fa-check mr-1"></i>Konfirmasi
                </button>
                @endif
                @if($transaction->status === 'confirmed')
                <button onclick="updateTransactionStatus({{ $transaction->id }}, 'completed')" class="text-green-600 hover:text-green-700 text-sm">
                    <i class="fas fa-check-double mr-1"></i>Selesai
                </button>
                @endif
                @if(in_array($transaction->status, ['pending', 'confirmed']))
                <button onclick="updateTransactionStatus({{ $transaction->id }}, 'cancelled')" class="text-red-600 hover:text-red-700 text-sm">
                    <i class="fas fa-times mr-1"></i>Batal
                </button>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <i class="fas fa-receipt text-gray-400 text-4xl mb-4"></i>
            <p class="text-gray-500">Belum ada transaksi</p>
            <p class="text-sm text-gray-400 mt-1">Transaksi akan muncul di sini setelah customer melakukan booking</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Transaction Detail Modal -->
<div id="transactionModal" class="modal">
    <div class="modal-content">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Detail Transaksi</h3>
                <button onclick="closeTransactionModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="transactionDetail" class="space-y-4">
                <!-- Transaction details will be loaded here -->
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

// View Transaction Detail
function viewTransaction(transactionId) {
    fetch(`/merchant/transactions/${transactionId}`)
        .then(response => response.json())
        .then(data => {
            const transaction = data.data;
            let detailHtml = `
                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">ID Transaksi</p>
                        <p class="text-sm text-gray-900">#${transaction.id}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Customer</p>
                        <p class="text-sm text-gray-900">${transaction.user.name}</p>
                        <p class="text-sm text-gray-500">${transaction.user.email}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Harga</p>
                        <p class="text-sm text-gray-900">Rp ${new Intl.NumberFormat('id-ID').format(transaction.total_price)}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status</p>
                        <p class="text-sm text-gray-900">${transaction.status}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tanggal</p>
                        <p class="text-sm text-gray-900">${new Date(transaction.created_at).toLocaleDateString('id-ID')}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Detail Service</p>
                        <div class="mt-2">
                            ${transaction.transaction_details && transaction.transaction_details.length > 0
                                ? transaction.transaction_details.map(detail => `
                                    <div class="text-sm text-gray-900">
                                        ${detail.product ? detail.product.name : 'Service tidak ditemukan'} - ${detail.quantity}x - Rp ${new Intl.NumberFormat('id-ID').format(detail.product ? detail.product.price : 0)}
                                    </div>
                                `).join('')
                                : '<div class="text-sm text-gray-500">Tidak ada detail</div>'
                            }
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('transactionDetail').innerHTML = detailHtml;
            document.getElementById('transactionModal').classList.add('show');
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorAlert('Terjadi kesalahan saat mengambil detail transaksi');
        });
}

// Close Transaction Modal
function closeTransactionModal() {
    document.getElementById('transactionModal').classList.remove('show');
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

// Update Transaction Status
function updateTransactionStatus(transactionId, newStatus) {
    const statusText = {
        'confirmed': 'mengkonfirmasi',
        'completed': 'menyelesaikan',
        'cancelled': 'membatalkan'
    };

    showConfirmModal(
        'Update Status Transaksi',
        `Apakah Anda yakin ingin ${statusText[newStatus]} transaksi ini?`,
        function() {
            fetch(`/merchant/transactions/${transactionId}/status`, {
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
                showErrorAlert('Terjadi kesalahan saat memperbarui status transaksi');
            });
        }
    );
}
</script>
@endsection
