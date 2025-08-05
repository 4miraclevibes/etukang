<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Lapangan - Sportlodek</title>
    <meta name="description" content="Kelola lapangan futsal merchant">

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
        .product-card {
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
        @include('layouts.merchant.navbar', ['headerTitle' => 'Kelola Lapangan'])

        <!-- Content -->
        <div class="px-4 py-6 pb-20">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Lapangan Saya</h2>
                    <p class="text-sm text-gray-500">Kelola lapangan futsal Anda</p>
                </div>
                <button onclick="showAddProductModal()"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah
                </button>
            </div>

            <!-- Products List -->
            @if($products->count() > 0)
                <div class="space-y-4">
                    @foreach($products as $product)
                    <div class="product-card">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-futbol text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-500">Lapangan {{ $loop->iteration }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">per jam</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <div class="flex space-x-2">
                                <button onclick="editProduct({{ $product->id }})"
                                        class="text-blue-600 text-sm font-medium">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </button>
                                <button onclick="deleteProduct({{ $product->id }})"
                                        class="text-red-600 text-sm font-medium">
                                    <i class="fas fa-trash mr-1"></i>
                                    Hapus
                                </button>
                            </div>
                            <div class="flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                <span class="text-xs text-gray-500">Aktif</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-futbol text-4xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Lapangan</h3>
                    <p class="text-gray-500 mb-6">Mulai dengan menambahkan lapangan pertama Anda</p>
                    <button onclick="showAddProductModal()"
                            class="bg-green-500 text-white px-6 py-3 rounded-lg font-medium">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Lapangan Pertama
                    </button>
                </div>
            @endif
        </div>

        @include('layouts.merchant.footer')
    </div>

    <!-- Modal Tambah/Edit Lapangan -->
    <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg w-full max-w-md">
                <div class="p-6">
                    <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 mb-4">Tambah Lapangan</h3>
                    
                    <form id="productForm">
                        <input type="hidden" id="productId" name="product_id">
                        
                        <div class="mb-4">
                            <label for="productName" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lapangan
                            </label>
                            <input type="text" id="productName" name="name" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        
                        <div class="mb-6">
                            <label for="productPrice" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga per Jam
                            </label>
                            <input type="number" id="productPrice" name="price" required min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="150000">
                        </div>
                        
                        <div class="flex space-x-3">
                            <button type="button" onclick="closeProductModal()"
                                    class="flex-1 px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                Batal
                            </button>
                            <button type="submit"
                                    class="flex-1 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentProductId = null;

        function showAddProductModal() {
            currentProductId = null;
            document.getElementById('modalTitle').textContent = 'Tambah Lapangan';
            document.getElementById('productForm').reset();
            document.getElementById('productId').value = '';
            document.getElementById('productModal').classList.remove('hidden');
        }

        function editProduct(productId) {
            currentProductId = productId;
            document.getElementById('modalTitle').textContent = 'Edit Lapangan';
            
            // Fetch product data
            fetch(`/merchant/products/${productId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.data) {
                    document.getElementById('productId').value = data.data.id;
                    document.getElementById('productName').value = data.data.name;
                    document.getElementById('productPrice').value = data.data.price;
                    document.getElementById('productModal').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomAlert({
                    title: 'Error',
                    message: 'Gagal mengambil data lapangan',
                    type: 'error'
                });
            });
        }

        function closeProductModal() {
            document.getElementById('productModal').classList.add('hidden');
            document.getElementById('productForm').reset();
        }

        function deleteProduct(productId) {
            showCustomAlert({
                title: 'Hapus Lapangan',
                message: 'Apakah Anda yakin ingin menghapus lapangan ini?',
                type: 'warning',
                confirmText: 'Ya, Hapus',
                cancelText: 'Batal',
                onConfirm: () => {
                    fetch(`/merchant/products/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        showCustomAlert({
                            title: 'Berhasil',
                            message: data.message || 'Lapangan berhasil dihapus',
                            type: 'success'
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showCustomAlert({
                            title: 'Error',
                            message: 'Gagal menghapus lapangan',
                            type: 'error'
                        });
                    });
                }
            });
        }

        // Handle form submission
        document.getElementById('productForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = {
                name: formData.get('name'),
                price: parseInt(formData.get('price'))
            };

            const url = currentProductId 
                ? `/merchant/products/${currentProductId}`
                : '/merchant/products';
            
            const method = currentProductId ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    showCustomAlert({
                        title: 'Berhasil',
                        message: data.message,
                        type: 'success'
                    });
                    closeProductModal();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    throw new Error('Response tidak valid');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomAlert({
                    title: 'Error',
                    message: 'Gagal menyimpan lapangan',
                    type: 'error'
                });
            });
        });

        // Close modal when clicking outside
        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeProductModal();
            }
        });

        // Custom Alert Function
        function showCustomAlert(options) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'custom-alert';
            alertDiv.innerHTML = `
                <div class="alert-content">
                    <div class="alert-header">
                        <div class="alert-icon ${options.type || 'info'}">
                            ${options.type === 'success' ? '<i class="fas fa-check"></i>' : 
                              options.type === 'error' ? '<i class="fas fa-times"></i>' :
                              options.type === 'warning' ? '<i class="fas fa-exclamation-triangle"></i>' :
                              '<i class="fas fa-info"></i>'}
                        </div>
                        <div class="alert-title">${options.title}</div>
                        <div class="alert-message">${options.message}</div>
                    </div>
                    <div class="alert-buttons">
                        ${options.cancelText ? `<button class="alert-button secondary" onclick="closeCustomAlert()">${options.cancelText}</button>` : ''}
                        <button class="alert-button primary" onclick="handleCustomAlertConfirm()">${options.confirmText || 'OK'}</button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(alertDiv);
            setTimeout(() => alertDiv.classList.add('show'), 10);
            
            // Store callback
            window.customAlertCallback = options.onConfirm;
        }

        function closeCustomAlert() {
            const alert = document.querySelector('.custom-alert');
            if (alert) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 300);
            }
        }

        function handleCustomAlertConfirm() {
            if (window.customAlertCallback) {
                window.customAlertCallback();
            }
            closeCustomAlert();
        }
    </script>
</body>
</html>
