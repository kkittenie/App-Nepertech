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

    public function fasilitas()
    {
        return view('fasilitas');
    }

    public function galeri()
    {
        return view('galeri');
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