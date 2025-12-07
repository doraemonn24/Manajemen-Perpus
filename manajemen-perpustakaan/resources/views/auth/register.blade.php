<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Taman Buku Ajaib</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .floating {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen w-full flex items-center justify-center px-4 py-4 overflow-hidden"
      style="background: linear-gradient(135deg, #fdf2f8 0%, #f5f3ff 50%, #eff6ff 100%);">

    <!-- Background decorative elements -->
    <div class="absolute top-5 left-5 w-6 h-6 bg-pink-300 rounded-full opacity-20 floating"></div>
    <div class="absolute bottom-10 right-5 w-5 h-5 bg-purple-300 rounded-full opacity-30 floating" style="animation-delay: 1s;"></div>
    
    <div class="w-full max-w-md bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-pink-100 relative">
        
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="h-16 w-16 bg-gradient-to-br from-pink-400 to-purple-500 rounded-full flex items-center justify-center shadow-lg mx-auto mb-4">
                <div class="h-12 w-12 bg-gradient-to-br from-pink-300 to-purple-400 rounded-full flex items-center justify-center">
                    <span class="text-white text-2xl">📚</span>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-1">
                Bergabung ke Taman Buku
            </h2>
            <p class="text-gray-500 text-sm">
                Mulai petualangan membaca Anda!
            </p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- Nama Lengkap -->
            <div>
                <input type="text" name="name" placeholder="Nama Lengkap" required
                       value="{{ old('name') }}"
                       class="w-full px-4 py-3 border border-pink-100 bg-white rounded-lg focus:ring-2 focus:ring-pink-300 focus:border-pink-300 outline-none transition text-sm">
                @error('name')
                    <p class="text-pink-500 text-xs mt-1 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <input type="email" name="email" placeholder="Email" required
                       value="{{ old('email') }}"
                       class="w-full px-4 py-3 border border-purple-100 bg-white rounded-lg focus:ring-2 focus:ring-purple-300 focus:border-purple-300 outline-none transition text-sm">
                @error('email')
                    <p class="text-purple-500 text-xs mt-1 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <input type="password" name="password" placeholder="Password (min 6 karakter)" required minlength="6"
                       class="w-full px-4 py-3 border border-blue-100 bg-white rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-300 outline-none transition text-sm">
                @error('password')
                    <p class="text-blue-500 text-xs mt-1 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required
                       class="w-full px-4 py-3 border border-pink-100 bg-white rounded-lg focus:ring-2 focus:ring-pink-300 focus:border-pink-300 outline-none transition text-sm">
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full py-3 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-300 shadow-md hover:shadow-lg mt-2">
                Daftar Sekarang
            </button>
        </form>

        <!-- Login link -->
        <div class="mt-6 pt-5 border-t border-pink-100">
            <p class="text-center text-gray-600 text-sm">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-pink-600 font-medium hover:text-purple-600 transition-colors">
                    Login di sini
                </a>
            </p>
        </div>

    </div>

</body>
</html>