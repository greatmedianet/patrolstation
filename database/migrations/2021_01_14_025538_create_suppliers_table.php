<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->integer('supplier_type');
            $table->date('paid_date')->nullable();
            $table->longText('address');
            $table->integer('quantities')->default(0);
            $table->integer('price_per_liter')->default(0);
            $table->integer('total_amount')->default(0);
            $table->unsignedBigInteger('tank_id');
            $table->foreign('tank_id')->references('id')->on('tanks');
            $table->unsignedBigInteger('shop_id');
            $table->foreign('shop_id')->references('id')->on('shops');
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
        Schema::dropIfExists('suppliers');
    }
}
