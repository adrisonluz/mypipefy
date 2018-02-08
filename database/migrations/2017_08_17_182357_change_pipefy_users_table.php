<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePipefyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pipefyusers');

        Schema::create('pipefyusers', function (Blueprint $table) {
            $table->integer('pipefy_id')->unique()->unsigned();
            $table->string('email')->unique();
            $table->string('username');
            $table->string('name')->nullable();
            $table->text('avatar_url');
            $table->timestamps();

            $table->primary('pipefy_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pipefyusers');

        Schema::create('pipefyusers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('username');
            $table->string('name')->nullable();
            $table->integer('pipefy_id')->unique();
            $table->mediumText('avatar_url');
            $table->timestamps();
        });
    }
}
