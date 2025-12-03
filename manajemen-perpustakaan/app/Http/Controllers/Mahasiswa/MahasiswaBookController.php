<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MahasiswaBookController extends Controller
{
    // Daftar buku (katalog)
    public function index(Request $request)
    {
        $categories = Book::select('kategori')->distinct()->pluck('kategori');

        $books = Book::where('stok', '>', 0);

        if ($request->q) {
            $books->where(function($query) use ($request) {
                $query->where('judul', 'like', '%'.$request->q.'%')
                      ->orWhere('penulis', 'like', '%'.$request->q.'%');
            });
        }

        if ($request->kategori) {
            $books->where('kategori', $request->kategori);
        }

        if ($request->sort) {
            match($request->sort) {
                'tahun_asc' => $books->orderBy('tahun_terbit', 'asc'),
                'tahun_desc' => $books->orderBy('tahun_terbit', 'desc'),
                'rating_desc' => $books->orderBy('rating', 'desc'),
                default => $books->orderBy('judul'),
            };
        } else {
            $books->orderBy('judul');
        }

        $books = $books->paginate(12)->withQueryString();

        return view('mahasiswa.books.index', compact('books', 'categories'))
            ->with('pageHeader', 'Daftar Buku');
    }

    // Detail buku
    public function show(Book $book)
    {
        return view('mahasiswa.books.show', compact('book'))
            ->with('pageHeader', 'Daftar Buku');
    }

    // Pinjam buku
    public function borrow(Book $book)
    {
        $user = Auth::user();

        // Cek stok
        if ($book->stok < 1) {
            return redirect()->back()->with('error', 'Buku ini sedang tidak tersedia.');
        }

        // Cek batas pinjaman aktif
        $activeLoans = Loan::where('user_id', $user->id)
                            ->where('status', 'dipinjam')
                            ->count();

        if ($activeLoans >= 3) {
            return redirect()->back()->with('error', 'Batas pinjaman aktif tercapai (maks 3 buku).');
        }

        // Cek denda tertunggak
        $hasDebt = Loan::where('user_id', $user->id)
                        ->where('denda', '>', 0)
                        ->where('denda_status', 'tertunggak')
                        ->exists();

        if ($hasDebt) {
            return redirect()->back()->with('error', 'Tidak dapat meminjam. Anda memiliki denda tertunggak.');
        }

        // Buat pinjaman baru
        $loan = Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'tanggal_pinjam' => now(),
            'tanggal_jatuh_tempo' => now()->addDays($book->maksimal_waktu_peminjaman),
            'status' => 'dipinjam',
            'denda_status' => 'lunas', // aman sesuai ENUM di DB
            'denda' => 0,
        ]);

        // Kurangi stok buku
        $book->decrement('stok');

        // Buat notifikasi
        Notification::create([
            'user_id' => $user->id,
            'type' => 'peminjaman',
            'title' => 'Berhasil Meminjam Buku',
            'message' => "Buku '{$book->judul}' berhasil dipinjam.",
        ]);

        return redirect()->route('mahasiswa.loans.index')->with('success', 'Buku berhasil dipinjam.');
    }
}
