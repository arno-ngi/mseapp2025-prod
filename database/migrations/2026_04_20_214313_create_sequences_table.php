<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sequences', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable();
            $table->string('type'); // 'RFA', 'ER', etc.
            $table->string('category_id')->nullable();
            $table->integer('year');
            $table->integer('last_value')->default(0);
            $table->timestamps();

            $table->unique(['tenant_id', 'type', 'category_id', 'year'], 'tenant_type_category_year_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sequences');
    }
};
