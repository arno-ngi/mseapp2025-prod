<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('date_identitycard')->nullable();
            $table->dateTime('date_goedgedragenzeden')->nullable();
            $table->string('partner_name')->nullable();
            $table->string('partner_firstname')->nullable();
            $table->dateTime('partner_birthdate')->nullable();
            $table->boolean('partner_tenlaste')->nullable();
            $table->boolean('partner_mindervalide')->nullable();
            $table->string('beroepsinkomsten')->nullable();
            $table->string('personentenlaste_kind_valide')->nullable();
            $table->string('personentenlaste_kind_invalide')->nullable();
            $table->string('personentenlaste_65mantel_valide')->nullable();
            $table->string('personentenlaste_65mantel_invalide')->nullable();
            $table->string('personentenlaste_65overgang_valide')->nullable();
            $table->string('personentenlaste_65overgang_invalide')->nullable();
            $table->string('personentenlaste_andere_valide')->nullable();
            $table->string('personentenlaste_andere_invalide')->nullable();
            $table->string('prive_email')->nullable();
            $table->string('telefoon')->nullable();
            $table->string('ice_name')->nullable();
            $table->string('ice_number')->nullable();
            $table->string('clothing_shirt')->nullable();
            $table->string('clothing_pants')->nullable();
            $table->string('burgerlijke_staat')->nullable();
            $table->string('opleidingsniveau')->nullable();
        });
    }


    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('has_allowance');
        });
    }
};
