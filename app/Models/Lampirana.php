<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampirana extends Model
{
    use HasFactory;

    protected $table = "lampirana"; 

    protected $primaryKey = 'NoKP';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'NoKP',
        'Nama',
        'NamaJabatan',
        'emel',
        'hp',
        'userlevel'
    ];

}
