<?php
// NOT a real file Laravel will load. Breeze already generates app/Models/User.php
// with HasFactory, Notifiable, etc. Add these pieces into that existing file
// instead of replacing it wholesale.

// 1. Add 'role' and 'status' to the existing $fillable array:
protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'status',
];

// 2. Add these relationships and helper methods inside the User class:
public function transactions()
{
    return $this->hasMany(Transaction::class);
}

public function reservations()
{
    return $this->hasMany(Reservation::class);
}

public function isAdmin(): bool
{
    return $this->role === 'admin';
}

public function isSuspended(): bool
{
    return $this->status === 'suspended';
}
