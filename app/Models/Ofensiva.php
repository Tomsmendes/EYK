<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ofensiva extends Model
{
    protected $fillable = ['titulo', 'data', 'descricao', 'user_id'];

    /**
     * Relacionamento: uma ofensiva pertence a um usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
