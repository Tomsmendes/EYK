<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionario extends Model
{
    use HasFactory;

    protected $fillable = [
        'aula_id',
        'qt_name',
        'qt_descricao'
    ];

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function perguntas()
    {
        return $this->hasMany(Pergunta::class);
    }
}
