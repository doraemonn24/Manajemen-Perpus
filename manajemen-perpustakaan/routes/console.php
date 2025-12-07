<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Illuminate\Support\Facades\Log;
use App\Models\Loan;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $loans = Loan::where('status', 'dipinjam')->get();

    foreach ($loans as $loan) {
        $dueDate = Carbon::parse($loan->tanggal_jatuh_tempo)->startOfDay();

        // Jika jatuh tempo besok
        if ($dueDate->isTomorrow()) {
            // Cek apakah notifikasi sudah pernah dibuat untuk loan ini
            $exists = Notification::where('user_id', $loan->user_id)
                ->where('type', 'loan')
                ->where('due_date', $loan->id)
                ->where('title', 'like', '%Pengingat%')
                ->exists();

            if (!$exists) {
                Notification::create([
                    'user_id' => $loan->user_id,
                    'title' => 'Pengingat Jatuh Tempo',
                    'message' => "Pengingat! Buku '{$loan->book->judul}' akan jatuh tempo besok ({$dueDate->format('d-m-Y')}).",
                    'type' => 'loan',
                    'due_date' => $loan->id,
                    'read' => false,
                ]);
            }
        }
    }
})->everyMinute();
