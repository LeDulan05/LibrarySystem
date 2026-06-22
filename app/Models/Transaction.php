<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'status', 'borrow_date', 'due_date', 'return_date', 'rejection_reason',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function penalty()
    {
        return $this->hasOne(Penalty::class);
    }

    public function isOverdue(): bool
    {
        return $this->status === 'active' && $this->due_date && $this->due_date->isPast();
    }
}
