<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_curso',
        'description',
        'category',
        'status',
        'thumbnail',
        'user_id'
    ];
    
    public function aulas()
    {
        return $this->hasMany(Aula::class);
    }
}