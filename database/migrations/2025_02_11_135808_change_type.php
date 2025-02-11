<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('pgsql')->table('sources', function (Blueprint $table) {
            $table->string('org_name')->nullable()->change();
            $table->string('lastname')->change();
            $table->string('name')->change();
            $table->string('middlename')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->date('birth_date')->change();
            $table->string('snils')->nullable()->change();
            $table->string('rh_factor')->nullable()->change();
            $table->string('kell')->nullable()->change();
            $table->string('phenotype')->nullable()->change();
            $table->string('document')->change();
            $table->string('donation_id')->change();
            $table->string('donation_org_name')->nullable()->change();
            $table->string('donation_type_id')->change();
            $table->string('donation_barcode')->change();
            $table->integer('donation_volume')->change();
            $table->string('address')->nullable()->change();
            $table->string('document_type')->change();
            $table->string('document_serial')->change();
            $table->string('document_number')->change();
            $table->string('anti_erythrocyte_antibodies')->nullable()->change();
            $table->string('donation_analysis_result')->nullable()->change();
            $table->integer('org_ex_id')->change();
            $table->string('org_ex_name')->nullable()->change();
            $table->string('ex_type')->change();
            $table->string('ex_name')->nullable()->change();
            $table->string('research_id')->change();
            $table->string('org_owner_id_code')->nullable()->change();
            $table->string('research_result')->change();
            $table->string('author_id_name')->nullable()->change();
            $table->string('remove_flg')->change();
            $table->string('analysis_result')->nullable()->change();
            $table->string('doctor_visit_id')->change();
            $table->string('org_owner_id_code_2')->nullable()->change();
            $table->string('remove_flg_2')->change();
            $table->string('doctor_visit_result')->nullable()->change();
            $table->string('comment')->nullable()->change();
            $table->string('analysis_value')->nullable()->change();
            $table->string('analysis_lower_bound')->nullable()->change();
            $table->string('analysis_upper_bound')->nullable()->change();
            $table->string('analysis_value_2')->nullable()->change();
            $table->string('doctor_visit_value')->nullable()->change();
        });
        Schema::connection('pgsql')->table('otvods', function (Blueprint $table) {
            $table->string('lastname')->change();
            $table->string('name')->change();
            $table->string('middlename')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('ex_type')->change();
            $table->string('org_ex_name')->nullable()->change();
            $table->string('comment')->nullable()->change();
            $table->string('snils')->nullable()->change();
            $table->string('analysis_result')->nullable()->change();
            $table->string('otv_kart')->nullable()->change();
            $table->string('otv_type')->nullable()->change();
            $table->integer('blood_group')->nullable()->change();
            $table->string('rh_factor')->nullable()->change();
            $table->string('kell')->nullable()->change();
            $table->string('phenotype')->nullable()->change();
            $table->string('document')->change();
            $table->string('address')->nullable()->change();
            $table->string('document_serial')->change();
            $table->string('document_number')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
