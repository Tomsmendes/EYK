<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pergunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'pg_texto', 'questionario_id'
    ];

    public function questionario()
    {
        return $this->belongsTo(Questionario::class);
    }

    public function respostas()
    {
        return $this->hasMany(Resposta::class);
    }
}