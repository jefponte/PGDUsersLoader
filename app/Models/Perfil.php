<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $connection = 'petrvs';

    protected $table = 'perfis';

    protected $fillable = [
        'id',
        'nome',
        'created_at',
        'updated_at',
    ];

    public $incrementing = false;

    protected $keyType = 'string';
}
