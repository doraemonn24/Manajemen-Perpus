@extends('admin.app')
@section('title', 'Manajemen Pengguna')

@section('content')

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Manajemen Pengguna</h1>
        <p class="text-gray-600">Kelola semua pengguna sistem</p>
    </div>
    <a href="{{ route('admin.users.create') }}" 
       class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-3 rounded-xl hover:from-pink-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-2">
        <span>➕</span>
        Tambah Pengguna Baru
    </a>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-gradient-to-r from-green-100 to-green-50 border border-green-200 rounded-2xl text-green-700 flex items-center gap-2">
    <span>✅</span>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-pink-50 to-purple-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Role</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                <tr class="hover:bg-gradient-to-r hover:from-pink-50/50 hover:to-purple-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center text-white text-sm">
                                {{ strtoupper(substr($user->nama ?? $user->name ?? 'U', 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-900">{{ $user->nama ?? $user->name ?? 'Belum Diisi' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1.5 text-xs rounded-full font-medium 
                            @if($user->role == 'admin') bg-red-100 text-red-700
                            @elseif($user->role == 'pegawai') bg-blue-100 text-blue-700
                            @else bg-green-100 text-green-700 @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                               class="px-4 py-2 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-lg hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 shadow hover:shadow-md text-sm font-medium">
                                Edit
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow hover:shadow-md text-sm font-medium"
                                        onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    Hapus
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

@endsection