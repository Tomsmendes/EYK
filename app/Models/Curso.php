<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'category',
        'status',
        'published_at',
        'thumbnail',
        'price',
        'duration',
        'user_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'price' => 'decimal:2',
        'duration' => 'integer'
    ];

    public function aulas()
    {
        return $this->hasMany(Aula::class);
    }
}