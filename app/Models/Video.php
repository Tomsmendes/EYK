<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'aula_id',
        'file_path',
        'vd_name',
        'vd_descricao'
    ];

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }
}