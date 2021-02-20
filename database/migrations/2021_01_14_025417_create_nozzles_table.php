<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNozzlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nozzles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('pump_id');
            $table->foreign('pump_id')->references('id')->on('pumps');
            $table->unsignedBigInteger('tank_id');
            $table->foreign('tank_id')->references('id')->on('tanks');
            $table->integer('default_pump_meter')->default(0);
            $table->integer('current_pump_meter')->default(0);
            $table->string('pipe_length')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nozzles');
    }
}
