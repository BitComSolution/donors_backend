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
            $table->integer('gender')->nullable()->change();
            $table->integer('rh_factor')->nullable()->change();
            $table->integer('kell')->nullable()->change();
            $table->integer('OrgId')->nullable();
            $table->string('LastModifiedDate')->nullable();

            $table->string('created')->nullable()->change();
            $table->string('birth_date')->nullable()->change();
            $table->string('donation_date')->nullable()->change();
            $table->string('ex_started')->nullable()->change();
            $table->string('ex_removed')->nullable()->change();
            $table->string('ex_created')->nullable()->change();
            $table->string('research_date')->nullable()->change();
            $table->string('research_date_2')->nullable()->change();
            $table->string('created_2')->nullable()->change();

        });
        Schema::connection('pgsql')->table('otvods', function (Blueprint $table) {
            $table->string('birth_date')->nullable()->change();
            $table->integer('gender')->nullable()->change();
            $table->integer('rh_factor')->nullable()->change();
            $table->integer('kell')->nullable()->change();
            $table->string('created')->nullable()->change();
            $table->string('LastModifiedDate')->nullable();
            $table->integer('OrgId')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
