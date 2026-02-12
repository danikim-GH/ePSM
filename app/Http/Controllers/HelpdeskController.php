<?php

namespace App\Http\Controllers;

use App\Models\Helpdesk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpdeskController extends Controller
{
    public function helpdesk(Request $request)
    {
        $navbarClass = 'navbar-light bg-dark shadow';

        if($request->has('aduan-Helpdesk')){
            return view('helpdesk', compact('navbarClass'));
        }
        return redirect()->route('home');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $user = Auth::guard('lampirana')->user();

        Helpdesk::create([
            'NoKP' => $user->NoKP,
            'helpdesk_user_name' => $user->Nama,
            'helpdesk_user_email' => $user->emel,
            'helpdesk_user_phone' => $user->hp ?? $user->telpej,
            'helpdesk_kategori' => $validated['kategori'],
            'helpdesk_subjek_aduan' => $validated['subject'],
            'helpdesk_butiran_aduan' => $validated['message'],
            'NamaJabatan' => $user->NamaJabatan,
            'Nama' => $user->Nama,
        ]);

        return redirect()->route('helpdesk')->with('success', 'Aduan berjaya dihantar!');
    }

    public function adminHelpdeskView()
    {
        return view('admin.admin_helpdesk');
    }

    /**
     * Fetch all helpdesk tickets for admin
     */
    public function getHelpdeskTickets(Request $request)
    {
        try {
            $query = Helpdesk::query();

            // Filter by status if provided
            if ($request->has('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            // Search functionality
            if ($request->has('search') && $request->search !== '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('helpdesk_user_name', 'LIKE', "%{$search}%")
                        ->orWhere('helpdesk_subjek_aduan', 'LIKE', "%{$search}%")
                        ->orWhere('helpdesk_butiran_aduan', 'LIKE', "%{$search}%")
                        ->orWhere('helpdesk_user_email', 'LIKE', "%{$search}%");
                });
            }

            // Order by latest first
            $helpdesks = $query->orderBy('created_at', 'desc')->get();

            // Count by status
            $counts = [
                'all' => Helpdesk::count(),
                'pending' => Helpdesk::where('status', 'pending')->count(),
                'resolved' => Helpdesk::where('status', 'resolved')->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $helpdesks,
                'counts' => $counts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching helpdesk tickets: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single helpdesk ticket details
     */
    public function getHelpdeskDetail($id)
    {
        try {
            $helpdesk = Helpdesk::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $helpdesk
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching ticket detail: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update helpdesk ticket status
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,resolved'
            ]);

            $helpdesk = Helpdesk::findOrFail($id);
            $helpdesk->status = $validated['status'];
            $helpdesk->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berjaya dikemaskini',
                'data' => $helpdesk
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }
}