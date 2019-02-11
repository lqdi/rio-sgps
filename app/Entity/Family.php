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
use SGPS\Services\UserAssignmentService;
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
 * @property bool $is_alert
 * @property string $sector_id
 * @property string $residence_id
 * @property string $person_in_charge_id
 * @property float $ipm_rate
 * @property integer $ipm_risk_factor
 * @property string $visit_status
 * @property integer $visit_attempt
 * @property string $case_opened_by
 * @property Carbon|null $visit_last
 * @property Carbon|null $opened_at
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
 * @property User|null $caseOpenedBy
 */
class Family extends Entity {

	use IndexedByUUID;
	use SoftDeletes;
	use HasShortCode;
	use Searchable;
	use LogsActivity;

	const VISIT_PENDING_AGENT = 'pending_agent'; // triggers first visit attempt
	const VISIT_DELIVERED = 'delivered'; // "snoozed" until is_alert is false or deadline passes
	const VISIT_LATE_TO_CRAS = 'late_to_cras'; // triggers second visit attempt
	const VISIT_PENDING_TECHNICAL_VISIT = 'pending_technical_visit'; // triggers technical visit

	protected $table = 'families';

	protected $fillable = [
		'is_alert',
		'sector_id',
		'residence_id',
		'person_in_charge_id',
		'ipm_rate',
		'ipm_risk_factor',
		'visit_status',
		'visit_attempt',
		'visit_last',
		'case_opened_by',
		'opened_at',
		'gis_global_id',
	];

	protected $casts = [
		'is_alert' => 'boolean',
		'ipm_rate' => 'float',
		'ipm_risk_factor' => 'integer',
		'visit_attempt' => 'integer',
		'visit_last' => 'date',
		'opened_at' => 'datetime',
	];

	protected static $logAttributes = [
		'is_alert',
		'person_in_charge_id',
		'ipm_rate',
		'ipm_risk_factor',
		'visit_status',
		'visit_attempt',
		'visit_last',
	];

	// ---------------------------------------------------------------------------------------------------------------

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
	 * Relationship: user that opened the case
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function caseOpenedBy() {
		return $this->hasOne(User::class, 'id', 'case_opened_by')->withTrashed();
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

	public function scopeNotAlerts($query) {
		return $query->where('is_alert', false);
	}

	public function scopeOnlyAlerts($query) {
		return $query->where('is_alert', true);
	}

	public function scopeAlreadyHadVisit($query) {
		return $query->where('visit_status', '!=', self::VISIT_PENDING_AGENT);
	}

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Marks the family referral as delivered.
	 * Updates the "date of last visit" date.
	 */
	public function markAsDelivered() {
		$this->visit_status = self::VISIT_DELIVERED;
		$this->visit_last = Carbon::now();
		$this->save();
	}

	/**
	 * Marks the family visit status as "pending" once again.
	 * If the visit attempt was the first (visit_attempt = 1), status goes to LATE_TO_CRAS.
	 * If the visit attempt was the second (visit_attempt = 2), status goes to PENDING_TECHNICAL_VISIT.
	 * Increases the visit attempt by 1 after the above validation.
	 */
	public function returnToPending() {
		$this->visit_status = ($this->visit_attempt >= 2)
			? self::VISIT_PENDING_TECHNICAL_VISIT
			: self::VISIT_LATE_TO_CRAS;
		$this->visit_attempt += 1;
		$this->save();
	}

	/**
	 * Marks the family case as open, removing it from the alerts list.
	 * Will update the "case opened at" date.
	 * If a user is given as parameter, they will be set as the user who opened the case.
	 * @param null|User $user
	 */
	public function openCase(?User $user = null) {
		$this->is_alert = false;
		$this->opened_at = Carbon::now();


		if($user) {
			$this->case_opened_by = $user->id;
		}

		$this->save();

		if(!$user) return;

		app(UserAssignmentService::class)
			->assignUserToEntity($user, $this, UserAssignment::TYPE_CREATOR);

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
			'name' => $this->personInCharge->name ?? '',
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
			'Código Residência' => $this->residence->shortcode ?? '',
			'Responsável' => $this->personInCharge->name ?? '',
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
			'Endereço' => $this->residence->address ?? '',
			'Referência' => $this->residence->reference ?? '',
			'Latitude' => $this->residence->lat ?? '',
			'Longitude' => $this->residence->lng ?? '',
		];

		if(!$includeQuestionAnswers) return $data;

		$answers = QuestionAnswer::buildAnswerGrid($this->answers);

		return array_merge($data, $answers);
	}

	/**
	 * Returns a collection with all entities linked to this one, including itself as first item.
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function fetchLinkedEntities() {
		$entities = collect([$this, $this->residence]);

		$this->members->each(function($member) use ($entities) {
			$entities->push($member);
		});

		return $entities;
	}

	/**
	 * Fetches a family by its shortcode
	 * @param string $shortcode
	 * @return null|Family|Model
	 */
	public static function fetchByShortcode(string $shortcode) : ?Family {
		return self::query()
			->where('shortcode', $shortcode)
			->first();
	}

	/**
	 * Fetches all alerts which the deadline is past to show up at the CRAS
	 */
	public static function fetchAlertsLateToCRAS() {

		$cutoffDate = Carbon::now()
			->addDays(-30)
			->format('Y-m-d');

		return self::query()
			->onlyAlerts()
			->where('visit_status', self::VISIT_DELIVERED)
			->where('visit_last', '<=', $cutoffDate)
			->get();
	}
}