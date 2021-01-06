<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commentaries', function (Blueprint $table) {
            $table->id();
            $table->text("descripcion");
            $table->unsignedBigInteger("likes")->nullable();
            $table->unsignedBigInteger("dislikes")->nullable();

            $table->unsignedBigInteger("id_questions");
            $table->unsignedBigInteger("id_users");
            $table->foreign("id_questions")->references("id")->on("questions")->onDelete("cascade");
            $table->foreign("id_users")->references("id")->on("users")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentaries');
    }
}
