<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanks', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('shop_id');
            $table->foreign('shop_id')->references('id')->on('shops');
            $table->integer('product_id');
            $table->integer('max_quantities')->default(0);
            $table->integer('current_quantities')->default(0);
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
        Schema::dropIfExists('tanks');
    }
}
