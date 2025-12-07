@extends('mahasiswa.app')

@section('title', 'Notifikasi Mahasiswa')

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            <span class="text-yellow-500">🔔</span>
            Notifikasi Saya
        </h1>
        <p class="text-gray-600">Pesan dan pemberitahuan penting untuk Anda</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-gradient-to-r from-green-100 to-green-50 border border-green-200 rounded-2xl text-green-700 flex items-center gap-2">
            <span>✅</span>
            {{ session('success') }}
        </div>
    @endif

    <!-- Notifications Container -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-pink-100">
        @forelse($notifications as $notif)
            <div class="p-6 border-b border-gray-100 last:border-b-0 
                       hover:bg-gradient-to-r hover:from-pink-50/50 hover:to-purple-50/50 transition-colors
                       {{ !$notif->read ? 'bg-gradient-to-r from-yellow-50/30 to-orange-50/30' : '' }}">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    
                    <!-- Notification Content -->
                    <div class="flex-1">
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0
                                {{ $notif->read ? 'bg-gradient-to-br from-gray-100 to-gray-200' : 'bg-gradient-to-br from-yellow-400 to-orange-500' }}">
                                <span class="text-lg">
                                    @if(str_contains(strtolower($notif->title ?? ''), 'denda'))
                                        💰
                                    @elseif(str_contains(strtolower($notif->message ?? ''), 'peminjaman'))
                                        📚
                                    @elseif(str_contains(strtolower($notif->message ?? ''), 'pengembalian'))
                                        📥
                                    @elseif(str_contains(strtolower($notif->message ?? ''), 'jatuh tempo'))
                                        ⚠️
                                    @else
                                        🔔
                                    @endif
                                </span>
                            </div>
                            
                            <!-- Text Content -->
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="font-bold text-gray-800 text-lg">{{ $notif->title ?? 'Notifikasi' }}</h3>
                                    @if(!$notif->read)
                                        <span class="px-2 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-yellow-400 to-orange-500 text-white animate-pulse">
                                            BARU
                                        </span>
                                    @endif
                                </div>
                                <p class="text-gray-700 mb-3">{{ $notif->message }}</p>
                                <p class="text-gray-400 text-sm flex items-center gap-2">
                                    <span>🕒</span>
                                    {{ $notif->created_at->locale('id')->translatedFormat('d M Y • H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="md:ml-4 shrink-0">
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold shadow-sm
                            {{ $notif->read ? 'bg-gradient-to-r from-green-100 to-green-200 text-green-700' : 'bg-gradient-to-r from-red-100 to-red-200 text-red-700' }}">
                            {{ $notif->read ? '✓ Sudah Dibaca' : '✗ Belum Dibaca' }}
                        </span>
                    </div>

                </div>

                <!-- Action Buttons (Optional - bisa ditambahkan jika ada action) -->
                @if(!$notif->read && str_contains(strtolower($notif->message ?? ''), 'denda'))
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('mahasiswa.loans.index') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 text-sm font-medium shadow hover:shadow-md">
                            <span>💳</span> Lihat Detail Peminjaman
                        </a>
                    </div>
                @endif

            </div>
        @empty
            <!-- Empty State -->
            <div class="p-12 text-center">
                <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                    <span class="text-3xl">📭</span>
                </div>
                <p class="text-gray-600 text-lg mb-2">Tidak ada notifikasi baru</p>
                <p class="text-gray-400 text-sm">Semua pesan sudah Anda baca</p>
            </div>
        @endforelse
    </div>

    <!-- Notification Tips -->
    @if($notifications->count() > 0)
        <div class="mt-8 bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl p-6 border border-pink-100">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-purple-500 rounded-lg flex items-center justify-center">
                    <span class="text-white">💡</span>
                </div>
                <h3 class="font-bold text-gray-800">Tips Notifikasi</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-start gap-3 p-3 bg-white rounded-xl border border-pink-100">
                    <span class="text-pink-500">🔔</span>
                    <div>
                        <p class="font-medium text-gray-800">Notifikasi Baru</p>
                        <p class="text-sm text-gray-600">Ditandai dengan badge kuning-orange</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-3 bg-white rounded-xl border border-purple-100">
                    <span class="text-purple-500">💰</span>
                    <div>
                        <p class="font-medium text-gray-800">Pemberitahuan Denda</p>
                        <p class="text-sm text-gray-600">Aksi cepat untuk menghindari penalti</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection