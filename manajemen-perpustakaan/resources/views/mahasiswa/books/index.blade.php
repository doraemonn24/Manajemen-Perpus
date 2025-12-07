@extends('mahasiswa.app')

@section('title', 'Katalog Buku')

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            <span class="text-pink-500">📚</span>
            Katalog Buku
        </h1>
        <p class="text-gray-600">Jelajahi koleksi buku menarik di Taman Buku</p>
    </div>

    <!-- Filter Form -->
    <div class="mb-10 bg-white rounded-2xl shadow-lg p-6 border border-pink-100">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <div class="relative">
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}" 
                           placeholder="Cari judul, penulis, atau kata kunci..." 
                           class="w-full px-6 py-4 border-2 border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-300 outline-none transition pl-12">
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Category & Sort -->
            <div class="flex flex-col md:flex-row gap-4">
                <select name="kategori" class="px-4 py-3 border-2 border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-300 focus:border-purple-300 outline-none transition bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('kategori')==$cat?'selected':'' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                
                <select name="sort" class="px-4 py-3 border-2 border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-300 focus:border-blue-300 outline-none transition bg-white">
                    <option value="">Urutkan</option>
                    <option value="tahun_asc" {{ request('sort')=='tahun_asc'?'selected':'' }}>Tahun Terbit (Asc)</option>
                    <option value="tahun_desc" {{ request('sort')=='tahun_desc'?'selected':'' }}>Tahun Terbit (Desc)</option>
                    <option value="rating_desc" {{ request('sort')=='rating_desc'?'selected':'' }}>Rating Tertinggi</option>
                </select>
            </div>

            <!-- Filter Button -->
            <button type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-xl hover:from-pink-600 hover:to-purple-700 transition-all duration-300 shadow hover:shadow-lg font-semibold flex items-center justify-center gap-2">
                <span>🔍</span> Filter
            </button>
        </form>
    </div>

    <!-- Book Grid -->
    @if($books->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($books as $book)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 border border-pink-100 group flex flex-col h-full">
                
                <!-- Book Cover -->
                <div class="h-72 w-full relative overflow-hidden bg-gradient-to-br from-pink-50 to-purple-50">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" 
                             alt="{{ $book->judul }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="flex items-center justify-center h-full">
                            <div class="w-32 h-40 bg-gradient-to-br from-pink-300 to-purple-400 rounded-lg shadow-inner flex items-center justify-center">
                                <span class="text-5xl text-white">📖</span>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Category Badge -->
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-pink-700 text-xs px-3 py-1.5 rounded-full font-semibold shadow-md border border-pink-200">
                        {{ $book->kategori }}
                    </div>
                    
                    <!-- Stock Indicator -->
                    <div class="absolute top-4 left-4 bg-gradient-to-r {{ $book->stok > 0 ? 'from-green-400 to-green-500' : 'from-red-400 to-red-500' }} text-white text-xs px-3 py-1.5 rounded-full font-bold shadow-lg">
                        {{ $book->stok > 0 ? 'Tersedia' : 'Habis' }}
                    </div>
                </div>

                <!-- Book Info -->
                <div class="p-5 flex flex-col flex-grow">
                    <!-- Title & Author -->
                    <h3 class="font-bold text-gray-900 text-lg mb-2 leading-tight line-clamp-2 group-hover:text-pink-600 transition-colors duration-300">
                        {{ $book->judul }}
                    </h3>
                    <p class="text-sm text-gray-600 mb-3 flex items-center gap-2">
                        <span class="text-gray-400">✍️</span>
                        {{ $book->penulis }}
                    </p>
                    
                    <!-- Rating & Year -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-400">⭐</span>
                            <span class="font-bold text-gray-800">{{ $book->rating ?? 0 }}</span>
                            <span class="text-xs text-gray-500">/5</span>
                        </div>
                        <span class="text-sm text-gray-500">
                            {{ $book->tahun_terbit }}
                        </span>
                    </div>
                    
                    <!-- Description Preview -->
                    <div class="mb-4 flex-grow">
                        <p class="text-gray-500 text-sm line-clamp-2">
                            {{ Str::limit($book->deskripsi ?? 'Buku menarik untuk dibaca', 80) }}
                        </p>
                    </div>
                    
                    <!-- Action Button -->
                    <div class="mt-auto pt-4 border-t border-pink-100">
                        <a href="{{ route('mahasiswa.books.show', $book->id) }}" 
                           class="block w-full text-center bg-gradient-to-r from-pink-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-pink-600 hover:to-purple-700 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2 group/btn">
                            <span class="group-hover/btn:rotate-12 transition-transform">👁️</span>
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl border-2 border-dashed border-pink-200 p-12 text-center">
            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-pink-200 to-purple-300 rounded-full flex items-center justify-center">
                <span class="text-3xl">🔍</span>
            </div>
            <p class="text-gray-600 text-lg mb-2">Tidak ada buku yang ditemukan</p>
            <p class="text-gray-500 text-sm">Coba ubah filter pencarian Anda</p>
            <a href="{{ route('mahasiswa.books.index') }}" 
               class="inline-block mt-4 px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-xl hover:from-pink-600 hover:to-purple-700 transition-all duration-300 text-sm font-medium">
                Reset Filter
            </a>
        </div>
    @endif

    <!-- Pagination -->
    @if($books->count() > 0)
        <div class="mt-10 flex justify-center">
            <div class="flex items-center space-x-2 bg-white rounded-xl p-4 shadow border border-pink-100">
                {{ $books->links() }}
            </div>
        </div>
    @endif
</div>
@endsection