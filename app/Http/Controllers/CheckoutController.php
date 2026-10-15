<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $cartItems = [];
        $totalAmount = 0;
        foreach ($cart as $productId => $item) {
            $product = Product::with('category')->find($productId);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity']
                ];
                $totalAmount += $product->price * $item['quantity'];
            }
        }

        return view('checkout', compact('cartItems', 'totalAmount'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string',
            'ewallet_provider' => 'required_if:payment_method,ewallet|string|nullable',
        ]);

        $user = Auth::user();
        $customer = $user->customer;

        if (!$customer) {
            // Auto-create customer if not exists
            $customer = \App\Models\Customer::create([
                'user_id' => $user->id,
                'name' => $user->name,
            ]);
        }

        DB::beginTransaction();

        try {
            $totalAmount = 0;

            // Calculate total first
            foreach ($cart as $productId => $item) {
                $product = Product::findOrFail($productId);
                $totalAmount += $product->price * $item['quantity'];
            }

            // Create order
            $order = Order::create([
                'customer_id' => $customer->id,
                'order_date' => now(),
                'total_amount' => $totalAmount + get_setting('default_shipping_fee'), // termasuk ongkir dinamis
                'status' => 'pending',
                'shipping_address' => $request->input('shipping_address'),
                'courier_name' => $request->input('courier_name'),
                'courier_service' => $request->input('courier_service'),
                'tracking_number' => null,
                'payment_method' => $request->input('payment_method'),
                'payment_status' => 'pending',
                'payment_details' => ($request->input('payment_details') || $request->input('ewallet_provider')) ? json_encode(array_filter([
                    'note' => $request->input('payment_details'),
                    'ewallet_provider' => $request->input('ewallet_provider'),
                ])) : null,
            ]);

            // Create order items
            foreach ($cart as $productId => $item) {
                $product = Product::findOrFail($productId);
                $subtotal = $product->price * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                // Reduce stock
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');

            return redirect()->route('customer.orders.index')->with('success', 'Pesanan Anda berhasil dibuat! Silakan lakukan pembayaran.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan saat checkout: ' . $e->getMessage());
        }
    }
}
