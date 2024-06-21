<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $connection = 'petrvs';

    protected $table = 'usuarios';

    protected $fillable = [
        'id',
        'email',
        'nome',
        'password',
        'cpf',
        'matricula',
        'apelido',
        'perfil_id',
        'situacao_funcional',
        'descricao_unidade',
        'sigla_unidade',
        'unidade_id',
        'created_at',
        'updated_at',
    ];

    public $incrementing = false;

    protected $keyType = 'string';
}
