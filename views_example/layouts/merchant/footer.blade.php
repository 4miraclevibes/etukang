<!-- Bottom Navigation -->
<div class="bottom-nav">
    <div class="flex justify-around">
        <a href="{{ route('merchant.dashboard') }}"
           class="nav-item {{ request()->routeIs('merchant.dashboard*') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('merchant.products') }}"
           class="nav-item {{ request()->routeIs('merchant.products*') ? 'active' : '' }}">
            <i class="fas fa-futbol"></i>
            <span>Lapangan</span>
        </a>
        <a href="{{ route('merchant.transactions') }}"
           class="nav-item {{ request()->routeIs('merchant.transactions*') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i>
            <span>Booking</span>
        </a>
        <a href="{{ route('merchant.payments') }}"
           class="nav-item {{ request()->routeIs('merchant.payments*') ? 'active' : '' }}">
            <i class="fas fa-credit-card"></i>
            <span>Pembayaran</span>
        </a>
        <a href="{{ route('merchant.profile') }}"
           class="nav-item {{ request()->routeIs('merchant.profile*') ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            <span>Pengaturan</span>
        </a>
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

    function showNotifications() {
        showCustomAlert({
            title: 'Notifikasi',
            message: 'Fitur notifikasi akan segera hadir!',
            type: 'info'
        });
    }

    function showProfile() {
        window.location.href = '{{ route("merchant.profile") }}';
    }
</script>
