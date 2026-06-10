<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Associadas extends Model
{
    use HasFactory;

    protected $table = 'acossiadas_tipo';

    protected $fillable = [
        'id',
        'id_tipo',
        'id_todas',
        'PDF'
    ];
}
