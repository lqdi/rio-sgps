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
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract {

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
		'password',
		'group_id',
		'registration_number',
		'cpf',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	public function groups() {
		return $this->belongsToMany(Group::class, 'user_groups');
	}
}
