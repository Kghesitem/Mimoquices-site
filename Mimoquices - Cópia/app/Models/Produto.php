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
        'conteudo',
        'detalhes',
        'url_completo',
        'tipo_prod',
        'nome_original',
        'nome_cod',
        'pode_personalizar',
        'personalizar_opcoes',
        'group_img'
    ];
    public function getRouteKeyName()
    {
        return 'url_completo';
    }

    public function personalizacoes()
    {
        return $this->hasMany(Personalizacao::class);
    }
}
