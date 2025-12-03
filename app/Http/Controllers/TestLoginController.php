<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class TestLoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function checkLogin(Request $request){

        $request->validate([
            'NoKP'=>'required',
            'katalaluan'=>'required'
        ]);

        $user= DB::table('lampirana')
        ->where('NoKP', $request->NoKP)
        ->first();

        if(!$user){
            return back()->with('error','NoKP Tidak Wujud');
        }

        //check password hashed
        if(!Hash::check($request->katalaluan, $user->katalaluan)){
            return back()->with('error','Katalaluan salah!');
        }

        if($user->userlevel === "0"){
            return back()->with('error', 'Akaun anda sedang menunggu kelulusan atmin :Ampun Atmin:');
        } 

        session(['user'=>$user]);
        session(['userlevel' => $user -> userlevel]);

        return redirect()->route('home')->with('success','Login Berjaya!');
    
    }
}
