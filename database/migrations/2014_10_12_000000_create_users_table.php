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
            $table->string('iban')->nullable();
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
