<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 'descricao', 'caminho_video', 'caminho_thumbnail', 'user_id', 'aula_id', 'upload_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }
}