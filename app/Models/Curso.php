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
<<<<<<< HEAD
        'user_id'
=======
        'price',
        'duration',
        'user_id',
>>>>>>> a8dcb6eaa9105b060fbf8c2d91853bd393a587b1
    ];
    
    public function aulas()
    {
        return $this->hasMany(Aula::class);
    }
}