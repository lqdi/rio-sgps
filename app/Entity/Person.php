<?php
/**
 * rio-sgps
 * Person.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 03/09/2018, 17:55
 */

namespace SGPS\Entity;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SGPS\Traits\HasShortCode;
use SGPS\Traits\IndexedByUUID;

/**
 * Class Person
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $shortcode
 * @property string $residence_id
 * @property string $family_id
 * @property string $name
 * @property string $nis
 * @property string $cpf
 * @property string $rg
 * @property string $phone_number
 * @property string $gis_global_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property Residence $residence
 * @property Family $family
 * @property Flag[]|Collection $flags
 */
class Person extends Entity {

	use IndexedByUUID;
	use SoftDeletes;
	use HasShortCode;

	protected $table = "persons";

	protected $fillable = [
		'residence_id',
		'family_id',
		'name',
		'nis',
		'cpf',
		'rg',
		'phone_number',
		'gis_global_id',
	];

	public function residence() {
		return $this->hasOne(Residence::class, 'id', 'residence_id');
	}

	public function family() {
		return $this->hasOne(Family::class, 'id', 'family_id');
	}

	public function flags() {
		return $this->morphToMany(Flag::class, 'entity', 'flagged_entities')
			->withPivot('reference_date', 'deadline', 'flagged_by_operator_id', 'created_at');
	}

	public function getAge() {
		// TODO: cache this?
		return 0;
	}

}