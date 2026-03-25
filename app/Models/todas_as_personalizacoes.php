<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class todas_as_personalizacoes extends Model
{
    use HasFactory;

    protected $table = 'todas_as_personalizacoes';

    protected $fillable = [
        'titulo',    
        'descrição',
        'tipo_de_input',
    ];

    // Relação com respostas/opções
    public function respostas()
    {
        return $this->hasMany(todas_as_respostas::class, 'id_personalizacao');
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