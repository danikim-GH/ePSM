<?php

namespace App\Http\Controllers;

use App\Models\Lampirana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    public function view(){
        $user = Auth::guard('lampirana')->user();

        if(!$user){
            return redirect()->route('login.show')->with('error','Sila log masuk terlebih dahulu!');
        }

        return view('components.user-profile-modal');
    }

    public function update(Request $request)
    {
        $user = Auth::guard('lampirana')->user();

        if(!$user){
            return response()->json(['success'=>false],401);
        }

        $validated = $request->validate([
            'Nama' => 'nullable|string|max:255',
            'emel' => 'nullable|email',
            'hp'   => 'nullable|string|max:20',
            'profile_pic' => 'nullable|image|max:2048',
        ]);

        // === UPDATE BASIC INFO ===
        $user = Lampirana::where('NoKP', Auth::guard('lampirana')->id())->firstOrFail();

          // === UPDATE USER DATA (OPTIONAL FIELDS) ===
        $user->fill([
            'Nama' => $validated['Nama'] ?? $user->Nama,
            'emel' => $validated['emel'] ?? $user->emel,
            'hp'   => $validated['hp']   ?? $user->hp,
        ]);

        // === UPDATE PROFILE PICTURE ===
        if ($request->hasFile('profile_pic')) {

            // padam gambar lama (kalau ada)
            if ($user->gambar && Storage::disk('public')->exists($user->gambar)) {
                Storage::disk('public')->delete($user->gambar);
            }

            $path = $request->file('profile_pic')
                ->storeAs(
                    'profile/lampirana',
                    $user->NoKP.'.'.$request->file('profile_pic')->extension(),
                    'public'
                );

            $user->gambar = $path;
        }
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berjaya dikemaskini',
            'user'=> $user->fresh(),
            'gambar' => $user->gambar
        ]);
    }
}
