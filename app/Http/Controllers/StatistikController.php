<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function statistikKehadiran(){
        return view('statistik_kehadiran');
    }

    public function getJabatan(Request $request){
        $jabatan = $request->query('nama');

        $data = DB::table('lampirana')
        ->where('NamaJabatan',$jabatan)
        ->get();
        
        if($data->isEmpty()){   
            return response()->json([
                'success' => false,
                'status'=>'ERROR_404_NOT_FOUND',
                'message'=>'NOT FOUND ANY DATA'
            ]);
        }

        $lantikanList = ['Tetap', 'Sementara', 'Kontrak'];
        $result = [];

        foreach($lantikanList as $lantikan){
            $subset = $data->where('lantikan', $lantikan);
            if($subset->isEmpty()) continue;

            $result[] = [
                'lantikan' => $lantikan,
                'pnp' => $subset->where('kumpulan','pnp')->count(),
                'sokongan1' => $subset->where('kumpulan','sokongan1')->count(),
                'sokongan2' => $subset->where('kumpulan','sokongan2')->count(),
                'total' => $subset->count(),
            ];
        }
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    public function getKursus(Request $request){
        // 1. Ambil input
        $jabatan = $request->query('NamaJabatan');
        $lantikan = $request->query('lantikan');
        $tahun = $request->query('tahun');

        // 2. Query Staff (Lampirana)
        $staffQuery = DB::table('lampirana')
            ->select('NoKP', 'Nama', 'kumpulan', 'lantikan', 'NamaJabatan')
            ->where('NamaJabatan', $jabatan);

        // Filter lantikan hanya jika user pilih specific, abaikan jika 'PERJAWATAN' (default value UI)
        if($lantikan && strtoupper($lantikan) !== 'PERJAWATAN'){
            $staffQuery->where('lantikan', $lantikan);
        }

        $staffList = $staffQuery->get();

        if($staffList->isEmpty()){
            return response()->json([
                'success'=>false,
                'message'=>'Tiada staff ditemui dalam jabatan ini.'
            ]);
        }

        // 3. Collect NoKP & Bersihkan (TRIM Space)
        // Kita guna key-value pair biar senang match nanti
        // Format: ['900101xx' => '900101xx']
        $cleanNokpMap = [];
        
        foreach($staffList as $staf){
            // Buang whitespace depan belakang
            $cleanIC = trim($staf->NoKP);
            if(!empty($cleanIC)){
                $cleanNokpMap[$cleanIC] = $cleanIC;
            }
        }
        
        $targetNokps = array_values($cleanNokpMap);

        // 4. Query Table Kursus
        $kursusQuery = DB::table('kursus')
            ->select('kursus_nokp', 'kursus_bilhari', 'kursus_thmula');
            
        // Guna whereIn biasa sebab NoKP tiada dash
        $kursusQuery->whereIn('kursus_nokp', $targetNokps);

        // Filter Tahun (Oleh sebab kursus_thmula adalah DATE, whereYear boleh guna)
        if($tahun){
            $kursusQuery->whereYear('kursus_thmula', $tahun);
        }

        // OPTIONAL: Filter Status Sah? (Uncomment jika perlu kira yang lulus saja)
        // $kursusQuery->where('kursus_sah', 1);

        $kursusRows = $kursusQuery->get();

        // 5. Mapping Hari ke Staff
        $hariPerStaff = [];

        foreach($kursusRows as $r){
            // Pastikan nokp dari table kursus pun kita trim juga
            $kp = trim($r->kursus_nokp); 
            $hari = (int) $r->kursus_bilhari; // Cast to int, null jadi 0
            
            if(!isset($hariPerStaff[$kp])) {
                $hariPerStaff[$kp] = 0;
            }
            $hariPerStaff[$kp] += $hari;
        }

        // 6. Aggregation Data
        $summary = [
            'total_staff' => 0,
            'staff_lebih7' => 0,
            'staff_kurang7' => 0,
            'staff_tidak_hadir' => 0,
            'total_hari_kursus' => 0
        ];

        // Struktur data kumpulan
        $byKumpulanData = [
            'jusa' => ['kumpulan' => 'jusa', 'total_staff' => 0, 'lebih7' => 0, 'kurang7' => 0, 'tidak_hadir' => 0, 'total_hari' => 0],
            'pnp' => ['kumpulan' => 'pnp', 'total_staff' => 0, 'lebih7' => 0, 'kurang7' => 0, 'tidak_hadir' => 0, 'total_hari' => 0],
            'sokongan1' => ['kumpulan' => 'sokongan1', 'total_staff' => 0, 'lebih7' => 0, 'kurang7' => 0, 'tidak_hadir' => 0, 'total_hari' => 0],
            'sokongan2' => ['kumpulan' => 'sokongan2', 'total_staff' => 0, 'lebih7' => 0, 'kurang7' => 0, 'tidak_hadir' => 0, 'total_hari' => 0],
        ];

        foreach($staffList as $staf){
            // Logic match guna IC yang dah di-trim
            $kp = trim($staf->NoKP);
            $sumHari = isset($hariPerStaff[$kp]) ? $hariPerStaff[$kp] : 0;
            
            // Normalize nama kumpulan (lowercase)
            $groupKey = strtolower($staf->kumpulan ?? '');
            
            // Fallback kalau kumpulan null atau typo
            if(!array_key_exists($groupKey, $byKumpulanData)){
                // Boleh create category 'lain-lain' atau masukkan ke salah satu group default
                // Buat masa ni kita skip error, anggap masuk unknown tapi kira dalam summary
                $groupKey = null; 
            }

            // Update Summary Global
            $summary['total_staff']++;
            $summary['total_hari_kursus'] += $sumHari;

            // Tentukan kategori kehadiran
            $isLebih7 = $sumHari >= 7;
            $isKurang7 = $sumHari > 0 && $sumHari < 7;
            $isTidakHadir = $sumHari == 0;

            if($isLebih7) $summary['staff_lebih7']++;
            elseif($isKurang7) $summary['staff_kurang7']++;
            elseif($isTidakHadir) $summary['staff_tidak_hadir']++;

            // Update Data Kumpulan (Jika valid)
            if($groupKey){
                $byKumpulanData[$groupKey]['total_staff']++;
                $byKumpulanData[$groupKey]['total_hari'] += $sumHari;

                if($isLebih7) $byKumpulanData[$groupKey]['lebih7']++;
                elseif($isKurang7) $byKumpulanData[$groupKey]['kurang7']++;
                elseif($isTidakHadir) $byKumpulanData[$groupKey]['tidak_hadir']++;
            }
        }

        return response()->json([
            'success' => true,
            'jabatan' => $jabatan,
            'lantikan' => $lantikan,
            'tahun' => $tahun,
            'summary' => $summary,
            'by_kumpulan' => array_values($byKumpulanData)
        ]);
    }
}