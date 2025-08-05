<!-- Bottom Navigation -->
<div class="bottom-nav">
    <div class="grid grid-cols-4">
        <a href="{{ route('welcome') }}" class="nav-item {{ request()->routeIs('welcome') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('cart') }}" class="nav-item {{ request()->routeIs('cart') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Keranjang</span>
        </a>
        <a href="{{ route('transaction') }}" class="nav-item {{ request()->routeIs('transaction*') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i>
            <span>Booking</span>
        </a>
        <a href="{{ route('profile.mobile') }}" class="nav-item {{ request()->routeIs('profile.mobile') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
    </div>
</div>

<!-- Install Prompt -->
<div id="installPrompt" class="hidden fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-white rounded-lg shadow-lg p-4 max-w-sm mx-4 z-50">
    <div class="flex items-center mb-3">
        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
            <i class="fas fa-futbol text-white"></i>
        </div>
        <div>
            <h4 class="font-semibold">Install Sportlodek</h4>
            <p class="text-sm text-gray-600">Akses lebih cepat dari home screen</p>
        </div>
    </div>
    <div class="flex space-x-2">
        <button id="installBtn" class="flex-1 bg-green-500 text-white py-2 rounded-lg text-sm font-medium">
            Install
        </button>
        <button id="dismissBtn" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg text-sm">
            Nanti
        </button>
    </div>
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

<script>
    // Install Prompt Logic
    let deferredPrompt;

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;

        setTimeout(() => {
            const installPrompt = document.getElementById('installPrompt');
            installPrompt.classList.remove('hidden');
        }, 3000);
    });

    document.getElementById('installBtn').addEventListener('click', async () => {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            if (outcome === 'accepted') {
                console.log('App installed successfully');
            }
            deferredPrompt = null;
        }
        document.getElementById('installPrompt').classList.add('hidden');
    });

    document.getElementById('dismissBtn').addEventListener('click', () => {
        document.getElementById('installPrompt').classList.add('hidden');
    });

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
            case 'info':
                iconClass.className = 'fas fa-info-circle';
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

    // Global alert functions
    window.showSuccessAlert = function(message) {
        showCustomAlert({
            title: 'Berhasil!',
            message: message,
            type: 'success'
        });
    };

    window.showErrorAlert = function(message) {
        showCustomAlert({
            title: 'Terjadi Kesalahan',
            message: message,
            type: 'error'
        });
    };

    window.showConfirmAlert = function(message, onConfirm, onCancel) {
        showCustomAlert({
            title: 'Konfirmasi',
            message: message,
            type: 'warning',
            confirmText: 'Ya',
            cancelText: 'Tidak',
            onConfirm: onConfirm,
            onCancel: onCancel
        });
    };
</script>
