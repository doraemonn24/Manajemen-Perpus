@extends('admin.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-blue-100">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            <span class="text-blue-500">✏️</span>
            Edit Data Pengguna
        </h2>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div>
                <label class="block mb-2 text-gray-700 font-medium">Nama</label>
                <input type="text" name="name" value="{{ $user->name }}" required 
                       class="w-full px-4 py-3 border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-300 outline-none transition bg-white">
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-2 text-gray-700 font-medium">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required 
                       class="w-full px-4 py-3 border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-300 focus:border-purple-300 outline-none transition bg-white">
            </div>

            <!-- Password -->
            <div>
                <label class="block mb-2 text-gray-700 font-medium">
                    Password <span class="text-gray-500 text-sm">(kosongkan jika tidak diganti)</span>
                </label>
                <input type="password" name="password" 
                       class="w-full px-4 py-3 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-300 focus:border-blue-300 outline-none transition bg-white">
            </div>

            <!-- Role -->
            <div>
                <label class="block mb-2 text-gray-700 font-medium">Role</label>
                <select name="role" required 
                        class="w-full px-4 py-3 border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-300 focus:border-purple-300 outline-none transition bg-white">
                    <option value="admin" @selected($user->role == 'admin')>Admin</option>
                    <option value="pegawai" @selected($user->role == 'pegawai')>Pegawai</option>
                    <option value="mahasiswa" @selected($user->role == 'mahasiswa')>Mahasiswa</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-xl hover:from-gray-500 hover:to-gray-600 transition-all duration-300 shadow hover:shadow-lg flex-1 text-center">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 shadow hover:shadow-lg flex-1">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection