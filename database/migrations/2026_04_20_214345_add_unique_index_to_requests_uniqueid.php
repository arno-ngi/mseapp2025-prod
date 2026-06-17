<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $this->handleDuplicates('invoice_requests');
        $this->handleDuplicates('expense_requests');

        Schema::table('invoice_requests', function (Blueprint $table) {
            $table->unique('uniqueid');
        });

        Schema::table('expense_requests', function (Blueprint $table) {
            $table->unique('uniqueid');
        });
    }

    protected function handleDuplicates(string $table)
    {
        $duplicates = DB::table($table)
            ->select('uniqueid')
            ->whereNotNull('uniqueid')
            ->groupBy('uniqueid')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('uniqueid');

        foreach ($duplicates as $uniqueid) {
            $records = DB::table($table)
                ->where('uniqueid', $uniqueid)
                ->orderBy('id')
                ->get();

            // Keep the first one, append ID to others
            foreach ($records->skip(1) as $record) {
                DB::table($table)
                    ->where('id', $record->id)
                    ->update(['uniqueid' => $uniqueid . '-DUP-' . $record->id]);
            }
        }
    }

    public function down()
    {
        Schema::table('invoice_requests', function (Blueprint $table) {
            $table->dropUnique(['uniqueid']);
        });

        Schema::table('expense_requests', function (Blueprint $table) {
            $table->dropUnique(['uniqueid']);
        });
    }
};
