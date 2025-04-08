<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::where('status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();
        
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $lowStockProducts = Product::where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact(
            'totalSales', 
            'totalOrders', 
            'totalProducts', 
            'totalCustomers',
            'recentOrders',
            'lowStockProducts'
        ));
    }
}