<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function beranda()
    {
        return view('beranda');
    }

    public function profil()
    {
        return view('profil');
    }

    public function layanan()
    {
        return view('layanan');
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
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }
}