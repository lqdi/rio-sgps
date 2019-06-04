<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBaseModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    	Schema::create('residences', function (Blueprint $table) {
    		$table->uuid('id');
    		$table->primary('id');

    		$table->string('sector_code')->index()->nullable();
    		$table->decimal('lat', 12, 8)->nullable();
    		$table->decimal('lng', 12, 8)->nullable();

    		$table->string('address')->nullable();
    		$table->string('territory')->nullable();
    		$table->string('reference')->nullable();

    		$table->string('gis_global_id')->index()->nullable();

    		$table->timestamps();
    		$table->softDeletes();
	    });

        Schema::create('families', function (Blueprint $table) {
        	$table->uuid('id');
        	$table->primary('id');

        	$table->uuid('residence_id')->index()->nullable();
        	$table->uuid('person_in_charge_id')->index()->nullable();

        	$table->decimal('ipm_rate', 12, 6)->nullable();
        	$table->integer('ipm_risk_factor')->nullable();

        	$table->string('visit_status')->index()->default('pending');
        	$table->integer('visit_attempt')->index()->default(1);
        	$table->date('visit_last')->nullable();

	        $table->string('gis_global_id')->index()->nullable();

        	$table->timestamps();
        	$table->softDeletes();
        });

        Schema::create('persons', function (Blueprint $table) {
        	$table->uuid('id');
        	$table->primary('id');

        	$table->uuid('residence_id')->index()->nullable();
        	$table->uuid('family_id')->index()->nullable();

	        $table->string('name')->nullable();

	        $table->string('nis')->index()->nullable();
	        $table->string('cpf')->index()->nullable();
	        $table->string('rg')->index()->nullable();

	        $table->string('phone_number')->index()->nullable();

	        $table->string('gis_global_id')->index()->nullable();

	        $table->timestamps();
	        $table->softDeletes();
        });

        Schema::create('questions', function (Blueprint $table) {
        	$table->uuid('id');
        	$table->primary('id');


        	$table->string('code')->index();
        	$table->string('key')->index();
        	$table->string('entity')->index();
        	$table->string('type')->default('string');

        	$table->integer('order')->index()->default(0);

        	$table->string('name')->nullable();
        	$table->mediumText('description')->nullable();

        	$table->longText('triggers')->nullable();

        	$table->timestamps();
        	$table->softDeletes();
        });

        Schema::create('answers', function (Blueprint $table) {
	        $table->uuid('id');
	        $table->primary('id');

	        $table->uuid('question_id')->index();
	        $table->string('question_code')->index();
	        $table->string('question_key')->index();

	        $table->uuid('residence_id')->index()->nullable();
	        $table->uuid('family_id')->index()->nullable();
	        $table->uuid('person_id')->index()->nullable();
	        $table->uuid('operator_id')->index()->nullable();

	        $table->string('value_string')->nullable();
	        $table->integer('value_integer')->nullable();
	        $table->longText('value_json')->nullable();

	        $table->boolean('is_filled')->index()->default(false);

	        $table->timestamps();
	        $table->softDeletes();

        });

        Schema::create('question_categories', function (Blueprint $table) {
        	$table->uuid('question_id');
        	$table->string('category_code');
        	$table->primary(['question_id', 'category_code']);
        });

        Schema::create('groups', function (Blueprint $table) {
        	$table->uuid('id');
        	$table->primary('id');

        	$table->string('name')->nullable();
        	$table->string('primary_category_code')->nullable();

        	$table->timestamps();
        	$table->softDeletes();
        });

        Schema::create('user_groups', function (BLueprint $table) {
        	$table->uuid('user_id');
        	$table->uuid('group_id');
        	$table->primary(['user_id', 'group_id']);
        	$table->timestamps();
        });

        Schema::create('flags', function (Blueprint $table) {
        	$table->uuid('id');
        	$table->primary('id');

        	$table->string('code')->index();
        	$table->string('name')->nullable();
        	$table->mediumText('description')->nullable();

        	$table->longText('triggers')->nullable();

        	$table->boolean('is_visible')->index()->default(true);

        	$table->timestamps();
        	$table->softDeletes();
        });

        Schema::create('flagged_entities', function (Blueprint $table) {
        	$table->increments('id');

        	$table->uuid('flag_id')->index();
        	$table->string('entity_type')->index();
        	$table->uuid('entity_id')->index();

        	$table->date('reference_date')->index()->nullable();
        	$table->integer('deadline')->default(30);

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
        //
    }
}
