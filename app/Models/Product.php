<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'status',
    ];

    /**
     * Relasi: Product dimiliki oleh satu Category (N:1)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: Product memiliki banyak OrderItem (1:N)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
