<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_code')->unsigned();
            $table->timestamps();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->float('unit_net_price', 8, 2);
            $table->string('unit', 64);
            $table->smallInteger('quantity');
            $table->float('tax', 8, 4);
            $table->float('tax_value', 8, 2);
            $table->float('total_cost', 8, 2);
        });
        
        Schema::table('items', function (Blueprint $table) {
            $table->foreign('invoice_code')
            ->references('code')
            ->on('invoices')
            ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}
