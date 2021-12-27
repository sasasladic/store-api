<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            //Restrict delete, because of the history of orders
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('product_variant_id')->constrained()->restrictOnDelete();
            $table->string('status');
            $table->integer('quantity');
            // On update that 'product variant' in_stock, check if needs to send/deliver more. If yes, make calculation for here and how many items are in stock
            // quantity > items_sent, on update action
            $table->integer('items_sent');
            $table->double('sum');
            $table->string('address');
            $table->foreignId('related_order_id')->nullable()->constrained('orders')->restrictOnDelete();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
