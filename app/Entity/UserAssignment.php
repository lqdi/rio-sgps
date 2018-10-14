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

	public function user() {
		return $this->hasOne(User::class, 'id', 'user_id');
	}

	public function entity() {
		return $this->morphTo('entity');
	}

}