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
 * @property Sector $sector
 * @property QuestionAnswer[]|Collection $answers
 * @property Flag[]|Collection $flags
 * @property User[]|Collection $assignedUsers
 * @property UserAssignment[]|Collection $assignments
 * @property FlagAttribution[]|Collection $attributedFlags
 */
abstract class Entity extends Model {

	/**
	 * Abstract: gets this entity's parent/self residence ID
	 * @return string
	 */
	abstract public function getEntityResidenceID() : string;

	/**
	 * Abstract: gets this entity's sector ID
	 * @return string
	 */
	abstract public function getEntitySectorID() : string;

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


	/**
	 * Builds an entity reference slug
	 * @return string Format: "entityType:UUID"
	 */
	public function getEntityReference() : string {
		return "{$this->getEntityType()}:{$this->getEntityID()}";
	}

	/**
	 * Abstract: Builds a basic JSON for entity identification
	 * @return array
	 */
	public function toBasicJson() : array {
		return [
			'type' => $this->getEntityType(),
			'id' => $this->getEntityID(),
		];
	}

	// ----------------------------------------------------------------------------------------------------------------

	/**
	 * Relationship: entities with sector
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function sector() {
		return $this->hasOne(Sector::class, 'id', 'sector_id');
	}

	/**
	 * Relationship: entities with question answers
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function answers() {
		return $this->morphMany(QuestionAnswer::class, 'entity');
	}

	/**
	 * Relationship: entities with flag attributions
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function attributedFlags() {
		return $this->hasMany(FlagAttribution::class, 'entity_id', 'id');
	}

	/**
	 * Relationship: entities with flags, through flag attributions
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function flags() {
		return $this->morphToMany(Flag::class, 'entity', 'flag_attributions');
	}

	/**
	 * Relationship: entities with flags, through flag attributions, that are active
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function activeFlags() {
		return $this->morphToMany(Flag::class, 'entity', 'flag_attributions')
			->where('is_completed', false)
			->where('is_cancelled', false);
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

	public function scopeHasAnsweredQuestionWith($query, $questionCode, $questionType, $expectedAnswer) {
		return $query->whereHas('answers', function ($sq) use ($questionCode, $questionType, $expectedAnswer) {
			return $sq
				->where('question_code', $questionCode)
				->valueEqualsTo($questionType, $expectedAnswer);
		});
	}

	public function scopeHasActiveFlag($query, $flagCode) {
		return $query->whereHas('activeFlags', function ($sq) use ($flagCode) {
			return $sq->where('code', $flagCode);
		});
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

	/**
	 * Gets an associative grid of answers by question code.
	 * The result is an associative array with question code (eg "CE123") as key, and the unserialized answer as value.
	 * @param array|null $questionIDs [optional] A list of question IDs to filter out the answers.
	 * @return array
	 */
	public function getAnswerGrid(?array $questionIDs = null) : array {
		return $this->getAnswers($questionIDs)
			->keyBy('question_code')
			->map(function ($answer) { /* @var $answer \SGPS\Entity\QuestionAnswer */
				return $answer->getValue();
			})
			->toArray();
	}

	public function getAnswerByCode(string $questionCode) {
		return QuestionAnswer::fetchByCode($this, $questionCode);
	}

	/**
	 * Sets a question's answer for this entity.
	 * Will create the answer if it doesn't exist, or update it if it does.
	 *
	 * @param Question $question
	 * @param mixed $answer
	 */
	public function setAnswer(Question $question, $answer) {
		QuestionAnswer::setAnswerForEntity($this, $question, $answer);
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
	 * @return Entity|Model|null The found entity, or null if not found.
	 */
	public static function fetchByID(string $type, string $id) : ?Entity {
		return static::getQuery($type)
			->where('id', $id)
			->first();
	}

	/**
	 * Fetches an entity by its reference slug
	 * @param string $reference The entity reference (in "type:UUID" format)
	 * @return Entity|null The found entity, or null if not found.
	 */
	public static function fetchByReference(string $reference) : ?Entity {
		$separatorPos = strpos($reference, ':');

		$type = substr($reference, 0, $separatorPos);
		$id = substr($reference, $separatorPos + 1);

		return self::fetchByID($type, $id);
	}

	/**
	 * Attribute a flag to this entity
	 * @param Flag $flag
	 * @param null|string $referenceDate
	 * @param int $deadline
	 * @return FlagAttribution
	 */
	public function addFlagAttribution(Flag $flag, ?string $referenceDate = null, int $deadline = 30) : ?FlagAttribution {
		if($this->hasFlagAttribution($flag)) { // Attribution already exists
			return null;
		}

		return FlagAttribution::createFromAttribution($flag, $this, $referenceDate, $deadline);
	}

	/**
	 * Checks if a specific flag has been already attributed to this entity
	 * @param Flag $flag
	 * @return bool
	 */
	public function hasFlagAttribution(Flag $flag) : bool {
		return $this->attributedFlags->where('flag_id', $flag->id)->isNotEmpty();
	}

	/**
	 * Gets the attribution of a specific flag to this entity, or null if flag is not attributed
	 * @param Flag $flag
	 * @return null|FlagAttribution
	 */
	public function getFlagAttribution(Flag $flag) : ?FlagAttribution {
		return $this->attributedFlags->where('id', $flag->id)->first();
	}

	/**
	 * Gets the list of all groups linked to this entity by their flag.
	 * @return Group[]|Collection
	 */
	public function resolveLinkedGroups() {
		return $this
			->loadMissing(['flags.groups'])
			->flags
			->map(function ($flag) {
				return $flag->groups;
			})
			->flatten();
	}

	/**
	 * Gets the list of all equipments linked to this entity by their sector.
	 * @return Equipment[]|Collection
	 */
	public function resolveLinkedEquipments() {
		return $this
			->loadMissing('sector.equipments')
			->sector
			->equipments;
	}

}