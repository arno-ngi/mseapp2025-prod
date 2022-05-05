<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->bigInteger('tenant_id')->unsigned()->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->string('name')->nullable();
            $table->string('firstname')->nullable();
            $table->string('initials')->nullable();
            $table->string('username')->nullable();
            $table->string('ad_email')->nullable();
            $table->string('notifier_position')->default('bottom-right');
            $table->string('color_mode')->default('light');
            $table->string('lang')->default('nl');
            $table->boolean('is_deleted')->default(false);
            $table->boolean('is_superadmin')->default(false);
            $table->boolean('is_onserver')->default(false);
            $table->boolean('is_clientvisible')->default(false);
            $table->boolean('is_active')->default(false);
            $table->integer('tariftype')->default(1);
            $table->integer('rows_per_table')->default(10);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('lastseen')->nullable();
            $table->string('birthplace')->nullable();
            $table->dateTime('birthdate')->nullable();
            $table->string('birth_country')->nullable();
            $table->string('gender')->nullable();
            $table->string('language')->nullable();
            $table->string('national_register_no')->nullable();
            $table->string('nationality')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('telephone')->nullable();
            $table->string('bankaccountno')->nullable();
            $table->string('hospital_previous_eployer')->nullable();
            $table->string('contract_no')->nullable();
            $table->string('meal_voucher_card')->nullable();
            $table->string('transport_used')->nullable();
            $table->string('civil_status')->nullable();
            $table->dateTime('marriage_date')->nullable();
            $table->string('name_partner')->nullable();
            $table->string('birthdate_partner')->nullable();
            $table->string('medicard_no')->nullable();
            $table->boolean('add_to_hospitalization')->default(false);
            $table->string('no_persons_dependant')->nullable();
            $table->string('contact_ice')->nullable();
            $table->string('contact_ice_number')->nullable();
            $table->string('clothing_shirt_sweater')->nullable();
            $table->string('clothing_trousers')->nullable();
            $table->string('clothing_shoes')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
