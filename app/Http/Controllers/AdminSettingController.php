<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function adminSettingView(){
    // Add this line to get carousel items
    $carouselItems = Carousel::orderBy('order', 'asc')->get();
    
    return view('admin.admin_setting', compact('carouselItems'));
    }
}
