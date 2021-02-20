<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjustments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('Date');
            $table->string('Adjustment_No');
            $table->integer('Adjustment_Type');
            $table->integer('Product');
            $table->decimal('Qty')->default(0);
            $table->integer('Price')->default(0);
            $table->integer('Tank_id');
            $table->integer('Shop_id');
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
        Schema::dropIfExists('adjustments');
    }
}
