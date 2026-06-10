<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// CORREÇÃO: Nome da classe alterado para PascalCase
class TodasAsPersonalizacoes extends Model
{
    use HasFactory;

    protected $table = 'todas_as_personalizacoes';

    protected $fillable = [
        'titulo',
        'descrição',
        'tipo_de_input',
    ];


    public function respostas()
    {
        return $this->hasMany(TodasAsRespostas::class, 'id_personalizacao');
    }

    public function tipos()
    {
        return $this->belongsToMany(
            Tipo::class,
            'acossiadas_tipo',
            'id_todas',
            'id_tipo'
        );
    }
}
