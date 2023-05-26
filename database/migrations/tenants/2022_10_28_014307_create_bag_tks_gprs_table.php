<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBagTksGprsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bag_tks_gprs', function (Blueprint $table) {
            $table->id();
            $table->string('imei')->nullable();
            $table->decimal('isi1', 8, 2)->default(0);
            $table->dateTime('date_time')->nullable();
            $table->integer('batarya')->nullable();
            $table->timestamps();

            $table->index(['date_time']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bag_tks_gprs');
    }
}
