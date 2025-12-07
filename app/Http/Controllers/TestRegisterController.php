<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestRegisterController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(Request $request){
        $request->validate([
            'Nama' => 'required',
            'NoKP' => 'required|unique:lampirana,NoKP',
            'katalaluan' => 'required',
            'emel' => 'required|email',
            'hp' => 'required'
        ]);

        DB::table('lampirana')->insert([
            'Nama' => $request->Nama,
            'NoKP' => $request->NoKP,
            'katalaluan' => Hash::make($request->katalaluan),
            'emel'=> $request->emel,
            'hp'=>$request->hp,
            'userlevel' => 0,
        ]);
        return redirect()->route('login.show')->with('success', 'Pendaftaran Berjaya!, Menunggu Kelulusan Admin');
    }
}
