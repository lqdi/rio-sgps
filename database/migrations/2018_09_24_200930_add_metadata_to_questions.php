<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetadataToQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
        	$table->renameColumn('type', 'field_type');
        	$table->renameColumn('entity', 'entity_type');
        	$table->longText('field_settings')->nullable()->after('type');
        	$table->longText('field_options')->nullable()->after('field_settings');
        	$table->longText('conditions')->nullable()->after('triggers');
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
