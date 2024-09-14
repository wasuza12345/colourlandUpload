<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuantityProductForFarmerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('quantityProduct_for_farmer'); // ลบตารางถ้ามีอยู่แล้ว
        Schema::create('quantityProduct_for_farmer', function (Blueprint $table) {
            $table->id();
            $table->integer('flower_quantity')->unsigned();
            $table->date('delivery_timeframe');
            $table->foreignId('product_id')->constrained('products');
            $table->enum('typefolwer', ['flower', 'tray']);
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quantityProduct_for_farmer');
    }
}
