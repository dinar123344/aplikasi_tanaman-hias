<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
    ];

    /**
     * Relasi: Customer dimiliki oleh satu User (1:1)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Customer memiliki banyak Order (1:N)
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
