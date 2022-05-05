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
        Schema::create('expense_requests', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->bigInteger('tenant_id')->unsigned()->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->bigInteger('requester_id')->unsigned()->nullable();
            $table->foreign('requester_id')->references('id')->on('users');
            $table->bigInteger('invoice_request_id')->unsigned()->nullable();
            $table->foreign('invoice_request_id')->references('id')->on('invoice_requests');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->double('total_cost')->nullable();
            $table->double('final_invoiceamount')->nullable();
            $table->string('internal_information')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('bankstatement')->nullable();
            $table->string('supplier')->nullable();
            $table->integer('status')->default(1);
            $table->dateTime('expense_date')->nullable();
            $table->string('uniqueid')->nullable();
            $table->string('iban')->nullable();
            $table->string('currency')->default('EUR');
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
        Schema::dropIfExists('expense_requests');
    }
};
