<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kursus;
use Illuminate\Http\Request;

use function Termwind\parse;

class KursusController extends Controller
{
    public function store(Request $request){
        try{
            $request->validate([
            'program' => 'required',
            'aktiviti' => 'required',
            'tajuk' => 'required|string|max:255',
            'tarikh_mula' => 'required|date',
            'tarikh_tamat' => 'nullable|date|after_or_equal:tarikh_mula',
            'tempat' => 'required|string',
            'anjuran' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'hari' => 'nullable|integer',
            'jam' => 'nullable|integer',
            'negeri' => 'nullable|string',
            'rujukan' => 'nullable|string|max:80',
            'masa_mula' => 'nullable|string',
            'masa_akhir' => 'nullable|string'
            ]);
    
            //function parsing masa_mula dan masa_akhir into time format
            $parseTime = function($timeStr){
                if(empty($timeStr)){
                    return null;
                }
    
                //clear spaces
                $timeStr = trim($timeStr);
    
                $formats = ['H:i', 'H:i:s', 'h:i A', 'h:iA'];
    
                foreach($formats as $fmt){
                        try{
                            $dt = \Carbon\Carbon::createFromFormat($fmt, $timeStr);
                            if($dt !== false){
                                return $dt->format('H:i:s');
                        }
                    } catch(\Exception $e){
    
                    }
                }
    
                try{
                    $dt = \Carbon\Carbon::parse($timeStr);
                    return $dt->format('H:i:s');
                }  catch (\Exception $e) {
                    return null;
                }
            };
    
            $masaMulaFormatted = $parseTime($request->masa_mula);
            $masaAkhirFormatted = $parseTime($request->masa_akhir);
    
            // Simpan ke DB
            Kursus::create([
                'kursus_sah' => 0,
                'kursus_idprogram' => $request->program,
                'kursus_idaktiviti' => $request->aktiviti,
                'kursus_tajuk' => $request->tajuk,
                'kursus_thmula' => $request->tarikh_mula,
                'kursus_thtamat' => $request->tarikh_tamat ?: null,
                'kursus_bilhari' => $request->hari,
                'kursus_biljam' => $request->jam,
                'kursus_tempat' => $request->tempat,
                'kursus_anjuran' => $request->anjuran,
                'kursus_jenistempat' => $request->lokasi,
                'kursus_namanegeri' => $request->negeri,
                'kursus_rujukan' => $request->rujukan,
                'kursus_tahun' => Carbon::parse($request->tarikh_mula)->year,
                'kursus_bulan' => Carbon::parse($request->tarikh_mula)->month,
                'kursus_daftar' => Carbon::now(),
                'kursus_msmula' => $masaMulaFormatted ?: null,
                'kursus_msakhir' => $masaAkhirFormatted ?: null,
                'kursus_sumber' => $request->sumber ?: null,
                'kursus_pembentangan' => $request->pembentangan ?: null,
                'kursus_penyelia' => $request->penyelia ?: null
            ]);
        return redirect()->route('kursus.create')->with('success', 'Kursus berjaya didaftarkan!');
        } catch(\Throwable $e){
            dd($e->getMessage());
            return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Pendaftaran kursus gagal. Sila cuba lagi.');
        }
    }
    
    public function create(){
        // Hantar user ke view daftar kursus
        return view('daftar_kursus');
    }

    //calendar fucntion
    public function getKursusEvents(){
        $kursus = Kursus::select('kursus_tajuk', 'kursus_thmula', 'kursus_thtamat')->get();

        //format based on calendar
        $events = $kursus->map(function($item){
            return [
                'title' => $item->kursus_tajuk,
                'start' => $item->kursus_thmula,
                'end' => $item->kursus_thtamat
            ];
        });

        return response()->json($events);
    }

}
