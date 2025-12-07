@extends('admin.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="container mx-auto px-6 py-8">

    {{-- Grid Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        {{-- Total Pengguna --}}
        <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-2xl p-6 border border-pink-200 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Pengguna</p>
                    <h3 class="text-4xl font-bold text-pink-600">{{ $totalUsers ?? 0 }}</h3>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-pink-400 to-pink-500 rounded-xl flex items-center justify-center shadow">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m0 0a4 4 0 100-8 4 4 0 000 8zm8-8a4 4 0 100-8 4 4 0 000 8z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-pink-500 mt-4">Semua pengguna terdaftar</p>
        </div>

        {{-- Total Buku --}}
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 border border-purple-200 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Buku</p>
                    <h3 class="text-4xl font-bold text-purple-600">{{ $totalBuku ?? 0 }}</h3>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-500 rounded-xl flex items-center justify-center shadow">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-purple-500 mt-4">Koleksi buku tersedia</p>
        </div>

        {{-- Peminjaman Aktif --}}
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Peminjaman Aktif</p>
                    <h3 class="text-4xl font-bold text-blue-600">{{ $peminjamanAktif ?? 0 }}</h3>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl flex items-center justify-center shadow">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-blue-500 mt-4">Sedang dipinjam</p>
        </div>

    </div>

    {{-- Informasi Dashboard --}}
    <div class="bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl p-8 border border-pink-100 shadow-lg">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-purple-500 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Informasi Dashboard</h3>
        </div>
        <p class="text-gray-700 leading-relaxed">
            Dashboard Admin berfungsi untuk memantau aktivitas seluruh pengguna, status peminjaman, 
            serta jumlah koleksi buku yang tersedia dalam sistem. Admin memiliki akses penuh untuk 
            mengelola data pengguna, koleksi buku, dan transaksi peminjaman melalui menu navigasi.
        </p>
    </div>
</div>

@endsection