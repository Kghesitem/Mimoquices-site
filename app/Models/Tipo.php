<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    protected $table = 'tipo';

    protected $fillable = [
        'Categoria',
    ];

    // Relação com personalizações
    public function personalizacoes()
    {
        return $this->belongsToMany(
            TodasAsPersonalizacoes::class,
            'acossiadas_tipo', // tabela pivot
            'id_tipo',               // FK deste model na pivot
            'id_todas'               // FK do personalizacao
        );
    }
}
