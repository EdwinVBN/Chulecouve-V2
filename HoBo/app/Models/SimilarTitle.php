<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('serie_similar_title', function (Blueprint $table) {
            $table->unsignedBigInteger('serie_id');
            $table->unsignedBigInteger('similar_title_id');
            $table->float('similarity');
            $table->primary(['serie_id', 'similar_title_id']);
            $table->foreign('serie_id')->references('id')->on('series')->onDelete('cascade');
            $table->foreign('similar_title_id')->references('id')->on('similar_titles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('serie_similar_title');
    }
};
