<?php

namespace App\Http\Controllers;

use App\Models\Lampirana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPanelController extends Controller
{
    public function adminView(){
        $pending = Lampirana::where('userlevel', 0) ->get();

        return view('admin/admin_panel', compact('pending'));
    }

    //pending user yang register
    public function pendingUsers(){
        $pending = DB::table('lampirana')
                    ->where('userlevel', 0)
                    ->get();

        return view('admin.pending', compact('pending'));
    }

    //APPROVAL USER
    public function approveUser(Request $request, $nokp){
        DB::table('lampirana')
            ->where('NoKP', $nokp)
            ->update([
                'userlevel' => $request->userlevel
            ]);

        return back()->with('success', 'User berjaya didaftarkan!');
    }
}
