<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido';

    protected $fillable = [
        'id_user',      
        'estado',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function personalizacoes()
    {
        return $this->hasMany(Personalizacao::class, 'id_pedido');
    }

}


