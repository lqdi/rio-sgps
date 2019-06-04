<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RedesignAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('answers');

	    Schema::create('question_answers', function (Blueprint $table) {
		    $table->uuid('id');
		    $table->primary('id');

		    $table->uuid('question_id')->index();
		    $table->string('question_code')->index();

		    $table->string('entity_type')->index();
		    $table->uuid('entity_id')->index();

		    $table->string('type')->default('text')->index();

		    $table->string('value_string')->nullable();
		    $table->integer('value_integer')->nullable();
		    $table->longText('value_json')->nullable();

		    $table->boolean('is_filled')->index()->default(false);

		    $table->timestamps();
		    $table->softDeletes();

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
