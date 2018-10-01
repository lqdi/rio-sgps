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

	public function question() {
		return $this->hasOne(Question::class, 'id', 'question_id')->withTrashed();
	}

	public function entity() {
		return $this->morphTo('entity');
	}

}