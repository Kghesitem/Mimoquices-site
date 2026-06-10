<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodasAsRespostas extends Model
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
        return $this->belongsTo(TodasAsPersonalizacoes::class, 'id_todas');
    }
}
