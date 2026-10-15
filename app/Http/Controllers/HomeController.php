<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;

class HomeController extends Controller
{
    public function index()
    {
        // Get all active products with their categories
        $products = Product::with('category')->where('status', 'aktif')->latest()->get();
        $categories = Category::all();

        return view('welcome', compact('products', 'categories'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        $customer = $user->customer;

        if (!$customer) {
            $customer = \App\Models\Customer::create([
                'user_id' => $user->id,
                'name' => $user->name,
            ]);
        }

        $totalOrders = \App\Models\Order::where('customer_id', $customer->id)->count();
        $totalSpent = \App\Models\Order::where('customer_id', $customer->id)->where('status', 'paid')->sum('total_amount');
        $cartCount = count(session()->get('cart', []));
        $recentOrders = \App\Models\Order::with('payment')->where('customer_id', $customer->id)->latest()->take(5)->get();

        return view('customer.dashboard', compact('totalOrders', 'totalSpent', 'cartCount', 'recentOrders'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('customer.profile_account', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Do not modify contact info here — account-only update
        if ($user->customer) {
            $user->customer->update(['name' => $request->name]);
        }

        return redirect()->back()->with('success', 'Akun berhasil diperbarui!');
    }

    public function contact()
    {
        $user = auth()->user();
        return view('customer.profile_contact', compact('user'));
    }

    public function updateContact(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:1000',
            'birthdate' => 'nullable|date',
        ]);

        if ($user->customer) {
            $user->customer->update(array_filter([
                'phone' => $request->phone,
                'address' => $request->address,
                'birthdate' => $request->birthdate,
            ]));
        } else {
            Customer::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'birthdate' => $request->birthdate,
            ]);
        }

        return redirect()->back()->with('success', 'Kontak dan alamat berhasil diperbarui!');
    }
}
