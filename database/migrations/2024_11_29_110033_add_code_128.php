<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('pgsql')->table('sources', function (Blueprint $table) {
            $table->integer('kod_128')->nullable();
            $table->integer('donation_org_128')->nullable();
            $table->date('birth_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql')->table('sources', function (Blueprint $table) {
            $table->dropColumn('kod_128');
            $table->dropColumn('donation_org_128');
        });
    }
};
