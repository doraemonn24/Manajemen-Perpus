@extends('admin.app')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="container mx-auto px-4">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Laporan Transaksi</h1>
        <p class="text-gray-600">Monitor semua transaksi peminjaman buku</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-blue-50 to-purple-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Mahasiswa</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Buku</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Jatuh Tempo</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tgl Kembali</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Sisa Hari</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Denda</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($loans as $loan)
                    @php
                        $tanggalPinjam = \Carbon\Carbon::parse($loan->tanggal_pinjam)->startOfDay();
                        $jatuhTempo = \Carbon\Carbon::parse($loan->tanggal_jatuh_tempo)->startOfDay();
                        $today = \Carbon\Carbon::now()->startOfDay();

                        // Sisa hari
                        $tanggalKembali = $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->startOfDay() : null;
                        
                        // Gunakan logika if untuk menentukan titik hitung
                        if ($tanggalKembali) {
                            $sisaHari = $tanggalKembali->diffInDays($jatuhTempo, false);
                        } else {
                            $sisaHari = $today->diffInDays($jatuhTempo, false);
                        }
                        
                        $isLate = $sisaHari < 0; // Jika minus, berarti terlambat

                        // Denda
                        $denda = $loan->denda;
                        $dendaStatus = $loan->denda_status;

                        // FIX: Perhitungan Denda Otomatis di View (Aman dari minus)
                        if ($isLate && ($denda == 0 || $dendaStatus != 'tertunggak') && $loan->status != 'dikembalikan') {
                            $hariTerlambat = abs($sisaHari); // Paksa Positif
                            $denda_per_hari = $loan->book->denda_per_hari ?? 5000;
                            
                            // FIX: Paksa hasil kali jadi positif
                            $hitungDenda = abs($hariTerlambat * $denda_per_hari); 
                            $dendaStatus = 'tertunggak';

                            // Update DB hanya jika perlu (Mencegah query berulang)
                            if($loan->denda != $hitungDenda) {
                                $loan->update([
                                    'denda' => $hitungDenda,
                                    'denda_status' => $dendaStatus
                                ]);
                                $denda = $hitungDenda;
                            }
                        }

                        $sisaHariClass = $isLate ? 'text-red-600 bg-red-50 px-2 py-1 rounded-lg' : 'text-green-600 bg-green-50 px-2 py-1 rounded-lg';
                    @endphp

                    <tr class="hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-purple-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-sm">
                                    {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-900">{{ $loan->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $loan->book->judul }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $loan->tanggal_pinjam }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $loan->tanggal_jatuh_tempo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $loan->tanggal_kembali ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-bold {{ $sisaHariClass }}">
                                @if($sisaHari > 0)
                                    {{ $sisaHari }} hari tersisa
                                @elseif($sisaHari == 0)
                                    Hari ini batas akhir
                                @else
                                    Terlambat {{ abs($sisaHari) }} hari
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 text-xs rounded-full font-bold 
                                @if($loan->status == 'dikembalikan') bg-green-100 text-green-700
                                @elseif($loan->status == 'dipinjam') bg-blue-100 text-blue-700
                                @else bg-yellow-100 text-yellow-700 @endif">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($denda > 0)
                                <div class="flex flex-col">
                                    <strong class="text-red-600">Rp {{ number_format($denda, 0, ',', '.') }}</strong>
                                    <span class="text-xs {{ $dendaStatus == 'lunas' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ ucfirst($dendaStatus) }}
                                    </span>
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                    <span class="text-2xl">📄</span>
                                </div>
                                <p class="text-lg">Belum ada transaksi</p>
                                <p class="text-sm">Data transaksi akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection