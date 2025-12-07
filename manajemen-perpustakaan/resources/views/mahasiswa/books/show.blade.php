@extends('mahasiswa.app')

@section('title', $book->judul)

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Back Button -->
    <a href="{{ route('mahasiswa.books.index') }}" 
       class="inline-flex items-center text-gray-500 hover:text-pink-600 mb-6 transition-all duration-300 group">
        <span class="transform group-hover:-translate-x-1 transition-transform">←</span>
        <span class="ml-2 group-hover:underline">Kembali ke Katalog</span>
    </a>

    <!-- Main Book Card -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-pink-100">
        <div class="flex flex-col lg:flex-row gap-8 p-8">
            
            <!-- Book Cover -->
            <div class="w-full lg:w-1/3 flex justify-center items-start">
                <div class="relative group">
                    @if($book->cover_image)
                        <div class="absolute -inset-1 bg-gradient-to-r from-pink-400 to-purple-500 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-500"></div>
                        <img src="{{ asset('storage/' . $book->cover_image) }}" 
                             alt="{{ $book->judul }}" 
                             class="relative rounded-xl shadow-xl max-h-[500px] w-full object-cover transform group-hover:scale-105 transition duration-500">
                    @else
                        <div class="h-96 w-64 bg-gradient-to-br from-pink-300 to-purple-400 flex flex-col items-center justify-center rounded-xl shadow-inner">
                            <span class="text-7xl mb-3 text-white">📖</span>
                            <span class="text-white font-medium">Tidak ada sampul</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Book Details -->
            <div class="w-full lg:w-2/3">
                <!-- Title & Author -->
                <div class="mb-6">
                    <h1 class="text-4xl font-bold text-gray-900 mb-3">{{ $book->judul }}</h1>
                    <div class="flex items-center gap-2 text-gray-600 text-lg">
                        <span>✍️</span>
                        <p>Penulis: <span class="font-semibold text-gray-800">{{ $book->penulis }}</span></p>
                    </div>
                </div>

                <!-- Rating -->
                @php
                    $averageRating = $book->reviews()->count() > 0 ? round($book->reviews()->avg('rating'), 1) : 0;
                    $reviewCount = $book->reviews()->count();
                @endphp
                <div class="flex items-center gap-3 mb-6">
                    <div class="px-4 py-2 bg-gradient-to-r from-yellow-100 to-orange-100 rounded-full flex items-center gap-2">
                        <span class="text-yellow-500 text-xl">⭐</span>
                        <span class="font-bold text-gray-800">{{ $averageRating }} / 5.0</span>
                    </div>
                    <span class="text-gray-500">({{ $reviewCount }} ulasan)</span>
                </div>

                <!-- Separator -->
                <div class="h-px bg-gradient-to-r from-transparent via-pink-200 to-transparent my-6"></div>

                <!-- Book Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-pink-50 to-pink-100 rounded-xl border border-pink-200">
                        <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-pink-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-lg">🏷️</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold">Kategori</p>
                            <p class="font-bold text-gray-800">{{ $book->kategori }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl border border-purple-200">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-lg">📅</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold">Tahun Terbit</p>
                            <p class="font-bold text-gray-800">{{ $book->tahun_terbit }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-lg">📚</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold">Stok Tersedia</p>
                            <p class="font-bold text-gray-800">{{ $book->stok }} eksemplar</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border border-green-200">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-lg">⏰</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold">Maks. Peminjaman</p>
                            <p class="font-bold text-gray-800">{{ $book->maksimal_waktu_peminjaman }} Hari</p>
                        </div>
                    </div>
                </div>

                <!-- Fine Info -->
                <div class="mb-6 flex items-center gap-3 p-4 bg-gradient-to-r from-red-50 to-red-100 rounded-xl border border-red-200">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-400 to-red-500 rounded-lg flex items-center justify-center">
                        <span class="text-white text-xl">💰</span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold">Denda Keterlambatan</p>
                        <p class="font-bold text-red-600 text-lg">Rp {{ number_format($book->denda_per_hari, 0, ',', '.') }} / hari</p>
                    </div>
                </div>

                <!-- Synopsis -->
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-purple-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-lg">📖</span>
                        </div>
                        <h3 class="font-bold text-gray-900 text-xl">Sinopsis</h3>
                    </div>
                    <div class="p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                        <p class="text-gray-700 leading-relaxed">
                            {{ $book->deskripsi ?? 'Tidak ada deskripsi untuk buku ini.' }}
                        </p>
                    </div>
                </div>

                <!-- Flash Messages -->
                @if(session('error'))
                    <div class="mb-6 p-4 bg-gradient-to-r from-red-100 to-red-50 border border-red-200 rounded-2xl text-red-700 flex items-center gap-2">
                        <span>❌</span>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                @if(session('success'))
                    <div class="mb-6 p-4 bg-gradient-to-r from-green-100 to-green-50 border border-green-200 rounded-2xl text-green-700 flex items-center gap-2">
                        <span>✅</span>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Borrow Button -->
                @if($book->stok > 0)
                    <form action="{{ route('mahasiswa.books.borrow', $book->id) }}" method="POST">
                        @csrf
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin meminjam buku ini?')" 
                            class="w-full px-8 py-4 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center gap-3 text-lg">
                            <span>📚</span>
                            Pinjam Buku Ini
                        </button>
                    </form>
                @else
                    <div class="w-full px-8 py-4 bg-gradient-to-r from-gray-300 to-gray-400 text-gray-500 font-bold rounded-xl flex items-center justify-center gap-3 text-lg cursor-not-allowed">
                        <span>❌</span>
                        Stok Habis
                    </div>
                @endif
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="border-t border-pink-100 pt-8 px-8 pb-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center">
                    <span class="text-white text-xl">⭐</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Ulasan Pembaca</h2>
            </div>
            
            <div class="space-y-6">
                @forelse($book->reviews as $review)
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl border border-gray-200 hover:border-pink-200 transition-colors">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                            <div class="flex items-center gap-3 mb-3 md:mb-0">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                    {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $review->user->name ?? 'Pengguna' }}</p>
                                    <div class="flex items-center gap-1 mt-1">
                                        @for($i=0; $i<5; $i++)
                                            <span class="text-lg {{ $i < $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 px-3 py-1 bg-white rounded-full border border-gray-300">
                                {{ $review->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <div class="pl-13">
                            <p class="text-gray-700 italic">"{{ $review->komentar }}"</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                            <span class="text-3xl">📝</span>
                        </div>
                        <p class="text-gray-500 text-lg mb-2">Belum ada ulasan untuk buku ini</p>
                        <p class="text-gray-400 text-sm">Jadilah yang pertama memberikan ulasan!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Related Info -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-pink-50 to-pink-100 rounded-xl p-6 border border-pink-200">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-pink-500 rounded-lg flex items-center justify-center">
                    <span class="text-white">ℹ️</span>
                </div>
                <h3 class="font-bold text-gray-800">Peminjaman</h3>
            </div>
            <p class="text-sm text-gray-600">
                Pinjam buku ini maksimal {{ $book->maksimal_waktu_peminjaman }} hari. 
                Perpanjangan hanya dapat dilakukan 1 kali.
            </p>
        </div>
        
        <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-500 rounded-lg flex items-center justify-center">
                    <span class="text-white">💰</span>
                </div>
                <h3 class="font-bold text-gray-800">Denda</h3>
            </div>
            <p class="text-sm text-gray-600">
                Denda berlaku jika pengembalian terlambat. 
                Hitungan denda mulai dari hari pertama keterlambatan.
            </p>
        </div>
        
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg flex items-center justify-center">
                    <span class="text-white">⭐</span>
                </div>
                <h3 class="font-bold text-gray-800">Ulasan</h3>
            </div>
            <p class="text-sm text-gray-600">
                Berikan ulasan setelah membaca. 
                Ulasan Anda membantu pembaca lain menemukan buku yang tepat.
            </p>
        </div>
    </div>

</div>
@endsection