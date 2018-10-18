<?php
/**
 * rio-sgps
 * FlagAssignment.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 17/10/2018, 20:11
 */

namespace SGPS\Entity;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FlagAttribution
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $residence_id
 * @property string $flag_id
 * @property string $entity_type
 * @property string $entity_id
 * @property Carbon $reference_date
 * @property integer $deadline
 * @property string $flagged_by_operator_id
 * @property boolean $is_default_deadline
 * @property boolean $is_late
 * @property boolean $is_completed
 * @property boolean $is_cancelled
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Flag $flag
 * @property Residence $residence
 * @property Entity $entity
 */
class FlagAttribution extends Model {

	protected $table = 'flag_attributions';
	protected $with = ['flag'];

	protected $fillable = [
		'residence_id',
		'flag_id',
		'entity_type',
		'entity_id',
		'reference_date',
		'deadline',
		'flagged_by_operator_id',
		'is_default_deadline',
		'is_late',
		'is_completed',
		'is_cancelled',
	];

	protected $casts = [
		'reference_date' => 'date',
		'deadline' => 'integer',
		'is_default_deadline' => 'boolean',
		'is_late' => 'boolean',
		'is_completed' => 'boolean',
		'is_cancelled' => 'boolean',
	];

	public function flag() {
		return $this->hasOne(Flag::class, 'id', 'flag_id');
	}

	public function residence() {
		return $this->hasOne(Residence::class, 'id', 'residence_id');
	}

	public function entity() {
		return $this->morphTo();
	}

}