<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $totalProducts  = Product::count();
        $totalCategories = Category::count();
        $totalUsers     = User::count();

        // Sum of all product prices as a simple "catalog value"
        $catalogValue = Product::sum('harga_jual');

        // Top products by price (simulate "top selling")
        $topProducts = Product::with('category')
            ->orderByDesc('harga_jual')
            ->take(5)
            ->get();

        // Low-priced products (simulate "low stock" — cheapest items)
        $lowPriceProducts = Product::with('category')
            ->orderBy('harga_jual')
            ->take(5)
            ->get();

        // Recent products
        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        // Category breakdown for donut chart
        $categoryBreakdown = Category::withCount('products')->get();

        // Monthly product additions (for bar chart)
        $monthlyData = Product::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupByRaw('MONTH(created_at)')
            ->pluck('count', 'month')
            ->toArray();

        $monthlyProducts = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyProducts[] = $monthlyData[$i] ?? 0;
        }

        return view('admin.index', compact(
            'totalProducts',
            'totalCategories',
            'totalUsers',
            'catalogValue',
            'topProducts',
            'lowPriceProducts',
            'recentProducts',
            'categoryBreakdown',
            'monthlyProducts',
        ));
    }
}