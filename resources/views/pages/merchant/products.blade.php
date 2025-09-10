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
                @if($product->sertifikasi)
                <button onclick="viewCertification('{{ $product->sertifikasi }}', '{{ $product->name }}')" class="text-blue-600 hover:text-blue-700 text-sm">
                    <i class="fas fa-certificate mr-1"></i>Sertifikasi
                </button>
                @endif
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

                <div class="mb-4">
                    <label for="sertifikasi" class="block text-sm font-medium text-gray-700 mb-2">File Sertifikasi</label>
                    <input type="file" id="sertifikasi" name="sertifikasi" accept=".jpg,.jpeg,.png,.pdf"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Format yang didukung: JPG, PNG, PDF (maksimal 5MB)</p>
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

<!-- Certification Modal -->
<div id="certificationModal" class="modal">
    <div class="modal-content">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 id="certificationTitle" class="text-lg font-semibold text-gray-900">Sertifikasi Layanan</h3>
                <button onclick="closeCertificationModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div id="certificationContent" class="text-center">
                <!-- Certification content will be loaded here -->
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <button onclick="closeCertificationModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    Tutup
                </button>
                <button id="downloadCertBtn" onclick="downloadCertification()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors" style="display: none;">
                    <i class="fas fa-download mr-1"></i>Download
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let isEditMode = false;
let currentAction = null;
let currentCertification = null;

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

    const formData = new FormData();
    formData.append('name', document.getElementById('name').value);
    formData.append('description', document.getElementById('description').value);
    formData.append('price', document.getElementById('price').value);
    formData.append('status', document.getElementById('status').value);

    // Add certification file if selected
    const certificationFile = document.getElementById('sertifikasi').files[0];
    if (certificationFile) {
        formData.append('sertifikasi', certificationFile);
    }

    const url = isEditMode
        ? `/merchant/products/${document.getElementById('productId').value}`
        : '/merchant/products';

    const method = isEditMode ? 'POST' : 'POST'; // Use POST for both with _method override

    if (isEditMode) {
        formData.append('_method', 'PUT');
    }

    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
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

// View certification
function viewCertification(certificationPath, serviceName) {
    currentCertification = certificationPath;

    // Update modal title
    document.getElementById('certificationTitle').textContent = `Sertifikasi: ${serviceName}`;

    // Get file extension
    const fileExtension = certificationPath.split('.').pop().toLowerCase();
    const certificationContent = document.getElementById('certificationContent');
    const downloadBtn = document.getElementById('downloadCertBtn');

    if (fileExtension === 'pdf') {
        // Show PDF viewer
        certificationContent.innerHTML = `
            <div class="bg-gray-100 rounded-lg p-4 mb-4">
                <iframe src="/storage/${certificationPath}"
                        width="100%"
                        height="400"
                        style="border: none; border-radius: 8px;">
                </iframe>
            </div>
            <p class="text-sm text-gray-600">Dokumen PDF - Klik download untuk menyimpan</p>
        `;
        downloadBtn.style.display = 'inline-block';
    } else if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
        // Show image viewer
        certificationContent.innerHTML = `
            <div class="bg-gray-100 rounded-lg p-4 mb-4">
                <img src="/storage/${certificationPath}"
                     alt="Sertifikasi"
                     class="max-w-full h-auto rounded-lg shadow-sm mx-auto"
                     style="max-height: 400px;">
            </div>
            <p class="text-sm text-gray-600">Dokumen Gambar - Klik download untuk menyimpan</p>
        `;
        downloadBtn.style.display = 'inline-block';
    } else {
        // Unsupported format
        certificationContent.innerHTML = `
            <div class="text-center py-8">
                <i class="fas fa-file text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Format file tidak didukung untuk preview</p>
                <p class="text-sm text-gray-400 mt-2">Klik download untuk melihat file</p>
            </div>
        `;
        downloadBtn.style.display = 'inline-block';
    }

    // Show modal
    document.getElementById('certificationModal').classList.add('show');
}

// Close certification modal
function closeCertificationModal() {
    document.getElementById('certificationModal').classList.remove('show');
    currentCertification = null;
}

// Download certification
function downloadCertification() {
    if (currentCertification) {
        const link = document.createElement('a');
        link.href = `/storage/${currentCertification}`;
        link.download = currentCertification.split('/').pop();
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}
</script>
@endsection
