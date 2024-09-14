<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained('users');
            $table->foreignId('order_id')->constrained('orders');
            $table->enum('status', ['assigned', 'cancel', 'in_progress', 'completed']);
            $table->integer('quantity');
            $table->dateTime('order_deadline');
            $table->foreignId('orderlist_id')->constrained('order_lists');
            $table->foreignId('product_id')->constrained('products');
            $table->string('product_name');
            $table->string('product_image');
            $table->string('farmer_name');
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
        Schema::dropIfExists('works');
    }
}
