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
        Schema::create('otvods', function (Blueprint $table) {
            $table->id();
            $table->integer('card_id');
            $table->string('lastname', length: 255);
            $table->string('name', length: 255);
            $table->string('middlename', length: 255)->nullable();
            $table->string('gender', length: 1)->nullable();
            $table->string('ex_type', length: 2);
            $table->string('org_ex_name', length: 39)->nullable();
            $table->string('comment', length: 250)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('snils', length: 20)->nullable();
            $table->string('analysis_result')->nullable();
            $table->string('otv_kart', length: 255)->nullable();
            $table->string('otv_type', length: 50)->nullable();
            $table->tinyInteger('blood_group')->nullable();
            $table->string('rh_factor', length: 1)->nullable();
            $table->string('kell', length: 1)->nullable();
            $table->string('phenotype', length: 6)->nullable();
            $table->string('document', length: 255);
            $table->string('address', length: 255)->nullable();
            $table->string('document_serial', length: 50);
            $table->string('document_number', length: 50);
            $table->date('created')->nullable();//created
            $table->integer('kod_128')->nullable();
            $table->boolean('validated')->default(true);
            $table->json('error')->nullable();
            $table->string('document_type', length: 255)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otvods');
    }
};
