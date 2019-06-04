<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use SGPS\Entity\Flag;
use SGPS\Entity\Group;

class InsertDefaultFlags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    	Schema::table('flags', function (Blueprint $table) {
    		$table->string('behavior')->default('\SGPS\Behavior\DefaultFlag');
    		$table->longText('conditions')->nullable();
    		$table->dropColumn('default_assigned_group_id');
	    });

    	Schema::table('groups', function (Blueprint $table) {
    		$table->string('code')->index()->nullable()->after('id');
    		$table->dropColumn('shortcode');
	    });

    	Schema::create('flag_groups', function (Blueprint $table) {
    		$table->increments('id');
    		$table->string('flag_code')->index();
    		$table->string('group_code')->index();
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
