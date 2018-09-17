<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOperatorIdsToFamily extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('families', function (Blueprint $table) {
        	$table->string('alert_reporter_name')->nullable()->after('visit_last');
        	$table->uuid('created_by')->nullable()->index()->after('alert_reporter_name');
        	$table->uuid('case_opened_by')->nullable()->index()->after('created_by');
        });

        Schema::table('persons', function (Blueprint $table) {
	        $table->uuid('created_by')->nullable()->index()->after('phone_number');
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
