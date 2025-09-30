<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analclidata', function (Blueprint $table) {
            $table->id();
            $table->integer('num')->nullable();
            $table->date('analysis_date')->nullable();
            $table->integer('hb')->nullable();
            $table->decimal('erit', 10, 2)->nullable();
            $table->decimal('cwet', 10, 2)->nullable();
            $table->decimal('ret', 10, 2)->nullable();
            $table->integer('trom')->nullable();
            $table->decimal('leyk', 10, 2)->nullable();
            $table->decimal('palja', 10, 2)->nullable();
            $table->decimal('segja', 10, 2)->nullable();
            $table->decimal('eos', 10, 2)->nullable();
            $table->decimal('bas', 10, 2)->nullable();
            $table->decimal('lim', 10, 2)->nullable();
            $table->decimal('mon', 10, 2)->nullable();
            $table->decimal('plkl', 10, 2)->nullable();
            $table->decimal('miel', 10, 2)->nullable();
            $table->decimal('meta', 10, 2)->nullable();
            $table->integer('soe')->nullable();
            $table->decimal('svrn', 10, 2)->nullable();
            $table->decimal('svrk', 10, 2)->nullable();
            $table->decimal('krtok', 10, 2)->nullable();
            $table->decimal('gemat', 10, 2)->nullable();
            $table->integer('belok')->nullable();
            $table->integer('abo')->nullable();
            $table->string('rh', 10)->nullable();
            $table->string('kell', 10)->nullable();
            $table->decimal('mch', 10, 2)->nullable();
            $table->decimal('mchc', 10, 2)->nullable();
            $table->decimal('mcv', 10, 2)->nullable();
            $table->integer('bel_fr')->nullable();
            $table->integer('donor_mail_num');
            $table->string('phenotype', 6)->nullable();
            $table->integer('mail_num')->nullable();
            $table->string('document_serial', 50);
            $table->string('document_number', 50);
            $table->string('document', 255);
            $table->string('lastname', 255);
            $table->string('name', 255);
            $table->string('middlename', 255)->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('snils', 20)->nullable();
            $table->date('birth_date')->nullable();
            $table->integer('kod_128')->default(7701);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analclidata');
    }
};
