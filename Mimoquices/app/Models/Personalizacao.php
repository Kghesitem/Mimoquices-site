<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personalizacao extends Model
{
    protected $table = 'personalizacaos';

    protected $fillable = [
        'personalizacao_pedida',
        'opcoes_selecionadas',
        'id_produto',
        'id_pedido',
    ];
}
