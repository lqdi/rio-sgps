<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFamilyIdToFlagAssignments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('flagged_entities', 'flag_attributions');

        Schema::table('flag_attributions', function (Blueprint $table) {
        	$table->uuid('residence_id')->after('flag_id')->index();
        });

        \SGPS\Entity\FlagAttribution::all()->each(function ($attribution) {

        	if($attribution->entity_type === 'residence') {
        		$attribution->residence_id = $attribution->entity_id;
	        } else {
		        $attribution->residence_id = $attribution->entity->residence_id;
	        }

	        $attribution->save();
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
