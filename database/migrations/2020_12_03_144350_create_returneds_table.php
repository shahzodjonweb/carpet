<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returneds', function (Blueprint $table) {
            $table->id();
            $table->string('productname');
            $table->integer('barcode');
            $table->integer('number');
            $table->double('volume')->nullable();
            $table->integer('d1')->nullable();
            $table->integer('d2')->nullable();
            $table->string('color')->nullable();
            $table->string('type')->nullable();
            $table->string('design')->nullable();
            $table->double('price')->nullable();
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
        Schema::dropIfExists('returneds');
    }
}
