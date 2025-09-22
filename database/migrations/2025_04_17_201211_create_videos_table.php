<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
        $table->id();
        $table->string('titulo'); // título do vídeo
        $table->text('descricao')->nullable(); // descrição
        $table->string('caminho_video', 255); // caminho do arquivo do vídeo
        $table->string('caminho_thumbnail', 255)->nullable(); // thumbnail opcional
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // usuário que enviou
        $table->foreignId('aula_id')->nullable()->constrained()->onDelete('cascade'); // agora opcional
        $table->timestamps();
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
