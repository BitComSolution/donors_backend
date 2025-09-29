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
        Schema::connection('pgsql')->create('scheduleds', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->dateTime('last_start')->default(now());
            $table->integer('period_hours')->default(1);
            $table->boolean('run')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql')->dropIfExists('scheduleds');
    }
};
