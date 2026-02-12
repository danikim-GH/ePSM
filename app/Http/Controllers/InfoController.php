<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{
    // InfoController.php
    public function show($id) {
        // Nota: Sesetengah data kau guna menu_idarah yang merujuk ke ID table info, 
        // sesetengah merujuk ke info_tajuk. Check balik mapping ni.
        $maklumat = DB::table('info')
                    ->where('info_tajuk', $id) 
                    ->orWhere('ID', $id)
                    ->first();

        return view('submenu.info.papar_info', compact('maklumat'));
    }
}
