<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportlodek - Booking Lapangan Futsal</title>
    <meta name="description" content="Booking lapangan futsal online yang mudah dan praktis">

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
        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
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
        @include('layouts.landing.navbar')

        <!-- Search Bar -->
        <div class="px-4 py-3">
            <div class="relative">
                <input type="text"
                       placeholder="Cari lapangan futsal..."
                       class="w-full px-4 py-3 bg-white rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500"
                       autocomplete="off">
                <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"></i>
            </div>
        </div>

        <!-- Categories -->
        <div class="px-4 mb-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Kategori</h3>
            <div class="flex space-x-4 overflow-x-auto pb-2">
                <div class="category-item active flex-shrink-0">
                    <i class="fas fa-futbol text-xl mb-1"></i>
                    <span class="text-xs">Semua</span>
                </div>
                <div class="category-item flex-shrink-0">
                    <i class="fas fa-map-marker-alt text-xl mb-1 text-gray-600"></i>
                    <span class="text-xs text-gray-600">Padang</span>
                </div>
                <div class="category-item flex-shrink-0">
                    <i class="fas fa-star text-xl mb-1 text-gray-600"></i>
                    <span class="text-xs text-gray-600">Terpopuler</span>
                </div>
                <div class="category-item flex-shrink-0">
                    <i class="fas fa-clock text-xl mb-1 text-gray-600"></i>
                    <span class="text-xs text-gray-600">24 Jam</span>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="px-4 pb-20">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Lapangan Tersedia</h3>
            <div class="grid grid-cols-2 gap-3">
                @forelse($featuredMerchants as $merchant)
                <div class="product-card">
                    <div class="h-32 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                        <i class="fas fa-futbol text-4xl text-white/80"></i>
                    </div>
                    <div class="p-3">
                        <h4 class="font-semibold text-gray-900 text-sm mb-1">{{ Str::limit($merchant->name, 20) }}</h4>
                        <p class="text-gray-500 text-xs mb-2">{{ Str::limit($merchant->address, 30) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-green-600 text-sm">
                                {{ $merchant->products->count() }} Lapangan
                            </span>
                            <button onclick="showMerchantDetails({{ $merchant->id }})"
                                    class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center hover:bg-green-600 transition duration-200">
                                <i class="fas fa-plus text-white text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-2 text-center py-8">
                    <i class="fas fa-futbol text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Belum ada lapangan tersedia</p>
                </div>
                @endforelse
            </div>
        </div>

        @include('layouts.landing.footer')
    </div>

    <!-- Merchant Details Modal -->
    <div id="merchantModal" class="modal">
        <div class="modal-content">
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Detail Lapangan</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="p-4">
                <!-- Merchant Info -->
                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                    <h4 class="font-semibold text-gray-900 mb-2" id="merchantName"></h4>
                    <p class="text-sm text-gray-600 mb-1" id="merchantAddress"></p>
                    <p class="text-sm text-gray-600 mb-1" id="merchantPhone"></p>
                    <p class="text-sm text-gray-600">Jam Operasional: <span id="merchantHours"></span></p>
                </div>

                <!-- Products List -->
                <div id="productsList">
                    <!-- Products will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Booking Lapangan</h3>
                    <button onclick="closeBookingModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="p-4">
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-900 mb-2" id="bookingProductName"></h4>
                    <p class="text-sm text-gray-600 mb-3" id="bookingProductPrice"></p>
                </div>

                <!-- Time Slots -->
                <div class="mb-4">
                    <h5 class="font-medium text-gray-900 mb-3">Pilih Jam Booking</h5>
                    <div id="timeSlots" class="flex flex-wrap">
                        <!-- Time slots will be loaded here -->
                    </div>
                </div>

                <!-- Selected Time -->
                <div class="mb-4 p-3 bg-green-50 rounded-lg hidden" id="selectedTimeInfo">
                    <p class="text-sm text-green-800">
                        Jam terpilih: <span id="selectedTime"></span>
                    </p>
                </div>

                <!-- Booking Button -->
                <div class="flex space-x-3">
                    <button onclick="closeBookingModal()"
                            class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg font-medium">
                        Batal
                    </button>
                    <button onclick="proceedToBooking()"
                            class="flex-1 bg-green-500 text-white py-3 rounded-lg font-medium">
                        Lanjutkan Booking
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentMerchant = null;
        let selectedProduct = null;
        let selectedHour = null;

        // Show merchant details
        async function showMerchantDetails(merchantId) {
            try {
                const response = await fetch(`/merchant/${merchantId}/details`);
                const data = await response.json();

                currentMerchant = data.merchant;

                // Update modal title
                document.getElementById('modalTitle').textContent = data.merchant.name;
                document.getElementById('merchantName').textContent = data.merchant.name;
                document.getElementById('merchantAddress').textContent = data.merchant.address;
                document.getElementById('merchantPhone').textContent = data.merchant.phone;
                document.getElementById('merchantHours').textContent = data.merchant.operational_hours_text;

                // Load products
                const productsList = document.getElementById('productsList');
                productsList.innerHTML = '';

                data.products.forEach(product => {
                    const productCard = document.createElement('div');
                    productCard.className = 'mb-4 p-3 border border-gray-200 rounded-lg';
                    productCard.innerHTML = `
                        <div class="flex items-center justify-between mb-2">
                            <h5 class="font-semibold text-gray-900">${product.name}</h5>
                            <span class="text-green-600 font-bold">${product.formatted_price}/jam</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">
                            Jam tersedia: ${product.total_available_hours} dari ${product.total_operational_hours} jam operasional
                        </p>
                        <div class="flex space-x-2">
                            <button onclick="showBookingModal(${JSON.stringify(product).replace(/"/g, '&quot;')})"
                                    class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                Booking Sekarang
                            </button>
                            <button onclick="showAvailability(${JSON.stringify(product).replace(/"/g, '&quot;')})"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                Lihat Ketersediaan
                            </button>
                        </div>
                    `;
                    productsList.appendChild(productCard);
                });

                // Show modal
                document.getElementById('merchantModal').classList.add('show');
            } catch (error) {
                console.error('Error loading merchant details:', error);
                showErrorAlert('Gagal memuat detail lapangan');
            }
        }

        // Show booking modal
        function showBookingModal(product) {
            selectedProduct = product;
            document.getElementById('bookingProductName').textContent = product.name;
            document.getElementById('bookingProductPrice').textContent = product.formatted_price + '/jam';

            // Generate time slots based on operational hours
            const timeSlots = document.getElementById('timeSlots');
            timeSlots.innerHTML = '';

            // Only show time slots within operational hours
            for (let hour = 0; hour < 24; hour++) {
                const isOperational = product.operational_hours.includes(hour);
                const isBooked = product.booked_hours.includes(hour);
                const isAvailable = product.available_hours.includes(hour);

                if (isOperational) {
                    const slot = document.createElement('div');
                    slot.className = `hour-slot ${isBooked ? 'booked' : 'available'}`;
                    slot.textContent = `${hour.toString().padStart(2, '0')}:00`;

                    if (isAvailable) {
                        slot.onclick = () => selectTimeSlot(hour, slot);
                    }

                    timeSlots.appendChild(slot);
                }
            }

            document.getElementById('bookingModal').classList.add('show');
        }

        // Select time slot
        function selectTimeSlot(hour, element) {
            // Remove previous selection
            document.querySelectorAll('.hour-slot.selected').forEach(el => {
                el.classList.remove('selected');
            });

            // Add selection
            element.classList.add('selected');
            selectedHour = hour;

            // Show selected time info
            document.getElementById('selectedTime').textContent = `${hour.toString().padStart(2, '0')}:00`;
            document.getElementById('selectedTimeInfo').classList.remove('hidden');
        }

        // Show availability dengan modal custom
        function showAvailability(product) {
            const operationalHours = product.operational_hours.map(h => h + ':00').join(', ');
            const bookedHours = product.booked_hours.map(h => h + ':00').join(', ');
            const availableHours = product.available_hours.map(h => h + ':00').join(', ');

            // Buat modal availability
            const availabilityModal = document.createElement('div');
            availabilityModal.className = 'modal';
            availabilityModal.id = 'availabilityModal';
            availabilityModal.innerHTML = `
                <div class="modal-content">
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Ketersediaan ${product.name}</h3>
                            <button onclick="closeAvailabilityModal()" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <div class="p-4">
                        <!-- Jam Operasional -->
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-900 mb-2 flex items-center">
                                <i class="fas fa-clock text-green-500 mr-2"></i>
                                Jam Operasional
                            </h4>
                            <div class="bg-green-50 p-3 rounded-lg">
                                <p class="text-sm text-green-800">
                                    ${operationalHours}
                                </p>
                            </div>
                        </div>

                        <!-- Jam yang Sudah Dibooking -->
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-900 mb-2 flex items-center">
                                <i class="fas fa-calendar-times text-red-500 mr-2"></i>
                                Jam yang Sudah Dibooking
                            </h4>
                            <div class="bg-red-50 p-3 rounded-lg">
                                <p class="text-sm text-red-800">
                                    ${bookedHours || 'Tidak ada booking'}
                                </p>
                            </div>
                        </div>

                        <!-- Jam yang Tersedia -->
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-900 mb-2 flex items-center">
                                <i class="fas fa-calendar-check text-blue-500 mr-2"></i>
                                Jam yang Tersedia
                            </h4>
                            <div class="bg-blue-50 p-3 rounded-lg">
                                <p class="text-sm text-blue-800">
                                    ${availableHours}
                                </p>
                            </div>
                        </div>

                        <!-- Statistik -->
                        <div class="grid grid-cols-3 gap-3 mb-4">
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <div class="text-2xl font-bold text-gray-900">${product.total_operational_hours}</div>
                                <div class="text-xs text-gray-600">Total Jam</div>
                            </div>
                            <div class="text-center p-3 bg-red-50 rounded-lg">
                                <div class="text-2xl font-bold text-red-600">${product.booked_hours.length}</div>
                                <div class="text-xs text-red-600">Sudah Booking</div>
                            </div>
                            <div class="text-center p-3 bg-green-50 rounded-lg">
                                <div class="text-2xl font-bold text-green-600">${product.total_available_hours}</div>
                                <div class="text-xs text-green-600">Tersedia</div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-3">
                            <button onclick="closeAvailabilityModal()"
                                    class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg font-medium">
                                Tutup
                            </button>
                            <button onclick="closeAvailabilityModal(); showBookingModal(${JSON.stringify(product).replace(/"/g, '&quot;')})"
                                    class="flex-1 bg-green-500 text-white py-3 rounded-lg font-medium">
                                Booking Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            `;

            // Tambahkan ke body
            document.body.appendChild(availabilityModal);

            // Show modal
            setTimeout(() => {
                availabilityModal.classList.add('show');
            }, 10);
        }

        // Close availability modal
        function closeAvailabilityModal() {
            const modal = document.getElementById('availabilityModal');
            if (modal) {
                modal.classList.remove('show');
                setTimeout(() => {
                    modal.remove();
                }, 300);
            }
        }

        // Proceed to booking
        function proceedToBooking() {
            if (!selectedHour) {
                showErrorAlert('Pilih jam booking terlebih dahulu');
                return;
            }

            // Cek apakah user sudah login
            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

            if (!isLoggedIn) {
                // Jika belum login, tampilkan konfirmasi
                showConfirmAlert(
                    'Untuk melanjutkan booking, Anda perlu login terlebih dahulu. Lanjutkan?',
                    () => {
                        window.location.href = '{{ route("login") }}';
                    }
                );
                return;
            }

            // Jika sudah login, lanjutkan ke proses booking
            const bookingData = {
                merchant_id: currentMerchant.id,
                product_id: selectedProduct.id,
                start: selectedHour,
                quantity: 1
            };

            // Kirim data booking ke API dengan Bearer token
            fetch('/api/cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer {{ Auth::user() ? Auth::user()->createToken("web-token")->plainTextToken : "" }}'
                },
                body: JSON.stringify(bookingData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success || data.message) {
                    showSuccessAlert('Booking berhasil ditambahkan ke keranjang!');
                    closeBookingModal();
                } else {
                    showErrorAlert('Gagal menambahkan booking: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorAlert('Terjadi kesalahan saat booking. Silakan coba lagi.');
            });
        }

        // Close modals
        function closeModal() {
            document.getElementById('merchantModal').classList.remove('show');
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.remove('show');
            selectedProduct = null;
            selectedHour = null;
            document.getElementById('selectedTimeInfo').classList.add('hidden');
        }

        // Tambahkan variabel global untuk menyimpan data merchant
        let allMerchants = [];
        let filteredMerchants = [];

        // Load data merchant saat halaman dimuat
        async function loadMerchants() {
            try {
                const response = await fetch('/merchant/all');
                const data = await response.json();
                allMerchants = data.merchants;
                filteredMerchants = [...allMerchants];
                renderMerchants();
            } catch (error) {
                console.error('Error loading merchants:', error);
            }
        }

        // Render merchants ke UI
        function renderMerchants() {
            const productsSection = document.querySelector('.grid.grid-cols-2.gap-3');
            if (!productsSection) return;

            productsSection.innerHTML = '';

            if (filteredMerchants.length === 0) {
                productsSection.innerHTML = `
                    <div class="col-span-2 text-center py-8">
                        <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Tidak ada lapangan yang ditemukan</p>
                    </div>
                `;
                return;
            }

            filteredMerchants.forEach(merchant => {
                const merchantCard = document.createElement('div');
                merchantCard.className = 'product-card';
                merchantCard.innerHTML = `
                    <div class="h-32 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                        <i class="fas fa-futbol text-4xl text-white/80"></i>
                    </div>
                    <div class="p-3">
                        <h4 class="font-semibold text-gray-900 text-sm mb-1">${merchant.name}</h4>
                        <p class="text-gray-500 text-xs mb-2">${merchant.address}</p>
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-green-600 text-sm">
                                ${merchant.products_count} Lapangan
                            </span>
                            <button onclick="showMerchantDetails(${merchant.id})"
                                    class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center hover:bg-green-600 transition duration-200">
                                <i class="fas fa-plus text-white text-xs"></i>
                            </button>
                        </div>
                    </div>
                `;
                productsSection.appendChild(merchantCard);
            });
        }

        // Live search function
        function performSearch(searchTerm) {
            if (!searchTerm.trim()) {
                filteredMerchants = [...allMerchants];
            } else {
                const term = searchTerm.toLowerCase();
                filteredMerchants = allMerchants.filter(merchant =>
                    merchant.name.toLowerCase().includes(term) ||
                    merchant.address.toLowerCase().includes(term) ||
                    merchant.phone.toLowerCase().includes(term)
                );
            }

            renderMerchants();
            updateSearchResults();
        }

        // Update search results info
        function updateSearchResults() {
            const resultsInfo = document.getElementById('searchResultsInfo');
            if (resultsInfo) {
                if (filteredMerchants.length === allMerchants.length) {
                    resultsInfo.textContent = `Menampilkan semua lapangan (${allMerchants.length})`;
                } else {
                    resultsInfo.textContent = `Ditemukan ${filteredMerchants.length} dari ${allMerchants.length} lapangan`;
                }
            }
        }

        // Debounce function untuk search
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Initialize search functionality
        function initializeSearch() {
            const searchInput = document.querySelector('input[placeholder="Cari lapangan futsal..."]');
            if (searchInput) {
                // Add search results info
                const searchContainer = searchInput.closest('.px-4');
                const resultsInfo = document.createElement('div');
                resultsInfo.id = 'searchResultsInfo';
                resultsInfo.className = 'text-xs text-gray-500 mt-2 text-center';
                resultsInfo.textContent = 'Menampilkan semua lapangan';
                searchContainer.appendChild(resultsInfo);

                // Add live search with debounce
                const debouncedSearch = debounce(performSearch, 300);

                searchInput.addEventListener('input', (e) => {
                    debouncedSearch(e.target.value);
                });

                // Add clear search functionality
                searchInput.addEventListener('keyup', (e) => {
                    if (e.key === 'Escape') {
                        searchInput.value = '';
                        performSearch('');
                    }
                });

                // Add search icon click to focus
                const searchIcon = searchInput.parentElement.querySelector('.fas.fa-search');
                if (searchIcon) {
                    searchIcon.style.cursor = 'pointer';
                    searchIcon.addEventListener('click', () => {
                        searchInput.focus();
                    });
                }
            }
        }

        // Category filtering
        function filterByCategory(category) {
            const searchInput = document.querySelector('input[placeholder="Cari lapangan futsal..."]');
            const searchTerm = searchInput ? searchInput.value : '';

            let filtered = allMerchants;

            // Apply category filter
            switch(category) {
                case 'padang':
                    filtered = filtered.filter(merchant =>
                        merchant.address.toLowerCase().includes('padang')
                    );
                    break;
                case 'terpopuler':
                    filtered = filtered.filter(merchant =>
                        merchant.products_count >= 3 // Consider popular if has 3+ fields
                    );
                    break;
                case '24jam':
                    filtered = filtered.filter(merchant =>
                        merchant.open === 0 && merchant.close === 24
                    );
                    break;
                default: // 'semua'
                    // No additional filtering
                    break;
            }

            // Apply search term filter
            if (searchTerm.trim()) {
                const term = searchTerm.toLowerCase();
                filtered = filtered.filter(merchant =>
                    merchant.name.toLowerCase().includes(term) ||
                    merchant.address.toLowerCase().includes(term) ||
                    merchant.phone.toLowerCase().includes(term)
                );
            }

            filteredMerchants = filtered;
            renderMerchants();
            updateSearchResults();
        }

        // Update category switching
        document.querySelectorAll('.category-item').forEach(item => {
            item.addEventListener('click', () => {
                document.querySelectorAll('.category-item').forEach(i => i.classList.remove('active'));
                item.classList.add('active');

                // Get category from text content
                const categoryText = item.querySelector('span').textContent.toLowerCase();
                let category = 'semua';

                if (categoryText.includes('jakarta')) category = 'jakarta';
                else if (categoryText.includes('terpopuler')) category = 'terpopuler';
                else if (categoryText.includes('24 jam')) category = '24jam';

                filterByCategory(category);
            });
        });

        // Load merchants when page loads
        document.addEventListener('DOMContentLoaded', () => {
            loadMerchants();
            initializeSearch();
        });

        // Custom Alert Functions
        function showCustomAlert(options) {
            const {
                title = 'Pesan',
                message = '',
                type = 'success', // success, error, warning
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

            // Set icon
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

            // Set content
            titleEl.textContent = title;
            messageEl.textContent = message;
            confirmBtn.textContent = confirmText;

            // Show/hide cancel button
            if (cancelText) {
                cancelBtn.textContent = cancelText;
                cancelBtn.style.display = 'block';
            } else {
                cancelBtn.style.display = 'none';
            }

            // Set event listeners
            confirmBtn.onclick = () => {
                hideCustomAlert();
                if (onConfirm) onConfirm();
            };

            cancelBtn.onclick = () => {
                hideCustomAlert();
                if (onCancel) onCancel();
            };

            // Show alert
            alert.classList.add('show');
        }

        function hideCustomAlert() {
            document.getElementById('customAlert').classList.remove('show');
        }

        // Replace all alert() calls
        function showSuccessAlert(message) {
            showCustomAlert({
                title: 'Berhasil!',
                message: message,
                type: 'success'
            });
        }

        function showErrorAlert(message) {
            showCustomAlert({
                title: 'Terjadi Kesalahan',
                message: message,
                type: 'error'
            });
        }

        function showConfirmAlert(message, onConfirm, onCancel) {
            showCustomAlert({
                title: 'Konfirmasi',
                message: message,
                type: 'warning',
                confirmText: 'Ya',
                cancelText: 'Tidak',
                onConfirm: onConfirm,
                onCancel: onCancel
            });
        }
    </script>
</body>
</html>
