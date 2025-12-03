<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class MahasiswaNotificationController extends Controller
{
    // Tampilkan semua notifikasi mahasiswa
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
                                     ->orderBy('created_at', 'desc')
                                     ->get();

        // Otomatis tandai semua notifikasi sebagai sudah dibaca
        Notification::where('user_id', Auth::id())
                    ->where('read', false)
                    ->update(['read' => true]);

        return view('mahasiswa.notifications.index', compact('notifications'));
    }

    // Fungsi bantu untuk membuat notifikasi
    public static function send($userId, $title, $message, $loanId = null, $type = 'info')
    {
        return Notification::create([
            'user_id' => $userId,
            'loan_id' => $loanId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'read' => false
        ]);
    }

    // Fungsi hapus notifikasi denda lama jika sudah dikembalikan
    public static function removeFineNotification($userId, $loanId)
    {
        Notification::where('user_id', $userId)
                    ->where('loan_id', $loanId)
                    ->where('type', 'denda')
                    ->delete();
    }
}
