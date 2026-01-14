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

        $totalUsers = $query
                    ->whereIn('userlevel',['9','8', '1', '2',] )
                    ->count();

        //get user & paginate to improve data fetching
        $users = $query
                ->select('Nama', 'NoKP as id', 'emel', 'hp', 'NamaJabatan', 'userlevel',)
                ->whereIn('userlevel',['9','8', '1', '2',] )
                ->orderBy('Nama')
                ->paginate(10);


        return response()->json([
            'success' => true,
            'users' => $users->items(),
            'current_page' => $users->currentPage(),
            'last_page'=> $users->lastPage(),
            'total_users' => $totalUsers,
        ]);
    }

    public function getTotalUsers(){
        $totalUsers = Lampirana::whereIn('userlevel',['9','8', '1', '2',])->count();

        return response()->json([
            'success' => true,
            'total_users' => $totalUsers,
        ]);
    }


    public function deleteUser($id){
        $user = Lampirana::where('NoKP', $id)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }


    public function updateUser(Request $request, $id){
        try {
            $user = Lampirana::where('NoKP', $id)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $user->update([
                'Nama'        => $request->name,
                'emel'        => $request->email,
                'hp'          => $request->phone,
                'userlevel'   => $request->level,
                'NamaJabatan' => $request->department,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully'
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
