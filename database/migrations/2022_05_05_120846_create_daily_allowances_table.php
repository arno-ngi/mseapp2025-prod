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
        Schema::create('daily_allowances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_request_id')->unsigned();
            $table->foreign('invoice_request_id')->references('id')->on('invoice_requests');
            $table->dateTime('from_date')->nullable();
            $table->dateTime('to_date')->nullable();
            $table->string('visit_to')->nullable();
            $table->float('days')->nullable();
            $table->float('entertainment')->nullable();
            $table->string('purposes')->nullable();
            $table->boolean('leave_after_noon')->nullable();
            $table->boolean('arrive_before_noon')->nullable();
            $table->boolean('advance_payment')->nullable();
            $table->float('allowance_per_day')->nullable();
            $table->float('allowance_total')->nullable();
            $table->boolean('tme_inhouse')->nullable();
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
        Schema::dropIfExists('daily_allowances');
    }
};
