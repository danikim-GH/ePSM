<?php

namespace App\Http\Controllers;

use App\Models\Kursus;
use Illuminate\Http\Request;

class SenaraiController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        $sortBy = $request->input('sortBy','kursus_ID');
        $order = $request->input('order','desc');

        $kursus = Kursus::when($search, function($query, $search){
            return $query->where('kursus_tajuk','like',"%{$search}%")
                        ->orWhere('kursus_idprogram','like',"%{$search}%")
                        ->orWhere('kursus_tempat', 'like', "%{$search}%");
        })

        ->orderBy($sortBy,$order)
        ->paginate(25)
        ->appends([
            'search' => $search,
            'sort_by' => $sortBy,
            'order' => $order
        ]);

        return view('/senarai_kursus',compact('kursus','search','sortBy','order'));
    }
}
