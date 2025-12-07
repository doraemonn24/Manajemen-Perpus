@extends('admin.app')

@section('title', 'Daftar Buku')

@section('content')

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Daftar Buku</h1>
        <p class="text-gray-600">Kelola koleksi buku di Taman Buku</p>
    </div>
    <a href="{{ route('admin.books.create') }}" 
       class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-3 rounded-xl hover:from-pink-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-2">
        <span>📚</span>
        Tambah Buku Baru
    </a>
</div>

<!-- Search Form -->
<div class="mb-8">
    <form method="GET" class="relative">
        <div class="relative">
            <input 
                type="text" 
                name="q" 
                value="{{ request('q') }}" 
                placeholder="Cari judul, penulis, atau kategori..." 
                class="w-full px-6 py-4 border-2 border-pink-100 rounded-2xl focus:ring-2 focus:ring-pink-300 focus:border-pink-300 outline-none transition pl-12"
            >
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </form>
</div>

@if($books->isEmpty())
<div class="bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl border-2 border-dashed border-pink-200 p-12 text-center">
    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-pink-200 to-purple-300 rounded-full flex items-center justify-center">
        <span class="text-3xl">📖</span>
    </div>
    <p class="text-gray-600 text-lg mb-2">Belum ada buku tersedia</p>
    <p class="text-gray-500 text-sm">Tambahkan buku pertama Anda!</p>
</div>
@else
<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-pink-50 to-purple-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Judul</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Penulis</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Kategori</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Stok</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tahun</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($books as $book)
                <tr class="hover:bg-gradient-to-r hover:from-pink-50/50 hover:to-purple-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $books->firstItem() + $loop->index }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            @if($book->cover_image)
                                <div class="w-10 h-14 rounded overflow-hidden bg-gradient-to-br from-pink-100 to-purple-100">
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->judul }}" 
                                         class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-10 h-14 rounded bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center">
                                    <span class="text-pink-400">📚</span>
                                </div>
                            @endif
                            <span class="font-medium text-gray-900">{{ $book->judul }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $book->penulis }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1.5 text-xs rounded-full font-medium bg-pink-100 text-pink-700">
                            {{ $book->kategori }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1.5 text-xs rounded-full font-medium 
                            @if($book->stok > 10) bg-green-100 text-green-700
                            @elseif($book->stok > 0) bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ $book->stok }} buku
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $book->tahun_terbit }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.books.edit', $book) }}" 
                               class="px-4 py-2 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-lg hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 shadow hover:shadow-md text-sm font-medium flex items-center gap-1">
                                <span>✏️</span> Edit
                            </a>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow hover:shadow-md text-sm font-medium flex items-center gap-1"
                                        onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                    <span>🗑️</span> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-8 flex justify-center">
    <div class="flex items-center space-x-2">
        {{ $books->links() }}
    </div>
</div>
@endif

@endsection