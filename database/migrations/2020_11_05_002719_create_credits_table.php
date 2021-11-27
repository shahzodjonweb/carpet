<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->integer('unicode');
            $table->char('contractcode');
            $table->text('contract');
            $table->text('productname');
            $table->integer('volume');
            $table->integer('debt_amount');
            $table->integer('debt_left');
            $table->integer('qqs')->nullable();
            $table->integer('first_payment');
            $table->integer('payment_time');
            $table->datetime('payment_timeleft');
            $table->datetime('payment_deadline')->nullable();
            $table->datetime('next_deadline')->nullable();
            $table->double('percentage')->nullable()->default(0);
            $table->double('penny')->nullable();
            $table->double('discount_percent')->nullable();
            $table->integer('discount_amount')->nullable();
            $table->integer('customer_id');
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
        Schema::dropIfExists('credits');
    }
}
