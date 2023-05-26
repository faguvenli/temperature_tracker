<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvDeviceDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('env_device_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('env_device_id')->constrained();
            $table->decimal('temperature', 10, 2)->nullable();
            $table->decimal('humidity', 10, 2)->nullable();
            $table->integer('battery')->nullable();
            $table->integer('adv_interval')->nullable();
            $table->string('source_gateway_mac')->nullable();
            $table->timestamp('record_date')->nullable();
            $table->timestamps();

            $table->index(['record_date', 'env_device_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('env_device_data');
    }
}
