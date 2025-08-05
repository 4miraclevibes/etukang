<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Etukang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="h-full gradient-bg">
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-tools text-green-500 text-2xl"></i>
                </div>
            </div>

            <h2 class="text-center text-3xl font-bold text-white mb-2">
                Verifikasi Email
            </h2>
            <p class="text-center text-white/80 text-sm">
                Terima kasih telah mendaftar! Silakan verifikasi email Anda
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="glass-effect rounded-2xl shadow-2xl px-8 py-8">
                <div class="text-center mb-6">
                    <i class="fas fa-envelope-open text-white text-4xl mb-4"></i>
                    <p class="text-white/80 text-sm">
                        Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirim. Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan yang lain.
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 p-3 bg-green-500/20 border border-green-500/30 rounded-xl text-green-200 text-sm">
                        <i class="fas fa-check-circle mr-2"></i>
                        Link verifikasi baru telah dikirim ke alamat email yang Anda berikan saat registrasi.
                    </div>
                @endif

                <div class="space-y-4">
                    <!-- Resend Verification Email -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent
                            text-sm font-medium rounded-xl text-green-600 bg-white hover:bg-gray-50
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white
                            transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-white/80 hover:text-white transition-colors text-sm">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
