<?php

namespace App\Http\Controllers;

use App\Models\Helpdesk;
use Illuminate\Http\Request;

class HelpdeskController extends Controller
{
    public function helpdesk(){
        $navbarClass = 'navbar-light bg-dark shadow';
        return view('helpdesk', compact('navbarClass'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email',
            'phone'=>'nullable|string|max:20',
            'kategori'=>'required|string',
            'subject'=>'required',
            'message'=>'required'
        ]);

        Helpdesk::create([
            'helpdesk_user_name'=>$validated['name'],
            'helpdesk_user_email'=>$validated['email'],
            'helpdesk_user_phone'=>$validated['phone']??null,
            'helpdesk_kategori'=>$validated['kategori'],
            'helpdesk_subjek_aduan'=>$validated['subject'],
            'helpdesk_butiran_aduan'=>$validated['message']
        ]);

        return redirect('helpdesk')->with('success','Aduan berjaya dihantar!');
    }
}
