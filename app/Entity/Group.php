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
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Group
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $shortcode
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
	use LogsActivity;

	protected $table = "groups";
	protected $fillable = ['name', 'code'];

	protected static $logAttributes = ['name', 'code'];

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Relationship: group with users
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users() {
		return $this->belongsToMany(User::class, 'user_groups');
	}

	/**
	 * Relationship: groups with flags
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function groups() {
		return $this->belongsToMany(Group::class, 'flag_groups', 'group_code', 'flag_code', 'code', 'code');
	}

}