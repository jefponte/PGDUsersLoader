<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidade extends Model
{
    use HasFactory;

    protected $connection = 'petrvs';

    protected $table = 'entidades';

    protected $fillable = [
        'id',
        'nome',
        'sigla',
        'created_at',
        'updated_at',
    ];

    public $incrementing = false;

    protected $keyType = 'string';
}
