<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    /**
     * Explicit table name (migration created 'produto' singular).
     */
    protected $table = 'produto';

    protected $fillable =[
        'titulo',
        'descricao',
        'url_completo',
        'tipo_prod',
        'nome_original',
        'nome_cod',
        'group_img'
    ];
    public function getRouteKeyName()
    {
        return 'url_completo';
    }
}
