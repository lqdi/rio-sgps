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
use Laravel\Scout\Searchable;
use SGPS\Traits\HasShortCode;
use SGPS\Traits\IndexedByUUID;
use SGPS\Utils\Sanitizers;
use SGPS\Utils\Shortcode;
use Spatie\Activitylog\Traits\LogsActivity;

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
	use Searchable;
	use LogsActivity;

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

	protected static $logAttributes = [
		'person_in_charge_id',
		'ipm_rate',
		'ipm_risk_factor',
		'visit_status',
		'visit_attempt',
		'visit_last',
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
		return $this->hasMany(Person::class, 'family_id', 'id')->withTrashed();
	}

	/**
	 * Relationship: family with user assignments
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function assignments() {
		return $this->hasMany(UserAssignment::class, 'entity_id', 'id');
	}

	/**
	 * Relationship: family with all flags associated with the family, residence or members
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function allFlagAttributions() {
		return $this->hasMany(FlagAttribution::class, 'residence_id', 'residence_id');
	}

	/**
	 * Relationship: family with all flags associated, through flag attributions
	 * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
	 */
	public function allActiveFlags() {
		return $this->hasManyThrough(Flag::class, FlagAttribution::class, 'residence_id', 'id', 'residence_id', 'flag_id')
			->where('flag_attributions.is_completed', false)
			->where('flag_attributions.is_cancelled', false);
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
	 * Concrete: Family has parent residence UUID.
	 * @return string
	 */
	public function getEntityResidenceID(): string {
		return $this->residence_id;
	}

	/**
	 * Concrete: gets this entity's sector ID
	 * @return string
	 */
	public function getEntitySectorID(): string {
		return $this->sector_id;
	}

	/**
	 * Concrete: Family has type string 'family'
	 * @return string
	 */
	public function getEntityType(): string {
		return 'family';
	}

	/**
	 * Concrete: Builds a basic JSON for entity identification
	 * @return array
	 */
	public function toBasicJson(): array {
		return [
			'type' => $this->getEntityType(),
			'id' => $this->getEntityID(),
			'name' => $this->personInCharge->name,
			'shortcode' => $this->shortcode,
		];
	}

	/**
	 * Concrete: Search array with family, residence and members infos for full-text search
	 * @return array
	 */
	public function toSearchableArray() {

		return array_dot([
			'id' => $this->id,
			'shortcode' => Sanitizers::clearForSearch($this->shortcode),
			'gis_global_id' => $this->gis_global_id,
			'sector_id' => $this->sector_id,
			'residence' => $this->residence->toSearchableArray(),
			'members' => $this->members->map(function ($member) { /* @var $member \SGPS\Entity\Person */
				return $member->toSearchableArray();
			}),
		]);
	}

	/**
	 * @param bool $includeQuestionAnswers
	 * @return array
	 */
	public function toExportArray(bool $includeQuestionAnswers = false) : array {

		$data = [
			'ID' => $this->id,
			'Código' => $this->shortcode,
			'Responsável' => $this->personInCharge->name,
			'Setor' => $this->sector->id,
			'Bairro' => $this->sector->cod_bairro,
			'AP' => $this->sector->cod_ap,
			'RA' => $this->sector->cod_ra,
			'RP' => $this->sector->cod_rp,
			'Endereço' => $this->residence->address,
			'Referência' => $this->residence->reference,
			'Latitude' => $this->residence->lat,
			'Longitude' => $this->residence->lng,
		];

		if(!$includeQuestionAnswers) return $data;

		$answers = QuestionAnswer::buildAnswerGrid($this->answers);

		return array_merge($data, $answers);
	}

	/**
	 * Fetches a family by its shortcode
	 * @param string $shortcode
	 * @return null|Family
	 */
	public static function fetchByShortcode(string $shortcode) : ?Family {
		return self::query()
			->where('shortcode', $shortcode)
			->first();
	}
}