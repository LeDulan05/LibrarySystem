<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'isbn', 'category_id', 'total_copies', 'available_copies'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // This is the single source of truth the borrow vs reserve button
    // logic should check: available_copies > 0, not total_copies.
    public function isAvailable(): bool
    {
        return $this->available_copies > 0;
    }
}
