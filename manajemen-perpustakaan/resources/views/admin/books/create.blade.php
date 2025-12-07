@extends('admin.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="bg-gradient-to-br from-pink-50 to-purple-50 p-6 rounded-2xl shadow-lg border border-pink-100">
    <h1 class="text-3xl font-bold mb-6 flex items-center text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-purple-600">
        <svg class="w-8 h-8 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Tambah Buku Baru
    </h1>

    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-purple-100">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class=" font-bold text-gray-700 flex items-center">
                    <span class="w-3 h-3 bg-pink-400 rounded-full mr-2"></span>
                    Judul
                </label>
                <input type="text" name="judul" value="{{ old('judul') }}" 
                       class="w-full p-3 border-2 border-pink-100 rounded-xl focus:border-pink-300 focus:ring-2 focus:ring-pink-200 transition duration-300">
                @error('judul')
                <span class="text-sm text-pink-600 flex items-center mt-1">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </span>
                @enderror
            </div>
            
            <div class="space-y-2">
                <label class="font-bold text-gray-700 flex items-center">
                    <span class="w-3 h-3 bg-purple-400 rounded-full mr-2"></span>
                    Penulis
                </label>
                <input type="text" name="penulis" value="{{ old('penulis') }}" 
                       class="w-full p-3 border-2 border-purple-100 rounded-xl focus:border-purple-300 focus:ring-2 focus:ring-purple-200 transition duration-300">
                @error('penulis')
                <span class="text-sm text-purple-600 flex items-center mt-1">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="space-y-2">
                <label class="font-bold text-gray-700 flex items-center">
                    <span class="w-3 h-3 bg-blue-400 rounded-full mr-2"></span>
                    Penerbit
                </label>
                <input type="text" name="penerbit" value="{{ old('penerbit') }}" 
                       class="w-full p-3 border-2 border-blue-100 rounded-xl focus:border-blue-300 focus:ring-2 focus:ring-blue-200 transition duration-300">
                @error('penerbit')
                <span class="text-sm text-blue-600 flex items-center mt-1">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="space-y-2">
                <label class=" font-bold text-gray-700 flex items-center">
                    <span class="w-3 h-3 bg-purple-400 rounded-full mr-2"></span>
                    Tahun Terbit
                </label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" 
                       class="w-full p-3 border-2 border-purple-100 rounded-xl focus:border-purple-300 focus:ring-2 focus:ring-purple-200 transition duration-300">
                @error('tahun_terbit')
                <span class="text-sm text-purple-600 flex items-center mt-1">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="space-y-2">
                <label class=" font-bold text-gray-700 flex items-center">
                    <span class="w-3 h-3 bg-pink-400 rounded-full mr-2"></span>
                    Kategori
                </label>
                <input type="text" name="kategori" value="{{ old('kategori') }}" 
                       class="w-full p-3 border-2 border-pink-100 rounded-xl focus:border-pink-300 focus:ring-2 focus:ring-pink-200 transition duration-300">
                @error('kategori')
                <span class="text-sm text-pink-600 flex items-center mt-1">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="space-y-2">
                <label class="font-bold text-gray-700 flex items-center">
                    <span class="w-3 h-3 bg-blue-400 rounded-full mr-2"></span>
                    Stok
                </label>
                <input type="number" name="stok" value="{{ old('stok') }}" 
                       class="w-full p-3 border-2 border-blue-100 rounded-xl focus:border-blue-300 focus:ring-2 focus:ring-blue-200 transition duration-300">
                @error('stok')
                <span class="text-sm text-blue-600 flex items-center mt-1">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="space-y-2">
                <label class=" font-bold text-gray-700 flex items-center">
                    <span class="w-3 h-3 bg-purple-400 rounded-full mr-2"></span>
                    Maksimal Peminjaman (hari)
                </label>
                <input type="number" name="maksimal_waktu_peminjaman" value="{{ old('maksimal_waktu_peminjaman') }}" 
                       class="w-full p-3 border-2 border-purple-100 rounded-xl focus:border-purple-300 focus:ring-2 focus:ring-purple-200 transition duration-300">
                @error('maksimal_waktu_peminjaman')
                <span class="text-sm text-purple-600 flex items-center mt-1">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="space-y-2">
                <label class=" font-bold text-gray-700 flex items-center">
                    <span class="w-3 h-3 bg-pink-400 rounded-full mr-2"></span>
                    Denda Per Hari
                </label>
                <input type="number" name="denda_per_hari" value="{{ old('denda_per_hari') }}" 
                       class="w-full p-3 border-2 border-pink-100 rounded-xl focus:border-pink-300 focus:ring-2 focus:ring-pink-200 transition duration-300">
                @error('denda_per_hari')
                <span class="text-sm text-pink-600 flex items-center mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input Sampul Buku --}}
            <div class="space-y-2">
                <label class=" font-bold text-gray-700 flex items-center">
                    <span class="w-3 h-3 bg-blue-400 rounded-full mr-2"></span>
                    Sampul Buku
                </label>
                <div class="relative">
                    <input type="file" name="cover_image" 
                           class="w-full p-3 border-2 border-dashed border-blue-200 rounded-xl bg-blue-50/50 hover:bg-blue-50 transition duration-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-blue-400 file:to-purple-500 file:text-white hover:file:from-blue-500 hover:file:to-purple-600">
                    <div class="absolute right-3 top-3 text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                    </div>
                </div>
                <span class="text-xs text-blue-500 flex items-center mt-1">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    Format: JPG, PNG. Maks: 2MB.
                </span>
                @error('cover_image')
                <br><span class="text-sm text-red-500 flex items-center mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input Deskripsi --}}
            <div class="md:col-span-2 space-y-2">
                <label class="font-bold text-gray-700 flex items-center">
                    <span class="w-3 h-3 bg-gradient-to-r from-pink-400 to-purple-400 rounded-full mr-2"></span>
                    Deskripsi / Sinopsis
                </label>
                <textarea name="deskripsi" rows="4" 
                          class="w-full p-3 border-2 border-gradient-to-r from-pink-100 to-purple-100 rounded-xl focus:border-gradient-to-r focus:from-pink-300 focus:to-purple-300 focus:ring-2 focus:ring-pink-200 transition duration-300">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                <span class="text-sm text-purple-600 flex items-center mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-8 border-t border-purple-100 pt-6">
            <a href="{{ route('admin.books.index') }}" class="px-5 py-3 bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-xl hover:from-gray-500 hover:to-gray-600 transition shadow-md flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Batal
            </a>
            <button type="submit" class="px-5 py-3 bg-gradient-to-r from-pink-400 via-purple-500 to-blue-500 text-white rounded-xl hover:from-pink-500 hover:via-purple-600 hover:to-blue-600 transition shadow-lg flex items-center group">
                <svg class="w-4 h-4 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Simpan Buku
            </button>
        </div>
    </form>
</div>
@endsection