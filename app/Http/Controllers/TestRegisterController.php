<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestRegisterController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(Request $request){
        DB::table('lampirana')->insert([
            'Nama' => $request->Nama,
            'NoKP' => $request->NoKP,
            'katalaluan' => $request->katalaluan,
            'userlevel' => $request->userlevel,
        ]);
        return redirect()->route('register.create')->with('success', 'Pendaftaran Berjaya!');
    }
}
