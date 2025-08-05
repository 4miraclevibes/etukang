@extends('layouts.merchant.app')

@section('title', 'Kelola Service')

@section('content')
<div class="px-4 py-6">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kelola Service</h1>
                <p class="text-gray-600 mt-1">Kelola service yang Anda tawarkan</p>
            </div>
            <button id="addProductBtn" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm">
                <i class="fas fa-plus mr-1"></i>Tambah
            </button>
        </div>
    </div>

    <!-- Products List -->
    <div class="space-y-4">
        @forelse($products as $product)
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $product->description ?: 'Tidak ada deskripsi' }}</p>
                    <p class="text-lg font-bold text-green-600 mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                <div class="text-right">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                        {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </div>
            </div>
            <div class="flex justify-end space-x-2 mt-4">
                <button onclick="editProduct({{ $product->id }})" class="text-blue-600 hover:text-blue-700 text-sm">
                    <i class="fas fa-edit mr-1"></i>Edit
                </button>
                <button onclick="toggleProductStatus({{ $product->id }})" class="text-yellow-600 hover:text-yellow-700 text-sm">
                    <i class="fas fa-toggle-on mr-1"></i>{{ $product->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
                <button onclick="deleteProduct({{ $product->id }})" class="text-red-600 hover:text-red-700 text-sm">
                    <i class="fas fa-trash mr-1"></i>Hapus
                </button>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <i class="fas fa-tools text-gray-400 text-4xl mb-4"></i>
            <p class="text-gray-500">Belum ada service</p>
            <p class="text-sm text-gray-400 mt-1">Klik tombol "Tambah" untuk menambahkan service pertama</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Add/Edit Product Modal -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Tambah Service</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="productForm">
                <input type="hidden" id="productId" name="product_id">
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Service</label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Masukkan nama service">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Masukkan deskripsi service (opsional)"></textarea>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                    <input type="number" id="price" name="price" required min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Masukkan harga">
                </div>

                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="status" name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
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
let isEditMode = false;
let currentAction = null;

// Add Product Button
document.getElementById('addProductBtn').addEventListener('click', function() {
    isEditMode = false;
    document.getElementById('modalTitle').textContent = 'Tambah Service';
    document.getElementById('productForm').reset();
    document.getElementById('productId').value = '';
    document.getElementById('productModal').classList.add('show');
});

// Edit Product
function editProduct(productId) {
    isEditMode = true;
    document.getElementById('modalTitle').textContent = 'Edit Service';
    
    // Fetch product data
    fetch(`/merchant/products/${productId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('productId').value = data.data.id;
            document.getElementById('name').value = data.data.name;
            document.getElementById('description').value = data.data.description || '';
            document.getElementById('price').value = data.data.price;
            document.getElementById('status').value = data.data.status;
            document.getElementById('productModal').classList.add('show');
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorAlert('Terjadi kesalahan saat mengambil data service');
        });
}

// Close Modal
function closeModal() {
    document.getElementById('productModal').classList.remove('show');
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

// Product Form Submit
document.getElementById('productForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        name: document.getElementById('name').value,
        description: document.getElementById('description').value,
        price: document.getElementById('price').value,
        status: document.getElementById('status').value
    };

    const url = isEditMode 
        ? `/merchant/products/${document.getElementById('productId').value}`
        : '/merchant/products';
    
    const method = isEditMode ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            showSuccessAlert(data.message);
            closeModal();
            setTimeout(() => {
                location.reload();
            }, 1500);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorAlert('Terjadi kesalahan saat menyimpan service');
    });
});

// Toggle Product Status
function toggleProductStatus(productId) {
    showConfirmModal(
        'Ubah Status Service',
        'Apakah Anda yakin ingin mengubah status service ini?',
        function() {
            const newStatus = 'active';
            
            fetch(`/merchant/products/${productId}/status`, {
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
                showErrorAlert('Terjadi kesalahan saat mengubah status service');
            });
        }
    );
}

// Delete Product
function deleteProduct(productId) {
    showConfirmModal(
        'Hapus Service',
        'Apakah Anda yakin ingin menghapus service ini? Tindakan ini tidak dapat dibatalkan.',
        function() {
            fetch(`/merchant/products/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
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
                showErrorAlert('Terjadi kesalahan saat menghapus service');
            });
        }
    );
}
</script>
@endsection
