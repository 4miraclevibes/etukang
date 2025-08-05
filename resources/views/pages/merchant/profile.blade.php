@extends('layouts.merchant.app')

@section('title', 'Profile Merchant')

@section('content')
<div class="px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Profile Merchant</h1>
        <p class="text-gray-600 mt-1">Kelola informasi merchant Anda</p>
    </div>

    @if(!$merchant)
        <!-- Create Merchant Profile -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">Buat Profile Merchant</h2>
            <p class="text-gray-600 text-sm mb-4">Anda belum memiliki profile merchant. Silakan isi form di bawah ini untuk membuat profile merchant.</p>
            
            <form id="createMerchantForm">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Merchant</label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Masukkan nama merchant">
                    <div id="name-error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Masukkan nomor telepon">
                    <div id="phone-error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>

                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea id="address" name="address" rows="3" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Masukkan alamat lengkap"></textarea>
                    <div id="address-error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>

                <button type="submit" 
                    class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium">
                    Buat Profile Merchant
                </button>
            </form>
        </div>
    @else
        <!-- Update Merchant Profile -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">Update Profile Merchant</h2>
            
            <form id="updateMerchantForm">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Merchant</label>
                    <input type="text" id="name" name="name" value="{{ $merchant->name }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Masukkan nama merchant">
                    <div id="name-error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ $merchant->phone }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Masukkan nomor telepon">
                    <div id="phone-error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>

                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea id="address" name="address" rows="3" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Masukkan alamat lengkap">{{ $merchant->address }}</textarea>
                    <div id="address-error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>

                <button type="submit" 
                    class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium">
                    Update Profile Merchant
                </button>
            </form>

            <!-- Merchant Info -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <h3 class="text-md font-semibold text-gray-900 mb-3">Informasi Merchant</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Status</span>
                        <span class="text-sm font-medium text-gray-900">{{ ucfirst($merchant->status) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Tanggal Dibuat</span>
                        <span class="text-sm font-medium text-gray-900">{{ $merchant->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Loading Modal -->
<div id="loadingModal" class="modal">
    <div class="modal-content">
        <div class="p-6">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <i class="fas fa-spinner fa-spin text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Memproses...</h3>
                <p class="text-sm text-gray-600">Mohon tunggu sebentar</p>
            </div>
        </div>
    </div>
</div>

<script>
// Show Loading Modal
function showLoadingModal() {
    document.getElementById('loadingModal').classList.add('show');
}

// Hide Loading Modal
function hideLoadingModal() {
    document.getElementById('loadingModal').classList.remove('show');
}

@if(!$merchant)
// Create Merchant Form
document.getElementById('createMerchantForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    showLoadingModal();
    
    const formData = {
        name: document.getElementById('name').value,
        phone: document.getElementById('phone').value,
        address: document.getElementById('address').value
    };

    fetch('{{ route("merchant.profile.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        hideLoadingModal();
        if (data.message) {
            showSuccessAlert(data.message);
            setTimeout(() => {
                location.reload();
            }, 1500);
        }
    })
    .catch(error => {
        hideLoadingModal();
        console.error('Error:', error);
        showErrorAlert('Terjadi kesalahan saat membuat profile merchant');
    });
});
@else
// Update Merchant Form
document.getElementById('updateMerchantForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    showLoadingModal();
    
    const formData = {
        name: document.getElementById('name').value,
        phone: document.getElementById('phone').value,
        address: document.getElementById('address').value
    };

    fetch('{{ route("merchant.profile.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        hideLoadingModal();
        if (data.message) {
            showSuccessAlert(data.message);
            setTimeout(() => {
                location.reload();
            }, 1500);
        }
    })
    .catch(error => {
        hideLoadingModal();
        console.error('Error:', error);
        showErrorAlert('Terjadi kesalahan saat memperbarui profile merchant');
    });
});
@endif
</script>
@endsection
