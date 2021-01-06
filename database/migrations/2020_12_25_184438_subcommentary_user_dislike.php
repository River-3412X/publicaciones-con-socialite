<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubcommentaryUserDislike extends Migration
{
    public function up()
    {
        Schema::create('sub_commentary_user_dislike', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("subcommentary_id");
            $table->unsignedBigInteger("user_id");
            $table->foreign("subcommentary_id")->references("id")->on("sub_commentaries")->onDelete("cascade");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
        });
    }
    public function down()
    {
        Schema::dropIfExists('sub_commentary_user_dislike');   
    }
}
