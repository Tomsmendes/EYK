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
            $table->string('vd_name');
            $table->string('file_path', 255);
            $table->text('vd_descricao')->nullable();
            $table->unsignedBigInteger('aula_id');
            $table->timestamps();
            $table->foreign('aula_id')->references('id')->on('aulas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};