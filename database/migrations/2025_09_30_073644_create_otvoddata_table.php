<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otvoddata', function (Blueprint $table) {
            $table->id();
            $table->string('address', 255)->nullable();
            $table->string('lastname', 255);
            $table->string('name', 255);
            $table->string('middlename', 255)->nullable();
            $table->integer('card_id');
            $table->date('birth_date')->nullable();
            $table->string('ex_type', 50);
            $table->string('org_ex_name', 255)->nullable();
            $table->text('comment')->nullable();
            $table->string('document_serial', 50);
            $table->string('document_number', 50);
            $table->string('document', 255);
            $table->string('snils', 20)->nullable();
            $table->tinyInteger('blood_group');
            $table->string('rh_factor', 10)->nullable();
            $table->text('analysis_result')->nullable();
            $table->string('otv_kart', 255)->nullable();
            $table->string('otv_type', 50)->nullable();
            $table->date('ex_created')->nullable();
            $table->integer('kod_128');
            $table->string('gender', 1)->nullable();
            $table->string('kell', 1)->nullable();
            $table->string('phenotype', 6)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otvoddata');
    }
};
