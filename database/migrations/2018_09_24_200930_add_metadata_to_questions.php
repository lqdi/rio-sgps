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
        	$table->json('field_settings')->nullable()->after('type');
        	$table->json('field_options')->nullable()->after('field_settings');
        	$table->json('conditions')->nullable()->after('triggers');
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
