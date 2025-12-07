<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Mahasiswa - Taman Buku')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #fdf2f8 0%, #f5f3ff 50%, #eff6ff 100%);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-pink-500 to-purple-600 text-white shadow-xl">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold">
                    {{ $pageHeader ?? 'Mahasiswa Taman Buku' }}
                </h1>
                <p class="text-pink-100 text-sm">Portal Mahasiswa</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('mahasiswa.dashboard') }}"
                   class="px-4 py-2 rounded-xl transition-all duration-300 flex items-center gap-2
                   {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-white/30 shadow-inner' : 'bg-white/10 hover:bg-white/20' }}">
                    <span>🏠</span> Dashboard
                </a>

                <a href="{{ route('mahasiswa.loans.index') }}"
                   class="px-4 py-2 rounded-xl transition-all duration-300 flex items-center gap-2
                   {{ request()->routeIs('mahasiswa.loans.*') ? 'bg-white/30 shadow-inner' : 'bg-white/10 hover:bg-white/20' }}">
                    <span>📖</span> Peminjaman Saya
                </a>

                <a href="{{ route('mahasiswa.notifications.index') }}"
                   class="px-4 py-2 rounded-xl transition-all duration-300 flex items-center gap-2
                   {{ request()->routeIs('mahasiswa.notifications.*') ? 'bg-white/30 shadow-inner' : 'bg-white/10 hover:bg-white/20' }}">
                    <span>🔔</span> Notifikasi
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-white text-pink-600 font-semibold hover:bg-pink-50 
                               rounded-xl transition-all duration-300 flex items-center gap-2 shadow hover:shadow-lg">
                        <span>🚪</span> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="flex-1 p-6 md:p-8">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-pink-50 to-purple-50 text-center py-6 mt-auto border-t border-pink-100">
        <p class="text-gray-600 text-sm">
            &copy; {{ date('Y') }} <span class="font-semibold text-purple-600">Taman Buku</span> - Portal Mahasiswa
        </p>
    </footer>

</body>
</html>