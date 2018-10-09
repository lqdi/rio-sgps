<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeadlinesToFlags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("flags", function (Blueprint $table) {
        	$table->integer('default_deadline')->after('is_visible')->default(30);
        	$table->uuid('default_assigned_group_id')->after('default_deadline')->nullable();
        });

        Schema::table('flagged_entities', function (Blueprint $table) {
        	$table->boolean('is_default_deadline')->default(true)->index();
        	$table->boolean('is_late')->default(false)->index();
        	$table->boolean('is_completed')->default(false)->index();
        	$table->boolean('is_cancelled')->default(false)->index();
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
