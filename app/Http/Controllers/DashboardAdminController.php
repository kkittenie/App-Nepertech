<?php
namespace App\Http\Controllers;

use App\Models\Product;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
        ];

        $recentProducts = Product::latest()->take(5)->get();

        $topProducts = Product::orderByDesc('price')->take(5)->get();

        return view('admin.index', compact(
            'stats',
            'recentProducts',
            'topProducts',
        ));
    }
}