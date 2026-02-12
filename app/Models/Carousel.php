<?php
// app/Models/Carousel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'button_text',
        'button_link',
        'image_path',
        'order',
        'is_active',
        'show_text',
        'overlay_opacity'
    ];
}