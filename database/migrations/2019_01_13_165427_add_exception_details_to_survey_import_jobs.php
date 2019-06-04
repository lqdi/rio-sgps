<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExceptionDetailsToSurveyImportJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("survey_import_jobs", function (Blueprint $table) {
        	$table->string('exception_message')->nullable()->after('stage');
        	$table->longText('exception_object')->nullable()->after('exception_message');
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
