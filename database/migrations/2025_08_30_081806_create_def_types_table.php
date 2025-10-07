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
        Schema::create('def_types', function (Blueprint $table) {
            $table->id();
            $table->string('aistCode')->collation('utf8mb4_bin')->nullable();
            $table->string('eidbCode')->collation('utf8mb4_bin')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('def_types');
    }
};
