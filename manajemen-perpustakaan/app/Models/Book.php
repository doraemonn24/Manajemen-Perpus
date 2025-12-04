<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'cover_image',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'stok',
        'deskripsi',
        'maksimal_waktu_peminjaman',
        'denda_per_hari',
        'rating',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->rating ?? 0;
        
        // Jika nanti ingin rata-rata dari tabel reviews
        // return $this->reviews()->avg('rating') ?? 0;
    }
}
