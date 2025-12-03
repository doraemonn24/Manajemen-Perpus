<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use App\Models\Notification;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MahasiswaLoanController extends Controller
{
    public function index()
    {
        $loans = Loan::where('user_id', Auth::id())
                     ->with(['book', 'review'])
                     ->latest()
                     ->get();

        return view('mahasiswa.loans.index', compact('loans'))
            ->with('pageHeader', 'Peminjaman Buku');
    }

    public function borrow($book_id)
    {
        try {
            $book = Book::findOrFail($book_id);

            if ($book->stok < 1) {
                MahasiswaNotificationController::send(Auth::id(), 'Peminjaman Gagal', "Stok buku '{$book->judul}' habis.");
                return back()->with('error', 'Stok buku habis.');
            }

            // CEK BLOKIR: Jika punya denda tertunggak
            $hasDebt = Loan::where('user_id', Auth::id())
                            ->where('denda_status', 'tertunggak')
                            ->exists();

            if ($hasDebt) {
                MahasiswaNotificationController::send(Auth::id(), 'Akses Ditolak', "Anda memiliki denda tertunggak.");
                return back()->with('error', 'Tidak dapat meminjam. Anda memiliki denda tertunggak.');
            }

            $activeLoans = Loan::where('user_id', Auth::id())
                               ->where('status', 'dipinjam')
                               ->count();

            if ($activeLoans >= 3) {
                MahasiswaNotificationController::send(Auth::id(), 'Melebihi Batas', "Tidak dapat meminjam lebih dari 3 buku aktif.");
                return back()->with('error', 'Tidak dapat meminjam lebih dari 3 buku aktif.');
            }

            $loan = Loan::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'tanggal_pinjam' => Carbon::now(),
                'tanggal_jatuh_tempo' => Carbon::now()->addDays($book->maksimal_waktu_peminjaman),
                'status' => 'dipinjam',
                'denda_status' => 'lunas',
                'perpanjangan_count' => 0,
                'denda' => 0
            ]);

            $book->decrement('stok');

            MahasiswaNotificationController::send(
                Auth::id(),
                'Berhasil Meminjam Buku',
                "Buku '{$book->judul}' berhasil dipinjam. Jatuh tempo: " . $loan->tanggal_jatuh_tempo->format('d-m-Y')
            );

            return back()->with('success', 'Buku berhasil dipinjam.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat meminjam buku.');
        }
    }

    public function renew(Request $request, $id)
    {
        try {
            $loan = Loan::where('user_id', Auth::id())->findOrFail($id);

            $days = (int) $request->input('days', 7);
            if ($days <= 0) $days = 7;

            // Gunakan startOfDay untuk akurasi tanggal
            if (Carbon::now()->startOfDay()->greaterThan(Carbon::parse($loan->tanggal_jatuh_tempo)->startOfDay())) {
                MahasiswaNotificationController::send(
                    Auth::id(),
                    'Perpanjangan Gagal',
                    "Sudah lewat jatuh tempo buku '{$loan->book->judul}'."
                );
                return back()->with('error', 'Tidak dapat memperpanjang. Sudah lewat jatuh tempo.');
            }

            if ($loan->perpanjangan_count >= 1) {
                MahasiswaNotificationController::send(
                    Auth::id(),
                    'Batas Perpanjangan',
                    "Batas perpanjangan buku '{$loan->book->judul}' sudah tercapai."
                );
                return back()->with('error', 'Sudah mencapai batas maksimal perpanjangan.');
            }

            $loan->update([
                'tanggal_jatuh_tempo' => Carbon::parse($loan->tanggal_jatuh_tempo)->addDays($days),
                'perpanjangan_count' => $loan->perpanjangan_count + 1
            ]);

            $loan->refresh();

            MahasiswaNotificationController::send(
                Auth::id(),
                'Perpanjangan Berhasil',
                "Buku '{$loan->book->judul}' berhasil diperpanjang hingga " .
                $loan->tanggal_jatuh_tempo->format('d-m-Y')
            );

            return redirect()->route('mahasiswa.loans.show', $loan->id)
                             ->with('success', 'Perpanjangan berhasil.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperpanjang peminjaman.');
        }
    }

    public function show($id)
    {
        $loan = Loan::where('user_id', Auth::id())
                    ->with(['book', 'review'])
                    ->findOrFail($id);

        // Gunakan startOfDay agar hitungan bulat (tidak desimal)
        $today = Carbon::now()->startOfDay();
        $dueDate = Carbon::parse($loan->tanggal_jatuh_tempo)->startOfDay();

        // LOGIKA DISPLAY & NOTIFIKASI
        if ($loan->status == 'dipinjam') {
            if ($today->greaterThan($dueDate)) {
                // === KASUS TERLAMBAT ===
                // Gunakan abs() agar positif
                $lateDays = abs($today->diffInDays($dueDate)); 
                $loan->denda = abs($lateDays * $loan->book->denda_per_hari);
                $loan->denda_status = 'tertunggak'; // Hanya visual di sini

                // Kirim Notifikasi DENDA (Jika belum ada tipe denda untuk loan ini)
                if (!Notification::where('user_id', Auth::id())
                                 ->where('loan_id', $loan->id)
                                 ->where('type', 'denda')
                                 ->exists()) {
                    
                    $dendaFormatted = number_format($loan->denda, 0, ',', '.');
                    MahasiswaNotificationController::send(
                        Auth::id(),
                        'Terlambat & Denda',
                        "Buku '{$loan->book->judul}' lewat jatuh tempo. Denda sementara: Rp{$dendaFormatted}",
                        $loan->id,
                        'denda'
                    );
                }
            } else {
                // === KASUS BELUM TELAT (TEPAT WAKTU) ===
                $loan->denda = 0;
                $loan->denda_status = 'lunas';

                // Hitung sisa hari (Integer karena pakai startOfDay)
                $daysLeft = $today->diffInDays($dueDate);

                // LOGIKA PENGINGAT (Hanya jika sisa <= 3 hari)
                if ($daysLeft <= 3) {
                    $todayStr = Carbon::now()->format('Y-m-d');
                    
                    // Cek apakah SUDAH diingatkan HARI INI?
                    $alreadyNotifiedToday = Notification::where('user_id', Auth::id())
                        ->where('loan_id', $loan->id)
                        ->where('type', 'pengingat')
                        ->whereDate('created_at', $todayStr)
                        ->exists();

                    if (!$alreadyNotifiedToday) {
                        $pesan = ($daysLeft == 0) 
                            ? "HARI INI adalah batas akhir pengembalian buku '{$loan->book->judul}'."
                            : "Jangan lupa! Buku '{$loan->book->judul}' harus kembali dalam {$daysLeft} hari lagi.";

                        MahasiswaNotificationController::send(
                            Auth::id(),
                            'Pengingat Jatuh Tempo',
                            $pesan,
                            $loan->id,
                            'pengingat'
                        );
                    }
                }
            }
        }

        return view('mahasiswa.loans.show', compact('loan'));
    }

    public function showRenewForm($id)
    {
        $loan = Loan::where('user_id', Auth::id())
                    ->with('book')
                    ->findOrFail($id);

        return view('mahasiswa.loans.renew', compact('loan'));
    }

    public function return($id)
    {
        $loan = Loan::where('user_id', Auth::id())->findOrFail($id);

        if ($loan->status !== 'dipinjam') {
            return back()->with('error', 'Buku tidak dalam status dipinjam.');
        }

        $today = Carbon::now()->startOfDay();
        $dueDate = Carbon::parse($loan->tanggal_jatuh_tempo)->startOfDay();
        
        $denda = 0;
        $dendaStatus = 'lunas';

        // Hitung Denda saat dikembalikan
        if ($today->greaterThan($dueDate)) {
            // FIX: Gunakan abs() untuk menjamin hasil positif
            $lateDays = abs($today->diffInDays($dueDate));
            $denda = abs($lateDays * $loan->book->denda_per_hari);
            
            // Set ke tertunggak agar sistem blokir aktif jika admin belum melunaskan
            $dendaStatus = 'tertunggak'; 

            $dendaFormatted = number_format($denda, 0, ',', '.');
            MahasiswaNotificationController::send(
                Auth::id(),
                'Denda Keterlambatan',
                "Kamu terkena denda Rp{$dendaFormatted} untuk buku '{$loan->book->judul}'."
            );
        }

        $loan->update([
            'tanggal_kembali' => Carbon::now(),
            'status' => 'dikembalikan',
            'denda' => $denda, // Pasti positif
            'denda_status' => $dendaStatus
        ]);

        if (method_exists(MahasiswaNotificationController::class, 'removeFineNotification')) {
            MahasiswaNotificationController::removeFineNotification(Auth::id(), $loan->id);
        }

        MahasiswaNotificationController::send(
            Auth::id(),
            'Pengembalian Berhasil',
            "Buku '{$loan->book->judul}' sudah berhasil dikembalikan."
        );

        return back()->with('success', 'Pengembalian berhasil.');
    }
}