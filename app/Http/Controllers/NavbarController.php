<?php
namespace App\Http\Controllers;

use App\Models\Menu;

class NavbarController extends Controller
{
    public static function getMenu()
    {
        // test dulu
        return Menu::where('menu_level', 1)->orderBy('menu_sort')->get();
    }

        public function index()
    {
        $mainMenu = self::getMenu();
        return view('partials.navbar', compact('mainMenu'));
    }
}

