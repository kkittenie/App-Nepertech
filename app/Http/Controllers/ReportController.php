<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        $totalProducts   = Product::count();
        $totalCategories = Category::count();
        $totalUsers      = User::count();
        $catalogValue    = Product::sum('price');
        $avgPrice        = Product::avg('price') ?? 0;
        $maxPrice        = Product::max('price') ?? 0;
        $minPrice        = Product::min('price') ?? 0;

        // All products with category
        $products = Product::with('category')
            ->orderByDesc('price')
            ->get();

        // Category breakdown
        $categoryBreakdown = Category::withCount('products')
            ->get();

        // Monthly product additions (for chart)
        $monthlyData = Product::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupByRaw('MONTH(created_at)')
            ->pluck('count', 'month')
            ->toArray();

        $monthlyProducts = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyProducts[] = $monthlyData[$i] ?? 0;
        }

        // Monthly catalog value growth
        $monthlyValue = Product::selectRaw('MONTH(created_at) as month, SUM(price) as total')
            ->whereYear('created_at', date('Y'))
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyValues = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyValues[] = (float) ($monthlyValue[$i] ?? 0);
        }

        return view('admin.reports.index', compact(
            'totalProducts',
            'totalCategories',
            'totalUsers',
            'catalogValue',
            'avgPrice',
            'maxPrice',
            'minPrice',
            'products',
            'categoryBreakdown',
            'monthlyProducts',
            'monthlyValues',
        ));
    }
}