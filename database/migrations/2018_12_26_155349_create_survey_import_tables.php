<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyImportTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create("survey_import_jobs", function(Blueprint $table) {
	    	$table->uuid('id');
	    	$table->primary('id');

	    	$table->string('families_csv')->nullable();
	    	$table->string('members_csv')->nullable();

	    	$table->string('stage')->default('csv_read')->index();

	    	$table->integer('num_families_read')->default(0);
	    	$table->integer('num_families_imported')->default(0);
	    	$table->integer('num_families_skipped')->default(0);
	    	$table->integer('num_persons_read')->default(0);
	    	$table->integer('num_persons_imported')->default(0);
	    	$table->integer('num_persons_skipped')->default(0);

	    	$table->timestamps();
	    });

        Schema::create("survey_import_families", function(Blueprint $table) {
        	$table->uuid('id');
        	$table->uuid('import_id')->index();

	        $table->primary(['id', 'import_id']);

        	$table->string('globalid')->nullable()->index();
        	$table->string('uniquerowid')->nullable()->index();

	        $table->string('objectid')->nullable();
	        $table->string('entrevista')->nullable();
	        $table->string('senha')->nullable();
	        $table->string('data')->nullable();
	        $table->string('setor')->nullable();
	        $table->string('x')->nullable();
	        $table->string('y')->nullable();
	        $table->string('endereco')->nullable();
	        $table->string('comunidade')->nullable();
	        $table->string('referencia')->nullable();
	        $table->string('obs')->nullable();
	        $table->string('status_ent')->nullable();
	        $table->string('ausente')->nullable();
	        $table->string('flag_nis')->nullable();
	        $table->string('nis')->nullable();
	        $table->string('flag_bf')->nullable();
	        $table->string('flag_cfc')->nullable();
	        $table->string('flag_bpc')->nullable();
	        $table->string('flag_outro')->nullable();
	        $table->string('qual_outro')->nullable();
	        $table->string('preoc_alim')->nullable();
	        $table->string('flag_mi')->nullable();
	        $table->string('idade_mi')->nullable();
	        $table->string('numero_fam')->nullable();
	        $table->string('paredes')->nullable();
	        $table->string('piso')->nullable();
	        $table->string('flag_chuv')->nullable();
	        $table->string('flag_vaso')->nullable();
	        $table->string('flag_pia')->nullable();
	        $table->string('agua')->nullable();
	        $table->string('esgoto')->nullable();
	        $table->string('comodos')->nullable();
	        $table->string('flag_fogao')->nullable();
	        $table->string('flag_filt')->nullable();
	        $table->string('flag_gel')->nullable();
	        $table->string('ipma1')->nullable();
	        $table->string('ipma2')->nullable();
	        $table->string('ipma3')->nullable();
	        $table->string('ipmb4')->nullable();
	        $table->string('ipmb5')->nullable();
	        $table->string('ipmc6')->nullable();
	        $table->string('ipmc7')->nullable();
	        $table->string('ipmc8')->nullable();
	        $table->string('ipmc9')->nullable();
	        $table->string('ipmc10')->nullable();
	        $table->string('ipmc11')->nullable();
	        $table->string('ipm')->nullable();
	        $table->string('risco_ipm')->nullable();
	        $table->string('created_date')->nullable();
	        $table->string('created_user')->nullable();
	        $table->string('last_edited_date')->nullable();
	        $table->string('last_edited_user')->nullable();
	        $table->string('x1')->nullable();
	        $table->string('y1')->nullable();

	        $table->timestamps();
        });

        Schema::create('survey_import_members', function (Blueprint $table) {

        	$table->uuid('id');
        	$table->uuid('import_id')->index();

	        $table->primary(['id', 'import_id']);

        	$table->uuid('family_id')->index();

	        $table->string('globalid')->nullable()->index();

	        $table->string('objectid')->nullable();
	        $table->string('parentesco')->nullable();
	        $table->string('nome')->nullable();
	        $table->string('nome_soc')->nullable();
	        $table->string('sexo')->nullable();
	        $table->string('raca_cor')->nullable();
	        $table->string('idade')->nullable();
	        $table->string('seis_meses')->nullable();
	        $table->string('nascimento')->nullable();
	        $table->string('nome_mae')->nullable();
	        $table->string('gravida')->nullable();
	        $table->string('flag_cn')->nullable();
	        $table->string('flag_rg')->nullable();
	        $table->string('rg')->nullable();
	        $table->string('flag_cpf')->nullable();
	        $table->string('cpf')->nullable();
	        $table->string('esc_5_anos')->nullable();
	        $table->string('freq_esc')->nullable();
	        $table->string('flag_ipma1')->nullable();
	        $table->string('flag_ipma2')->nullable();
	        $table->string('flag_ipma3')->nullable();
	        $table->string('parentrowid')->nullable();
	        $table->string('created_date')->nullable();
	        $table->string('created_user')->nullable();
	        $table->string('last_edited_date')->nullable();
	        $table->string('last_edited_user')->nullable();

	        $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_import_jobs');
        Schema::dropIfExists('survey_import_families');
        Schema::dropIfExists('survey_import_members');
    }
}
