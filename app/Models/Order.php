<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_date',
        'total_amount',
        'status',
        'shipping_address',
        'courier_name',
        'courier_service',
        'tracking_number',
        'payment_method',
        'payment_status',
        'payment_details',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (empty($order->tracking_number)) {
                $order->tracking_number = self::generateTrackingNumber();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'order_date' => 'datetime',
            'payment_details' => 'array',
        ];
    }

    public static function generateTrackingNumber(): string
    {
        do {
            $trackingNumber = 'TN' . str_pad((string) random_int(10000000, 99999999), 8, '0', STR_PAD_LEFT);
        } while (self::where('tracking_number', $trackingNumber)->exists());

        return $trackingNumber;
    }

    /**
     * Relasi: Order dimiliki oleh satu Customer (N:1)
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relasi: Order memiliki banyak OrderItem (1:N)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi: Order memiliki satu Payment (1:1)
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
