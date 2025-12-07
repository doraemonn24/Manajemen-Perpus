@extends('admin.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-pink-100">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            <span class="text-pink-500">➕</span>
            Tambah Pengguna Baru
        </h2>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama -->
            <div>
                <label class="block mb-2 text-gray-700 font-medium">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                       class="w-full px-4 py-3 border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-300 outline-none transition bg-white">
                @error('name')
                    <span class="text-pink-500 text-sm mt-1 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-2 text-gray-700 font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                       class="w-full px-4 py-3 border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-300 focus:border-purple-300 outline-none transition bg-white">
                @error('email')
                    <span class="text-purple-500 text-sm mt-1 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block mb-2 text-gray-700 font-medium">Password</label>
                <input type="password" name="password" required 
                       class="w-full px-4 py-3 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-300 focus:border-blue-300 outline-none transition bg-white">
                @error('password')
                    <span class="text-blue-500 text-sm mt-1 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label class="block mb-2 text-gray-700 font-medium">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required 
                       class="w-full px-4 py-3 border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-300 outline-none transition bg-white">
            </div>

            <!-- Role -->
            <div>
                <label class="block mb-2 text-gray-700 font-medium">Role</label>
                <select name="role" required 
                        class="w-full px-4 py-3 border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-300 focus:border-purple-300 outline-none transition bg-white">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                    <option value="pegawai" {{ old('role')=='pegawai' ? 'selected' : '' }}>Pegawai</option>
                    <option value="mahasiswa" {{ old('role')=='mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                </select>
                @error('role')
                    <span class="text-purple-500 text-sm mt-1 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-xl hover:from-gray-500 hover:to-gray-600 transition-all duration-300 shadow hover:shadow-lg flex-1 text-center">
                    Kembali
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-xl hover:from-pink-600 hover:to-purple-700 transition-all duration-300 shadow hover:shadow-lg flex-1">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection