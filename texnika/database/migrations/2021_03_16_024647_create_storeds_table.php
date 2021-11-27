<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoredsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storeds', function (Blueprint $table) {
            $table->id();
            $table->string('productname');
            $table->integer('barcode')->nullable();
            $table->integer('number');
            $table->string('color')->nullable();
            $table->string('type')->nullable();
            $table->string('design')->nullable();
            $table->double('price')->nullable();
            $table->integer('qqs')->nullable();
            $table->integer('total')->nullable();
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
        Schema::dropIfExists('storeds');
    }
}
