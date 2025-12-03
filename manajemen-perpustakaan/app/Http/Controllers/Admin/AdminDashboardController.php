<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Loan;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalPegawai = User::where('role', 'pegawai')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalBuku = Book::count();
        $totalPeminjaman = Loan::count();
        $peminjamanAktif = Loan::where('status', 'dipinjam')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalMahasiswa',
            'totalPegawai',
            'totalAdmin',
            'totalBuku',
            'totalPeminjaman',
            'peminjamanAktif'
        ))->with('pageHeader', 'Dashboard Admin'); 
    }
}