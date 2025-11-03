<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    

class DashboardController extends Controller
{
    //
    public function index(){
        $user = session('user');

        if(!$user){
            return redirect()->route('login.show')->with('error','Sila log masuk terlebih dahulu!');
        }

        return view('index',['user'=>$user]);
    }
}
