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

            
            $table->unsignedBigInteger('cart_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('pro_id')->unsigned();
            $table->decimal('quantity');
            $table->string('address');
            $table->string('email');
            $table->string('phone');
            $table->string('payment_type');            
            $primaryKey = 'id';    
                    
            $table->foreign('cart_id')->references('id')->on('carts');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('pro_id')->references('id')->on('products');
            

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
        Schema::dropIfExists('orders');
    }
}
