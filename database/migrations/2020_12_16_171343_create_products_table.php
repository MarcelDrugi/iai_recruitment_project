<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{

    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->float('unit_price', 8, 2);
            $table->string('unit', 64)->default('szt');
            $table->float('tax', 8, 4);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
