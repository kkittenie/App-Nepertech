<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products'  => Product::count(),
            'low_stock'       => Product::lowStock()->count(),
            'out_of_stock'    => Product::outOfStock()->count(),
            'in_stock'        => Product::inStock()->count(),
            'total_value'     => Product::sum(\DB::raw('price * stock')),
        ];

        $recentProducts = Product::latest()->take(5)->get();

        $topProducts = Product::orderByDesc('stock')->take(5)->get();

        // Monthly sales data for chart (mock data seeded from db or static)
        $chartData = [
            'labels' => ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            'values' => [3200, 4500, 3800, 5100, 4200, 6000, 5500, 4800, 6200, 5800, 7100, 6800],
        ];

        return view('admin.index', compact('stats', 'recentProducts', 'topProducts', 'chartData'));
    }
}