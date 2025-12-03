<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PegawaiLoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('book', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pegawai.loans.index', compact('loans'))
            ->with('pageHeader', 'Transaksi Peminjaman & Pengembalian');
    }

    public function processLoan(Request $request)
    {
        $book = Book::findOrFail($request->book_id);
        $userId = $request->user_id;

        if ($book->stok < 1) {
            return redirect()->back()->with('error', 'Stok buku tidak mencukupi.');
        }

        $hasDebt = Loan::where('user_id', $userId)
            ->where('denda_status', 'tertunggak')
            ->exists();

        if ($hasDebt) {
            return redirect()->back()->with('error', 'Mahasiswa ini memiliki denda tertunggak. Tidak dapat meminjam.');
        }

        $book->decrement('stok');

        $loan = Loan::create([
            'user_id' => $userId,
            'book_id' => $book->id,
            'status' => 'dipinjam',
            'tanggal_pinjam' => now(),
            'tanggal_jatuh_tempo' => Carbon::now()->addDays(7)->endOfDay(), 
            'tanggal_kembali' => null,
            'denda' => 0,
            'denda_status' => 'lunas'
        ]);

        \App\Http\Controllers\Mahasiswa\MahasiswaNotificationController::send(
            $userId,
            'Berhasil Meminjam Buku',
            "Buku “{$book->judul}” berhasil dipinjam.",
            'loan',
            $loan->id
        );

        return redirect()->back()->with('success', 'Peminjaman berhasil diproses.');
    }

    public function processReturn(Loan $loan)
    {
        if ($loan->status === 'dikembalikan') {
            return redirect()->back()->with('warning', 'Buku sudah dikembalikan sebelumnya.');
        }

        $loan->tanggal_kembali = now();
        $loan->book->increment('stok');

        $dueDate = Carbon::parse($loan->tanggal_jatuh_tempo)->startOfDay();
        $returnedDate = Carbon::parse($loan->tanggal_kembali)->startOfDay();

        if ($returnedDate->greaterThan($dueDate)) {
            $daysLate = abs($returnedDate->diffInDays($dueDate));
            $fineTotal = abs($daysLate * $loan->book->denda_per_hari);
            $loan->denda = $fineTotal; 
            $loan->denda_status = 'tertunggak';

            \App\Http\Controllers\Mahasiswa\MahasiswaNotificationController::send(
                $loan->user_id,
                'Denda Keterlambatan',
                "Denda Rp " . number_format($fineTotal, 0, ',', '.') .
                " untuk buku “{$loan->book->judul}”. Harap segera melakukan pelunasan.",
                'loan',
                $loan->id
            );
        } else {
            $loan->denda = 0;
            $loan->denda_status = 'lunas';
        }

        $loan->status = 'dikembalikan';
        $loan->save(); 

        return redirect()->back()->with('success', 'Pengembalian buku berhasil diproses.');
    }

    public function markFinePaid(Loan $loan)
    {
        if ($loan->denda <= 0) {
            return redirect()->back()->with('info', 'Tidak ada denda positif yang perlu dilunasi.');
        }
        $loan->update([
            'denda_status' => 'lunas'
        ]);

        if (class_exists(\App\Http\Controllers\Mahasiswa\MahasiswaNotificationController::class) && method_exists(\App\Http\Controllers\Mahasiswa\MahasiswaNotificationController::class, 'removeFineNotification')) {
            \App\Http\Controllers\Mahasiswa\MahasiswaNotificationController::removeFineNotification(
                $loan->user_id,
                $loan->id
            );
        }

        return redirect()->back()->with('success', 'Denda berhasil ditandai lunas.');
    }
}