<?php
/**
 * rio-sgps
 * QuestionCategory.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 20/09/2018, 15:31
 */

namespace SGPS\Entity;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SGPS\Traits\IndexedByUUID;

/**
 * Class QuestionCategory
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $name
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property Question[]|Collection $questions
 */
class QuestionCategory extends Model {

	use IndexedByUUID;
	use SoftDeletes;

	protected $table = 'question_categories';

	protected $fillable = [
		'name',
	];

	public function questions() {
		return $this->belongsToMany(Question::class, 'category_questions', 'question_id', 'category_id');
	}

}