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
 * Created at: 01/10/2018, 18:46
 */

namespace SGPS\Http\Controllers\API;


use SGPS\Entity\Entity;
use SGPS\Entity\Question;
use SGPS\Entity\QuestionAnswer;
use SGPS\Entity\QuestionCategory;
use SGPS\Http\Controllers\Controller;
use SGPS\Services\EntityFieldLinkService;
use SGPS\Services\FlagBehaviorService;

class QuestionsController extends Controller {

	public function fetch_categories() {

		$categories = QuestionCategory::all();

		return $this->api_success([
			'categories' => $categories
		]);

	}

	public function fetch_questions_by_category(QuestionCategory $category) {

		$questions = $category->questions;

		return $this->api_success([
			'questions' => $questions
		]);

	}

	public function fetch_questions_for_entity(QuestionCategory $category, string $entity_type, string $entity_id) {

		$questions = $category->questions()
			->where('entity_type', $entity_type)
			->ordered()
			->get();

		$entity = Entity::fetchByID($entity_type, $entity_id);

		//$questionIDs = $questions->pluck('id')->toArray();
		$answers = $entity->getAnswerGrid();

		return $this->api_success([
			'questions' => $questions,
			'answers' => (object) $answers,
		]);

	}

	public function save_answers(string $entity_type, string $entity_id, FlagBehaviorService $flagBehaviorService, EntityFieldLinkService $entityFieldLinkService) {

		$answers = request('answers');
		$entity = Entity::fetchByID($entity_type, $entity_id);

		if(!$this->permissions->canEditEntity($this->currentUser, $entity)) {
			return $this->api_failure('user_cannot_edit_entity');
		}

		$questions = Question::query()
			->whereIn('code', array_keys($answers))
			->get()
			->keyBy('code');

		$previousAnswers = $entity->getAnswerGrid();

		foreach($answers as $questionCode => $answerValue) {
			QuestionAnswer::setAnswerForEntity($entity, $questions[$questionCode] ?? null, $answerValue);
		}

		$answers = $entity->getAnswerGrid();

		$this->activityLog->writeToFamilyLog($entity, "saved_answers", ['given_answers' => $answers]);

		$hasChangedFields = $entityFieldLinkService->updateEntityFields($entity, $previousAnswers, $answers);
		$hasAddedFlags = $flagBehaviorService->evaluateBehaviorsForAnswers($entity, $answers);

		return $this->api_success([
			'has_changed_profile' => ($hasChangedFields || $hasAddedFlags),
		]);

	}

}