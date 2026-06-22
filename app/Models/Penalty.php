<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    protected $fillable = ['transaction_id', 'days_late', 'amount', 'status'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
