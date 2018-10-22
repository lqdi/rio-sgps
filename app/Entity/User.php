<?php
/**
 * rio-sgps
 * User.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 */

namespace SGPS\Entity;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use SGPS\Traits\HasShortCode;
use SGPS\Traits\IndexedByUUID;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\JWTAuth;

/**
 * Class User
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $shortcode
 * @property string $group_id
 * @property string $registration_number
 * @property string $cpf
 * @property string $email
 * @property string $name
 * @property string $password
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property Group[]|Collection $groups
 * @property Equipment[]|Collection $equipments
 * @property UserAssignment[]|Collection $assignments
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject {

	use Authenticatable;
	use Authorizable;

	use IndexedByUUID;
	use SoftDeletes;
	use Notifiable;
	use HasRoles;
	use HasShortCode;

	protected $table = "users";

	protected $fillable = [
		'name',
		'email',
		'group_id',
		'registration_number',
		'cpf',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Relationship: users with groups
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function groups() {
		return $this->belongsToMany(Group::class, 'user_groups');
	}

	/**
	 * Relationship: users with equipments
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function equipments() {
		return $this->belongsToMany(Equipment::class, 'user_equipments');
	}

	/**
	 * Relationship: users with user assignments (pivot between user and entities)
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function assignments() {
		return $this->hasMany(UserAssignment::class, 'user_id', 'id');
	}

	// ---------—---------—---------—---------—---------—---------—---------—---------—---------—---------—---------—

	/**
	 * Gets the user's first name
	 * @return string
	 */
	public function getFirstName() {
		if(!$this->name) return '';
		if(strpos($this->name, ' ') === false) return $this->name;
		return substr($this->name, 0, strpos($this->name, ' '));
	}

	/**
	 * Updates the hashed password for the user.
	 * Does not persist the change.
	 * @param string $password
	 */
	public function setPassword(string $password) {
		$this->password = password_hash($password, PASSWORD_DEFAULT);
	}

	/**
	 * Checks if a given password matches the hash
	 * @param string $password
	 * @return bool
	 */
	public function validatePassword(string $password) : bool {
		return password_verify($password, $this->password);
	}

	/**
	 * Gets the JWT token for this user
	 * @return string
	 */
	public function toJWT() : string {
		return auth('api')->tokenById($this->id);
	}

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier() {
		return $this->id;
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims() {
		return [];
	}
}
