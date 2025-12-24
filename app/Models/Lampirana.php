<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Lampirana extends Authenticable
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
        'userlevel',
        'gambar'
    ];
    protected $hidden = ['katalaluan'];
    public function username(){
        return 'NoKP';
    }
    public function getStatusBadge(){
        return match($this->userlevel){
            '0',0 => ['Pending', 'pending', 'clock'], //pending
            'SP' => ['Suspend', 'suspend', 'user-slash'], //suspended
            default => ['Error','error', 'user-fill'],
        }; 
    }
}
