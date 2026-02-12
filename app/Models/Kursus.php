<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kursus extends Model
{
    use HasFactory;

    protected $table = 'kursus';
    protected $primaryKey = 'kursus_ID';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'kursus_sah',
        'kursus_idprogram',
        'kursus_idaktiviti',
        'kursus_tajuk',
        'kursus_thmula',
        'kursus_thtamat',
        'kursus_bilhari',
        'kursus_biljam',
        'kursus_tempat',
        'kursus_anjuran',
        'kursus_jenistempat',
        'kursus_namanegeri',
        'kursus_rujukan',
        'kursus_tahun',
        'kursus_bulan',
        'kursus_daftar',
        'kursus_msmula',
        'kursus_msakhir',
        'kursus_sumber',
        'kursus_pembentangan',
        'kursus_penyelia',
        'kursus_sijil',
        'kursus_tarikhsijil',
        'NoKP',
        'kursus_nokp',
        'ts',
        'txt_online',
        'NoKP', 
        'Nama',
        'Gred', 
        'KodMaksud', 
        'NamaJabatan', 
        'Cawangan',
        'Unit', 
        'Jawatan', 
        'glrnjawatan', 
        'Th_Masuk', 
        'ThPegang', 
        'Th_Sah',
        'ThTugas', 
        'katalaluan', 
        'emel', 
        'hp', 
        'telpej', 
        'jantina', 
        'firsttimelogin', 
        'faks', 
        'soalan', 
        'jawapan', 
        'kategori', 
        'aktif', 
        'last_login', 
        'last_logout', 
        'bil_hari', 
        'bil_jam',
        'gambar', 
        'userlevel', 
        'kumpulan', 
        'lantikan', 
        'blacklist', 
        'penyelia_keberkesanan', 
        'penyelia_trm', 
        'ketuajabatan',
        'skim_id', 
        'bidang_id', 
        'trm_id', 
        'gred_sspa', 
        'gred_str', 
        'gred_num', 
        'sspa_num', 
        'Auto'
    ];

    public function infoAnjuran(){
        // Parameter: Model, Foreign Key (di table kursus), Owner Key (di table anjuran)
        return $this->belongsTo(Anjuran::class, 'kursus_anjuran', 'ID');
    }
}
