<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('pgsql')->table('analclidata', function (Blueprint $table) {
            $table->integer('anal_org_kod_128')->nullable();
        });
        Schema::connection('pgsql')->table('osmotrdata', function (Blueprint $table) {
            $table->integer('osmtor_org_kod_128')->nullable();
        });
        DB::statement("
                ALTER TABLE osmotrdata
                MODIFY COLUMN address VARCHAR(300)
                CHARACTER SET utf8mb4
                COLLATE utf8mb4_0900_ai_ci
                NULL
            ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
