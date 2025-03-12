<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Authenticatable;

class Funcao extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name_fc',
        'descricao',
    ];
}
