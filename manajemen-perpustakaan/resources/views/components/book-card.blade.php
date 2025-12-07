<div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition duration-300 border border-gray-100 group flex flex-col h-full">
    <div class="h-72 w-full bg-gray-100 relative overflow-hidden">
        @if($book->cover_image)
            <img src="{{ asset('storage/' . $book->cover_image) }}" 
                 alt="{{ $book->judul }}" 
                 class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
        @else
            <div class="flex items-center justify-center h-full text-gray-400 bg-gray-200">
                <span class="text-5xl">📖</span>
            </div>
        @endif
        
        <div class="absolute top-3 right-3 bg-black/70 backdrop-blur-sm text-white text-xs px-3 py-1 rounded-full font-medium">
            {{ $book->kategori }}
        </div>

        <div class="absolute top-3 left-3 bg-yellow-400 text-white text-xs px-3 py-1 rounded-full font-bold shadow-lg flex items-center gap-1">
            ⭐ {{ $book->rating }}
        </div>
    </div>

    <div class="p-5 flex flex-col flex-grow">
        <h3 class="font-bold text-gray-900 text-lg mb-1 leading-tight line-clamp-2 hover:text-blue-600 transition" title="{{ $book->judul }}">
            {{ $book->judul }}
        </h3>
        <p class="text-sm text-gray-500 mb-4">{{ $book->penulis }}</p>
        
        <div class="mt-auto">
            <a href="{{ route('books.show', $book->id) }}" class="block w-full text-center bg-blue-50 text-blue-600 border border-blue-200 py-2 rounded-lg font-semibold hover:bg-blue-600 hover:text-white transition">
                Detail Buku
            </a>
        </div>
    </div>
</div>