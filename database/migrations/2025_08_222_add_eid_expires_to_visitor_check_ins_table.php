<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('visitor_check_ins', function (Blueprint $table) {
            $table->date('eid_expires')->nullable()->after('photoblob');
        });
    }

    public function down()
    {
        Schema::table('visitor_check_ins', function (Blueprint $table) {
            $table->dropColumn('eid_expires');
        });
    }
};
