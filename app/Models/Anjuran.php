<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anjuran extends Model
{
    use HasFactory;

    protected $table = 'anjuran';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'nama_anjuran',
        'sort',
    ];
}
