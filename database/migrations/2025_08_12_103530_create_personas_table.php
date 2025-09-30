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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('card_id')->nullable();
            $table->string('ms_card_id')->nullable();
            $table->string('lastname')->nullable();
            $table->string('name')->nullable();
            $table->string('middlename')->nullable();
            $table->string('gender')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('IdentityDocs')->nullable();
            $table->string('address')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('kell')->nullable();
            $table->string('phenotype')->nullable();
            $table->string('created')->nullable();
            $table->string('LastModifiedDate')->nullable();
            $table->string('rh_factor')->nullable();
            $table->string('snils')->nullable();
            $table->string('document_serial');
            $table->string('document_number');
            $table->string('document');
            $table->boolean('validated')->default(true);
            $table->string('document_type')->nullable();
            $table->string('anti_erythrocyte_antibodies', length: 1)->nullable();
            $table->integer('kod_128')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
