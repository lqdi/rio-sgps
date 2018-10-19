<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use SGPS\Entity\Question;
use SGPS\Entity\QuestionCategory;

class InsertIpmQuestions extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::dropIfExists('question_categories');
		Schema::dropIfExists('category_questions');
		Schema::dropIfExists('question_categories_pivot');

		Schema::create('question_categories', function (Blueprint $table) {
			$table->uuid('id');
			$table->primary('id');

			$table->string('name')->nullable();
			$table->string('color')->nullable();

			$table->integer('order')->default(0)->index();

			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('question_categories_pivot', function (Blueprint $table) {
			$table->increments('id');
			$table->uuid('question_id')->index();
			$table->uuid('category_id')->index();
			$table->timestamps();
		});

		Schema::table('questions', function (Blueprint $table) {
			$table->renameColumn('name', 'title');
		});



	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('question_categories');
		Schema::dropIfExists('category_questions');
		Schema::dropIfExists('question_categories_pivot');

		Schema::table('questions', function (Blueprint $table) {
			$table->renameColumn('title', 'name');
		});

	}
}
