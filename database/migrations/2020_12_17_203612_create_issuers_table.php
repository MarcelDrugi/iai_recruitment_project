<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuersTable extends Migration
{
    public function up()
    {
        Schema::create('issuers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nip', 10);
            $table->string('name', 255);
            $table->string('address', 255);
            $table->string('telephone', 16)->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists('issuers');
    }
}
