<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'status', 'reservation_date', 'hold_expires_at', 'queue_position',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'hold_expires_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
