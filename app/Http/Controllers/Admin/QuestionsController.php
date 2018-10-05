<?php
/**
 * rio-sgps
 * QuestionsController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 05/10/2018, 17:39
 */

namespace SGPS\Http\Controllers\Admin;


use SGPS\Entity\Question;
use SGPS\Http\Controllers\Controller;

class QuestionsController extends Controller {

	public function index() {
		$questions = Question::query()->with(['categories'])->paginate(24);
		return view('admin.questions_index', compact('questions'));
	}

	public function create() {
		$question = new Question();
		return view('admin.questions_edit', compact('question'));
	}

	public function show(Question $question) {
		return view('admin.questions_edit', compact('question'));
	}

	public function save(?Question $question = null) {
		if(!$question) $question = new Question();

		$question->fill(request()->all());
		$question->field_settings = json_decode(request('field_settings'));
		$question->field_options = json_decode(request('field_options'));
		$question->conditions = json_decode(request('conditions'));
		$question->triggers = json_decode(request('triggers'));
		$question->save();

		return redirect()->route('admin.questions.show', [$question->id]);
	}

	public function destroy(Question $question) {
		$question->delete();

		return redirect()->route('admin.questions.index')
			->with('success', 'record_deleted');
	}

}