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
            return back()->with([
                'status'=>'error',
                'message'=>'Harap Maaf, NoKP Tidak Wujud',
            ]);
        }

        
        if($request->NoKP === null || $request->NoKP === ""){
            return back()->with([
                'status'=>'pending',
                'message'=>'Sila isi NoKP lagi sekali!',
            ]);
        }

        /** Apply untuk hash password lama in DB if possible
         * if(md5($request->katalaluan) === $user->katalaluan){
        *  $user->katalaluan = Hash::make($request->katalaluan); // auto rehash ke bcrypt
        *  $user->save();
         * }
         * 
        **/


        $dbPassword = $user->katalaluan;
        $inputPassword = $request->katalaluan;

        // Jika password dalam DB BUKAN bcrypt
        if (!str_starts_with($dbPassword, '$2y$')) {

            // Jika dulu guna md5
            if (md5($inputPassword) === $dbPassword) {

                // AUTO REHASH ke bcrypt (SANGAT BAGUS)
                $user->katalaluan = Hash::make($inputPassword);
                $user->save();

            } else {
                return back()->with('error','Katalaluan salah!');
            }

        } 
        // Jika sudah bcrypt, guna Hash::check biasa
        else {
            if (!Hash::check($inputPassword, $dbPassword)) {
                return back()->with([ 
                'status' => 'pass_error',
                'message' => 'Katalaluan salah!']);
            }
        }

        if($user->userlevel === "0"){
            return back()->with([
                    'status' => 'pending', 
                    'message' => 'Akaun anda sedang menunggu kelulusan admin'
                ]);
        } 

        if($user->userlevel === "SP"){
            return back()->with([
                'status' => 'suspended',
                'message' => 'Akaun anda telah ditangguhkan, sila hubungi admin!'
            ]);
        }

        Auth::guard('lampirana')->login($user);

        return redirect()->route('home')->with('success','Login Berjaya!');
    }
}
