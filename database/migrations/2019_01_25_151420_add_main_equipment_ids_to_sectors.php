<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMainEquipmentIdsToSectors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("sectors", function (Blueprint $table) {
            $table->string('cod_cap')->nullable()->index();
            $table->string('cod_cms')->nullable()->index();
            $table->string('cod_esf')->nullable()->index();
            $table->string('cod_casdh')->nullable()->index();
            $table->string('cod_cras')->nullable()->index();
            $table->string('cod_cre')->nullable()->index();

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
