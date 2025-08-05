<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Sportlodek</title>
    <meta name="description" content="Profile pengguna Sportlodek">

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
        .profile-header {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
            padding: 24px 20px;
            text-align: center;
        }
        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 32px;
        }
        .menu-item {
            background: white;
            border-radius: 12px;
            margin-bottom: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .menu-link {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            color: #374151;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .menu-link:hover {
            background: #f9fafb;
        }
        .menu-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
            font-size: 18px;
        }
        .menu-content {
            flex: 1;
        }
        .menu-title {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 2px;
        }
        .menu-subtitle {
            font-size: 14px;
            color: #6b7280;
        }
        .menu-arrow {
            color: #9ca3af;
            font-size: 14px;
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
        .modal {
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
        .modal.show {
            display: flex;
        }
        .modal-content {
            background: white;
            border-radius: 16px;
            max-width: 90%;
            width: 360px;
            margin: 20px;
            max-height: 80vh;
            overflow-y: auto;
        }
        .modal-header {
            padding: 20px 20px 0 20px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 16px;
        }
        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
        }
        .modal-body {
            padding: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: #10B981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        .form-input[rows] {
            resize: vertical;
            min-height: 80px;
        }
        .modal-footer {
            padding: 16px 20px 20px 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 12px;
        }
        .btn {
            flex: 1;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }
        .btn-primary {
            background: #10B981;
            color: white;
        }
        .btn-primary:hover {
            background: #059669;
        }
        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }
        .btn-secondary:hover {
            background: #e5e7eb;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="mobile-container">
        @include('layouts.landing.navbar')

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <h1 class="text-xl font-semibold mb-2">{{ Auth::user()->name }}</h1>
            <p class="text-sm opacity-90">{{ Auth::user()->email }}</p>
        </div>

        <!-- Profile Menu -->
        <div class="px-4 py-6 pb-20">
            <!-- Account Settings -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Akun</h2>

                <div class="menu-item">
                    <a href="#" onclick="openEditProfile()" class="menu-link">
                        <div class="menu-icon bg-blue-100 text-blue-600">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="menu-content">
                            <div class="menu-title">Edit Profile</div>
                            <div class="menu-subtitle">Ubah nama dan email</div>
                        </div>
                        <div class="menu-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="#" onclick="openChangePassword()" class="menu-link">
                        <div class="menu-icon bg-yellow-100 text-yellow-600">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="menu-content">
                            <div class="menu-title">Ubah Password</div>
                            <div class="menu-subtitle">Ganti password akun</div>
                        </div>
                        <div class="menu-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Booking History -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Booking</h2>

                <div class="menu-item">
                    <a href="#" onclick="openBookingHistory()" class="menu-link">
                        <div class="menu-icon bg-green-100 text-green-600">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="menu-content">
                            <div class="menu-title">Riwayat Booking</div>
                            <div class="menu-subtitle">Lihat semua booking Anda</div>
                        </div>
                        <div class="menu-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="#" onclick="openPaymentHistory()" class="menu-link">
                        <div class="menu-icon bg-purple-100 text-purple-600">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="menu-content">
                            <div class="menu-title">Riwayat Pembayaran</div>
                            <div class="menu-subtitle">Lihat semua transaksi pembayaran</div>
                        </div>
                        <div class="menu-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                </div>
            </div>

            <!-- App Settings -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Aplikasi</h2>

                <div class="menu-item">
                    <a href="#" onclick="openNotifications()" class="menu-link">
                        <div class="menu-icon bg-red-100 text-red-600">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="menu-content">
                            <div class="menu-title">Notifikasi</div>
                            <div class="menu-subtitle">Atur notifikasi aplikasi</div>
                        </div>
                        <div class="menu-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="#" onclick="openPrivacy()" class="menu-link">
                        <div class="menu-icon bg-gray-100 text-gray-600">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="menu-content">
                            <div class="menu-title">Privasi & Keamanan</div>
                            <div class="menu-subtitle">Pengaturan privasi dan keamanan</div>
                        </div>
                        <div class="menu-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Merchant Registration -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Daftar Merchant</h2>

                @if(Auth::user()->merchant)
                    <div class="menu-item">
                        <a href="/merchant/dashboard" class="menu-link">
                            <div class="menu-icon bg-green-100 text-green-600">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="menu-content">
                                <div class="menu-title">Dashboard Merchant</div>
                                <div class="menu-subtitle">Kelola {{ Auth::user()->merchant->name }}</div>
                            </div>
                            <div class="menu-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                    </div>
                @else
                    <div class="menu-item">
                        <a href="#" onclick="openMerchantRegistration()" class="menu-link">
                            <div class="menu-icon bg-orange-100 text-orange-600">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="menu-content">
                                <div class="menu-title">Daftar Sebagai Merchant</div>
                                <div class="menu-subtitle">Kelola lapangan futsal Anda</div>
                            </div>
                            <div class="menu-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Account Actions -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Akun</h2>

                <div class="menu-item">
                    <a href="#" onclick="openLogout()" class="menu-link">
                        <div class="menu-icon bg-red-100 text-red-600">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <div class="menu-content">
                            <div class="menu-title">Keluar</div>
                            <div class="menu-subtitle">Logout dari aplikasi</div>
                        </div>
                        <div class="menu-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        @include('layouts.landing.footer')
    </div>

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

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Profile</h3>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" id="editName" name="name" class="form-input" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" id="editEmail" name="email" class="form-input" value="{{ Auth::user()->email }}" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeEditProfile()" class="btn btn-secondary">Batal</button>
                <button type="button" onclick="saveProfile()" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ubah Password</h3>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    <div class="form-group">
                        <label class="form-label">Password Saat Ini</label>
                        <input type="password" id="currentPassword" name="current_password" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <input type="password" id="newPassword" name="password" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" id="confirmPassword" name="password_confirmation" class="form-input" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeChangePassword()" class="btn btn-secondary">Batal</button>
                <button type="button" onclick="savePassword()" class="btn btn-primary">Ubah Password</button>
            </div>
        </div>
    </div>

    <!-- Merchant Registration Modal -->
    <div id="merchantRegistrationModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Daftar Sebagai Merchant</h3>
            </div>
            <div class="modal-body">
                <form id="merchantRegistrationForm">
                    <div class="form-group">
                        <label class="form-label">Nama Lapangan</label>
                        <input type="text" id="merchantName" name="name" class="form-input" placeholder="Contoh: Futsal Center Jakarta" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <textarea id="merchantAddress" name="address" class="form-input" rows="3" placeholder="Alamat lengkap lapangan" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" id="merchantPhone" name="phone" class="form-input" placeholder="Contoh: 021-1234567" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam Buka</label>
                        <select id="merchantOpen" name="open" class="form-input" required>
                            <option value="">Pilih jam buka</option>
                            @for($i = 0; $i <= 24; $i++)
                                <option value="{{ $i }}">{{ sprintf('%02d:00', $i) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam Tutup</label>
                        <select id="merchantClose" name="close" class="form-input" required>
                            <option value="">Pilih jam tutup</option>
                            @for($i = 0; $i <= 24; $i++)
                                <option value="{{ $i }}">{{ sprintf('%02d:00', $i) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select id="merchantStatus" name="status" class="form-input" required>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeMerchantRegistration()" class="btn btn-secondary">Batal</button>
                <button type="button" onclick="saveMerchantRegistration()" class="btn btn-primary">Daftar Merchant</button>
            </div>
        </div>
    </div>

    <!-- Merchant Registration Modal -->
    <div id="merchantRegistrationModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Daftar Sebagai Merchant</h3>
            </div>
            <div class="modal-body">
                <form id="merchantRegistrationForm">
                    <div class="form-group">
                        <label class="form-label">Nama Tempat</label>
                        <input type="text" id="merchantName" name="name" class="form-input" placeholder="Contoh: Futsal Center Jakarta" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <textarea id="merchantAddress" name="address" class="form-input" rows="3" placeholder="Alamat lengkap tempat futsal" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="tel" id="merchantPhone" name="phone" class="form-input" placeholder="Contoh: 021-1234567" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam Buka</label>
                        <select id="merchantOpen" name="open" class="form-input" required>
                            <option value="">Pilih jam buka</option>
                            <option value="6">06:00</option>
                            <option value="7">07:00</option>
                            <option value="8">08:00</option>
                            <option value="9">09:00</option>
                            <option value="10">10:00</option>
                            <option value="11">11:00</option>
                            <option value="12">12:00</option>
                            <option value="13">13:00</option>
                            <option value="14">14:00</option>
                            <option value="15">15:00</option>
                            <option value="16">16:00</option>
                            <option value="17">17:00</option>
                            <option value="18">18:00</option>
                            <option value="19">19:00</option>
                            <option value="20">20:00</option>
                            <option value="21">21:00</option>
                            <option value="22">22:00</option>
                            <option value="23">23:00</option>
                            <option value="24">24:00</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam Tutup</label>
                        <select id="merchantClose" name="close" class="form-input" required>
                            <option value="">Pilih jam tutup</option>
                            <option value="6">06:00</option>
                            <option value="7">07:00</option>
                            <option value="8">08:00</option>
                            <option value="9">09:00</option>
                            <option value="10">10:00</option>
                            <option value="11">11:00</option>
                            <option value="12">12:00</option>
                            <option value="13">13:00</option>
                            <option value="14">14:00</option>
                            <option value="15">15:00</option>
                            <option value="16">16:00</option>
                            <option value="17">17:00</option>
                            <option value="18">18:00</option>
                            <option value="19">19:00</option>
                            <option value="20">20:00</option>
                            <option value="21">21:00</option>
                            <option value="22">22:00</option>
                            <option value="23">23:00</option>
                            <option value="24">24:00</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select id="merchantStatus" name="status" class="form-input" required>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeMerchantRegistration()" class="btn btn-secondary">Batal</button>
                <button type="button" onclick="saveMerchantRegistration()" class="btn btn-primary">Daftar Merchant</button>
            </div>
        </div>
    </div>

    <script>
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

        // Modal Functions
        function openEditProfile() {
            document.getElementById('editProfileModal').classList.add('show');
        }

        function closeEditProfile() {
            document.getElementById('editProfileModal').classList.remove('show');
        }

        function openChangePassword() {
            document.getElementById('changePasswordModal').classList.add('show');
        }

        function closeChangePassword() {
            document.getElementById('changePasswordModal').classList.remove('show');
        }

        // Merchant Registration Functions
        function openMerchantRegistration() {
            // Cek apakah user sudah memiliki merchant
            @if(Auth::user()->merchant)
                showCustomAlert({
                    title: 'Info',
                    message: 'Anda sudah terdaftar sebagai merchant',
                    type: 'info'
                });
                return;
            @endif

            document.getElementById('merchantRegistrationModal').classList.add('show');
        }

        function closeMerchantRegistration() {
            document.getElementById('merchantRegistrationModal').classList.remove('show');
            document.getElementById('merchantRegistrationForm').reset();
        }

        function saveMerchantRegistration() {
            const name = document.getElementById('merchantName').value;
            const address = document.getElementById('merchantAddress').value;
            const phone = document.getElementById('merchantPhone').value;
            const open = document.getElementById('merchantOpen').value;
            const close = document.getElementById('merchantClose').value;
            const status = document.getElementById('merchantStatus').value;

            if (!name || !address || !phone || !open || !close || !status) {
                showCustomAlert({
                    title: 'Error',
                    message: 'Semua field harus diisi',
                    type: 'error'
                });
                return;
            }

            if (parseInt(close) <= parseInt(open)) {
                showCustomAlert({
                    title: 'Error',
                    message: 'Jam tutup harus lebih besar dari jam buka',
                    type: 'error'
                });
                return;
            }

            // Validasi jam operasional minimal 1 jam
            if (parseInt(close) - parseInt(open) < 1) {
                showCustomAlert({
                    title: 'Error',
                    message: 'Minimal jam operasional adalah 1 jam',
                    type: 'error'
                });
                return;
            }

            fetch('/merchant/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name: name,
                    address: address,
                    phone: phone,
                    open: parseInt(open),
                    close: parseInt(close),
                    status: status
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                showCustomAlert({
                    title: 'Berhasil!',
                    message: data.message || 'Merchant berhasil didaftarkan',
                    type: 'success',
                    onConfirm: () => {
                        closeMerchantRegistration();
                        // Redirect ke merchant dashboard jika berhasil
                        window.location.href = '/merchant/dashboard';
                    }
                });
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomAlert({
                    title: 'Error',
                    message: 'Terjadi kesalahan saat mendaftar merchant',
                    type: 'error'
                });
            });
        }

        // Profile Functions
        function saveProfile() {
            const name = document.getElementById('editName').value;
            const email = document.getElementById('editEmail').value;

            if (!name || !email) {
                showCustomAlert({
                    title: 'Error',
                    message: 'Semua field harus diisi',
                    type: 'error'
                });
                return;
            }

            fetch('/api/profile-update', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer {{ Auth::user() ? Auth::user()->createToken("web-token")->plainTextToken : "" }}'
                },
                body: JSON.stringify({ name, email })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Simpan pesan success ke session storage
                    sessionStorage.setItem('profileMessage', 'Profile berhasil diperbarui');
                    sessionStorage.setItem('profileMessageType', 'success');
                    location.reload();
                } else {
                    showCustomAlert({
                        title: 'Error',
                        message: data.message || 'Gagal memperbarui profile',
                        type: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomAlert({
                    title: 'Error',
                    message: 'Terjadi kesalahan saat memperbarui profile',
                    type: 'error'
                });
            });
        }

        function savePassword() {
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (!currentPassword || !newPassword || !confirmPassword) {
                showCustomAlert({
                    title: 'Error',
                    message: 'Semua field harus diisi',
                    type: 'error'
                });
                return;
            }

            if (newPassword !== confirmPassword) {
                showCustomAlert({
                    title: 'Error',
                    message: 'Password baru dan konfirmasi password tidak cocok',
                    type: 'error'
                });
                return;
            }

            fetch('/api/password-change', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer {{ Auth::user() ? Auth::user()->createToken("web-token")->plainTextToken : "" }}'
                },
                body: JSON.stringify({
                    current_password: currentPassword,
                    password: newPassword,
                    password_confirmation: confirmPassword
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Simpan pesan success ke session storage
                    sessionStorage.setItem('profileMessage', 'Password berhasil diubah');
                    sessionStorage.setItem('profileMessageType', 'success');
                    location.reload();
                } else {
                    showCustomAlert({
                        title: 'Error',
                        message: data.message || 'Gagal mengubah password',
                        type: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomAlert({
                    title: 'Error',
                    message: 'Terjadi kesalahan saat mengubah password',
                    type: 'error'
                });
            });
        }

        // Merchant Registration Functions
        function saveMerchantRegistration() {
            const formData = new FormData(document.getElementById('merchantRegistrationForm'));
            const data = {
                name: formData.get('name'),
                address: formData.get('address'),
                phone: formData.get('phone'),
                open: parseInt(formData.get('open')),
                close: parseInt(formData.get('close')),
                status: formData.get('status')
            };

            // Validasi jam operasional
            if (data.open >= data.close) {
                showCustomAlert({
                    title: 'Error',
                    message: 'Jam tutup harus lebih besar dari jam buka',
                    type: 'error'
                });
                return;
            }

            fetch('/api/merchants', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer {{ Auth::user() ? Auth::user()->createToken("web-token")->plainTextToken : "" }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.message) {
                    showCustomAlert({
                        title: 'Berhasil!',
                        message: data.message + '. Anda sekarang dapat mengakses dashboard merchant.',
                        type: 'success'
                    });
                    closeMerchantRegistration();
                    // Redirect ke merchant dashboard setelah 2 detik
                    setTimeout(() => {
                        window.location.href = '/merchant/dashboard';
                    }, 2000);
                } else {
                    throw new Error('Response tidak valid');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomAlert({
                    title: 'Error',
                    message: 'Terjadi kesalahan saat mendaftar sebagai merchant',
                    type: 'error'
                });
            });
        }

        // Other Functions
        function openBookingHistory() {
            showCustomAlert({
                title: 'Riwayat Booking',
                message: 'Fitur ini akan segera hadir!',
                type: 'info'
            });
        }

        function openPaymentHistory() {
            showCustomAlert({
                title: 'Riwayat Pembayaran',
                message: 'Fitur ini akan segera hadir!',
                type: 'info'
            });
        }

        function openNotifications() {
            showCustomAlert({
                title: 'Notifikasi',
                message: 'Fitur ini akan segera hadir!',
                type: 'info'
            });
        }

        function openPrivacy() {
            showCustomAlert({
                title: 'Privasi & Keamanan',
                message: 'Fitur ini akan segera hadir!',
                type: 'info'
            });
        }

        function openLogout() {
            showCustomAlert({
                title: 'Keluar',
                message: 'Apakah Anda yakin ingin keluar dari aplikasi?',
                type: 'warning',
                confirmText: 'Ya, Keluar',
                cancelText: 'Batal',
                onConfirm: () => {
                    // Submit logout form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/logout';
                    form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Check for success message on page load
        document.addEventListener('DOMContentLoaded', function() {
            const message = sessionStorage.getItem('profileMessage');
            const messageType = sessionStorage.getItem('profileMessageType');

            if (message) {
                showCustomAlert({
                    title: messageType === 'success' ? 'Berhasil!' : 'Error',
                    message: message,
                    type: messageType || 'success'
                });

                // Clear the message
                sessionStorage.removeItem('profileMessage');
                sessionStorage.removeItem('profileMessageType');
            }
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
            }
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
            }
        });
    </script>
</body>
</html>
