<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_cards', function (Blueprint $table) {
            $table->id();
            $table->string('GSMID');
            $table->string('SIMID')->nullable();
            $table->string('PIN1')->nullable();
            $table->string('PUK1')->nullable();
            $table->string('PIN2')->nullable();
            $table->string('PUK2')->nullable();
            $table->string('IMEI')->nullable();
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
        Schema::dropIfExists('data_cards');
    }
}
