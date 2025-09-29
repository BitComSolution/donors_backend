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
        Schema::create('osmotrs', function (Blueprint $table) {
            $table->id();
            $table->integer('card_id');
            $table->integer('kod_128');
            $table->tinyInteger('blood_group')->nullable();
            $table->integer('rh_factor')->nullable();
            $table->integer('kell')->nullable();
            $table->string('phenotype')->nullable();
            $table->string('anti_erythrocyte_antibodies')->nullable();
            $table->string('document_type');
            $table->string('date')->nullable();
            $table->integer('ad_sis')->nullable();
            $table->integer('ad_dias')->nullable();
            $table->integer('puls')->nullable();
            $table->decimal('temp', 10, 2)->nullable();
            $table->integer('doza')->nullable();
            $table->integer('ves')->nullable();
            $table->string('document_serial');
            $table->string('document_number');
            $table->string('document');
            $table->string('lastname');
            $table->string('name');
            $table->string('middlename')->nullable();
            $table->integer('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('snils')->nullable();
            $table->string('birth_date')->nullable();
            $table->integer('rost')->nullable();
            $table->boolean('validated')->default(true);
            $table->string('LastModifiedDate')->nullable();
            $table->integer('OrgId')->nullable();
            $table->json('error')->nullable();
            $table->string('created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('osmotrs');
    }
};
