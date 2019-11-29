<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('brand', 30);
            $table->enum('volume', ['250ml', '600ml', '1l']);
            $table->enum('type', ['PET', 'GARRAFA', 'LATA']);
            $table->double('quantity', 8, 2);
            $table->double('unit_value', 8, 2);
            $table->unique(['brand', 'volume']);
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
        Schema::dropIfExists('products');
    }
}
