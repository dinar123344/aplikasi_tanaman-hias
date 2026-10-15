<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Payment;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistik Utama
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalCustomers = Customer::count();

        // Revenue
        $totalRevenue = Payment::where('payment_status', 'paid')->sum('amount');
        $monthlyRevenue = Payment::where('payment_status', 'paid')
            ->whereMonth('paid_at', Carbon::now()->month)
            ->whereYear('paid_at', Carbon::now()->year)
            ->sum('amount');

        // Pendapatan 6 bulan terakhir untuk chart
        $revenueChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Payment::where('payment_status', 'paid')
                ->whereMonth('paid_at', $date->month)
                ->whereYear('paid_at', $date->year)
                ->sum('amount');
            $revenueChart[] = [
                'month' => $date->translatedFormat('M Y'),
                'revenue' => (float) $revenue,
            ];
        }

        // Pesanan per status
        $ordersByStatus = [
            'pending' => Order::where('status', 'pending')->count(),
            'paid' => Order::where('status', 'paid')->count(),
            'cancelled' => Order::where('status', 'cancel')->count(),
        ];

        // Produk terlaris (top 5)
        $topProducts = Product::select('products.*', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Produk stok rendah (< 10)
        $lowStockProducts = Product::where('stock', '<', 10)
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->take(5)
            ->get();

        // Produk habis
        $outOfStockCount = Product::where('stock', 0)->count();

        // Pesanan terbaru
        $recentOrders = Order::with(['customer', 'payment'])->latest()->take(7)->get();

        // Kategori dengan jumlah produk
        $categorySummary = Category::withCount('products')->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'pendingOrders',
            'totalCustomers',
            'totalRevenue',
            'monthlyRevenue',
            'revenueChart',
            'ordersByStatus',
            'topProducts',
            'lowStockProducts',
            'outOfStockCount',
            'recentOrders',
            'categorySummary'
        ));
    }

    public function reports()
    {
        $totalRevenue = Payment::where('payment_status', 'paid')->sum('amount');
        $totalPaidOrders = Order::where('status', 'paid')->count();
        $totalCancelledOrders = Order::where('status', 'cancel')->count();
        
        $monthlyReport = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthStart = Carbon::now()->month($i)->startOfMonth();
            $revenue = Payment::where('payment_status', 'paid')
                ->whereMonth('paid_at', $i)
                ->whereYear('paid_at', Carbon::now()->year)
                ->sum('amount');
            $monthlyReport[] = [
                'month' => $monthStart->translatedFormat('F'),
                'revenue' => (float) $revenue,
            ];
        }

        $categoryReport = Category::withCount('products')->get();

        return view('admin.reports', compact(
            'totalRevenue',
            'totalPaidOrders',
            'totalCancelledOrders',
            'monthlyReport',
            'categoryReport'
        ));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_slogan' => 'nullable|string|max:255',
            'store_whatsapp' => 'nullable|string|max:20',
            'store_email' => 'required|email|max:255',
            'store_address' => 'required|string',
            'default_shipping_fee' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
        ]);

        update_settings($validated);

        return redirect()->back()->with('success', 'Pengaturan toko berhasil diperbarui!');
    }
}
