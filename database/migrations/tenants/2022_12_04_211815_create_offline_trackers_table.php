<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfflineTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_trackers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('env_device_id')->constrained();
            $table->timestamp('alarm_date');
            $table->decimal('temperature', 10, 2);
            $table->boolean('message_sent')->default(false);
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
        Schema::dropIfExists('offline_trackers');
    }
}
