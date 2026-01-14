<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    /**
     * Get side menu items based on user level
     * Filters menu where menu_arah = 'menutepi'
     */
    public function getSideMenu(Request $request)
    {
        try {
            // Get user level from session or auth
            $userLevel = session('user_level') ?? Auth::guard('lampirana')->user()->userlevel ?? null;

            if (!$userLevel) {
                return response()->json([
                    'success' => false,
                    'message' => 'User level not found'
                ], 401);
            }

            // Fetch menu items where menu_arah = 'menutepi'
            $menuItems = DB::table('menu')
                ->where('menu_arah', 'menutepi')
                ->whereRaw("FIND_IN_SET(?, userlevel) > 0", [$userLevel])
                ->orderBy('menu_sort', 'asc')
                ->select('ID', 'menu_tajuk', 'menu_url', 'menu_action', 'menu_target', 'menu_sort', 'menu_url_alternate')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $menuItems,
                'user_level' => $userLevel
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching menu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get menu count for user
     */
    public function getMenuCount(Request $request)
    {
        try {
            $userLevel = session('user_level') ?? Auth::guard('lampirana')->user()->userlevel ?? null;

            if (!$userLevel) {
                return response()->json(['count' => 0]);
            }

            $count = DB::table('menu')
                ->where('menu_arah', 'menutepi')
                ->whereRaw("FIND_IN_SET(?, userlevel) > 0", [$userLevel])
                ->count();

            return response()->json(['count' => $count]);

        } catch (\Exception $e) {
            return response()->json(['count' => 0]);
        }
    }
}