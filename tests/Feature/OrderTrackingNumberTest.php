<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTrackingNumberTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_generates_tracking_number_automatically(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $customer = Customer::create([
            'user_id' => $user->id,
            'name' => 'Test Customer',
        ]);

        $order = Order::create([
            'customer_id' => $customer->id,
            'order_date' => now(),
            'total_amount' => 150000,
            'status' => 'pending',
            'shipping_address' => 'Jl. Contoh No. 1',
            'payment_method' => 'cod',
            'payment_status' => 'pending',
        ]);

        $this->assertNotEmpty($order->tracking_number);
        $this->assertMatchesRegularExpression('/^TN\d{8,12}$/', $order->tracking_number);
    }
}
