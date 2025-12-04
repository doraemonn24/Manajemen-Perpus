<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'denda',
        'denda_status',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_jatuh_tempo' => 'datetime',
        'tanggal_kembali' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function hasReview()
    {
        return $this->review()->exists();
    }

    public function hitungDenda()
{
    if (!$this->tanggal_kembali) {
        return 0;
    }

    $due = Carbon::parse($this->tanggal_jatuh_tempo)->startOfDay();
    $returned = Carbon::parse($this->tanggal_kembali)->startOfDay();

    if ($returned->lte($due)) {
        return 0;
    }

    $selisihHari = abs($due->diffInDays($returned));

    return $selisihHari * ($this->book->denda_per_hari ?? 0);
}
}
