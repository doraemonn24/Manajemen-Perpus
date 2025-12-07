@extends('layouts.app')

@section('content')

    <!-- Hero Section dengan tema taman peri -->
    <div class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 py-24 text-center text-gray-800 relative overflow-hidden">
        <!-- Background pattern bunga -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M50 20c-16.6 0-30 13.4-30 30s13.4 30 30 30 30-13.4 30-30-13.4-30-30-30zm0 54c-13.2 0-24-10.8-24-24s10.8-24 24-24 24 10.8 24 24-10.8 24-24 24zm-6-24c0-3.3 2.7-6 6-6s6 2.7 6 6-2.7 6-6 6-6-2.7-6-6z" fill="%23d946ef" fill-opacity="0.3"/%3E%3Ccircle cx="20" cy="20" r="8" fill="%23a855f7" fill-opacity="0.3"/%3E%3Ccircle cx="80" cy="80" r="8" fill="%238b5cf6" fill-opacity="0.3"/%3E%3Ccircle cx="80" cy="20" r="6" fill="%23ec4899" fill-opacity="0.3"/%3E%3Ccircle cx="20" cy="80" r="6" fill="%230ea5e9" fill-opacity="0.3"/%3E%3C/svg%3E'); background-size: 300px;"></div>
        </div>
        
        <!-- Bintang-bintang kecil -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-10 left-1/4 w-2 h-2 bg-pink-300 rounded-full opacity-60"></div>
            <div class="absolute top-20 right-1/3 w-3 h-3 bg-blue-300 rounded-full opacity-50"></div>
            <div class="absolute bottom-32 left-1/3 w-2 h-2 bg-purple-300 rounded-full opacity-70"></div>
            <div class="absolute top-40 left-1/2 w-1 h-1 bg-pink-200 rounded-full opacity-80"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <!-- Book icon decorative element dengan tema peri -->
            <div class="w-24 h-24 mx-auto mb-8 bg-gradient-to-br from-pink-400 to-purple-500 rounded-full flex items-center justify-center shadow-2xl transform rotate-6 floating">
                <div class="w-20 h-20 bg-gradient-to-br from-pink-300 to-purple-400 rounded-full flex items-center justify-center shadow-inner">
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-6 0c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/>
                    </svg>
                </div>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-bold mb-6 drop-shadow-sm font-serif bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent">
                Selamat Datang di <span class="block">Perpustakaan Taman Buku</span>
            </h1>
            <p class="text-xl mb-10 text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Masuk ke dunia ajaib pengetahuan, dimana setiap buku adalah bunga yang mekar 
                di taman imajinasi. Temukan keajaiban dalam setiap halaman.
            </p>
            
            <!-- Search Bar dengan desain peri -->
            <form action="{{ route('books.index') }}" method="GET" class="max-w-3xl mx-auto relative group">
                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-pink-400 to-purple-500 rounded-3xl blur opacity-30 group-hover:opacity-50 transition duration-1000"></div>
                    <input type="text" name="search" placeholder="🔍 Cari buku impianmu..." 
                           class="relative w-full px-8 py-5 rounded-2xl text-gray-800 focus:outline-none focus:ring-4 focus:ring-pink-300/50 shadow-xl text-lg pl-16 bg-white/90 backdrop-blur-sm border-2 border-white/50">
                    
                    <!-- Search Icon -->
                    <div class="absolute left-6 top-1/2 transform -translate-y-1/2 text-pink-400 group-focus-within:text-purple-500 transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white font-bold px-8 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl active:scale-95 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Jelajahi
                    </button>
                </div>
            </form>
            
            <!-- Quick Stats dengan tema peri -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-2xl p-6 border border-pink-200/50 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="text-4xl font-bold bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent mb-2">10+</div>
                    <div class="text-gray-600 font-medium">Buku Ajaib</div>
                    <div class="text-sm text-pink-500 mt-2">✨ Di taman kami</div>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 border border-purple-200/50 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="text-4xl font-bold bg-gradient-to-r from-purple-500 to-blue-500 bg-clip-text text-transparent mb-2">24/7</div>
                    <div class="text-gray-600 font-medium">Pintu Terbuka</div>
                    <div class="text-sm text-purple-500 mt-2">🌙 Kapan saja</div>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200/50 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="text-4xl font-bold bg-gradient-to-r from-blue-500 to-pink-500 bg-clip-text text-transparent mb-2">20+</div>
                    <div class="text-gray-600 font-medium">Jenis Bunga</div>
                    <div class="text-sm text-blue-500 mt-2">📚 Kategori buku</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-16">
        
        <!-- New Books Section dengan tema peri -->
        <div class="mb-20">
            <div class="flex justify-between items-end mb-10 pb-6 border-b border-pink-100">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 font-serif">Buku Baru di Taman</h2>
                            <p class="text-gray-500 mt-1">Bunga-buku baru yang baru mekar</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('books.index', ['sort' => 'terbaru']) }}" class="bg-gradient-to-r from-pink-400 to-purple-500 text-white px-6 py-3 rounded-xl hover:from-pink-500 hover:to-purple-600 font-semibold flex items-center gap-2 group transition-all duration-300 shadow-lg hover:shadow-xl">
                    Lihat Semua 
                    <span class="transform group-hover:translate-x-2 transition-transform">&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @if(isset($newBooks) && $newBooks->count() > 0)
                    @foreach($newBooks as $book)
                        <div class="group cursor-pointer">
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 border border-pink-100 h-full flex flex-col relative">
                                <!-- Glow effect -->
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-pink-400 to-purple-500 rounded-2xl blur opacity-0 group-hover:opacity-20 transition duration-1000"></div>
                                
                                <!-- Book Cover -->
                                <div class="h-80 w-full relative overflow-hidden bg-gradient-to-br from-pink-50 to-purple-50 z-10">
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                             alt="{{ $book->judul }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    @else
                                        <div class="flex items-center justify-center h-full">
                                            <div class="w-32 h-40 bg-gradient-to-br from-pink-300 to-purple-400 rounded-lg shadow-inner flex items-center justify-center">
                                                <span class="text-5xl text-white">✨</span>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Category Badge -->
                                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-purple-700 text-xs px-3 py-1.5 rounded-full font-semibold shadow-md border border-purple-200">
                                        {{ $book->kategori }}
                                    </div>
                                    
                                    <!-- New Badge -->
                                    <div class="absolute top-4 left-4 bg-gradient-to-r from-pink-400 to-purple-500 text-white text-xs px-3 py-1.5 rounded-full font-bold shadow-lg flex items-center gap-1">
                                        <span>🌸</span> BARU
                                    </div>
                                </div>

                                <!-- Book Info -->
                                <div class="p-6 flex flex-col flex-grow z-10">
                                    <h3 class="font-bold text-gray-900 text-lg mb-2 leading-tight line-clamp-2 group-hover:text-purple-600 transition-colors duration-300">
                                        {{ $book->judul }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-1 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-pink-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M16 12h2v4h-2z"></path>
                                            <path d="M20 8H4v10h16V8zm-2 8H6v-6h12v6z"></path>
                                        </svg>
                                        {{ $book->penulis }}
                                    </p>
                                    
                                    <!-- Description -->
                                    <p class="text-gray-500 text-sm mt-3 mb-4 line-clamp-2 flex-grow italic">
                                        "Bunga baru di taman ajaib kami..."
                                    </p>
                                    
                                    <!-- Action Button -->
                                    <div class="mt-auto pt-4 border-t border-pink-100">
                                        <a href="{{ route('books.show', $book->id) }}" 
                                           class=" w-full text-center bg-gradient-to-r from-pink-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-pink-600 hover:to-purple-700 transition-all duration-300 shadow-md hover:shadow-lg active:scale-95 flex items-center justify-center gap-2 group/btn">
                                            <span class="group-hover/btn:rotate-12 transition-transform">📖</span>
                                            Lihat Buku
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full text-center py-16 bg-gradient-to-br from-pink-50 to-purple-50 rounded-2xl border-2 border-dashed border-pink-200">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-pink-200 to-purple-300 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600 text-lg font-medium">Belum ada bunga baru mekar...</p>
                        <p class="text-gray-400 text-sm mt-2">Nantikan keajaiban berikutnya! 🌸</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Popular Books Section -->
        <div>
            <div class="flex justify-between items-end mb-10 pb-6 border-b border-purple-100">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 font-serif">Bintang Taman</h2>
                            <p class="text-gray-500 mt-1">Buku-buku paling bersinar</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('books.index', ['sort' => 'rating_tertinggi']) }}" class="bg-gradient-to-r from-purple-400 to-blue-500 text-white px-6 py-3 rounded-xl hover:from-purple-500 hover:to-blue-600 font-semibold flex items-center gap-2 group transition-all duration-300 shadow-lg hover:shadow-xl">
                    Lihat Semua 
                    <span class="transform group-hover:translate-x-2 transition-transform">&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @if(isset($popularBooks) && $popularBooks->count() > 0)
                    @foreach($popularBooks as $book)
                        <div class="group cursor-pointer">
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 border border-blue-100 h-full flex flex-col relative">
                                <!-- Glow effect -->
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-400 to-blue-500 rounded-2xl blur opacity-0 group-hover:opacity-20 transition duration-1000"></div>
                                
                                <!-- Book Cover -->
                                <div class="h-80 w-full relative overflow-hidden bg-gradient-to-br from-purple-50 to-blue-50 z-10">
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                             alt="{{ $book->judul }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    @else
                                        <div class="flex items-center justify-center h-full">
                                            <div class="w-32 h-40 bg-gradient-to-br from-purple-300 to-blue-400 rounded-lg shadow-inner flex items-center justify-center">
                                                <span class="text-5xl text-white">⭐</span>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Rating Badge -->
                                    <div class="absolute top-4 right-4 bg-gradient-to-r from-yellow-300 to-yellow-400 text-gray-800 text-sm px-4 py-2 rounded-full font-bold shadow-lg flex items-center gap-1">
                                        ⭐ {{ $book->rating }}
                                    </div>
                                    
                                    <!-- Popular Badge -->
                                    <div class="absolute top-4 left-4 bg-gradient-to-r from-pink-400 to-purple-500 text-white text-xs px-3 py-1.5 rounded-full font-bold shadow-lg flex items-center gap-1">
                                        <span>🌟</span> TERBAIK
                                    </div>
                                </div>

                                <!-- Book Info -->
                                <div class="p-6 flex flex-col flex-grow z-10">
                                    <h3 class="font-bold text-gray-900 text-lg mb-2 leading-tight line-clamp-2 group-hover:text-purple-600 transition-colors duration-300">
                                        {{ $book->judul }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-1 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M16 12h2v4h-2z"></path>
                                            <path d="M20 8H4v10h16V8zm-2 8H6v-6h12v6z"></path>
                                        </svg>
                                        {{ $book->penulis }}
                                    </p>
                                    
                                    <!-- Description -->
                                    <p class="text-gray-500 text-sm mt-3 mb-4 line-clamp-2 flex-grow italic">
                                        "Bintang yang paling bersinar di langit kami..."
                                    </p>
                                    
                                    <!-- Action Button -->
                                    <div class="mt-auto pt-4 border-t border-purple-100">
                                        <a href="{{ route('books.show', $book->id) }}" 
                                           class=" w-full text-center bg-gradient-to-r from-purple-500 to-blue-600 text-white py-3 rounded-xl font-semibold hover:from-purple-600 hover:to-blue-700 transition-all duration-300 shadow-md hover:shadow-lg active:scale-95 flex items-center justify-center gap-2 group/btn">
                                            <span class="group-hover/btn:rotate-12 transition-transform">📚</span>
                                            Baca Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full text-center py-16 bg-gradient-to-br from-purple-50 to-blue-50 rounded-2xl border-2 border-dashed border-purple-200">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-purple-200 to-blue-300 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600 text-lg font-medium">Belum ada bintang yang bersinar...</p>
                        <p class="text-gray-400 text-sm mt-2">Rating akan muncul seperti bintang di malam hari ✨</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Decorative Bottom Pattern -->
    <div class="container mx-auto px-4 py-12">
        <div class="text-center relative">
            <!-- Magic sparkles -->
            <div class="absolute left-1/4 top-1/2 w-3 h-3 bg-pink-300 rounded-full opacity-60 animate-ping"></div>
            <div class="absolute right-1/4 top-1/2 w-2 h-2 bg-purple-300 rounded-full opacity-70 animate-pulse"></div>
            
            <div class="inline-flex items-center gap-4 text-gray-400">
                <div class="h-px w-32 bg-gradient-to-r from-transparent via-pink-300 to-transparent"></div>
                <div class="flex items-center gap-2">
                    <span class="text-2xl">✨</span>
                    <span class="text-sm text-gray-500 font-serif">Setiap buku adalah pintu ke taman ajaib</span>
                    <span class="text-2xl">🌸</span>
                </div>
                <div class="h-px w-32 bg-gradient-to-l from-transparent via-purple-300 to-transparent"></div>
            </div>
        </div>
    </div>
@endsection