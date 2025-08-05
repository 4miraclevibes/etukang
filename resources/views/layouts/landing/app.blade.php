<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Etukang - Pesan Teknisi ke Rumah')</title>
    <meta name="description" content="Pesan teknisi profesional untuk perbaikan dan pemeliharaan rumah Anda. Layanan elektrik, plumbing, AC, dan cleaning.">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

        @media (max-width: 480px) {
            .bottom-nav {
                left: 0;
                transform: none;
                border-radius: 0;
            }
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

    <!-- Main Content -->
        <main>
        @yield('content')
    </main>
    </div>

    <!-- Footer di luar mobile container -->
    @include('layouts.landing.footer')

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

    @stack('scripts')

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
</body>
</html>
