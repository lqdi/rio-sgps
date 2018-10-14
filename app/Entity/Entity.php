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
 * @property User[]|Collection $assignedUsers
 * @property UserAssignment[]|Collection $assignments
 */
abstract class Entity extends Model {

	/**
	 * Abstract: gets this entity's unique ID
	 * @return string
	 */
	abstract public function getEntityID() : string;

	/**
	 * Abstract: gets this entity's type string
	 * @return string
	 */
	abstract public function getEntityType() : string;

	// ----------------------------------------------------------------------------------------------------------------

	/**
	 * Relationship: entities with question answers
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function answers() {
		return $this->morphMany(QuestionAnswer::class, 'entity');
	}

	/**
	 * Relationship: entities with flags
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function flags() {
		// TODO: create actual entity to represent the pivot between Entity and Flag
		return $this
			->morphToMany(Flag::class, 'entity', 'flagged_entities')
			->orderBy('is_completed')
			->orderBy('is_cancelled')
			->orderBy('created_at', 'desc')
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

	/**
	 * Relationship: entities with assigned users (through UserAssignment's table)
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function assignedUsers() {
		return $this
			->morphToMany(User::class, 'entity', 'user_assignments')
			->withPivot(['type']);
	}

	/**
	 * Relationshio: entities with user assignments
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function assignments() {
		// This is possible because of UUID uniqueness; otherwise, entity_type would be necessary
		return $this->hasMany(UserAssignment::class, 'entity_id', 'id');
	}

	// ----------------------------------------------------------------------------------------------------------------

	/**
	 * Builds a collection of the answers given for this entity, optionally filtering only by a specific set of questions.
	 * @param array|null $questionIDs
	 * @return Collection
	 */
	public function getAnswers(?array $questionIDs = null) {
		$q = $this->answers();

		if($questionIDs !== null) {
			$q->whereIn('question_id', $questionIDs);
		}

		return $q->get();
	}

	// ----------------------------------------------------------------------------------------------------------------

	/**
	 * Gets a query builder based on the entity type being targeted
	 * @param string $type The entity type ('residence', 'family' or 'person')
	 * @return Builder|null
	 */
	public static function getQuery(string $type) : ?Builder {
		switch($type) {
			case 'residence': return Residence::query();
			case 'family': return Family::query();
			case 'person': return Person::query();
		}

		return null;
	}

	/**
	 * Fetches an entity by type/ID pair
	 * @param string $type The entity type ('residence', 'family' or 'person')
	 * @param string $id The entity ID
	 * @return Entity|null The found entity, or null if not found.
	 */
	public static function fetchByID(string $type, string $id) : ?Entity {
		return static::getQuery($type)
			->where('id', $id)
			->first();
	}

}