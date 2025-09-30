<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blooddata', function (Blueprint $table) {
            $table->id();
            $table->integer('card_id');
            $table->integer('mail_num')->nullable();
            $table->string('org_name', 40)->nullable();
            $table->string('lastname', 30);
            $table->string('name', 30);
            $table->string('middlename', 30)->nullable();
            $table->string('gender', 1)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('snils', 11)->nullable();
            $table->tinyInteger('blood_group')->nullable();
            $table->string('rh_factor', 1)->nullable();
            $table->string('kell', 1)->nullable();
            $table->string('phenotype', 6)->nullable();
            $table->string('document', 30);
            $table->string('donation_id', 12);
            $table->integer('donor_card_id');
            $table->smallInteger('donation_org_id');
            $table->string('donation_org_name', 40)->nullable();
            $table->string('donation_type_id', 3);
            $table->date('donation_date')->nullable();
            $table->string('donation_barcode', 12);
            $table->smallInteger('donation_volume');
            $table->string('address', 300)->nullable();
            $table->string('document_type', 7);
            $table->string('document_serial', 5);
            $table->string('document_number', 6);
            $table->string('anti_erythrocyte_antibodies', 1)->nullable();
            $table->string('donation_analysis_result', 120)->nullable();
            $table->integer('donor_card_id_2');
            $table->smallInteger('org_ex_id');
            $table->string('org_ex_name', 40)->nullable();
            $table->string('ex_type', 2);
            $table->string('ex_name', 198)->nullable();
            $table->date('ex_started')->nullable();
            $table->date('ex_removed')->nullable();
            $table->date('ex_created')->nullable();
            $table->tinyInteger('author_id');
            $table->string('research_id', 12);
            $table->integer('org_owner_id')->nullable();
            $table->string('org_owner_id_code', 40)->nullable();
            $table->integer('donor_card_id_3');
            $table->date('research_date');
            $table->string('research_result', 9);
            $table->date('created')->nullable();
            $table->smallInteger('author_id_code');
            $table->string('author_id_name', 40)->nullable();
            $table->string('remove_flg', 10);
            $table->string('analysis_result', 10)->nullable();
            $table->string('doctor_visit_id', 100);
            $table->string('org_owner_id_code_2', 40);
            $table->integer('org_owner_id_2')->nullable();
            $table->integer('donor_card_id_4');
            $table->date('research_date_2')->nullable();
            $table->date('created_2')->nullable();
            $table->tinyInteger('author_id_2');
            $table->string('remove_flg_2', 10);
            $table->string('doctor_visit_result', 100)->nullable();
            $table->integer('donor_card_id_5');
            $table->string('comment', 250)->nullable();
            $table->string('analysis_value', 100)->nullable();
            $table->string('analysis_lower_bound', 100)->nullable();
            $table->string('analysis_upper_bound', 100)->nullable();
            $table->string('analysis_value_2', 100)->nullable();
            $table->string('doctor_visit_value', 100)->nullable();
            $table->integer('kod_128');
            $table->integer('donation_org_128');
            $table->string('vich', 10)->nullable();
            $table->string('hbs', 10)->nullable();
            $table->string('sif', 10)->nullable();
            $table->string('hcv', 10)->nullable();
            $table->string('pcr', 10)->nullable();
            $table->string('anti_a', 10)->nullable();
            $table->string('anti_b', 10)->nullable();
            $table->string('hla', 20)->nullable();
            $table->string('gra', 10)->nullable();
            $table->string('grb', 10)->nullable();
            $table->string('mn', 10)->nullable();
            $table->string('ss', 10)->nullable();
            $table->string('fy', 10)->nullable();
            $table->string('lu', 10)->nullable();
            $table->string('le', 10)->nullable();
            $table->string('jk', 10)->nullable();
            $table->string('kp', 10)->nullable();
            $table->string('pi', 10)->nullable();
            $table->string('pcrraw', 10)->nullable();
            $table->string('vichraw', 10)->nullable();
            $table->string('hbsraw', 10)->nullable();
            $table->string('sifraw', 10)->nullable();
            $table->string('hcvraw', 10)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blooddata');
    }
};
