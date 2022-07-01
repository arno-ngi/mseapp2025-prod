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
        Schema::create('visitor_check_ins', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('licenseplate')->nullable();
            $table->string('reason')->nullable();
            $table->dateTime('checkin')->nullable();
            $table->dateTime('checkout')->nullable();
            $table->integer('status')->default(1);
            $table->string('nationalnumber')->nullable();
            $table->string('nationality')->nullable();
            $table->string('gender')->default('m')->nullable();
            $table->string('language')->default('nl')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('birthplace')->nullable();
            $table->binary('photoblob')->nullable();
            $table->string('country_iso')->nullable();
            $table->string('country')->nullable();
            $table->string('address_zip')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_number')->nullable();
            $table->string('address_extra')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
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
        Schema::dropIfExists('visitor_check_ins');
    }
};
