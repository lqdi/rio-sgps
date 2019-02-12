<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToSurveyImports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survey_import_families', function (Blueprint $table) {
			$table->string('logradouro')->nullable();
			$table->string('numero')->nullable();
			$table->string('complement')->nullable();
			$table->string('cep')->nullable();
			$table->string('outro_prog')->nullable();
			$table->string('renda_fam')->nullable();
			$table->string('renda_cpta')->nullable();
			$table->string('perf_renda')->nullable();

			$table->string('ipma1', 128)->nullable()->change();
			$table->string('ipma2', 128)->nullable()->change();
			$table->string('ipma3', 128)->nullable()->change();
			$table->string('ipmb4', 128)->nullable()->change();
			$table->string('ipmb5', 128)->nullable()->change();
			$table->string('ipmc6', 128)->nullable()->change();
			$table->string('ipmc7', 128)->nullable()->change();
			$table->string('ipmc8', 128)->nullable()->change();
			$table->string('ipmc9', 128)->nullable()->change();
			$table->string('ipmc10', 128)->nullable()->change();
			$table->string('ipmc11', 128)->nullable()->change();
			$table->string('ipm', 128)->nullable()->change();
        });

        Schema::table('survey_import_members', function (Blueprint $table) {
			$table->string('flag_rn', 3)->nullable();
			$table->string('pos_renda')->nullable();
			$table->string('renda_memb')->nullable();
			$table->string('deficienc')->nullable();
			$table->string('tipo_defic')->nullable();
			$table->string('flag_vis', 3)->nullable();
			$table->string('flag_aud', 3)->nullable();
			$table->string('flag_fis', 3)->nullable();
			$table->string('flag_ment', 3)->nullable();
			$table->string('flag_outra', 3)->nullable();
			$table->string('outra_def')->nullable();
			$table->string('flag_idade', 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
