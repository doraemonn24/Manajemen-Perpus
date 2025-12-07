@extends('mahasiswa.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')

<div class="container mx-auto px-4 py-8">

    {{-- BAGIAN 1: PROFIL PENGGUNA & PENGATURAN AKUN --}}
    <div class="bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl shadow-lg p-8 mb-8 border border-pink-100">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-6">
                {{-- Avatar Inisial dengan Gradient Tema --}}
                <div class="relative">
                    <div class="w-24 h-24 bg-gradient-to-br from-pink-400 to-purple-500 rounded-full flex items-center justify-center text-white text-4xl font-bold shadow-xl">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    {{-- Decorative sparkle --}}
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-300 rounded-full flex items-center justify-center text-xs animate-ping">
                        ✨
                    </div>
                </div>
                
                {{-- Info Akun --}}
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-1">{{ Auth::user()->name }}</h2>
                    <p class="text-gray-500 text-sm mb-3 flex items-center gap-2">
                        <span>📧</span> {{ Auth::user()->email }}
                    </p>
                    <span class="bg-gradient-to-r from-pink-500 to-purple-600 text-white text-xs px-4 py-1.5 rounded-full font-semibold uppercase tracking-wide">
                        Mahasiswa Penjelajah
                    </span>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex flex-wrap gap-3">
                {{-- Link ke Pengaturan Akun --}}
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center gap-2 bg-white text-gray-700 px-5 py-3 rounded-xl hover:bg-pink-50 transition-all duration-300 font-medium border border-pink-200 shadow hover:shadow-lg">
                    <span>⚙️</span>
                    Pengaturan Akun
                </a>

                {{-- Link ke Katalog --}}
                <a href="{{ route('mahasiswa.books.index') }}"
                   class="flex items-center gap-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-3 rounded-xl hover:from-pink-600 hover:to-purple-700 transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <span>📚</span>
                    Jelajahi Buku Baru
                </a>
            </div>
        </div>
    </div>

    {{-- BAGIAN 2: INFORMASI STATISTIK --}}
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            <span class="text-pink-500">📊</span>
            Ringkasan Aktivitas
        </h3>
        <p class="text-gray-600">Statistik peminjaman dan aktivitas Anda di Taman Buku</p>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">

        {{-- Total Peminjaman --}}
        <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-2xl p-6 border border-pink-200 shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="flex justify-between items-center mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-pink-400 to-pink-500 rounded-xl flex items-center justify-center shadow">
                    <span class="text-white text-2xl">📖</span>
                </div>
                <span class="text-4xl font-bold text-pink-600">{{ $total_pinjaman ?? 0 }}</span>
            </div>
            <h5 class="text-gray-700 text-sm font-medium">Total Riwayat Pinjaman</h5>
            <p class="text-pink-500 text-xs mt-2">Semua peminjaman Anda</p>
        </div>

        {{-- Peminjaman Aktif --}}
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 border border-purple-200 shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="flex justify-between items-center mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-500 rounded-xl flex items-center justify-center shadow">
                    <span class="text-white text-2xl">⏳</span>
                </div>
                <span class="text-4xl font-bold text-purple-600">{{ $pinjaman_aktif->count() ?? 0 }}</span>
            </div>
            <h5 class="text-gray-700 text-sm font-medium">Sedang Dipinjam</h5>
            <p class="text-purple-500 text-xs mt-2">Buku yang masih Anda pinjam</p>
        </div>

        {{-- Pinjaman Terlambat --}}
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-2xl p-6 border border-red-200 shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="flex justify-between items-center mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-red-400 to-red-500 rounded-xl flex items-center justify-center shadow">
                    <span class="text-white text-2xl">⚠️</span>
                </div>
                <span class="text-4xl font-bold text-red-600">{{ $pinjaman_terlambat ?? 0 }}</span>
            </div>
            <h5 class="text-gray-700 text-sm font-medium">Pinjaman Terlambat</h5>
            <p class="text-red-500 text-xs mt-2">Perlu segera dikembalikan</p>
        </div>

        {{-- Total Denda --}}
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200 shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="flex justify-between items-center mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-orange-500 rounded-xl flex items-center justify-center shadow">
                    <span class="text-white text-2xl">💰</span>
                </div>
                <span class="text-3xl font-bold text-orange-600">Rp{{ number_format(abs($total_denda ?? 0), 0, ',', '.') }}</span>
            </div>
            <h5 class="text-gray-700 text-sm font-medium">Total Denda</h5>
            <p class="text-orange-500 text-xs mt-2">Jumlah denda yang perlu dibayar</p>
        </div>

        {{-- Notifikasi --}}
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-6 border border-yellow-200 shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="flex justify-between items-center mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl flex items-center justify-center shadow">
                    <span class="text-white text-2xl">🔔</span>
                </div>
                <span class="text-4xl font-bold text-yellow-600">{{ $notifikasi->count() ?? 0 }}</span>
            </div>
            <h5 class="text-gray-700 text-sm font-medium">Pesan Notifikasi</h5>
            <p class="text-yellow-500 text-xs mt-2">Penting untuk diperhatikan</p>
        </div>

        {{-- Total Buku Tersedia --}}
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200 shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="flex justify-between items-center mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl flex items-center justify-center shadow">
                    <span class="text-white text-2xl">📚</span>
                </div>
                <span class="text-4xl font-bold text-blue-600">{{ $total_buku ?? 0 }}</span>
            </div>
            <h5 class="text-gray-700 text-sm font-medium">Buku di Taman Buku</h5>
            <p class="text-blue-500 text-xs mt-2">Koleksi tersedia untuk Anda</p>
        </div>

    </div>

    {{-- BAGIAN 3: CATATAN PENTING --}}
    <div class="bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl p-8 border border-pink-100 shadow-lg">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-purple-500 rounded-xl flex items-center justify-center">
                <span class="text-white text-xl">💡</span>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Tips untuk Anda</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-start gap-3 p-4 bg-white rounded-xl border border-pink-100">
                <span class="text-pink-500 text-xl">📅</span>
                <div>
                    <p class="font-medium text-gray-800">Perhatikan Jatuh Tempo</p>
                    <p class="text-sm text-gray-600">Kembalikan buku sebelum tanggal jatuh tempo untuk menghindari denda</p>
                </div>
            </div>
            <div class="flex items-start gap-3 p-4 bg-white rounded-xl border border-purple-100">
                <span class="text-purple-500 text-xl">🔍</span>
                <div>
                    <p class="font-medium text-gray-800">Jelajahi Koleksi Baru</p>
                    <p class="text-sm text-gray-600">Temukan buku-buku menarik di katalog kami setiap minggu</p>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection