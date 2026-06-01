<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function beranda()
    {
        $categories = Category::withCount('products')->get();
        $products   = Product::with('category')->latest()->take(6)->get();
        $totalProducts   = Product::count();
        $totalCategories = Category::count();
        $totalUsers      = User::count();

        return view('beranda', compact(
            'categories', 'products',
            'totalProducts', 'totalCategories', 'totalUsers'
        ));
    }

    public function profil()
    {
        return view('profil');
    }

    public function layanan()
    {
        $categories = Category::withCount('products')->get();
        $products   = Product::with('category')->get();

        return view('layanan', compact('categories', 'products'));
    }

    public function mitra()
    {
        $mitras = \App\Models\Mitra::latest()->get();
        return view('mitra', compact('mitras'));
    }

    public function project()
    {
        $categories = Category::withCount('products')->get();
        $products   = Product::with('category', 'images')->latest()->get();

        return view('project', compact('categories', 'products'));
    }

    public function projectDetail($slug)
    {
        $product = Product::with('category', 'images')
            ->where('slug', $slug)
            ->firstOrFail();

        // Get next product for "Next Project" section
        $nextProduct = Product::where('id', '>', $product->id)->orderBy('id')->first();
        if (!$nextProduct) {
            $nextProduct = Product::where('id', '!=', $product->id)->orderBy('id')->first();
        }

        return view('project-detail', compact('product', 'nextProduct'));
    }

    public function kontak()
    {
        return view('kontak');
    }

    public function pendaftaran()
    {
        if (auth()->check()) {
            return redirect()->route('profile');
        }

        return view('auth.register');
    }
}