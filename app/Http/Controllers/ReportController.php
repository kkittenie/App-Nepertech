<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
        ];

        $topProducts = Product::with('category')
            ->orderByDesc('price')
            ->take(10)
            ->get();

        $categoryBreakdown = Category::withCount('products')
            ->get();

        $chartData = [
            'labels'  => ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            'revenue' => [3200, 4500, 3800, 5100, 4200, 6000, 5500, 4800, 6200, 5800, 7100, 6800],
        ];

        return view('admin.reports.index', compact(
            'stats',
            'topProducts',
            'categoryBreakdown',
            'chartData'
        ));
    }
}