@extends('mahasiswa.app')

@section('title', 'Perpanjang Peminjaman')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-pink-100">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-purple-500 rounded-xl flex items-center justify-center">
                    <span class="text-white text-xl">📅</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Perpanjang Peminjaman Buku</h1>
            </div>
            <p class="text-gray-600">Perpanjang waktu peminjaman buku Anda</p>
        </div>

        <!-- Book Information Card -->
        <div class="mb-10 bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl p-6 border border-pink-200">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Book Cover -->
                <div class="w-32 h-40 rounded-xl overflow-hidden bg-gradient-to-br from-pink-100 to-purple-100 shadow">
                    @if($loan->book->cover_image)
                        <img src="{{ asset('storage/' . $loan->book->cover_image) }}" 
                             alt="{{ $loan->book->judul }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-4xl text-pink-400">📚</span>
                        </div>
                    @endif
                </div>
                
                <!-- Book Details -->
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $loan->book->judul ?? '-' }}</h3>
                    <p class="text-gray-600 mb-4">oleh {{ $loan->book->penulis ?? '-' }}</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="text-pink-500">📅</span>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal Pinjam</p>
                                    <p class="font-medium text-gray-800">
                                        {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->locale('id')->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-purple-500">⏰</span>
                                <div>
                                    <p class="text-sm text-gray-500">Jatuh Tempo Saat Ini</p>
                                    <p class="font-medium text-gray-800">
                                        {{ \Carbon\Carbon::parse($loan->tanggal_jatuh_tempo)->locale('id')->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="text-blue-500">🔄</span>
                                <div>
                                    <p class="text-sm text-gray-500">Perpanjangan Dilakukan</p>
                                    <p class="font-medium text-gray-800">{{ $loan->perpanjangan_count }} kali</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-yellow-500">⚠️</span>
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('mahasiswa.loans.renew', $loan->id) }}" method="POST">
            @csrf
            
            <!-- Days Input -->
            <div class="mb-8">
                <label for="days" class="block mb-3 text-gray-700 font-medium">
                    <span class="text-green-500">➕</span> Tambah Hari Perpanjangan
                </label>
                <div class="relative">
                    <input 
                        type="number" 
                        name="days" 
                        id="days" 
                        value="7" 
                        min="1" 
                        step="1"
                        class="w-full px-5 py-4 border-2 border-green-200 rounded-xl focus:ring-2 focus:ring-green-300 focus:border-green-300 outline-none transition text-center text-lg font-bold"
                        required
                    >
                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <span class="text-sm">hari</span>
                    </div>
                </div>
                <p class="text-gray-500 text-sm mt-2">
                    Maksimal perpanjangan biasanya {{ $loan->book->maksimal_waktu_peminjaman ?? 14 }} hari dari tanggal jatuh tempo
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('mahasiswa.loans.show', $loan->id) }}" 
                   class="px-6 py-3 bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-xl hover:from-gray-500 hover:to-gray-600 transition-all duration-300 shadow hover:shadow-lg flex-1 text-center flex items-center justify-center gap-2">
                    <span>↩️</span> Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow hover:shadow-lg flex-1 flex items-center justify-center gap-2">
                    <span>🔄</span> Perpanjang Sekarang
                </button>
            </div>
        </form>

        <!-- Information Note -->
        <div class="mt-8 p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200">
            <div class="flex items-start gap-3">
                <span class="text-blue-500 text-xl">💡</span>
                <div>
                    <p class="font-medium text-gray-800 mb-1">Informasi Penting</p>
                    <p class="text-sm text-gray-600">
                        Perpanjangan hanya dapat dilakukan sebelum tanggal jatuh tempo. 
                        Pastikan untuk mengembalikan buku tepat waktu untuk menghindari denda.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection