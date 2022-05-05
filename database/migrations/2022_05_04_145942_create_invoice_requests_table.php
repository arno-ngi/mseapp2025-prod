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
        Schema::create('invoice_requests', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->bigInteger('tenant_id')->unsigned()->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->bigInteger('requester_id')->unsigned()->nullable();
            $table->foreign('requester_id')->references('id')->on('users');
            $table->double('total_invoice_amount')->nullable();
            $table->double('final_invoiceamount')->nullable();
            $table->string('internal_information')->nullable();
            $table->string('supplier')->nullable();
            $table->integer('status')->default(1);
            $table->dateTime('invoice_date')->nullable();
            $table->string('extra_info')->nullable();
            $table->string('invoicefile')->nullable();
            $table->string('final_amount_reason')->nullable();
            $table->double('final_amount')->nullable();
            $table->string('uniqueid')->nullable();
            $table->string('safety_assesment')->nullable();
            $table->string('safety_description')->nullable();
            $table->string('environment_assesment')->nullable();
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
        Schema::dropIfExists('invoice_requests');
    }
};
