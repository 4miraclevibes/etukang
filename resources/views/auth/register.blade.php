<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Etukang</title>
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
                Bergabung dengan Etukang
            </h2>
            <p class="text-center text-white/80 text-sm">
                Buat akun baru untuk mulai pesan teknisi
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="glass-effect rounded-2xl shadow-2xl px-8 py-8">
                <form class="space-y-6" method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-user mr-2"></i>Nama Lengkap
                        </label>
                        <div class="relative">
                            <input id="name" name="name" type="text" autocomplete="name" required
                                class="appearance-none relative block w-full px-4 py-3 border border-white/20 rounded-xl
                                bg-white/10 text-white placeholder-white/60 focus:outline-none focus:ring-2
                                focus:ring-white/50 focus:border-transparent transition-all duration-200"
                                placeholder="Masukkan nama lengkap Anda">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-user text-white/40"></i>
                            </div>
                        </div>
                        @error('name')
                            <p class="mt-1 text-red-300 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-envelope mr-2"></i>Email
                        </label>
                        <div class="relative">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="appearance-none relative block w-full px-4 py-3 border border-white/20 rounded-xl
                                bg-white/10 text-white placeholder-white/60 focus:outline-none focus:ring-2
                                focus:ring-white/50 focus:border-transparent transition-all duration-200"
                                placeholder="Masukkan email Anda">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-envelope text-white/40"></i>
                            </div>
                        </div>
                        @error('email')
                            <p class="mt-1 text-red-300 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-lock mr-2"></i>Password
                        </label>
                        <div class="relative">
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                class="appearance-none relative block w-full px-4 py-3 border border-white/20 rounded-xl
                                bg-white/10 text-white placeholder-white/60 focus:outline-none focus:ring-2
                                focus:ring-white/50 focus:border-transparent transition-all duration-200"
                                placeholder="Minimal 8 karakter">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" onclick="togglePassword('password')" class="text-white/40 hover:text-white/60">
                                    <i id="password-icon" class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <p class="mt-1 text-red-300 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-lock mr-2"></i>Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                                class="appearance-none relative block w-full px-4 py-3 border border-white/20 rounded-xl
                                bg-white/10 text-white placeholder-white/60 focus:outline-none focus:ring-2
                                focus:ring-white/50 focus:border-transparent transition-all duration-200"
                                placeholder="Ulangi password Anda">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" onclick="togglePassword('password_confirmation')" class="text-white/40 hover:text-white/60">
                                    <i id="password_confirmation-icon" class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="flex items-center">
                        <input id="terms" name="terms" type="checkbox" required
                            class="h-4 w-4 text-green-500 focus:ring-green-400 border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-white/80">
                            Saya setuju dengan
                            <a href="#" class="text-white hover:text-green-200 transition-colors">Syarat & Ketentuan</a>
                        </label>
                    </div>

                    <!-- Register Button -->
                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent
                            text-sm font-medium rounded-xl text-green-600 bg-white hover:bg-gray-50
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white
                            transition-all duration-200 transform hover:scale-105">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="fas fa-user-plus text-green-500 group-hover:text-green-600"></i>
                            </span>
                            Daftar Sekarang
                        </button>
                    </div>

                    <!-- Divider -->
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/20"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-transparent text-white/60">Atau</span>
                        </div>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-white/80 text-sm">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-medium text-white hover:text-green-200 transition-colors">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const password = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');

            if (password.type === 'password') {
                password.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                password.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
    </script>
</body>
</html>
