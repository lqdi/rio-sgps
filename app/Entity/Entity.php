<?php
/**
 * rio-sgps
 * Entity.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 01/10/2018, 19:01
 */

namespace SGPS\Entity;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Entity
 * @package SGPS\Entity
 * @property QuestionAnswer[]|Collection $answers
 * @property Flag[]|Collection $flags
 */
abstract class Entity extends Model {

	public static function getQuery(string $type) : ?Builder {
		switch($type) {
			case 'residence': return Residence::query();
			case 'family': return Family::query();
			case 'person': return Person::query();
		}

		return null;
	}

	public static function fetchByID(string $type, string $id) : ?Entity {
		return static::getQuery($type)
			->where('id', $id)
			->first();
	}

	public function answers() {
		return $this->morphMany(QuestionAnswer::class, 'entity');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function flags() {
		return $this
			->morphToMany(Flag::class, 'entity', 'flagged_entities')
			->withPivot([
				'reference_date',
				'deadline',
				'flagged_by_operator_id',
				'created_at',
				'is_default_deadline',
				'is_late',
				'is_completed',
				'is_cancelled',
			]);
	}

	abstract public function getEntityID() : string;
	abstract public function getEntityType() : string;

	public function getAnswers(?array $questionIDs = null) {
		$q = $this->answers();

		if($questionIDs !== null) {
			$q->whereIn('question_id', $questionIDs);
		}

		return $q->get();
	}

}