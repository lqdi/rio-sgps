<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('sectors', function (Blueprint $table) {
    		$table->increments('id');

    		$table->string('name')->nullable();

    		$table->integer('cod_bairro')->index();
		    $table->integer('cod_ra')->index();
		    $table->string('cod_rp')->index();
		    $table->integer('cod_ap')->index();

		    $table->timestamps();
		    $table->softDeletes();
	    });

    	Schema::create('sector_equipments', function (Blueprint $table) {
    		$table->increments('id');

    		$table->integer('sector_id')->index();
    		$table->uuid('equipment_id')->index();

    		$table->timestamps();
	    });

        Schema::create('equipments', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->string('type')->index();
            $table->string('code')->index();

            $table->string('name')->nullable();
            $table->string('address')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('families', function (Blueprint $table) {
        	$table->integer('sector_id')->after('shortcode')->index();
        });

        Schema::table('residences', function (Blueprint $table) {
        	$table->integer('sector_id')->after('shortcode')->index();
        	$table->dropColumn('sector_code');
        });

        Schema::table('persons', function (Blueprint $table) {
        	$table->integer('sector_id')->before('residence_id')->index();
        });

        \SGPS\Entity\Family::with('residence')->get()->each(function ($family) {
        	$family->sector_id = $family->residence->sector_id;
        	$family->save();
        });

        \SGPS\Entity\Person::with('residence')->get()->each(function ($person) {
        	$person->sector_id = $person->residence->sector_id;
        	$person->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipments');
    }
}
