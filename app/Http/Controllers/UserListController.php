<?php

namespace App\Http\Controllers;

use App\Models\Lampirana;
use Illuminate\Http\Request;

class UserListController extends Controller
{
    //
    public function view(){
        return view('admin/partials/admin_user_list');
    }

    public function getUsers(Request $request){
        $search = $request->search;
        $jabatan = $request->jabatan;

        $query = Lampirana::query();

        //filter search
        if($search){
            $query->where(function ($q) use ($search) {
                $q->where('Nama', 'like', "%$search%")
                ->orWhere('emel','like',"%$search%");
            });
        }
    
        //filter jabatan
        if($jabatan){
            $query->where('NamaJabatan',$jabatan);
        }

        //get user & paginate to improve data fetching
        $users = $query
                ->select('Nama', 'NoKP', 'emel', 'hp', 'NamaJabatan', 'userlevel',)
                ->orderBy('Nama')
                ->paginate(10);


        return response()->json([
            'success' => true,
            'users' => $users->items(),
            'current_page' => $users->currentPage(),
            'last_page'=> $users->lastPage(),
        ]);
    }
}
