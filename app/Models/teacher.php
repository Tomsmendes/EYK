<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'specialization'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Métodos para manipular conteúdo de vídeo
    public function createVideocontent(array $params): bool
    {
        // Lógica para criar conteúdo
        return true;
    }

    public function updateVideocontent(int $id, array $params): bool
    {
        // Lógica para atualizar conteúdo
        return true;
    }

    public function getCourses(): array
    {
        // Lógica para retornar cursos
        return [];
    }
}
