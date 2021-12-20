<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            
            $table->unsignedBigInteger('cart_id')->unsigned();
            $table->bigInteger('pro_id')->unsigned();
            $table->string('email');
            $table->string('payment_id');
            $table->decimal('amount');    
            $table->boolean('payment_status');    
                
            $primaryKey = 'id';  

            $table->foreign('cart_id')->references('id')->on('carts');      
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
        Schema::dropIfExists('payments');
    }
}
