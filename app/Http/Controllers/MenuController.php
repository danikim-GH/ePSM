<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function navbar()
    {
        // Ambil semua menu level 1 dari table "menu"
        $mainMenu = DB::table('menu')
            ->where('menu_level', 1)
            ->orderBy('menu_sort', 'asc')
            ->get();

        // Hantar data ke view partials/navbar.blade.php
        return view('partials.navbar', compact('mainMenu'));
    }
}
