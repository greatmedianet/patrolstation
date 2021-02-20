<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('Date');
            $table->string('Invoice_No');
            $table->string('Supplier');
            $table->integer('Supplier_Type');
            $table->integer('Product');
            $table->decimal('Qty')->default(0);
            $table->integer('Price')->default(0);
            $table->integer('Tank_Id');
            $table->integer('Shop_Id');
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
        Schema::dropIfExists('purchases');
    }
}
