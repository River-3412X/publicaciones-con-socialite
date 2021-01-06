<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuestionUserDislike extends Migration
{
    public function up()
    {
        Schema::create('question_user_dislike', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("question_id");
            $table->unsignedBigInteger("user_id");
            $table->foreign("question_id")->references("id")->on("questions")->onDelete("cascade");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
        });
    }
    public function down()
    {
        Schema::dropIfExists('question_user_dislike');   
    }
}