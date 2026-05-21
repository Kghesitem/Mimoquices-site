<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class todas_as_respostas extends Model
{
    use HasFactory;

    protected $table = 'respostas';

    protected $fillable = [
        'id_personalizacao',
        'resposta',
    ];

    // Relação inversa para a personalização
    public function personalizacao()
    {
        return $this->belongsTo(Todas_as_personalizacoes::class, 'id_todas');
    }
}