@extends('mahasiswa.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <!-- Back Button -->
    <a href="{{ route('mahasiswa.loans.index') }}" 
       class="inline-flex items-center text-gray-500 hover:text-pink-600 mb-6 transition-all duration-300 group">
        <span class="transform group-hover:-translate-x-1 transition-transform">←</span>
        <span class="ml-2 group-hover:underline">Kembali ke Riwayat</span>
    </a>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-pink-100">
        <div class="flex flex-col lg:flex-row">
            
            <!-- LEFT COLUMN: BOOK COVER -->
            <div class="w-full lg:w-1/3 bg-gradient-to-br from-pink-50 to-purple-50 p-8 flex items-center justify-center border-b lg:border-b-0 lg:border-r border-pink-100">
                @if($loan->book->cover_image)
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-pink-400 to-purple-500 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-500"></div>
                        <img src="{{ asset('storage/' . $loan->book->cover_image) }}" 
                             alt="{{ $loan->book->judul }}" 
                             class="relative rounded-xl shadow-lg max-h-[400px] w-auto object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                @else
                    <div class="h-64 w-48 bg-gradient-to-br from-pink-200 to-purple-300 flex flex-col items-center justify-center rounded-xl shadow-inner">
                        <span class="text-5xl mb-3 text-white">📚</span>
                        <span class="text-sm text-white font-medium">Tidak ada sampul</span>
                    </div>
                @endif
            </div>

            <!-- RIGHT COLUMN: DETAILS -->
            <div class="w-full lg:w-2/3 p-8">
                <!-- Header -->
                <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $loan->book->judul ?? '-' }}</h1>
                        <div class="flex items-center gap-2 text-gray-600">
                            <span>✍️</span>
                            <p>Penulis: <span class="font-semibold text-gray-800">{{ $loan->book->penulis ?? '-' }}</span></p>
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="mt-4 md:mt-0">
                        <span class="px-4 py-2 rounded-full text-sm font-bold shadow-sm
                            {{ $loan->status == 'dipinjam' ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700' : 'bg-gradient-to-r from-green-100 to-green-200 text-green-700' }}">
                            {{ $loan->status == 'dipinjam' ? '📚 Sedang Dipinjam' : '✅ Dikembalikan' }}
                        </span>
                    </div>
                </div>

                <!-- Separator -->
                <div class="h-px bg-gradient-to-r from-transparent via-pink-200 to-transparent my-6"></div>

                <!-- Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-pink-100 to-pink-200 rounded-lg flex items-center justify-center">
                                <span class="text-pink-500">📅</span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold mb-1">Tanggal Pinjam</p>
                                <p class="font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->locale('id')->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-purple-200 rounded-lg flex items-center justify-center">
                                <span class="text-purple-500">⏰</span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold mb-1">Jatuh Tempo</p>
                                <p class="font-medium {{ \Carbon\Carbon::now()->gt($loan->tanggal_jatuh_tempo) && $loan->status == 'dipinjam' ? 'text-red-600 animate-pulse' : 'text-gray-800' }}">
                                    {{ \Carbon\Carbon::parse($loan->tanggal_jatuh_tempo)->locale('id')->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                <span class="text-blue-500">📥</span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold mb-1">Tanggal Kembali</p>
                                <p class="font-medium text-gray-800">
                                    {{ $loan->tanggal_kembali 
                                        ? \Carbon\Carbon::parse($loan->tanggal_kembali)->locale('id')->translatedFormat('d F Y')
                                        : 'Belum dikembalikan' 
                                    }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-lg flex items-center justify-center">
                                <span class="text-yellow-500">🏷️</span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold mb-1">Kategori</p>
                                <p class="font-medium text-gray-800">{{ $loan->book->kategori ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fine Card -->
                <div class="mb-8 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="text-center md:text-left">
                            <p class="text-xs text-gray-500 uppercase font-bold mb-2">Total Denda</p>
                            <p class="text-2xl font-bold {{ $loan->denda > 0 ? 'text-red-600' : 'text-gray-800' }}">
                                Rp {{ number_format(abs($loan->denda), 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <span class="px-4 py-2 rounded-lg text-sm font-bold shadow
                                {{ $loan->denda_status == 'tertunggak' ? 'bg-gradient-to-r from-red-100 to-red-200 text-red-700' : 'bg-gradient-to-r from-green-100 to-green-200 text-green-700' }}">
                                {{ $loan->denda_status == 'tertunggak' ? '⚠️ Tertunggak' : '✅ Lunas' }}
                            </span>
                        </div>
                    </div>
                    @if($loan->denda > 0 && $loan->denda_status == 'tertunggak')
                        <p class="text-xs text-red-500 mt-3 text-center md:text-left">
                            Segera lunasi denda untuk menghindari pemblokiran peminjaman
                        </p>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-4">
                    <!-- Renew Button -->
                    @if($loan->status == 'dipinjam' && $loan->perpanjangan_count < 1)
                        <a href="{{ route('mahasiswa.loans.renew.form', $loan->id) }}"
                            class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow hover:shadow-lg font-medium flex items-center gap-2">
                            <span>🔄</span>
                            Perpanjang Peminjaman
                        </a>
                    @endif

                    <!-- Review Section -->
                    @if($loan->status == 'dikembalikan')
                        @if(!$loan->review)
                            <a href="{{ route('mahasiswa.loans.review', $loan->id) }}" 
                               class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 shadow hover:shadow-lg font-medium flex items-center gap-2">
                                <span>⭐</span>
                                Beri Ulasan
                            </a>
                        @else
                            <div class="w-full bg-gradient-to-r from-blue-50 to-purple-50 p-6 rounded-xl border border-blue-100">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex items-center justify-center">
                                        <span class="text-white">⭐</span>
                                    </div>
                                    <h3 class="font-bold text-gray-800">Ulasan Anda:</h3>
                                </div>
                                <div class="pl-13">
                                    <p class="text-gray-700 italic mb-2">"{{ $loan->review->komentar }}"</p>
                                    <div class="flex items-center gap-2">
                                        <span class="text-yellow-500 font-bold">Rating:</span>
                                        <div class="flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="text-xl {{ $i <= $loan->review->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                            @endfor
                                        </div>
                                        <span class="text-gray-600 text-sm">({{ $loan->review->rating }}/5)</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection