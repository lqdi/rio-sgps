<?php
/**
 * rio-sgps
 * UserAssignment.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 14/10/2018, 20:30
 */

namespace SGPS\Entity;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use SGPS\Services\UserAssignmentService;
use SGPS\Traits\IndexedByUUID;

/**
 * Class UserAssignment
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $user_id
 * @property string $entity_type
 * @property string $entity_id
 * @property string $type
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Entity $entity
 */
class UserAssignment extends Model {

	use IndexedByUUID;

	const TYPE_WATCHING = 'watching';
	const TYPE_ACTING = 'acting';
	const TYPE_CREATOR = 'creator';

	const TYPES = [self::TYPE_WATCHING, self::TYPE_ACTING, self::TYPE_ACTING];

	protected $table = "user_assignments";
	protected $fillable = [
		'user_id',
		'entity_type',
		'entity_id',
		'type',
	];

	// --------------------------------------------------------------------------------------------------------------

	/**
	 * Relationship: assignment with user (assigned user)
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function user() {
		return $this->hasOne(User::class, 'id', 'user_id');
	}

	/**
	 * Relationship: assignment with target entity
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function entity() {
		return $this->morphTo('entity');
	}

	// --------------------------------------------------------------------------------------------------------------

	/**
	 * Creates a new user assignment entry.
	 * Should not be called directly; @see UserAssignmentService
	 * @param User $user The user being assigned
	 * @param Entity $entity The target entity
	 * @param string $assignmentType The assignment type; @see UserAssignment::TYPE_*
	 * @return UserAssignment
	 */
	public static function assignUserToEntity(User $user, Entity $entity, string $assignmentType) : UserAssignment {
		return parent::create([
			'user_id' => $user->id,
			'entity_id' => $entity->getEntityID(),
			'entity_type' => $entity->getEntityType(),
			'type' => $assignmentType,
		]);
	}

}