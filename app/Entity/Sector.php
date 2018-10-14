<?php
/**
 * rio-sgps
 * Sector.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 11/10/2018, 17:19
 */

namespace SGPS\Entity;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Sector
 * @package SGPS\Entity
 *
 * @property integer $id
 * @property integer $cod_bairro
 * @property integer $cod_ra
 * @property string $cod_rp
 * @property integer $cod_ap
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property Equipment[]|Collection $equipments
 * @property Family[]|Collection $families
 * @property Residence[]|Collection $residences
 * @property Person[]|Collection $persons
 */
class Sector extends Model {

	use SoftDeletes;

	protected $table = 'sectors';
	protected $fillable = [
		'cod_bairro',
		'cod_ra',
		'cod_rp',
		'cod_ap',
	];

	protected $casts = [
		'cod_bairro' => 'integer',
		'cod_ra' => 'integer',
		'cod_ap' => 'integer',
	];

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Gets the Bairro object associated to this sector, via geo_bairros config
	 * @return object
	 */
	public function getBairro() {
		return (object) config('geo_bairros.' . $this->cod_bairro, []);
	}

	/**
	 * Gets the RA (região administrativa) object associated to this sector, via geo_ra config
	 * @return object
	 */
	public function getRA() {
		return (object) config('geo_ra.' . $this->cod_ra, []);
	}

	/**
	 * Gets the RP (região de planejamento) object associated to this sector, via geo_rp config
	 * Warning: because RP codes have dots (eg '1.2'), the config keys must be accessed via array syntax instead.
	 * @return object
	 */
	public function getRP() {
		return (object) (config('geo_rp')[$this->cod_rp] ?? []);
	}

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Relationship: sectors with equipments
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function equipments() {
		return $this->belongsToMany(Equipment::class, 'sector_equipments');
	}

	/**
	 * Relationship: sectors with families
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function families() {
		return $this->hasMany(Family::class, 'sector_id', 'id');
	}

	/**
	 * Relationship: sectors with residences
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function residences() {
		return $this->hasMany(Residence::class, 'sector_id', 'id');
	}

	/**
	 * Relationship: sectors with persons
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function persons() {
		return $this->hasMany(Person::class, 'sector_id', 'id');
	}

}