<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class testDebugController extends Controller
{
    function viewDebug(){
        return view('debug_test');
    }
}
