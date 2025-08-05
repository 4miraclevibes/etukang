@extends('layouts.landing.app')

@section('title', 'Profil - Etukang')

@section('content')
    <!-- Header -->
    <div class="px-4 py-3 border-b border-gray-200 bg-white">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-900">Profil</h1>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="px-4 py-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center mb-4">
                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mr-4">
                    <span class="text-white text-xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-500">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Nama Lengkap</span>
                    <span class="font-medium">{{ $user->name }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Email</span>
                    <span class="font-medium">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Bergabung Sejak</span>
                    <span class="font-medium">{{ $user->created_at->format('d M Y') }}</span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-100">
                <button onclick="showEditProfile()"
                        class="w-full bg-green-500 text-white py-2 rounded-lg font-medium">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Profil
                </button>
            </div>
        </div>

        <!-- Settings Menu -->
        <div class="space-y-4">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <h3 class="font-semibold text-gray-900 mb-4">Pengaturan</h3>
                <div class="space-y-3">
                    <button onclick="showChangePassword()"
                            class="w-full flex items-center justify-between py-3 text-left">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-lock text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Ubah Password</p>
                                <p class="text-sm text-gray-500">Keamanan akun</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </button>

                    <button onclick="showNotificationSettings()"
                            class="w-full flex items-center justify-between py-3 text-left">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-bell text-purple-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Notifikasi</p>
                                <p class="text-sm text-gray-500">Pengaturan notifikasi</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </button>

                    <button onclick="showPrivacySettings()"
                            class="w-full flex items-center justify-between py-3 text-left">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-shield-alt text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Privasi</p>
                                <p class="text-sm text-gray-500">Pengaturan privasi</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <h3 class="font-semibold text-gray-900 mb-4">Akun</h3>
                <div class="space-y-3">
                    <button onclick="logout()"
                            class="w-full flex items-center justify-between py-3 text-left">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-sign-out-alt text-red-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-red-600">Logout</p>
                                <p class="text-sm text-gray-500">Keluar dari aplikasi</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.landing.footer')
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

<!-- Edit Profile Modal -->
<div id="editProfileModal" class="custom-alert">
    <div class="alert-content" style="width: 95%; max-width: 400px;">
        <div class="alert-header">
            <div class="alert-icon warning">
                <i class="fas fa-user-edit"></i>
            </div>
            <div class="alert-title">Edit Profil</div>
            <div class="alert-message">Ubah informasi profil Anda</div>
        </div>

        <form id="editProfileForm" class="p-4 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" id="editName" name="name" value="{{ $user->name }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="editEmail" name="email" value="{{ $user->email }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
        </form>

        <div class="alert-buttons">
            <button onclick="closeEditProfileModal()" class="alert-button secondary">Batal</button>
            <button onclick="saveProfile()" class="alert-button primary">Simpan</button>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div id="changePasswordModal" class="custom-alert">
    <div class="alert-content" style="width: 95%; max-width: 400px;">
        <div class="alert-header">
            <div class="alert-icon warning">
                <i class="fas fa-lock"></i>
            </div>
            <div class="alert-title">Ubah Password</div>
            <div class="alert-message">Masukkan password lama dan password baru</div>
        </div>

        <form id="changePasswordForm" class="p-4 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                <input type="password" id="oldPassword" name="old_password"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" id="newPassword" name="new_password"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" id="confirmPassword" name="confirm_password"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
        </form>

        <div class="alert-buttons">
            <button onclick="closeChangePasswordModal()" class="alert-button secondary">Batal</button>
            <button onclick="savePassword()" class="alert-button primary">Simpan</button>
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
</style>

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

    // Profile Functions
    function showEditProfile() {
        document.getElementById('editProfileModal').classList.add('show');
    }

    function closeEditProfileModal() {
        document.getElementById('editProfileModal').classList.remove('show');
    }

    function saveProfile() {
        const name = document.getElementById('editName').value;
        const email = document.getElementById('editEmail').value;

        if (!name || !email) {
            showCustomAlert({
                title: 'Error',
                message: 'Nama dan email harus diisi',
                type: 'error'
            });
            return;
        }

        fetch('/api/profile', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer {{ Auth::user() ? Auth::user()->createToken("web-token")->plainTextToken : "" }}'
            },
            body: JSON.stringify({
                name: name,
                email: email
            })
        })
        .then(response => response.json())
        .then(data => {
            closeEditProfileModal();

            if (data.success) {
                showCustomAlert({
                    title: 'Berhasil',
                    message: 'Profil berhasil diperbarui',
                    type: 'success',
                    onConfirm: () => {
                        location.reload();
                    }
                });
            } else {
                showCustomAlert({
                    title: 'Error',
                    message: data.message || 'Gagal memperbarui profil',
                    type: 'error'
                });
            }
        })
        .catch(error => {
            closeEditProfileModal();
            showCustomAlert({
                title: 'Error',
                message: 'Terjadi kesalahan saat memperbarui profil',
                type: 'error'
            });
        });
    }

    function showChangePassword() {
        document.getElementById('changePasswordModal').classList.add('show');
    }

    function closeChangePasswordModal() {
        document.getElementById('changePasswordModal').classList.remove('show');
    }

    function savePassword() {
        const oldPassword = document.getElementById('oldPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (!oldPassword || !newPassword || !confirmPassword) {
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
                message: 'Password baru dan konfirmasi password tidak sama',
                type: 'error'
            });
            return;
        }

        fetch('/api/profile/password', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer {{ Auth::user() ? Auth::user()->createToken("web-token")->plainTextToken : "" }}'
            },
            body: JSON.stringify({
                old_password: oldPassword,
                new_password: newPassword
            })
        })
        .then(response => response.json())
        .then(data => {
            closeChangePasswordModal();

            if (data.success) {
                showCustomAlert({
                    title: 'Berhasil',
                    message: 'Password berhasil diubah',
                    type: 'success',
                    onConfirm: () => {
                        // Clear form
                        document.getElementById('changePasswordForm').reset();
                    }
                });
            } else {
                showCustomAlert({
                    title: 'Error',
                    message: data.message || 'Gagal mengubah password',
                    type: 'error'
                });
            }
        })
        .catch(error => {
            closeChangePasswordModal();
            showCustomAlert({
                title: 'Error',
                message: 'Terjadi kesalahan saat mengubah password',
                type: 'error'
            });
        });
    }

    function showNotificationSettings() {
        showCustomAlert({
            title: 'Pengaturan Notifikasi',
            message: 'Fitur pengaturan notifikasi akan segera hadir!',
            type: 'info'
        });
    }

    function showPrivacySettings() {
        showCustomAlert({
            title: 'Pengaturan Privasi',
            message: 'Fitur pengaturan privasi akan segera hadir!',
            type: 'info'
        });
    }

    function logout() {
        showCustomAlert({
            title: 'Logout',
            message: 'Apakah Anda yakin ingin keluar?',
            type: 'warning',
            confirmText: 'Ya, Logout',
            cancelText: 'Batal',
            onConfirm: () => {
                fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer {{ Auth::user() ? Auth::user()->createToken("web-token")->plainTextToken : "" }}'
                    }
                })
                .then(() => {
                    window.location.href = '{{ route("login") }}';
                })
                .catch(error => {
                    showCustomAlert({
                        title: 'Error',
                        message: 'Gagal logout: ' + error.message,
                        type: 'error'
                    });
                });
            }
        });
    }
</script>
