<?php

namespace App\Http\Controllers;

use App\Models\Lampirana;
use Illuminate\Http\Request;
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

        $user = Lampirana::where('NoKP',$request->NoKP)
                ->first();

        if(!$user){
            return back()->with('error','NoKP Tidak Wujud');
        }

        /** Apply untuk hash password lama in DB if possible
         * if(md5($request->katalaluan) === $user->katalaluan){
        *  $user->katalaluan = Hash::make($request->katalaluan); // auto rehash ke bcrypt
        *  $user->save();
         * }
         * 
        **/

        //check password hashed
        if(!Hash::check($request->katalaluan, $user->katalaluan)){
            return back()->with('error','Katalaluan salah!');
        }

        if($user->userlevel === "0"){
            return back()->with('error', 'Akaun anda sedang menunggu kelulusan atmin :Ampun Atmin:');
        } 

        if($user->userlevel === "SP"){
            return back()->with('error', 'Akaun anda telah ditangguhkan, sila hubungi admin untuk maklumat lanjut!');
        }

        Auth::guard('lampirana')->login($user);

        return redirect()->route('home')->with('success','Login Berjaya!');
    }
}
