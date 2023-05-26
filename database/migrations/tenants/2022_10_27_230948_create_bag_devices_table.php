<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBagDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bag_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->foreignId('bag_device_type_id')->nullable()->constrained();
            $table->string('device_model')->nullable();
            $table->string('device_mac')->nullable();
            $table->string('device_location')->nullable();
            $table->string('serial_number')->nullable();
            $table->decimal('temperature_calibration_trim', 10,2)->nullable();
            $table->decimal('temperature_max', 10, 2)->nullable();
            $table->decimal('temperature_min', 10, 2)->nullable();
            $table->timestamps();

            $table->index(['serial_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bag_devices');
    }
}
