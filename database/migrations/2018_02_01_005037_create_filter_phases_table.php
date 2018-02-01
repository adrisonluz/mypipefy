<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterPhasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_phases', function (Blueprint $table) {
            $table->integer('phase_id')->unsigned();
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
        Schema::dropIfExists('filter_phases');
    }
}
