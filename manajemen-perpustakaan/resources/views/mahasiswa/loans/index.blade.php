@extends('mahasiswa.app')

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            <span class="text-pink-500">📋</span>
            Riwayat Peminjaman Saya
        </h1>
        <p class="text-gray-600">Semua riwayat peminjaman buku Anda di Taman Buku</p>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-pink-50 to-purple-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Buku</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Jatuh Tempo</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Sisa Hari</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Denda</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($loans as $index => $loan)
                    @php
                        $jatuhTempo = \Carbon\Carbon::parse($loan->tanggal_jatuh_tempo)->startOfDay();
                        $today = \Carbon\Carbon::now()->startOfDay();
                        $isFinished = ($loan->status == 'dikembalikan');
                        
                        $tanggalHitung = ($isFinished && $loan->tanggal_kembali) 
                            ? \Carbon\Carbon::parse($loan->tanggal_kembali)->startOfDay() 
                            : $today;

                        $diff = $tanggalHitung->diffInDays($jatuhTempo, false);
                        
                        // UI Logic
                        if (!$isFinished) {
                            if ($diff > 0) {
                                $textHari = $diff . ' hari lagi';
                                $hariClass = 'px-3 py-1.5 text-xs rounded-full font-bold bg-green-100 text-green-700';
                            } elseif ($diff == 0) {
                                $textHari = 'Hari ini';
                                $hariClass = 'px-3 py-1.5 text-xs rounded-full font-bold bg-yellow-100 text-yellow-700';
                            } else {
                                $textHari = 'Telat ' . abs($diff) . ' hari';
                                $hariClass = 'px-3 py-1.5 text-xs rounded-full font-bold bg-red-100 text-red-700 animate-pulse';
                            }
                        } else {
                            $textHari = ($diff < 0) ? 'Selesai (Telat)' : 'Selesai';
                            $hariClass = 'px-3 py-1.5 text-xs rounded-full font-bold bg-gray-100 text-gray-600';
                        }

                        // Tampilan Denda
                        $dendaShow = abs($loan->denda);
                    @endphp

                    <tr class="hover:bg-gradient-to-r hover:from-pink-50/50 hover:to-purple-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                @if($loan->book->cover_image)
                                    <div class="w-10 h-14 rounded overflow-hidden bg-gradient-to-br from-pink-100 to-purple-100">
                                        <img src="{{ asset('storage/' . $loan->book->cover_image) }}" 
                                             alt="{{ $loan->book->judul }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-10 h-14 rounded bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center">
                                        <span class="text-pink-400">📚</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900">{{ $loan->book->judul }}</p>
                                    <p class="text-xs text-gray-500">{{ $loan->book->penulis }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                            {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                            {{ $jatuhTempo->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="{{ $hariClass }}">
                                {{ $textHari }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 text-xs rounded-full font-bold 
                                {{ $loan->status == 'dipinjam' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($dendaShow > 0)
                                <div class="flex flex-col">
                                    <span class="font-bold text-red-600">Rp {{ number_format($dendaShow, 0, ',', '.') }}</span>
                                    <span class="text-xs {{ $loan->denda_status == 'tertunggak' ? 'text-red-500' : 'text-green-500' }}">
                                        {{ ucfirst($loan->denda_status) }}
                                    </span>
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('mahasiswa.loans.show', $loan->id) }}" 
                               class="px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-lg hover:from-pink-600 hover:to-purple-700 transition-all duration-300 shadow hover:shadow-md text-sm font-medium flex items-center gap-1">
                                <span>👁️</span> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <!-- Empty State -->
                    <tr>
                        <td colspan="8" class="p-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-3xl">📭</span>
                                </div>
                                <p class="text-gray-600 text-lg mb-2">Belum ada riwayat peminjaman</p>
                                <p class="text-gray-400 text-sm mb-4">Mulai pinjam buku pertama Anda!</p>
                                <a href="{{ route('mahasiswa.books.index') }}" 
                                   class="px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-xl hover:from-pink-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl text-sm font-medium flex items-center gap-2">
                                    <span>📚</span> Jelajahi Buku
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tips Section -->
    @if($loans->count() > 0)
        <div class="mt-8 bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl p-6 border border-pink-100">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-purple-500 rounded-lg flex items-center justify-center">
                    <span class="text-white">💡</span>
                </div>
                <h3 class="font-bold text-gray-800">Tips Membaca</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-start gap-3 p-3 bg-white rounded-xl border border-pink-100">
                    <span class="text-pink-500">📅</span>
                    <div>
                        <p class="font-medium text-gray-800">Perhatikan Waktu</p>
                        <p class="text-sm text-gray-600">Kembalikan tepat waktu untuk menghindari denda</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-3 bg-white rounded-xl border border-purple-100">
                    <span class="text-purple-500">⭐</span>
                    <div>
                        <p class="font-medium text-gray-800">Beri Ulasan</p>
                        <p class="text-sm text-gray-600">Bagikan pengalaman membaca Anda setelah mengembalikan</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-3 bg-white rounded-xl border border-blue-100">
                    <span class="text-blue-500">📚</span>
                    <div>
                        <p class="font-medium text-gray-800">Eksplorasi Baru</p>
                        <p class="text-sm text-gray-600">Temukan genre baru setiap bulan</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection