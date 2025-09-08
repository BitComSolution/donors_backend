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
        Schema::connection('pgsql')->create('sources', function (Blueprint $table) {
            $table->id();
            $table->integer('card_id');
            $table->integer('mail_num')->nullable();
            $table->string('org_name', length: 39)->nullable();
            $table->string('lastname', length: 30);
            $table->string('name', length: 30);
            $table->string('middlename', length: 30)->nullable();
            $table->string('gender', length: 1)->nullable();
            $table->date('birth_date');
            $table->string('snils', length: 11)->nullable();
            $table->tinyInteger('blood_group')->nullable();
            $table->string('rh_factor', length: 1)->nullable();
            $table->string('kell', length: 1)->nullable();
            $table->string('phenotype', length: 6)->nullable();
            $table->string('document', length: 30);
            $table->string('donation_id', length: 12);
            $table->integer('donor_card_id');
            $table->tinyInteger('donation_org_id');
            $table->string('donation_org_name', length: 39)->nullable();
            $table->string('donation_type_id', length: 3);
            $table->date('donation_date');
            $table->string('donation_barcode', length: 12);
            $table->smallInteger('donation_volume');
            $table->string('address', length: 120)->nullable();
            $table->string('document_type', length: 7);
            $table->string('document_serial', length: 5);
            $table->string('document_number', length: 6);
            $table->string('anti_erythrocyte_antibodies', length: 1)->nullable();
            $table->string('donation_analysis_result', length: 120)->nullable();
            $table->integer('donor_card_id_2');
            $table->smallInteger('org_ex_id');
            $table->string('org_ex_name', length: 39)->nullable();
            $table->string('ex_type', length: 2);
            $table->string('ex_name', length: 198)->nullable();
            $table->date('ex_started')->nullable();
            $table->date('ex_removed')->nullable();
            $table->date('ex_created')->nullable();
            $table->tinyInteger('author_id');
            $table->string('research_id', length: 12);
            $table->integer('org_owner_id')->nullable();
//            $table->string('org_owner_id', length: 39)->nullable();
            $table->string('org_owner_id_code', length: 39)->nullable();
//            $table->tinyInteger('org_owner_id_code')->nullable();
            $table->integer('donor_card_id_3');
            $table->date('research_date');
            $table->string('research_result', length: 9);
            $table->date('created');
            $table->tinyInteger('author_id_code');
            $table->string('author_id_name', length: 39)->nullable();
            $table->string('remove_flg', length: 10);
            $table->string('analysis_result', length: 10)->nullable();
            $table->string('doctor_visit_id', length: 100);
            $table->string('org_owner_id_code_2', length: 39)->nullable();
//            $table->tinyInteger('org_owner_id_code_2');
            $table->integer('org_owner_id_2')->nullable();
//            $table->string('org_owner_id_2', length: 39)->nullable();
            $table->integer('donor_card_id_4');
//            $table->string('donor_card_id_4', length: 39);
            $table->date('research_date_2');
            $table->date('created_2');
            $table->tinyInteger('author_id_2');
            $table->string('remove_flg_2', length: 10);
            $table->string('doctor_visit_result', length: 100)->nullable();
            $table->integer('donor_card_id_5');
            $table->string('comment', length: 250)->nullable();
            $table->string('analysis_value', length: 100)->nullable();
            $table->string('analysis_lower_bound', length: 100)->nullable();
            $table->string('analysis_upper_bound', length: 100)->nullable();
            $table->string('analysis_value_2', length: 100)->nullable();
            $table->string('doctor_visit_value', length: 100)->nullable();
            $table->boolean('validated')->default(true);
            $table->json('error')->nullable();
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
            $table->timestamps();
        });
//        Schema::connection('db_two')->create('blooddata', function (Blueprint $table) {
//            $table->id();
//            $table->integer('card_id');
//            $table->integer('mail_num')->nullable();
//            $table->string('org_name', length: 39)->nullable();
//            $table->string('lastname', length: 30);
//            $table->string('name', length: 30);
//            $table->string('middlename', length: 30)->nullable();
//            $table->string('gender', length: 1)->nullable();
//            $table->date('birth_date');
//            $table->string('snils', length: 11)->nullable();
//            $table->tinyInteger('blood_group')->nullable();
//            $table->string('rh_factor', length: 1)->nullable();
//            $table->string('kell', length: 1)->nullable();
//            $table->string('phenotype', length: 6)->nullable();
//            $table->string('document', length: 30);
//            $table->string('donation_id', length: 12);
//            $table->integer('donor_card_id');
//            $table->tinyInteger('donation_org_id');
//            $table->string('donation_org_name', length: 39)->nullable();
//            $table->string('donation_type_id', length: 3);
//            $table->date('donation_date');
//            $table->string('donation_barcode', length: 12);
//            $table->smallInteger('donation_volume');
//            $table->string('address', length: 120)->nullable();
//            $table->string('document_type', length: 7);
//            $table->string('document_serial', length: 5);
//            $table->string('document_number', length: 6);
//            $table->string('anti_erythrocyte_antibodies', length: 1)->nullable();
//            $table->string('donation_analysis_result', length: 120)->nullable();
//            $table->integer('donor_card_id_2');
//            $table->smallInteger('org_ex_id');
//            $table->string('org_ex_name', length: 39)->nullable();
//            $table->string('ex_type', length: 2);
//            $table->string('ex_name', length: 198)->nullable();
//            $table->date('ex_started');
//            $table->date('ex_removed')->nullable();
//            $table->date('ex_created');
//            $table->tinyInteger('author_id');
//            $table->string('research_id', length: 12);
//            $table->integer('org_owner_id')->nullable();
////            $table->string('org_owner_id', length: 39)->nullable();
//            $table->string('org_owner_id_code', length: 39)->nullable();
////            $table->tinyInteger('org_owner_id_code')->nullable();
//            $table->integer('donor_card_id_3');
//            $table->date('research_date');
//            $table->string('research_result', length: 9);
//            $table->date('created');
//            $table->tinyInteger('author_id_code');
//            $table->string('author_id_name', length: 39)->nullable();
//            $table->string('remove_flg', length: 10);
//            $table->string('analysis_result', length: 10)->nullable();
//            $table->string('doctor_visit_id', length: 100);
//            $table->string('org_owner_id_code_2', length: 39)->nullable();
////            $table->tinyInteger('org_owner_id_code_2');
//            $table->integer('org_owner_id_2')->nullable();
////            $table->string('org_owner_id_2', length: 39)->nullable();
//            $table->integer('donor_card_id_4');
////            $table->string('donor_card_id_4', length: 39);
//            $table->date('research_date_2');
//            $table->date('created_2');
//            $table->tinyInteger('author_id_2');
//            $table->string('remove_flg_2', length: 10);
//            $table->string('doctor_visit_result', length: 100)->nullable();
//            $table->integer('donor_card_id_5');
//            $table->string('comment', length: 250)->nullable();
//            $table->string('analysis_value', length: 100)->nullable();
//            $table->string('analysis_lower_bound', length: 100)->nullable();
//            $table->string('analysis_upper_bound', length: 100)->nullable();
//            $table->string('analysis_value_2', length: 100)->nullable();
//            $table->string('doctor_visit_value', length: 100)->nullable();
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql')->dropIfExists('sources');
//        Schema::connection('db_two')->dropIfExists('blooddata');
    }
};
