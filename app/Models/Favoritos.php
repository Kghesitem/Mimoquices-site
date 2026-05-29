<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favoritos extends Model
{
    // Vi no teu log que a tabela se chama 'favoritos_cliente'
    protected $table = 'favoritos_cliente';

    protected $fillable = ['id_user', 'id_produto'];

    /**
     * Define a relação: Um favorito pertence a um Produto.
     */
    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class, 'id_produto','id');
    }
}