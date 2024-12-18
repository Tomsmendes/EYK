<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'preferred'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollInCourse(int $course_id): bool
    {
        // Lógica para matricular em um curso
        return true;
    }

    public function getEnrolledCourses(): array
    {
        // Lógica para retornar cursos matriculados
        return [];
    }

    public function getSupportContent(): array
    {
        // Lógica para obter conteúdo de suporte
        return [];
    }
}
