<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('pgsql')->table('sources', function (Blueprint $table) {
            $table->integer('donation_org_id')->change();
            $table->integer('author_id')->change();
            $table->integer('author_id_code')->change();
            $table->integer('author_id_2')->change();
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
