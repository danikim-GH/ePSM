<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function adminSettingView(){
        return view('admin.admin_setting');
    }

    public function carouselSettingsView(){
        $carouselItems = Carousel::orderBy('order', 'asc')->get();
        return view('admin.carousel', compact('carouselItems'));
    }
}
