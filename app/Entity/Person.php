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
 * @property Sector $sector
 * @property Residence $residence
 * @property Family $family
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

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Relationship: person with sector
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function sector() {
		return $this->hasOne(Sector::class, 'id', 'sector_id');
	}

	/**
	 * Relationship: person with residence
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function residence() {
		return $this->hasOne(Residence::class, 'id', 'residence_id');
	}

	/**
	 * Relationship: person with family
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function family() {
		return $this->hasOne(Family::class, 'id', 'family_id');
	}

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Gets the person's age, based on the given date of birth
	 * @return int
	 */
	public function getAge() {
		// TODO: cache this?
		return 0;
	}

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Concrete: Persons have unique UUIDs.
	 * @return string
	 */
	public function getEntityID(): string {
		return $this->id;
	}

	/**
	 * Concrete: Persons have type string 'person'
	 * @return string
	 */
	public function getEntityType(): string {
		return 'person';
	}

}