<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Illuminate\Log\log;

class StatistikController extends Controller
{
    //
    public function statistikKehadiran(){
        return view('statistik_kehadiran');
    }

    public function getJabatan(Request $request){
        $jabatan = $request->query('nama');

        //fetch dari lampirana
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

        //sort ikut lantikan
        $lantikanList = [
            'Tetap', 'Sementara', 'Kontrak'
        ];
        $result = [];

        foreach($lantikanList as $lantikan){
            $subset = $data->where('lantikan', $lantikan);
            if($subset->isEmpty())continue;

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
        $jabatan = $request->query('NamaJabatan');
        $lantikan = $request->query('lantikan');
        $tahun = $request->query('tahun');
        $namaStaff = $request->query('Nama');
        $nokp = $request->query('NoKP');

        //fetch data table lampirana
        $staffQuery = DB::table('lampirana')
        ->select('NoKP', 'Nama', 'kumpulan', 'lantikan', 'NamaJabatan')
        ->where('NamaJabatan', $jabatan);

        if($lantikan){
            $staffQuery->where('lantikan', $lantikan);
        }

        $staffList = $staffQuery->get(); // collect staff variable store dalam $stafflist

        if($staffList->isEmpty()){
            return response()->json([
                'success'=>false,
                'message'=>'Tiada staff/lantikan yang ditemui dalam jabatan tersebut!'
            ]);
        }

        $nokpArr = $staffList->pluck('NoKP')->unique()->toArray();

        //fetch table kursus !!untuk hari
        $kursusData = DB::table('kursus')
        ->select('kursus_nokp', 'kursus_bilhari', 'kursus_thmula')
        ->whereIn('kursus_nokp', $nokpArr);
        
        if($tahun){
            $kursusData->whereYear('kursus_thmula', $tahun);
        }

        $kursusRows = $kursusData->get();

        $hariPerStaff = []; //create array for storing staff kursus day attend

        foreach($kursusRows as $r){
            $kp = $r->kursus_nokp;
            $hari = (int)$r->kursus_bilhari;
            if(!isset($hariPerStaff[$kp])) $hariPerStaff[$kp] = 0; //ni kalau variable null or not declared
            $hariPerStaff[$kp] += $hari;
        }

        //aggregation
        $summary = [
            'total_staff' => 0,
            'staff_lebih7' => 0,
            'staff_kurang7' => 0,
            'staff_tidak_hadir' => 0,
            'total_hari_kursus' => array_sum($hariPerStaff)
        ];

        $byKumpulan=[]; //array untuk kumpulan[pnp/jusa/sok1/sok2]

        foreach($staffList as $staf){
            $kp = $staf->NoKP;
            $group = $staf->kumpulan??'unknown';
            $sumHari = isset($hariPerStaff[$kp]) ? $hariPerStaff[$kp] : 0;

            //nak confirm key exist
            if(!isset($byKumpulan[$group])){
                $byKumpulan[$group] = [
                    'kumpulan' => $group,
                    'total_staff' => 0,
                    'lebih7' => 0,
                    'kurang7' => 0,
                    'tidak_hadir' => 0,
                    'total_hari' => 0
                ];
            }

            //update total
            $summary['total_staff']++;
            $byKumpulan[$group]['total_staff']++;
            $byKumpulan[$group]['total_hari']+=$sumHari;

            if($sumHari >=7){
                $summary['staff_lebih7']++;
                $byKumpulan[$group]['lebih7']++;
            } elseif($sumHari > 0 && $sumHari <= 6){
                $summary['staff_kurang7']++;
                $byKumpulan[$group]['kurang7']++;
            } elseif($sumHari == 0){
                $summary['staff_tidak_hadir']++;
                $byKumpulan[$group]['tidak_hadir']++;
            } else{
                    return response()->json([
                    'message' => 'sorang problem',
                    'NoKP' => $nokp,
                    'Nama staff' => $namaStaff
                ]);
            }
        }

        $byKumpulanArray = array_values($byKumpulan);

        return response()->json([
            'success' => true,
            'jabatan' => $jabatan,
            'lantikan' => $lantikan,
            'tahun' => $tahun,
            'summary' => $summary,
            'by_kumpulan' => $byKumpulanArray
        ]);
    }
}
