<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MahasiswaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::now()->startOfDay();

        // Ambil semua pinjaman user beserta buku untuk hitung denda
        $loans = Loan::where('user_id', $user->id)
                     ->with('book')
                     ->get();

        $total_denda = 0;
        $pinjaman_aktif = [];

        foreach ($loans as $loan) {
            if ($loan->status === 'dipinjam') {
                $pinjaman_aktif[] = $loan;

                $dueDate = Carbon::parse($loan->tanggal_jatuh_tempo)->startOfDay();

                if ($today->greaterThan($dueDate)) {
                    $lateDays = $today->diffInDays($dueDate);
                    $denda = $lateDays * $loan->book->denda_per_hari;

                    $total_denda += $denda;

                    // Update database agar konsisten
                    $loan->update([
                        'denda' => $denda,
                        'denda_status' => 'tertunggak'
                    ]);
                }
            }
        }

        $pinjaman_aktif = collect($pinjaman_aktif)->sortBy('tanggal_jatuh_tempo');

        $total_pinjaman = $loans->count();
        $pinjaman_terlambat = $loans->where('denda_status', 'tertunggak')->count();

        // Perbaikan notifikasi
        $notifikasi = Notification::where('user_id', $user->id)
                                  ->orderBy('created_at', 'desc')
                                  ->limit(5)
                                  ->get();

        $notifikasi_belum_dibaca = Notification::where('user_id', $user->id)
                                              ->where('read', false)
                                              ->count();

        $books_to_review = Loan::where('user_id', $user->id)
                               ->where('status', 'dikembalikan')
                               ->whereDoesntHave('review')
                               ->with('book')
                               ->get();

        $total_buku = \App\Models\Book::where('stok', '>', 0)->count();

        return view('mahasiswa.dashboard', compact(
            'pinjaman_aktif',
            'total_pinjaman',
            'pinjaman_terlambat',
            'total_denda',
            'notifikasi',
            'notifikasi_belum_dibaca',
            'books_to_review',
            'total_buku'
        ));
    }
}
