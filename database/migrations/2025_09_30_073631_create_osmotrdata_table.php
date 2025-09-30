<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('osmotrdata', function (Blueprint $table) {
            $table->id();
            $table->integer('card_id');
            $table->integer('kod_128');
            $table->tinyInteger('blood_group')->nullable();
            $table->string('rh_factor', 1)->nullable();
            $table->string('kell', 1)->nullable();
            $table->string('phenotype', 6)->nullable();
            $table->string('anti_erythrocyte_antibodies', 1)->nullable();
            $table->string('document_type', 7);
            $table->date('date')->nullable();
            $table->integer('ad_sis')->nullable();
            $table->integer('ad_dias')->nullable();
            $table->integer('puls')->nullable();
            $table->decimal('temp', 10, 2)->nullable();
            $table->integer('doza')->nullable();
            $table->integer('ves')->nullable();
            $table->string('document_serial', 5);
            $table->string('document_number', 6);
            $table->string('document', 30);
            $table->string('lastname', 30);
            $table->string('name', 30);
            $table->string('middlename', 30)->nullable();
            $table->string('gender', 1)->nullable();
            $table->string('address', 120)->nullable();
            $table->string('snils', 20)->nullable();
            $table->date('birth_date')->nullable();
            $table->integer('rost')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('osmotrdata');
    }
};
