<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserListController extends Controller
{
    //
    public function view(){
        return view('admin/partials/admin_user_list');
    }
}
