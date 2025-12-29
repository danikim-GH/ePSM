<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;    
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index(){
        $user = Auth::guard('lampirana')->user();

        if(!$user){
            return redirect()->route('login.show')->with('error','Sila log masuk terlebih dahulu!');
        }

        $carouselItems = Carousel::where('is_active',true)
                        ->orderBy('order','asc')
                        ->get();

        return view('index',[
            'user'=>$user,
            'carouselItems' => $carouselItems
        ]);
    }
}
