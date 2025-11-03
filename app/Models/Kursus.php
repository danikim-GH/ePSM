<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kursus extends Model
{
    use HasFactory;

    protected $table = 'kursus';
    protected $primaryKey = 'kursus_ID';
    public $timestamps = false;

    protected $fillable = [
        'kursus_sah',
        'kursus_idprogram',
        'kursus_idaktiviti',
        'kursus_nokp',
        'kursus_tahun',
        'kursus_bulan',
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
        'kursus_msmula',
        'kursus_msakhir',
        'kursus_daftar'        
    ];
}
