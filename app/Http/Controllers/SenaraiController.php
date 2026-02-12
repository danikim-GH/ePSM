<?php

namespace App\Http\Controllers;

use App\Models\Kursus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SenaraiController extends Controller
{
    public function index(Request $request)
    {
        // Get authenticated user
        $user = Auth::guard('lampirana')->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Sila log masuk terlebih dahulu.');
        }

        $nokp = $user->NoKP;
        $search = $request->input('search');
        $sortBy = $request->input('sortBy', 'kursus_thmula');
        $order = $request->input('order', 'desc');

        // Query kursus based on authenticated user's NoKP
        $kursus = Kursus::with('infoAnjuran')
            ->where(function($query) use ($nokp) {
                $query->where('NoKP', $nokp)
                        ->orWhere('kursus_nokp', $nokp);
            })
            ->when($search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('kursus_tajuk', 'like', "%{$search}%")
                        ->orWhere('kursus_idprogram', 'like', "%{$search}%")
                        ->orWhere('kursus_tempat', 'like', "%{$search}%")
                        ->orWhereHas('infoAnjuran', function($subQuery) use ($search){
                            $subQuery->where('Anjuran', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy($sortBy, $order)
            ->paginate(15)
            ->appends([
                'search' => $search,
                'sortBy' => $sortBy,
                'order' => $order
            ]);

        // Calculate total statistics
        $totalKursus = Kursus::where('NoKP', $nokp)
            ->orWhere('kursus_nokp', $nokp)
            ->count();
        
        $totalJam = Kursus::where('NoKP', $nokp)
            ->orWhere('kursus_nokp', $nokp)
            ->sum('kursus_biljam');
        
        $totalHari = Kursus::where('NoKP', $nokp)
            ->orWhere('kursus_nokp', $nokp)
            ->sum('kursus_bilhari');

        return view('senarai_kursus', compact('kursus', 'search', 'sortBy', 'order', 'totalKursus', 'totalJam', 'totalHari'));
    }
}