<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShortcodeToEntities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = ['families', 'flags', 'groups', 'persons', 'residences', 'users'];

        foreach($tables as $name) {
        	Schema::table($name, function (Blueprint $table) {
        		$table->string('shortcode')->index()->after('id')->nullable();
	        });
        }
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
