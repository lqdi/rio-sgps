<?php
/**
 * rio-sgps
 * Question.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 20/09/2018, 14:34
 */

namespace SGPS\Entity;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SGPS\Traits\IndexedByUUID;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Question
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $code
 * @property string $field_type
 * @property string $field_settings
 * @property string $field_options
 * @property string $entity_type
 * @property string $order
 * @property string $title
 * @property string $description
 * @property \stdClass|null $options
 * @property \stdClass|null $triggers
 * @property \stdClass|null $conditions
 * @property \stdClass|null $metadata
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property QuestionAnswer[]|Collection $answers
 * @property QuestionCategory[]|Collection $categories
 */
class Question extends Model {

	use IndexedByUUID;
	use SoftDeletes;
	use LogsActivity;

	const TYPE_TEXT = 'text';
	const TYPE_NUMERIC = 'numeric';
	const TYPE_YESNO = 'yesno';
	const TYPE_YESNO_NULLABLE = 'yesnonullable';
	const TYPE_SELECT_ONE = 'select_one';
	const TYPE_SELECT_MANY = 'select_many';
	const TYPE_NUMBER = 'number';
	const TYPE_DATE = 'date';
	
	const TYPES = [
		self::TYPE_TEXT,
		self::TYPE_NUMERIC,
		self::TYPE_YESNO,
		self::TYPE_YESNO_NULLABLE,
		self::TYPE_SELECT_ONE,
		self::TYPE_SELECT_MANY,
		self::TYPE_NUMBER,
		self::TYPE_DATE,
	];

	protected $table = 'questions';

	protected $fillable = [
		'code',
		'key',
		'field_type',
		'field_settings',
		'field_options',
		'entity_type',
		'order',
		'title',
		'description',
		'triggers',
		'conditions',
	];

	protected $casts = [
		'field_settings' => 'object',
		'field_options' => 'object',
		'triggers' => 'array',
		'conditions' => 'array',
	];

	protected static $logAttributes = [
		'code',
		'key',
		'field_type',
		'field_settings',
		'field_options',
		'entity_type',
		'order',
		'title',
		'description',
		'triggers',
		'conditions',
	];

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Relationship: question with answers
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function answers() {
		return $this->hasMany(QuestionAnswer::class, 'question_id', 'id');
	}

	/**
	 * Relationship: question with categories
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function categories() {
		return $this->belongsToMany(QuestionCategory::class, 'question_categories_pivot', 'category_id', 'question_id');
	}

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Query scope: orders the query by the 'order' key, in ascending order.
	 * @param $query
	 * @return mixed
	 */
	public function scopeOrdered($query) {
		return $query->orderBy('order', 'asc');
	}

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Fetches a question by it's code.
	 * @param string $questionCode The question code.
	 * @return null|Question The question, or null if none found.
	 */
	public static function fetchByCode(string $questionCode) : ?Question {
		return self::query()
			->where('code', $questionCode)
			->first();
	}
}