<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CommentaryUser extends Migration
{
    public function up()
    {
        Schema::create('commentary_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("commentary_id");
            $table->unsignedBigInteger("user_id");
            $table->foreign("commentary_id")->references("id")->on("commentaries")->onDelete("cascade");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
        });
    }
    public function down()
    {
        Schema::dropIfExists('commentary_user');   
    }
}
