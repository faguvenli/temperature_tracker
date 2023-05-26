<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('env_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->string('name');
            $table->string('device_mac');
            $table->boolean('confirmed')->default(false);
            $table->integer('device_type');
            $table->boolean('alarm_active')->default(true);
            $table->decimal('temperature_calibration_trim', 10,2)->nullable();
            $table->decimal('humidity_calibration_trim', 10 , 2)->nullable();
            $table->decimal('temperature_max', 10, 2)->nullable();
            $table->decimal('temperature_min', 10, 2)->nullable();
            $table->decimal('humidity_max',10,2)->nullable();
            $table->decimal('humidity_min', 10, 2)->nullable();
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
        Schema::dropIfExists('env_devices');
    }
}
