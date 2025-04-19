<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'aula_id',
        'url',
        'mt_descricao',
        'mt_name'
    ];

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }
}
