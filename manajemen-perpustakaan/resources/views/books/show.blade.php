@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- BREADCRUMB (Navigasi Kecil) --}}
    <nav class="text-sm mb-6 text-gray-500">
        <a href="{{ route('home') }}" class="hover:underline hover:text-blue-600">Home</a> 
        <span class="mx-2">/</span>
        <a href="{{ route('books.index') }}" class="hover:underline hover:text-blue-600">Katalog</a> 
        <span class="mx-2">/</span>
        <span class="text-gray-800 font-bold">{{ $book->judul }}</span>
    </nav>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="flex flex-col md:flex-row">
            
            {{-- KOLOM KIRI: GAMBAR SAMPUL --}}
            <div class="w-full md:w-1/3 bg-gray-50 flex items-center justify-center p-8 border-r border-gray-100">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                         class="rounded-lg shadow-xl max-h-[500px] w-auto object-cover transform hover:scale-105 transition duration-500" 
                         alt="{{ $book->judul }}">
                @else
                    <div class="h-96 w-64 bg-gray-200 flex items-center justify-center rounded-lg text-gray-400 shadow-inner">
                        <div class="text-center">
                            <span class="text-6xl block mb-2">📖</span>
                            <span class="text-sm">No Cover</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- KOLOM KANAN: DETAIL INFORMASI --}}
            <div class="w-full md:w-2/3 p-8 md:p-10">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        {{-- JUDUL --}}
                        <h1 class="text-4xl font-extrabold text-gray-900 mb-2 leading-tight">{{ $book->judul }}</h1>
                        {{-- PENULIS --}}
                        <p class="text-lg text-gray-600">Ditulis oleh <span class="font-semibold text-blue-600">{{ $book->penulis }}</span></p>
                    </div>
                    
                    {{-- RATING & ULASAN --}}
                    <div class="text-right">
                        <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg font-bold text-lg inline-flex items-center gap-1">
                            ⭐ {{ $book->rating }} <span class="text-sm font-normal text-yellow-700">/ 5.0</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">{{ $book->reviews->count() }} Ulasan</p>
                    </div>
                </div>

                <hr class="my-6 border-gray-100">

                {{-- INFORMASI LENGKAP (Grid) --}}
                <div class="grid grid-cols-2 gap-y-4 gap-x-8 text-sm mb-8">
                    <div>
                        <p class="text-gray-500 mb-1">Kategori</p>
                        <p class="font-bold text-gray-800">{{ $book->kategori }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Penerbit & Tahun</p>
                        <p class="font-bold text-gray-800">{{ $book->penerbit }} ({{ $book->tahun_terbit }})</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Maksimal Peminjaman</p>
                        <p class="font-bold text-gray-800">{{ $book->maksimal_waktu_peminjaman }} Hari</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Denda Keterlambatan</p>
                        <p class="font-bold text-red-600">Rp {{ number_format($book->denda_per_hari, 0, ',', '.') }} / hari</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500 mb-1">Status Stok</p>
                        @if($book->stok > 0)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                                ✅ Tersedia ({{ $book->stok }} Buku)
                            </span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                                ❌ Stok Habis
                            </span>
                        @endif
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-8">
                    <h3 class="font-bold text-lg text-gray-900 mb-3 border-b pb-2">Sinopsis / Deskripsi</h3>
                    <p class="text-gray-700 leading-relaxed text-justify">
                        {{ $book->deskripsi ?? 'Tidak ada deskripsi untuk buku ini.' }}
                    </p>
                </div>

                {{-- TOMBOL PINJAM BUKU --}}
                <div class="mt-auto">
                    @auth
                        @if(auth()->user()->role == 'mahasiswa')
                            {{-- Cek Stok --}}
                            @if($book->stok > 0)
                                <form action="{{ route('mahasiswa.books.borrow', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Yakin ingin meminjam buku {{ $book->judul }}?')" 
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-xl transition shadow-lg hover:shadow-blue-200 transform hover:-translate-y-1 flex justify-center items-center gap-2">
                                        <span>📖</span> Ajukan Peminjaman
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full bg-gray-200 text-gray-400 font-bold py-4 px-6 rounded-xl cursor-not-allowed border border-gray-300">
                                    ❌ Maaf, Stok Buku Habis
                                </button>
                            @endif
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-xl text-center">
                                <p class="font-semibold">Mode Pegawai/Admin</p>
                                <p class="text-sm">Anda login sebagai {{ ucfirst(auth()->user()->role) }}. Peminjaman hanya untuk akun Mahasiswa.</p>
                            </div>
                        @endif
                    @else
                        {{-- Jika Belum Login --}}
                        <a href="{{ route('login') }}" class="text-center w-full bg-gray-900 hover:bg-black text-white font-bold py-4 px-6 rounded-xl transition shadow-lg flex justify-center items-center gap-2">
                            <span>🔒</span> Login untuk Meminjam
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </div>

    {{-- BAGIAN ULASAN --}}
    <div class="mt-12 max-w-4xl mx-auto">
        <h3 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            💬 Ulasan Pembaca <span class="text-sm font-normal text-gray-500">({{ $book->reviews->count() }})</span>
        </h3>
        
        <div class="space-y-4">
            @forelse($book->reviews as $review)
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">{{ $review->user->name }}</h4>
                                <div class="text-yellow-400 text-xs">
                                    @for($i=0; $i<$review->rating; $i++) ★ @endfor
                                    @for($i=$review->rating; $i<5; $i++) <span class="text-gray-300">★</span> @endfor
                                </div>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-600 text-sm pl-13 ml-13 border-l-2 border-gray-100 pl-4">
                        "{{ $review->komentar }}"
                    </p>
                </div>
            @empty
                <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500">Belum ada ulasan untuk buku ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection