<?php

namespace App\Models;

use Illuminate\Cache\HasCacheLock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Helpdesk extends Model
{
    use HasFactory;

    protected $table = 'helpdesks';

    protected $fillable = [
        'helpdesk_user_name',
        'helpdesk_user_email',
        'helpdesk_user_phone',
        'helpdesk_kategori',
        'helpdesk_subjek_aduan',
        'helpdesk_butiran_aduan'
    ];
}
