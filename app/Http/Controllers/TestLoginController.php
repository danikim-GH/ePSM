<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestLoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function checkLogin(Request $request){
        $user= DB::table('lampirana')
        ->where('NoKP',$request->NoKP)
        ->where('katalaluan',$request->katalaluan)
        ->first();

        if($user){
            session(['user'=>$user]);

            session(['userlevel' => $user -> userlevel ?? 0]);

            return redirect()->route('home')->with('success','Login Berjaya!');
        } else{
            return back()->with('error','No KP atau Katalaluan salah!');
        }
    }
}
