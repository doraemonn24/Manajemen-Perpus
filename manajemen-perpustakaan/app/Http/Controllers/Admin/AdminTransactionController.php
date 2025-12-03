<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    /**
     * Tampilkan semua transaksi (read-only)
     */
    public function index()
    {
        $loans = Loan::with(['user', 'book'])
                    ->orderBy('tanggal_pinjam', 'desc')
                    ->paginate();

        return view('admin.transactions.index', compact('loans'))
            ->with('pageHeader', 'Transaksi');
    }
}