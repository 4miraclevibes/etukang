@extends('layouts.landing.app')

@section('title', 'Beranda - Etukang')

@section('content')
    <!-- Search Bar -->
    <div class="px-4 py-3">
        <div class="relative">
            <input type="text"
                   placeholder="Cari teknisi atau layanan..."
                   class="w-full px-4 py-3 bg-white rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500"
                   autocomplete="off">
            <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"></i>
        </div>
    </div>

    <!-- Categories -->
    <div class="px-4 mb-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Kategori Layanan</h3>
        <div class="flex space-x-4 overflow-x-auto pb-2">
            <div class="category-item active flex-shrink-0" onclick="filterByCategory('all')">
                <i class="fas fa-tools text-xl mb-1"></i>
                <span class="text-xs">Semua</span>
            </div>
            <div class="category-item flex-shrink-0" onclick="filterByCategory('listrik')">
                <i class="fas fa-bolt text-xl mb-1 text-gray-600"></i>
                <span class="text-xs text-gray-600">Listrik</span>
            </div>
            <div class="category-item flex-shrink-0" onclick="filterByCategory('plumbing')">
                <i class="fas fa-wrench text-xl mb-1 text-gray-600"></i>
                <span class="text-xs text-gray-600">Plumbing</span>
            </div>
            <div class="category-item flex-shrink-0" onclick="filterByCategory('ac')">
                <i class="fas fa-snowflake text-xl mb-1 text-gray-600"></i>
                <span class="text-xs text-gray-600">AC Service</span>
            </div>
            <div class="category-item flex-shrink-0" onclick="filterByCategory('cleaning')">
                <i class="fas fa-broom text-xl mb-1 text-gray-600"></i>
                <span class="text-xs text-gray-600">Cleaning</span>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="px-4 mb-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Statistik Layanan</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center p-3 bg-white rounded-lg shadow-sm">
                <div class="text-2xl font-bold text-green-500">{{ $stats['total_technicians'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">Teknisi Aktif</div>
            </div>
            <div class="text-center p-3 bg-white rounded-lg shadow-sm">
                <div class="text-2xl font-bold text-green-500">{{ $stats['total_services'] ?? 1500 }}</div>
                <div class="text-sm text-gray-600">Layanan Tersedia</div>
            </div>
            <div class="text-center p-3 bg-white rounded-lg shadow-sm">
                <div class="text-2xl font-bold text-green-500">{{ number_format($stats['total_customers'] ?? 5000) }}</div>
                <div class="text-sm text-gray-600">Pelanggan Puas</div>
            </div>
            <div class="text-center p-3 bg-white rounded-lg shadow-sm">
                <div class="text-2xl font-bold text-green-500">{{ $stats['satisfaction_rate'] ?? 98 }}%</div>
                <div class="text-sm text-gray-600">Kepuasan</div>
            </div>
        </div>
    </div>

    <!-- Technicians Section -->
    <div class="px-4 pb-20">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Teknisi Tersedia</h3>
        <div class="grid grid-cols-2 gap-3">
            @forelse($featuredMerchants as $merchant)
            <div class="product-card">
                <div class="h-32 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                    <i class="fas fa-user-cog text-4xl text-white/80"></i>
                </div>
                <div class="p-3">
                    <h4 class="font-semibold text-gray-900 text-sm mb-1">{{ Str::limit($merchant->name, 20) }}</h4>
                    <p class="text-gray-500 text-xs mb-2">{{ Str::limit($merchant->address, 30) }}</p>
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-green-600 text-sm">
                            {{ $merchant->products->count() }} Layanan
                        </span>
                        <button onclick="showTechnicianDetails({{ $merchant->id }})"
                                class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center hover:bg-green-600 transition duration-200">
                            <i class="fas fa-plus text-white text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-2 text-center py-8">
                <i class="fas fa-user-cog text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Belum ada teknisi tersedia</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection

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

<!-- Technician Details Modal -->
<div id="technicianModal" class="custom-alert">
    <div class="alert-content" style="width: 95%; max-width: 450px; max-height: 80vh; overflow-y: auto;">
        <div class="alert-header">
            <div class="alert-icon warning">
                <i class="fas fa-user-cog"></i>
            </div>
            <div id="technicianName" class="alert-title">Detail Teknisi</div>
            <div id="technicianAddress" class="alert-message">Alamat teknisi</div>
        </div>

        <div id="technicianServices" class="p-4">
            <!-- Services will be loaded here -->
        </div>

        <div class="alert-buttons">
            <button onclick="closeTechnicianModal()" class="alert-button secondary">Tutup</button>
        </div>
    </div>
</div>

<!-- Order Modal -->
<div id="orderModal" class="custom-alert">
    <div class="alert-content" style="width: 95%; max-width: 450px;">
        <div class="alert-header">
            <div class="alert-icon warning">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div id="orderTitle" class="alert-title">Pesan Layanan</div>
            <div id="orderMessage" class="alert-message">Pilih layanan dan jumlah quantity</div>
        </div>

        <form id="orderForm" class="p-4 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Layanan</label>
                <select id="serviceSelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">Pilih layanan...</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Quantity</label>
                <div class="flex items-center space-x-2">
                    <button type="button" onclick="decreaseQuantity()" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-minus text-xs"></i>
                    </button>
                    <input type="number" id="quantityInput" value="1" min="1" max="10"
                           class="w-16 text-center px-2 py-1 border border-gray-300 rounded">
                    <button type="button" onclick="increaseQuantity()" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-plus text-xs"></i>
                    </button>
                </div>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Harga:</span>
                    <span id="totalPrice" class="font-bold text-green-600">Rp 0</span>
                </div>
            </div>
        </form>

        <div class="alert-buttons">
            <button onclick="closeOrderModal()" class="alert-button secondary">Batal</button>
            <button onclick="addToCart()" class="alert-button primary">Tambah ke Keranjang</button>
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
    .category-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 12px 8px;
        border-radius: 12px;
        transition: all 0.2s;
        cursor: pointer;
    }
    .category-item.active {
        background: #10B981;
        color: white;
    }
    .category-item.active i,
    .category-item.active span {
        color: white;
    }
</style>

<script>
    let currentTechnician = null;
    let selectedService = null;
    let selectedQuantity = 1;
    let currentPrice = 0;

    // Filter by category
    function filterByCategory(category) {
        // Remove active class from all categories
        document.querySelectorAll('.category-item').forEach(item => {
            item.classList.remove('active');
            item.querySelector('i').classList.remove('text-white');
            item.querySelector('span').classList.remove('text-white');
            item.querySelector('i').classList.add('text-gray-600');
            item.querySelector('span').classList.add('text-gray-600');
        });

        // Add active class to selected category
        event.currentTarget.classList.add('active');
        event.currentTarget.querySelector('i').classList.add('text-white');
        event.currentTarget.querySelector('i').classList.remove('text-gray-600');
        event.currentTarget.querySelector('span').classList.add('text-white');
        event.currentTarget.querySelector('span').classList.remove('text-gray-600');

        // TODO: Implement filtering logic
        showCustomAlert({
            title: 'Filter Kategori',
            message: `Menampilkan layanan kategori: ${category}`,
            type: 'info'
        });
    }

    // Show technician details
    async function showTechnicianDetails(technicianId) {
        try {
            // Gunakan endpoint yang benar sesuai dengan API routes
            const response = await fetch(`/api/merchants/${technicianId}`, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer {{ Auth::user() ? Auth::user()->createToken("web-token")->plainTextToken : "" }}'
                }
            });

            if (!response.ok) {
                // Jika response tidak OK, coba ambil data dari controller Landing
                const fallbackResponse = await fetch(`/merchant/${technicianId}/details`);
                if (!fallbackResponse.ok) {
                    throw new Error('Failed to fetch technician details');
                }
                const fallbackData = await fallbackResponse.json();
                currentTechnician = fallbackData.merchant;
            } else {
                const data = await response.json();
                currentTechnician = data.merchant;
            }

            // Update modal content
            document.getElementById('technicianName').textContent = currentTechnician.name;
            document.getElementById('technicianAddress').textContent = currentTechnician.address;

            // Load services
            const servicesContainer = document.getElementById('technicianServices');
            servicesContainer.innerHTML = '';

            if (currentTechnician.products && currentTechnician.products.length > 0) {
                currentTechnician.products.forEach(product => {
                    const serviceDiv = document.createElement('div');
                    serviceDiv.className = 'bg-gray-50 rounded-lg p-3 mb-3';
                    serviceDiv.innerHTML = `
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-gray-900">${product.name}</h4>
                                <p class="text-sm text-gray-500">${product.description || 'Layanan teknisi'}</p>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-green-600">Rp ${numberFormat(product.price)}</div>
                                <button onclick="orderService(${product.id}, '${product.name}', ${product.price})"
                                        class="mt-2 bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                                    Pesan
                                </button>
                            </div>
                        </div>
                    `;
                    servicesContainer.appendChild(serviceDiv);
                });
            } else {
                servicesContainer.innerHTML = '<p class="text-gray-500 text-center">Belum ada layanan tersedia</p>';
            }

            document.getElementById('technicianModal').classList.add('show');
        } catch (error) {
            console.error('Error loading technician details:', error);

            // Tampilkan error yang lebih spesifik
            let errorMessage = 'Gagal memuat detail teknisi';
            if (error.message.includes('401')) {
                errorMessage = 'Silakan login terlebih dahulu';
            } else if (error.message.includes('404')) {
                errorMessage = 'Teknisi tidak ditemukan';
            } else if (error.message.includes('500')) {
                errorMessage = 'Server error, silakan coba lagi';
            }

            showCustomAlert({
                title: 'Error',
                message: errorMessage,
                type: 'error'
            });
        }
    }

    // Order service
    function orderService(productId, productName, price) {
        selectedService = { id: productId, name: productName, price: price };
        currentPrice = price;
        selectedQuantity = 1;

        // Update modal content
        document.getElementById('orderTitle').textContent = `Pesan: ${productName}`;
        document.getElementById('orderMessage').textContent = 'Pilih jumlah quantity layanan';

        // Update service select
        const serviceSelect = document.getElementById('serviceSelect');
        serviceSelect.innerHTML = `<option value="${productId}" selected>${productName}</option>`;

        // Update total price
        updateTotalPrice();

        // Close technician modal and open order modal
        document.getElementById('technicianModal').classList.remove('show');
        document.getElementById('orderModal').classList.add('show');
    }

    // Close modals
    function closeTechnicianModal() {
        document.getElementById('technicianModal').classList.remove('show');
    }

    function closeOrderModal() {
        document.getElementById('orderModal').classList.remove('show');
        selectedService = null;
        selectedQuantity = 1;
    }

    // Quantity control
    function increaseQuantity() {
        const quantityInput = document.getElementById('quantityInput');
        const currentValue = parseInt(quantityInput.value);
        if (currentValue < 10) {
            quantityInput.value = currentValue + 1;
            selectedQuantity = currentValue + 1;
            updateTotalPrice();
        }
    }

    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantityInput');
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            selectedQuantity = currentValue - 1;
            updateTotalPrice();
        }
    }

    // Update total price
    function updateTotalPrice() {
        const total = currentPrice * selectedQuantity;
        document.getElementById('totalPrice').textContent = `Rp ${numberFormat(total)}`;
    }

    // Add to cart
    async function addToCart() {
        if (!selectedService) {
            showCustomAlert({
                title: 'Error',
                message: 'Silakan pilih layanan terlebih dahulu',
                type: 'error'
            });
            return;
        }

        try {
            const response = await fetch('/api/carts', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer {{ Auth::user() ? Auth::user()->createToken("web-token")->plainTextToken : "" }}'
                },
                body: JSON.stringify({
                    merchant_id: currentTechnician.id,
                    product_id: selectedService.id,
                    quantity: selectedQuantity,
                    price: selectedService.price * selectedQuantity,
                    price_per_hour: selectedService.price
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                closeOrderModal();
                showCustomAlert({
                    title: 'Berhasil',
                    message: 'Layanan berhasil ditambahkan ke keranjang',
                    type: 'success',
                    onConfirm: () => {
                        window.location.href = '{{ route("cart") }}';
                    }
                });
            } else {
                throw new Error(data.message || 'Gagal menambahkan ke keranjang');
            }
        } catch (error) {
            console.error('Error adding to cart:', error);
            showCustomAlert({
                title: 'Error',
                message: error.message || 'Gagal menambahkan ke keranjang',
                type: 'error'
            });
        }
    }

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

    // Utility function
    function numberFormat(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    // Event listeners
    document.getElementById('quantityInput').addEventListener('input', function() {
        selectedQuantity = parseInt(this.value) || 1;
        updateTotalPrice();
    });
</script>
