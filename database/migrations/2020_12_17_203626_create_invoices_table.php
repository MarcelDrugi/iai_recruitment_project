<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigInteger('issuer_id')->unsigned();
            $table->timestamps();
            $table->bigInteger('code')->unsigned();
            $table->date('date');
            $table->string('nip', 10)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->float('delivery_cost', 8, 2)->default(0);
            $table->float('to_pay', 8, 2)->nullable();
        });
        
        Schema::table('invoices', function (Blueprint $table) {
            $table->primary('code');
            $table->foreign('issuer_id')
            ->references('id')
            ->on('issuers')
            ->onDelete('RESTRICT');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
