<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('p_name');
            $table->text('p_desc');
            $table->decimal('p_price', $places = 2, $unsigned =TRUE);
            $table->string('p_cat');
            $table->json('p_tag');            
            $table->boolean('is_avail');  
            
            $table->timestamps();

            $primaryKey = 'id';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
