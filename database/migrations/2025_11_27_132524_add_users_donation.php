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
        Schema::connection('pgsql')->table('m_s_configs', function (Blueprint $table) {
            $table->string('vich')->default('1');
            $table->string('hbs')->default('1');
            $table->string('sif')->default('1');
            $table->string('hcv')->default('1');
            $table->string('pcr')->default('1');
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
