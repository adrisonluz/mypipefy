<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterAssigneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_assignees', function (Blueprint $table) {
            $table->integer('assignee_id')->unsigned();
            $table->foreign('assignee_id')->references('pipefy_id')->on('pipefyusers');
            $table->integer('filter_id')->unsigned();
            $table->foreign('filter_id')->references('id')->on('filters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filter_assignees');
    }
}
