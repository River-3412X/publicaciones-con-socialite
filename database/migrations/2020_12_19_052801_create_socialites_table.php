<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socialites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_users");
            $table->foreign("id_users")->references("id")->on("users")->onDelete("cascade");
            $table->string("id_social")->unique();
            $table->string("nombre_social");
            $table->string("nombre");
            $table->string("email");
            $table->text("avatar");
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
        Schema::dropIfExists('socialites');
    }
}
