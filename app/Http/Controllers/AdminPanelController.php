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
                    ->select('Nama', 'NoKP', 'emel', 'hp', 'NamaJabatan')
                    ->where('userlevel', '0')
                    ->orderBy('Nama')
                    ->paginate(5);

        return response()->json([
            'success' => true,
            'title'=>'Pending User List',
            'users' => $pending->items(),
            'current_page' => $pending->currentPage(),
            'last_page'=>$pending->lastPage(),
            'total_users' => $pending->total(),
        ]);
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

    public function suspendUser($nokp){
        DB::table('lampirana')
            ->where('NoKP', $nokp)
            ->update([
                'userlevel' => 'SP'
            ]);

        return back()->with('success', 'User berjaya disuspend!');
    }

    //fetch api for pending users count
    public function pendingUsersCount(){
        $count = DB::table('lampirana')
                    ->where('userlevel', '0')
                    ->count();

        return response()->json([
            'success' => true,
            'message' => 'Pending users count fetched successfully.',
            'pending_users_count' => $count,
        ]);
    }

    public function suspendedUsersCount(){
        $count = DB::table('lampirana')
                ->where('userlevel', 'SP')
                ->count();
        return response()->json(['total_suspended'=>$count]);
    }
    public function getUsers(){
        
    }
}
