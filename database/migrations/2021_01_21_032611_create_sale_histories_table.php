<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date');
            $table->string('invoice_no');
            $table->string('customer_name');
            $table->integer('business_type');
            $table->integer('product');
            $table->integer('pump_id');
            $table->integer('nozzle_id')->nullable();
            $table->integer('counter_id');
            $table->decimal('qty')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('price')->default(0);
            $table->integer('shop_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('sales_history');
    }
}
