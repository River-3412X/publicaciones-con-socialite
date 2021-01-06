<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCommentariesTable extends Migration
{
    
    public function up()
    {
        Schema::create('sub_commentaries', function (Blueprint $table) {
            $table->id();
            $table->text("descripcion");
            $table->unsignedBigInteger("likes")->nullable();
            $table->unsignedBigInteger("dislikes")->nullable();

            $table->unsignedBigInteger("id_commentaries");
            $table->unsignedBigInteger("id_users");
            $table->foreign("id_commentaries")->references("id")->on("commentaries")->onDelete("cascade");
            $table->foreign("id_users")->references("id")->on("users")->onDelete("cascade");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_commentaries');
    }
}
