<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Helpdesk extends Model
{
    use HasFactory;

    
    protected $table = 'helpdesks';
    
    protected $primaryKey = 'id';

    protected $keyType = 'string';
    
    protected $fillable = [
        'helpdesk_user_name',
        'helpdesk_user_email',
        'helpdesk_user_phone',
        'helpdesk_kategori',
        'helpdesk_subjek_aduan',
        'helpdesk_butiran_aduan',
        'NoKP',
        'Nama',
        'NamaJabatan'
    ];
}
