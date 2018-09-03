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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SGPS\Traits\IndexedByUUID;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property Group[]|Collection $groups
 */
class User extends Authenticatable {

	use IndexedByUUID;
	use SoftDeletes;
	use Notifiable;
	use HasRoles;

	protected $table = "users";

	protected $fillable = [
		'name',
		'email',
		'password',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	public function groups() {
		return $this->belongsToMany(Group::class, 'user_groups');
	}
}
