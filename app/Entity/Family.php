<?php
/**
 * rio-sgps
 * Family.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 03/09/2018, 17:54
 */

namespace SGPS\Entity;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SGPS\Traits\HasShortCode;
use SGPS\Traits\IndexedByUUID;

/**
 * Class Family
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $shortcode
 * @property string $sector_id
 * @property string $residence_id
 * @property string $person_in_charge_id
 * @property float $ipm_rate
 * @property integer $ipm_risk_factor
 * @property string $visit_status
 * @property integer $visit_attempt
 * @property Carbon|null $visit_last
 * @property string $gis_global_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property Sector $sector
 * @property Residence $residence
 * @property Person $personInCharge
 * @property Person[]|Collection $members
 */
class Family extends Entity {

	use IndexedByUUID;
	use SoftDeletes;
	use HasShortCode;

	protected $table = 'families';

	protected $fillable = [
		'sector_id',
		'residence_id',
		'person_in_charge_id',
		'ipm_rate',
		'ipm_risk_factor',
		'visit_status',
		'visit_attempt',
		'visit_last',
		'gis_global_id',
	];

	protected $casts = [
		'ipm_rate' => 'float',
		'ipm_risk_factor' => 'integer',
		'visit_attempt' => 'integer',
		'visit_last' => 'date',
	];

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Relationship: family with sector
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function sector() {
		return $this->hasOne(Sector::class, 'id', 'sector_id');
	}

	/**
	 * Relationship: family with residence
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function residence() {
		return $this->hasOne(Residence::class, 'id', 'residence_id');
	}

	/**
	 * Relationship: family with person (which is in charge of the family)
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function personInCharge() {
		return $this->hasOne(Person::class, 'id', 'person_in_charge_id');
	}

	/**
	 * Relationship: family with persons (who are members of the family)
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function members() {
		return $this->hasMany(Person::class, 'family_id', 'id');
	}

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Concrete: Family has unique UUID.
	 * @return string
	 */
	public function getEntityID(): string {
		return $this->id;
	}

	/**
	 * Concrete: Family has type string 'family'
	 * @return string
	 */
	public function getEntityType(): string {
		return 'family';
	}
}