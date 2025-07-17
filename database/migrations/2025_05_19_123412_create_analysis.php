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
        Schema::create('analyses', function (Blueprint $table) {
            $table->id();
            $table->string('lastname', length: 255);
            $table->string('name', length: 255);
            $table->string('middlename', length: 255)->nullable();
            $table->string('gender', length: 1)->nullable();
            $table->string('document', length: 255);
            $table->string('address', length: 255)->nullable();
            $table->string('document_serial', length: 50);
            $table->string('document_number', length: 50);
            $table->string('snils', length: 20)->nullable();
            $table->string('birth_date')->nullable();
            $table->integer('rh_factor')->nullable();
            $table->integer('kell')->nullable();
            $table->string('analysis_date')->nullable();

            $table->integer('hb')->nullable();
            $table->integer('soe')->nullable();
            $table->integer('belok')->nullable();
            $table->integer('abo')->nullable();
            $table->integer('trom')->nullable();
            $table->integer('num')->nullable();
            $table->integer('bel_fr')->nullable();
            $table->decimal('erit', 10, 2)->nullable();
            $table->decimal('cwet', 10, 2)->nullable();
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
            $table->decimal('svrn', 10, 2)->nullable();
            $table->decimal('krtok', 10, 2)->nullable();
            $table->decimal('gemat', 10, 2)->nullable();
            $table->decimal('mch', 10, 2)->nullable();
            $table->decimal('mchc', 10, 2)->nullable();
            $table->decimal('ret', 10, 2)->nullable();
            $table->decimal('mcv', 10, 2)->nullable();
            $table->decimal('svrk', 10, 2)->nullable();

            $table->string('document_type');
            $table->string('created');
            $table->string('phenotype', length: 6)->nullable();
            $table->integer('donor_mail_num');
            $table->integer('mail_num')->nullable();
            $table->boolean('validated')->default(true);
            $table->string('LastModifiedDate')->nullable();
            $table->integer('kod_128')->nullable();
            $table->integer('OrgId')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
