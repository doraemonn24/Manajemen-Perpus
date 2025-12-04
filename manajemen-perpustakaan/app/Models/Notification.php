<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',               // loan, returned, fine, reminder
        'related_entity',     // loan, book, penalty/denda
        'related_entity_id',  // foreign id entity terkait
        'due_date',           // khusus notifikasi denda
        'is_read',            // status sudah dibaca
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'due_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔔 Helper untuk membuat notifikasi baru
    public static function send($userId, $title, $message, $type = null, $entityId = null, $dueDate = null)
    {
        return self::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'related_entity' => $type,
            'related_entity_id' => $entityId,
            'due_date' => $dueDate,
            'read' => false, 
        ]);
    }
}
