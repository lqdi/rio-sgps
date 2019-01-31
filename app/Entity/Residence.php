<?php
/**
 * rio-sgps
 * Residence.php
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
use Laravel\Scout\Searchable;
use SGPS\Traits\HasShortCode;
use SGPS\Traits\IndexedByUUID;
use SGPS\Utils\Sanitizers;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Residence
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $shortcode
 * @property string $sector_id
 * @property string $lat
 * @property string $lng
 * @property string $address
 * @property string $territory
 * @property string $reference
 * @property string $gis_global_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property Sector $sector
 * @property Family[]|Collection $families
 * @property Person[]|Collection $residents
 */
class Residence extends Entity {

	use IndexedByUUID;
	use SoftDeletes;
	use HasShortCode;
	use Searchable;
	use LogsActivity;

	protected $table = 'residences';

	protected $fillable = [
		'sector_code',
		'lat',
		'lng',
		'address',
		'territory',
		'reference',
		'gis_global_id',
	];

	protected $casts = [
		'lat' => 'float',
		'lng' => 'float',
	];

	protected static $logAttributes = [
		'sector_code',
		'lat',
		'lng',
		'address',
		'territory',
		'reference',
	];

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Relationship: residences with families
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function families() {
		return $this->hasMany(Family::class, 'residence_id', 'id');
	}

	/**
	 * Relationship: residences with persons (called residents)
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function residents() {
		return $this->hasMany(Person::class, 'residence_id', 'id');
	}

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Concrete: Residences have unique UUID
	 * @return string
	 */
	public function getEntityID(): string {
		return $this->id;
	}

	/**
	 * Concrete: Residence is self residence UUID.
	 * @return string
	 */
	public function getEntityResidenceID(): string {
		return $this->id;
	}

	/**
	 * Concrete: gets this entity's sector ID
	 * @return string
	 */
	public function getEntitySectorID(): string {
		return $this->sector_id;
	}

	/**
	 * Concrete: Residences have type 'residence'
	 * @return string
	 */
	public function getEntityType(): string {
		return 'residence';
	}

	/**
	 * Concrete: Builds a basic JSON for entity identification
	 * @return array
	 */
	public function toBasicJson(): array {
		return [
			'type' => $this->getEntityType(),
			'id' => $this->getEntityID(),
			'address' => $this->address,
			'shortcode' => $this->shortcode,
		];
	}

	/**
	 * Concrete: Search array with residence basic data
	 * @return array
	 */
	public function toSearchableArray() {

		return [
			'id' => $this->id,
			'shortcode' => Sanitizers::clearForSearch($this->shortcode),
			'gis_global_id' => $this->gis_global_id,
			'sector_id' => $this->sector_id,
			'address' => $this->address,
			'territory' => $this->territory,
			'reference' => $this->reference,
		];
	}

	/**
	 * @param bool $includeQuestionAnswers
	 * @return array
	 */
	public function toExportArray(bool $includeQuestionAnswers = false) : array {

		$data = [
			'ID' => $this->id,
			'Código' => $this->shortcode,
			'Setor' => $this->sector->id ?? '',
			'Bairro' => $this->sector->cod_bairro ?? '',
			'AP' => $this->sector->cod_ap ?? '',
			'RA' => $this->sector->cod_ra ?? '',
			'RP' => $this->sector->cod_rp ?? '',
			'CAP' => $this->sector->cod_cap ?? '',
			'CASDH' => $this->sector->cod_casdh ?? '',
			'CMS' => $this->sector->cod_cms ?? '',
			'CRAS' => $this->sector->cod_cras ?? '',
			'CRE' => $this->sector->cod_cre ?? '',
			'ESF' => $this->sector->cod_esf ?? '',
			'Endereço' => $this->address,
			'Referência' => $this->reference,
			'Latitude' => $this->lat,
			'Longitude' => $this->lng,
		];

		if(!$includeQuestionAnswers) return $data;

		$answers = QuestionAnswer::buildAnswerGrid($this->answers);

		return array_merge($data, $answers);
	}

}