<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'title',
        'description',
        'order'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function questionarios()
    {
        return $this->hasMany(Questionario::class);
    }
}