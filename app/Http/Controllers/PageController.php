<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Menampilkan halaman "menunggu persetujuan admin".
     */
    public function pending()
    {
        return view('auth.pending'); // Kita akan buat view ini selanjutnya
    }
}
