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
use SGPS\Constants\UserLevel;
use SGPS\Traits\HasShortCode;
use SGPS\Traits\IndexedByUUID;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $source
 * @property string $shortcode
 * @property string $group_id
 * @property string $registration_number
 * @property string $cpf
 * @property string $level @see \SGPS\Constants\UserLevel
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
	use HasShortCode;
	use LogsActivity;

	protected $table = "users";

	protected $fillable = [
		'source',
		'name',
		'level',
		'email',
		'group_id',
		'registration_number',
		'cpf',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected static $logAttributes = [
		'source',
		'name',
		'level',
		'email',
		'group_id',
		'registration_number',
		'cpf',
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
	 * String representation of the user
	 * @return string
	 */
	public function __toString() {
		return "{$this->name} (" . ($this->registration_number ?? $this->email) . ")";
	}

	/**
	 * Returns a basic JSON object with user info
	 * @return array
	 */
	public function toBasicJson() : array {
		return [
			'id' => $this->id,
			'name' => $this->name,
			'registration_number' => $this->registration_number,
			'email' => $this->email,
		];
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

	/**
	 * Checks if a user has a certain level or higher.
	 *
	 * @param null|string $level
	 * @return bool
	 */
	public function hasLevel(?string $level) : bool {
		if(!$level) return false;
		if(!$this->level) return false;

		return UserLevel::check($level, $this->level);
	}

	/**
	 * Checks if a user is external or local.
	 * @return bool
	 */
	public function isExternal() : bool {
		return isset($this->source) && $this->source !== 'sgps';
	}

	/**
	 * Check if the user has an assignment for the target entity.
	 * @param Entity $entity The target entity.
	 * @param array|null $assignmentTypes Which assignment types to look for. If omitted, will look for all of them.
	 * @return bool
	 */
	public function isAssignedToEntity(Entity $entity, ?array $assignmentTypes = null) : bool {
		return $this
			->assignments
			->where('entity_id', $entity->getEntityID())
			->whereIn('type', $assignmentTypes ?? UserAssignment::TYPES)
			->isNotEmpty();
	}

	/**
	 * Updates the user from new external provider data.
	 * Must have at least one logon key (email, CPF or registration number).
	 * Source cannot be 'sgps', as these are reserved for local users.
	 * Given level must be a valid SGPS level.
	 *
	 * @param null|string $name
	 * @param null|string $email
	 * @param null|string $cpf
	 * @param null|string $registrationNumber
	 * @param string $level
	 */
	public function updateFromExternal(?string $name, ?string $email, ?string $cpf, ?string $registrationNumber, string $level = UserLevel::OPERADOR) {

		if(is_null($email) && is_null($cpf) && is_null($registrationNumber)) {
			throw new \InvalidArgumentException("Cannot update external user with no logon data (email, CPF or registration number)");
		}

		if($this === 'sgps') {
			throw new \InvalidArgumentException("User is not an external user, so cannot be updated from external.");
		}

		if(!UserLevel::exists($level)) {
			throw new \InvalidArgumentException("Cannot update external user with invalid level: {$level}");
		}

		$this->fill([
			'level' => $level,
			'email' => $email,
			'name' => $name,
			'cpf' => $cpf,
			'registration_number' => $registrationNumber,
		]);

		$this->save();
	}

	/**
	 * Gets the list of codes for user groups
	 * @return \Illuminate\Support\Collection
	 */
	public function getGroupCodes() {
		return $this->groups->pluck('code');
	}

	/**
	 * Gets the list of metrics that this user can view, based on his group membership.
	 * @return \Illuminate\Support\Collection
	 */
	public function getMetricsToView() {

		return $this
			->getGroupCodes()
			->map(function ($code) {
				return config('group_metrics.' . $code, []);
			})
			->flatten();

	}

	// ---------—---------—---------—---------—---------—---------—---------—---------—---------—---------—---------—

	/**
	 * Creates a user via an external provider.
	 * Must have at least one logon key (email, CPF or registration number).
	 * Will generate a random long password to prevent password authentication.
	 * Source cannot be 'sgps', as these are reserved for local users.
	 * Given level must be a valid SGPS level.
	 *
	 * @param null|string $name [optional] The user name.
	 * @param null|string $email The user e-mail. Optional if CPF or reg number is given.
	 * @param null|string $cpf The user CPF. Optional if e-mail or reg number is given.
	 * @param null|string $registrationNumber The user registration number. Optional if e-mail or CPF is given.
	 * @param string $level The user level. @see \SGPS\Constants\UserLevel
	 * @param string $source The external user source. Identify here which system is providing this user.
	 * @return User
	 */
	public static function createFromExternal(?string $name, ?string $email, ?string $cpf, ?string $registrationNumber, string $level = UserLevel::OPERADOR, string $source = 'external') : User {

		if(is_null($email) && is_null($cpf) && is_null($registrationNumber)) {
			throw new \InvalidArgumentException("Cannot create external user with no logon data (email, CPF or registration number)");
		}

		if($source === 'sgps') {
			throw new \InvalidArgumentException("Cannot create external user with source 'sgps'. Must inform another source.");
		}

		if(!UserLevel::exists($level)) {
			throw new \InvalidArgumentException("Cannot create external user with invalid level: {$level}");
		}

		$user = new User();
		$user->fill([
			'source' => $source,
			'level' => $level,
			'email' => $email,
			'name' => $name,
			'cpf' => $cpf,
			'registration_number' => $registrationNumber,
		]);

		// External users cannot login with password
		$user->setPassword(str_random(64));

		$user->save();

		return $user;
	}
}
