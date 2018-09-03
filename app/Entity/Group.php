<?php
/**
 * rio-sgps
 * Group.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 03/09/2018, 18:55
 */

namespace SGPS\Entity;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SGPS\Traits\IndexedByUUID;

/**
 * Class Group
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $name
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property User[]|Collection $users
 */
class Group extends Model {

	use IndexedByUUID;
	use SoftDeletes;

	protected $table = "groups";
	protected $fillable = ['name'];

	public function users() {
		return $this->belongsToMany(User::class, 'user_groups');
	}

}