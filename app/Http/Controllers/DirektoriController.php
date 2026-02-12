<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
//use Illuminate\Http\Request;

class DirektoriController extends Controller
{
    public function index(){
        // Query JOIN
        $direktori = DB::table('direktori')
            ->join('menu', 'direktori.dir_idmenu', '=', 'menu.ID')
            ->where('direktori.dir_papar', 'Y')
            ->select(
                'direktori.*',
                'menu.menu_tajuk',
                'menu.menu_sort'
            )
            ->orderBy('menu.menu_sort', 'asc')
            ->get();

        // Group ikut menu_tajuk
        $groupedDirektori = $direktori->groupBy('menu_tajuk');
        
        // Hantar ke blade
        return view('submenu.direktori.index', [
            'direktori' => $groupedDirektori
        ]);
    }

    public function show($id){
        $direktori = DB::table('direktori')
            ->join('menu', 'direktori.dir_idmenu', '=', 'menu.ID')
            ->where('direktori.dir_papar', 'Y')
            ->where('menu.ID', $id)
            ->select(
                'direktori.*',
                'menu.menu_tajuk'
            )
            ->get();

        $unitName = $direktori->first()->menu_tajuk ?? 'Direktori';

        return view('submenu.direktori.show', [
            'direktori' => $direktori,
            'unitName' => $unitName
        ]);
    }
}
