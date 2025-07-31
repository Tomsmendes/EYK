<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\PostLike;
use App\Models\PostComment;


class ComunidadePost extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'conteudo'];

    // Um post pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function comentarios()
    {
        return $this->hasMany(PostComment::class);
    }

}
