<?php
/**
 * rio-sgps
 * QuestionAnswer.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 01/10/2018, 19:07
 */

namespace SGPS\Entity;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SGPS\Traits\IndexedByUUID;

/**
 * Class QuestionAnswer
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $question_id
 * @property string $question_code
 * @property string $entity_type
 * @property string $entity_id
 * @property string $type
 * @property string|null $value_string
 * @property integer|null $value_integer
 * @property array|null $value_json
 * @property boolean $is_filled
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property Question $question
 * @property Entity $entity
 *
 */
class QuestionAnswer extends Model {

	use IndexedByUUID;
	use SoftDeletes;

	protected $table = 'question_answers';

	protected $fillable = [
		'question_id',
		'question_code',
		'entity_type',
		'entity_id',
		'type',
		'value_string',
		'value_integer',
		'value_json',
		'is_filled',
	];

	protected $casts = [
		'is_filled' => 'boolean',
		'value_json' => 'array',
		'value_integer' => 'integer',
	];

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Relationship: answer with question
	 * @return mixed
	 */
	public function question() {
		return $this->hasOne(Question::class, 'id', 'question_id')->withTrashed();
	}

	/**
	 * Relationship: answer with targeted entity
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function entity() {
		return $this->morphTo('entity');
	}

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Sets the value of the answer; will handle answer type and appropriately serialize and store in the right field.
	 * @param $value
	 * @return array|int|null|string Returns the serialized value
	 */
	public function setValue($value) {
		switch($this->type) {
			case Question::TYPE_TEXT:
			case Question::TYPE_NUMERIC:
			case Question::TYPE_SELECT_ONE:
				return $this->value_string = strval($value);

			case Question::TYPE_DATE:
				if(is_object($value)) {
					return $this->value_string = $value->format('Y-m-d');
				}

				return $this->value_string = Carbon::parse($value)->format('Y-m-d');

			case Question::TYPE_NUMBER:
			case Question::TYPE_YESNO:
				return $this->value_integer = intval($value);

			case Question::TYPE_YESNO_NULLABLE:
				if($value === null || $value === 'null') {
					return $this->value_integer = null;
				}

				return $this->value_integer = intval($value);

			case Question::TYPE_SELECT_MANY:
				return $this->value_json = (array) $value;

			default:
				return $this->value_json = $value;
		}

	}

	/**
	 * Gets the value for the answer; will handle answer and appropriately unserialize the correct field.
	 * @return array|bool|int|null|string The unserialized value.
	 */
	public function getValue() {
		switch($this->type) {
			case Question::TYPE_TEXT:
			case Question::TYPE_NUMERIC:
			case Question::TYPE_SELECT_ONE:
			case Question::TYPE_DATE:
				return strval($this->value_string);

			case Question::TYPE_NUMBER:
				return intval($this->value_integer);

			case Question::TYPE_YESNO:
			case Question::TYPE_YESNO_NULLABLE:
				if($this->value_integer === null) return null;
				return boolval($this->value_integer);

			case Question::TYPE_SELECT_MANY:
			default:
				return (array) $this->value_json;
		}
	}

	/**
	 * Sets and saves (persists) the value of the question.
	 * @see QuestionAnswer::setValue()
	 * @param mixed $value
	 */
	public function updateValue($value) : void {
		$this->setValue($value);
		$this->save();
	}

	/**
	 * Resolves (finds or creates) the answer for a specific question+entity pair.
	 * @param Entity $entity The targeted entity
	 * @param Question $question The question this answer regards to
	 * @return QuestionAnswer The found answer, or a new one.
	 */
	public static function fetchOrCreateForEntityQuestion(Entity $entity, Question $question) : QuestionAnswer {
		return self::query()
			->where('entity_type', $entity->getEntityType())
			->where('entity_id', $entity->id)
			->where('question_id', $question->id)
			->firstOrNew([
				'entity_type' => $entity->getEntityType(),
				'entity_id' => $entity->getEntityID(),
				'question_id' => $question->id,
				'question_code' => $question->code,
				'type' => $question->field_type,
			]);
	}

	/**
	 * Updates the answer value to a specific entity+question pair.
	 * Will resolve (find or create) the answer based on the pair.
	 * Will appropriately serialize and store the answer in the right field.
	 * Will persist the change on the database.
	 * @param Entity $entity The targeted entity
	 * @param Question $question The question the answer regards to
	 * @param mixed $answerValue The value of the answer
	 */
	public static function setAnswerForEntity(Entity $entity, Question $question, $answerValue) : void {
		$answer = self::fetchOrCreateForEntityQuestion($entity, $question);
		$answer->updateValue($answerValue);
	}

}