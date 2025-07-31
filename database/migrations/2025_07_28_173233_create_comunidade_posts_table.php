<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('comunidade_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // usuário que publicou
            $table->text('conteudo');              // o conteúdo publicado
            $table->timestamps();                  // created_at e updated_at

            // Relacionamento com users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comunidade_posts');
    }
};
