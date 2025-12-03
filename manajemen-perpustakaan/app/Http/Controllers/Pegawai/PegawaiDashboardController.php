<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class PegawaiDashboardController extends Controller
{
    public function index()
    {
        $total_buku = Book::count();
        $total_stok = Book::sum('stok');
        $pinjaman_aktif = Loan::where('status', 'dipinjam')->count();
        $pinjaman_terlambat = Loan::where('status', 'dipinjam')->where('tanggal_jatuh_tempo', '<', now())->count();
        $user = Auth::user();
        $notifikasi = Notification::where('user_id', $user->id)->latest()->limit(5)->get();

        return view('pegawai.dashboard', compact(
            'total_buku',
            'total_stok',
            'pinjaman_aktif',
            'pinjaman_terlambat',
            'notifikasi'
        ))->with('pageHeader', 'Dashboard Pegawai');
    }
}
