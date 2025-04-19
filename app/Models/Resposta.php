<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    use HasFactory;

    protected $fillable = [
        'rp_texto', 'is_correct', 'pergunta_id'
    ];

    protected $casts = [
        'is_correct' => 'boolean'
    ];

    public function pergunta()
    {
        return $this->belongsTo(Pergunta::class);
    }
}