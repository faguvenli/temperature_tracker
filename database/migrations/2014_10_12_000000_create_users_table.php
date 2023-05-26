<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('tcKimlikNo')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('isPanelUser')->default(false);
            $table->boolean('isSuperAdmin')->default(false);
            $table->boolean('send_email_notification')->default(false);
            $table->boolean('send_sms_notification')->default(false);
            $table->boolean('active')->default(true);
            $table->string('smsConfirmationCode')->nullable();
            $table->boolean('phoneNumberVerified')->default(false);
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
