<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();

            $table->string('slug')->nullable();
            $table->string('mail_info')->nullable();
            $table->string('o365_client_id')->nullable();
            $table->string('o365_client_secret')->nullable();
            $table->longText('o365_authorizationcode')->nullable();
            $table->longText('o365_accesstoken')->nullable();
            $table->longText('o365_refreshtoken')->nullable();
            $table->string('o365_expires_in')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_mail')->nullable();
            $table->string('shortname')->nullable();
            $table->text('localips')->nullable();
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
        Schema::dropIfExists('tenants');
    }
};
