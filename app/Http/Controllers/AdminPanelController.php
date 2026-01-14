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
    public function pendingUsers(Request $request){
        $pending = DB::table('lampirana')
                    ->select('Nama', 'NoKP', 'emel', 'hp', 'NamaJabatan','userlevel')
                    ->where('userlevel', '0')
                    ->when($request->search, function($q) use ($request){
                        $q->where(function ($sub) use ($request){
                            $sub->where('Nama', 'like', '%' . $request->search . '%')
                                ->orWhere('NoKP', 'like', '%' . $request->search . '%')
                                ->orWhere('emel', 'like', '%' . $request->search . '%');
                        });
                    })
                    ->orderBy('Nama')
                    ->paginate(10);

        return response()->json([
            'success' => true,
            'title'=>'Pending User List',
            'users' => $pending->items(),
            'current_page' => $pending->currentPage(),
            'last_page'=>$pending->lastPage(),
            'total_users' => $pending->total(),
        ]);
    }

    public function suspendedUsers(Request $request){
        $suspend = DB::table('lampirana')
                    ->select('Nama', 'NoKP', 'emel', 'hp', 'NamaJabatan', 'userlevel')
                    ->where('userlevel', 'SP')
                    ->when($request->search, function($q) use ($request){
                        $q->where(function ($sub) use ($request){
                            $sub->where('Nama', 'like', '%' . $request->search . '%')
                                ->orWhere('NoKP', 'like', '%' . $request->search . '%')
                                ->orWhere('emel', 'like', '%' . $request->search . '%');
                        });
                    })
                    ->orderBy('Nama')
                    ->paginate(5);

        return response()->json([
            'success' => true,
            'title'=>'Pending User List',
            'users' => $suspend->items(),
            'current_page' => $suspend->currentPage(),
            'last_page'=>$suspend->lastPage(),
            'total_users' => $suspend->total(),
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

    public function editUser($nokp){
        $user = DB::table('lampirana')
                ->where('NoKP', $nokp)
                ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function deleteUser($nokp){
        $user = Lampirana::where('NoKP', $nokp)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }

    public function updateLevel(Request $request, $nokp)
    {
        $user = Lampirana::where('NoKP', $nokp)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        // 
        $userlevel = $request->input('userlevel');

        if ($userlevel === null) {
            return response()->json([
                'success' => false,
                'message' => 'Missing userlevel'
            ], 400);
        }

        $user->update(['userlevel' => $userlevel]);

        return response()->json([
            'success' => true,
            'message' => match ($userlevel) {
                'SP' => 'User berjaya disuspend',
                '0'  => 'User dikembalikan ke pending',
                '1'  => 'User berjaya disahkan',
                default => 'User updated'
            }
        ]);
    }

}

