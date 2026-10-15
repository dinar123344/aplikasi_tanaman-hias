<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;

        if (!$customer) {
            $orders = collect(); // empty collection
        } else {
            $orders = Order::with('orderItems.product')
                ->where('customer_id', $customer->id)
                ->latest()
                ->get();
        }

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Make sure user can only see their own orders
        $customer = Auth::user()->customer;
        if (!$customer || $order->customer_id !== $customer->id) {
            abort(403);
        }

        $order->load(['orderItems.product', 'payment']);

        return view('customer.orders.show', compact('order'));
    }

    public function print(Order $order)
    {
        $customer = Auth::user()->customer;
        if (!$customer || $order->customer_id !== $customer->id) {
            abort(403);
        }

        $order->load(['orderItems.product', 'payment']);

        return view('customer.orders.print', compact('order'));
    }

    public function pay(Order $order)
    {
        // Make sure user can only pay their own orders
        $customer = Auth::user()->customer;
        if (!$customer || $order->customer_id !== $customer->id) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan ini sudah dibayar atau dibatalkan.');
        }

        // Create payment record
        Payment::create([
            'order_id' => $order->id,
            'paid_at' => now(),
            'amount' => $order->total_amount,
            'payment_method' => 'transfer',
            'payment_status' => 'paid',
        ]);

        // Update order status
        $order->update(['status' => 'paid']);

        return redirect()->route('customer.orders.show', $order)->with('success', 'Pembayaran berhasil! Terima kasih telah berbelanja.');
    }
}
