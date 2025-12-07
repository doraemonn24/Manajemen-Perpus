@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Katalog Buku</h1>

    {{-- FILTER & SORTING TOOLBAR --}}
    <form action="{{ route('books.index') }}" method="GET" class="bg-white p-4 rounded-lg shadow mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
            {{-- 1. Search (Persist) --}}
            <div class="col-span-1 md:col-span-2">
                <label class="text-xs font-bold text-gray-500 uppercase">Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Judul atau Penulis..." 
                       class="w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:border-blue-500">
            </div>

            {{-- 2. Filter Kategori --}}
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase">Kategori</label>
                <select name="kategori" class="w-full border border-gray-300 rounded p-2 mt-1" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 3. Sorting --}}
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase">Urutkan</label>
                <select name="sort" class="w-full border border-gray-300 rounded p-2 mt-1" onchange="this.form.submit()">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru Ditambahkan</option>
                    <option value="rating_tertinggi" {{ request('sort') == 'rating_tertinggi' ? 'selected' : '' }}>Rating Tertinggi</option>
                    <option value="tahun_terbaru" {{ request('sort') == 'tahun_terbaru' ? 'selected' : '' }}>Tahun Terbit (Baru-Lama)</option>
                    <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>
        </div>
    </form>

    {{-- HASIL BUKU --}}
    @if($books->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($books as $book)
                @include('components.book-card', ['book' => $book])
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $books->links() }} 
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">Buku yang Anda cari tidak ditemukan.</p>
            <a href="{{ route('books.index') }}" class="text-blue-600 hover:underline">Reset Filter</a>
        </div>
    @endif
</div>
@endsection