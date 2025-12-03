<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Tampilkan form review
    public function create(Loan $loan)
    {
        // Validasi: pastikan user adalah peminjam dan buku sudah dikembalikan
        if ($loan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($loan->status !== 'dikembalikan') {
            return redirect()->route('mahasiswa.loans.index')
                           ->with('error', 'Hanya bisa mereview buku yang sudah dikembalikan.');
        }

        // Cek apakah sudah pernah review
        $existingReview = Review::where('loan_id', $loan->id)->exists();
        if ($existingReview) {
            return redirect()->route('mahasiswa.loans.index')
                           ->with('error', 'Anda sudah memberikan review untuk peminjaman ini.');
        }

        return view('mahasiswa.reviews.create', compact('loan'))
            ->with('pageHeader', 'Review');
    }

    // Simpan review
    public function store(Request $request, Loan $loan)
    {
        // Validasi authorization
        if ($loan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        Review::create([
            'book_id' => $loan->book_id,
            'user_id' => Auth::id(),
            'loan_id' => $loan->id,  // ← TAMBAHKAN INI untuk tracking
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('mahasiswa.loans.index')
                         ->with('success', 'Ulasan berhasil dikirim.');
    }
}