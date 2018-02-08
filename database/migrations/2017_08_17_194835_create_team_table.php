<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('pipefy_id')->unsigned();
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        Schema::table('team', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('pipefy_id')->references('pipefy_id')->on('pipefyusers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team');
    }
}
