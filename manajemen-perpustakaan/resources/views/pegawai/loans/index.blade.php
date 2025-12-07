@extends('pegawai.app')

@section('title', 'Transaksi Peminjaman & Pengembalian')

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Transaksi Peminjaman</h1>
        <p class="text-gray-600">Kelola semua transaksi peminjaman dan pengembalian buku</p>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-gradient-to-r from-green-100 to-green-50 border border-green-200 rounded-2xl text-green-700 flex items-center gap-2">
            <span>✅</span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-gradient-to-r from-red-100 to-red-50 border border-red-200 rounded-2xl text-red-700 flex items-center gap-2">
            <span>⚠️</span>
            {{ session('error') }}
        </div>
    @endif

    <!-- Table Container -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-pink-50 to-purple-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Buku</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Peminjam</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Jatuh Tempo</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status Waktu</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Denda</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                @foreach($loans as $index => $loan)
                    @php
                        // === 1. LOGIKA AUTO-FIX DATABASE (PENTING) ===
                        // Memperbaiki data lama yang terlanjur minus di database
                        if ($loan->denda < 0) {
                            $fixDenda = abs($loan->denda);
                            $loan->update(['denda' => $fixDenda]);
                            $loan->denda = $fixDenda; 
                        }

                        // === 2. SETUP TANGGAL (Wajib startOfDay agar hasil bulat) ===
                        // startOfDay() memaksa jam menjadi 00:00:00, menghilangkan desimal
                        $jatuhTempo = \Carbon\Carbon::parse($loan->tanggal_jatuh_tempo)->startOfDay();
                        $today = \Carbon\Carbon::now()->startOfDay();
                        $isFinished = ($loan->status == 'dikembalikan');
                        
                        // Tentukan tanggal hitung (Hari ini atau Tanggal Kembali)
                        if ($isFinished && $loan->tanggal_kembali) {
                            // FIX: Pakai startOfDay() di sini juga agar tidak desimal
                            $tanggalHitung = \Carbon\Carbon::parse($loan->tanggal_kembali)->startOfDay();
                        } else {
                            $tanggalHitung = $today;
                        }

                        // === 3. HITUNG SELISIH HARI (Hasil Pasti Integer) ===
                        // false = agar bisa minus kalau telat
                        $diff = $tanggalHitung->diffInDays($jatuhTempo, false);
                        $isLate = $diff < 0; 
                        
                        // Variabel bantuan untuk angka hari (tanpa minus)
                        $angkaHari = abs($diff); 

                        // === 4. UPDATE DENDA REAL-TIME (Jika Berjalan) ===
                        // Hitung ulang denda jika buku belum kembali dan statusnya telat
                        if (!$isFinished && $isLate) {
                            $dendaPerHari = $loan->book->denda_per_hari ?? 2000;
                            $totalDenda = $angkaHari * $dendaPerHari;

                            // Update DB jika angka beda atau status belum tertunggak
                            if ($loan->denda != $totalDenda || $loan->denda_status != 'tertunggak') {
                                $loan->update([
                                    'denda' => $totalDenda,
                                    'denda_status' => 'tertunggak'
                                ]);
                                $loan->denda = $totalDenda;
                                $loan->denda_status = 'tertunggak';
                            }
                        }

                        // === 5. STATUS WAKTU (TAMPILAN UI) ===
                        if (!$isFinished) {
                            // STATUS: DIPINJAM
                            if ($diff > 0) {
                                $sisaHariText = $angkaHari . ' hari tersisa';
                                $timeStatusClass = 'px-3 py-1.5 text-xs rounded-full font-bold bg-green-100 text-green-700';
                            } elseif ($diff == 0) {
                                $sisaHariText = 'Hari ini batas akhir';
                                $timeStatusClass = 'px-3 py-1.5 text-xs rounded-full font-bold bg-yellow-100 text-yellow-700';
                            } else {
                                // Telat (Sedang berjalan)
                                $sisaHariText = 'Terlambat ' . $angkaHari . ' hari';
                                $timeStatusClass = 'px-3 py-1.5 text-xs rounded-full font-bold bg-red-100 text-red-700 animate-pulse';
                            }
                        } else {
                            // STATUS: DIKEMBALIKAN
                            // Karena sudah pakai startOfDay, $diff pasti bulat. Tidak perlu ceil() lagi.
                            if ($isLate) {
                                $sisaHariText = 'Selesai (Telat ' . $angkaHari . ' hari)';
                                $timeStatusClass = 'px-3 py-1.5 text-xs rounded-full font-bold bg-red-50 text-red-600';
                            } else {
                                $sisaHariText = 'Selesai (Tepat Waktu)';
                                $timeStatusClass = 'px-3 py-1.5 text-xs rounded-full font-bold bg-gray-100 text-gray-600';
                            }
                        }
                    @endphp

                    <tr class="hover:bg-gradient-to-r hover:from-pink-50/50 hover:to-purple-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                @if($loan->book->cover_image)
                                    <div class="w-10 h-14 rounded overflow-hidden bg-gradient-to-br from-pink-100 to-purple-100">
                                        <img src="{{ asset('storage/' . $loan->book->cover_image) }}" alt="{{ $loan->book->judul }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-10 h-14 rounded bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center">
                                        <span class="text-pink-400">📚</span>
                                    </div>
                                @endif
                                <span class="font-medium text-gray-900">{{ $loan->book->judul }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-sm">
                                    {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                                </div>
                                <span class="text-gray-700">{{ $loan->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700 text-center">
                            {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700 text-center">
                            {{ $jatuhTempo->format('d/m/Y') }}
                        </td>
                        
                        {{-- Kolom Status Waktu --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="{{ $timeStatusClass }}">
                                {{ $sisaHariText }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 text-xs rounded-full font-bold shadow-sm
                                {{ $loan->status == 'dikembalikan' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ strtoupper($loan->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($loan->denda > 0)
                                <div class="flex flex-col items-start">
                                    <span class="font-bold text-red-600">Rp {{ number_format($loan->denda, 0, ',', '.') }}</span>
                                    <span class="text-xs font-semibold {{ $loan->denda_status == 'tertunggak' ? 'text-red-500' : 'text-green-500' }}">
                                        {{ ucfirst($loan->denda_status) }}
                                    </span>
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col gap-2">
                                @if($loan->status === 'dipinjam')
                                    <form action="{{ route('pegawai.loans.processReturn', $loan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin memproses pengembalian?');">
                                        @csrf
                                        <button class="w-full px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-all duration-300 shadow hover:shadow-md text-sm font-medium flex items-center justify-center gap-1">
                                            <span>📥</span> Kembalikan
                                        </button>
                                    </form>
                                @endif

                                {{-- Tombol Lunasi Denda --}}
                                @if($loan->denda_status === 'tertunggak' && $loan->denda > 0)
                                    <form action="{{ route('pegawai.loans.markFinePaid', $loan->id) }}" method="POST" onsubmit="return confirm('Yakin denda sudah dibayar?');">
                                        @csrf
                                        <button class="w-full px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg transition-all duration-300 shadow hover:shadow-md text-sm font-medium flex items-center justify-center gap-1">
                                            <span>💰</span> Lunasi Denda
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection