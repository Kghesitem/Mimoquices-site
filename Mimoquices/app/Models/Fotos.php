<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Fotos extends Model
{
    use HasFactory;
    // correct table name for photos
    protected $table = 'fotos_produto';

    protected $fillable =[
        'group_img',
        'img_original',
        'img_cod',
    ];
}
