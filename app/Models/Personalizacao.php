<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Personalizacao extends Model
{

    protected $fillable = [
        'id_produto',
        'id_pedido',
        'personalizacao_pedida',
        'opcoes_selecionadas',
    ];

    /**
     * Relação com o Produto
     */
    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class, 'id_produto');
    }

    /**
     * Relação com o Pedido
     */
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

}
