<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Lampirana;
use Carbon\Carbon;
use App\Models\Kursus;
use Illuminate\Support\Facades\Auth;
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
                'masa_akhir' => 'nullable|string',
                'sijil' => 'nullable|file|mimes:pdf|max:2048', // 2MB
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



    
            $user = Auth::guard('lampirana')->user();

            $sijilStatus = $request->hasFile('sijil') ? 1 : 0;
            $sijilTarikh = $request->hasFile('sijil') ? now()->format('Y-m-d H:i:s') : null;

            //logic untuk upload sijil pdf
        
            //**if ($request->hasFile('sijil')) {

              //  $file = $request->file('sijil');

                //$sijilFile = 'sijil_' . $user->NoKP . '_' . time() . '.pdf';

                //$file->storeAs('sijil_kursus', $sijilFile, 'public');

                //$sijilStatus = 1;
                //$sijilTarikh = now()->format('Y-m-d H:i:s');
            //} 
            //


            // Simpan ke DB
             $kursusBaru = Kursus::create([
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
                'kursus_penyelia' => $request->penyelia ?: null,
                'kursus_nokp' => $user->NoKP,
                'kursus_sijil' => $sijilStatus,
                'kursus_tarikhsijil' => $sijilTarikh,
                
                //boleh guna kalau add column dekat table kursus
                //'kursus_sijil_file' => $sijilFile,

                //start lampirana duplicate
                'NoKP' => $user->NoKP,
                'Nama' => $user->Nama,
                'Gred' => $user->Gred, 
                'KodMaksud' => $user->KodMaksud, 
                'NamaJabatan' => $user-> NamaJabatan, 
                'Cawangan' => $user-> Cawangan,
                'Unit' => $user-> Unit, 
                'Jawatan' => $user -> Jawatan, 
                'glrnjawatan' => $user -> glrnJawatan, 
                'Th_Masuk' => $user ->Th_Masuk, 
                'ThPegang' => $user -> ThPegang, 
                'Th_Sah' => $user ->Th_Sah,
                'ThTugas' => $user -> ThTugas, 
                'katalaluan' => $user -> katalaluan, 
                'emel' => $user->emel,
                'hp' => $user->hp,
                'telpej' => $user->telpej, 
                'jantina' => $user->jantina, 
                'firsttimelogin' => $user-> firsttimelogin, 
                'faks' => $user-> faks, 
                'soalan' => $user-> soalan, 
                'jawapan' => $user-> jawapan, 
                'kategori' => $user-> kategori, 
                'aktif' => $user-> aktif, 
                'last_login' => $user -> last_login, 
                'last_logout' => $user-> last_logout, 
                'bil_hari' => $user-> bil_hari, 
                'bil_jam' => $user-> bil_jam,
                'gambar' => $user-> gambar, 
                'userlevel' => $user->userlevel,
                'kumpulan' => $user->kumpulan, 
                'lantikan' => $user->lantikan, 
                'blacklist' => $user-> blacklist, 
                'penyelia_keberkesanan' => $user->penyelia_keberkesanan, 
                'penyelia_trm' => $user->penyelia_trm, 
                'ketuajabatan' => $user-> ketuajabatan,
                'skim_id' => $user-> skim_id, 
                'bidang_id' => $user-> bidang_id, 
                'trm_id' => $user-> trm_id, 
                'gred_sspa' => $user-> gred_sspa, 
                'gred_str' => $user-> gred_str, 
                'gred_num' => $user-> gred_num, 
                'sspa_num' => $user-> sspam_num, 
                'Auto' => $user-> Auto, 

            ]);

            // 3. Proses Upload File (Jika ada)
            // Kita namakan file guna ID kursus: sijil_{kursus_ID}.pdf
            if ($request->hasFile('sijil')) {
                $file = $request->file('sijil');
                
                // Nama fail standardized: sijil_IDKURSUS.pdf
                // Contoh: sijil_105.pdf
                // Ini memudahkan kita cari fail ni nanti tanpa perlu simpan nama dalam DB
                $namaFail = 'sijil_' . $kursusBaru->kursus_ID . '-'. $kursusBaru->kursus_nokp .'.pdf'; 
                
                $file->storeAs('sijil_kursus', $namaFail, 'public');
            }

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

        $senaraiAnjuran = DB::table('anjuran')
            ->orderBy('sort', 'asc')
            ->get();

        // Hantar user ke view daftar kursus
        return view('daftar_kursus',compact('senaraiAnjuran'));
    }

    //calendar fucntion
    public function getKursusEvents(){

        $user = Auth::guard('lampirana')->user();

        if (!$user) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }


        $nokp = $user->NoKP;


        $kursus = Kursus::where('NoKP', $nokp)
            ->orWhere('kursus_nokp', $nokp)
            ->select('kursus_tajuk', 'kursus_thmula', 'kursus_thtamat')
            ->get();

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

    public function myKursus(){
        $nokp = Auth::guard('lampirana')->user()->NoKP;

        $kursus = Kursus::where('NoKP', $nokp)->get();

        return view('kursus.my_kursus', compact('kursus'));
    } 

    public function viewAdminApproveKursus(){
        return view('admin.admin_approve_kursus');
    }

   // NEW METHODS FOR ADMIN APPROVAL

    /**
     * Get all pending courses for approval
     */
    public function getPendingKursus(Request $request){
        try {
            $query = Kursus::where('kursus_sah', 0);

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('kursus_tajuk', 'LIKE', "%{$search}%")
                      ->orWhere('Nama', 'LIKE', "%{$search}%")
                      ->orWhere('NoKP', 'LIKE', "%{$search}%")
                      ->orWhere('kursus_tempat', 'LIKE', "%{$search}%");
                });
            }

            // Filter by month
            if ($request->has('month') && !empty($request->month)) {
                $query->where('kursus_bulan', $request->month);
            }

            // Filter by year
            if ($request->has('year') && !empty($request->year)) {
                $query->where('kursus_tahun', $request->year);
            }

            $kursus = $query->orderBy('kursus_daftar', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $kursus,
                'count' => $kursus->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan data kursus',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single course details for modal
     */
    public function getKursusDetails($id){
        try {
            $kursus = Kursus::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $kursus
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kursus tidak dijumpai'
            ], 404);
        }
    }

    /**
     * Approve course
     */
    public function approveKursus(Request $request, $id){
        try {
            $kursus = Kursus::findOrFail($id);
            
            // Update approval status
            $kursus->kursus_sah = 1;
            $kursus->save();

            return response()->json([
                'success' => true,
                'message' => 'Kursus berjaya disahkan!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengesahkan kursus',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject/Delete course
     */
    public function rejectKursus($id){
        try {
            $kursus = Kursus::findOrFail($id);
            
            // Delete the course
            $kursus->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kursus berjaya ditolak dan dipadam!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memadam kursus',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAnjuranList(Request $request){
        $search = $request->q; // Apa yang user taip

        $query = DB::table('anjuran');

        if ($search) {
            $query->where('Anjuran', 'LIKE', "%{$search}%");
        }

        // Ambil 20 data per page, susun ikut sort, kemudian nama
        $data = $query->orderBy('sort', 'ASC')
                    ->orderBy('Anjuran', 'ASC')
                    ->paginate(20);

        // Formatkan data supaya Select2 faham (id & text)
        $results = [];
        foreach ($data as $item) {
            $results[] = [
                'id' => $item->ID, // Value yang akan disimpan dalam DB
                'text' => $item->Anjuran // Apa yang user nampak
            ];
        }

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => $data->hasMorePages() // Beritahu Select2 kalau ada page seterusnya
            ]
        ]);
    }
}
