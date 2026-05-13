<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue'   => 45231,   // Replace with real order data
            'products_sold'   => 1234,
            'low_stock'       => Product::lowStock()->count(),
            'out_of_stock'    => Product::outOfStock()->count(),
        ];

        $topProducts = Product::orderByDesc('price')->take(10)->get();

        $categoryBreakdown = Product::select('category', DB::raw('count(*) as count'), DB::raw('sum(stock) as total_stock'))
            ->groupBy('category')
            ->get();

        $chartData = [
            'labels' => ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            'revenue' => [3200, 4500, 3800, 5100, 4200, 6000, 5500, 4800, 6200, 5800, 7100, 6800],
        ];

        return view('admin.reports.index', compact('stats', 'topProducts', 'categoryBreakdown', 'chartData'));
    }
}