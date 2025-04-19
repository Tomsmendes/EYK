<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('category');
            $table->string('status');
            $table->timestamp('published_at')->nullable();
            $table->string('thumbnail')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('duration')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cursos');
    }
};