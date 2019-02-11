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
use Illuminate\Database\Eloquent\SoftDeletes;
use SGPS\Traits\HasShortCode;
use SGPS\Traits\IndexedByUUID;
use SGPS\Utils\Sanitizers;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Person
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $shortcode
 * @property string $residence_id
 * @property string $family_id
 * @property string $sector_id
 * @property string $name
 * @property Carbon|null $dob
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
 * @property string $archived_reason
 * @property string $archived_by
 *
 * @property Sector $sector
 * @property Residence $residence
 * @property Family $family
 * @property User $archivedBy
 */
class Person extends Entity {

	use IndexedByUUID;
	use SoftDeletes;
	use HasShortCode;
	use LogsActivity;

	protected $table = "persons";

	protected $fillable = [
		'residence_id',
		'family_id',
		'sector_id',
		'name',
		'dob',
		'nis',
		'cpf',
		'rg',
		'phone_number',
		'gis_global_id',
	];

	protected $casts = [
		'dob' => 'date',
	];

	protected static $logAttributes = [
		'name',
		'dob',
		'nis',
		'cpf',
		'rg',
		'phone_number',
	];

	// ---------------------------------------------------------------------------------------------------------------

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

	/**
	 * Relationship: user that archived this family member
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function archivedBy() {
		return $this->hasOne(User::class, 'id', 'archived_by')->withTrashed();
	}

	// ---------------------------------------------------------------------------------------------------------------

	public function scopeWithAgeUpTo($query, $age) {
		$cutoffDate = Carbon::now()->addYears(0 - intval($age))->format('Y-m-d');
		return $query->where('dob', '>=', $cutoffDate);
	}
	public function scopeWithAgeOver($query, $age) {
		$cutoffDate = Carbon::now()->addYears(0 - intval($age))->format('Y-m-d');
		return $query->where('dob', '<', $cutoffDate);
	}

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Checks if the person has the age information available
	 * @return bool
	 */
	public function hasAgeAvailable() : bool {
		return $this->dob !== null && $this->dob->isPast();
	}

	/**
	 * Gets the person's age, based on the given date of birth.
	 * @return int
	 */
	public function getAge() {
		if(!$this->dob) return null;
		return $this->dob->diffInYears();
	}

	/**
	 * Gets the person's age in months, based on the given date of birth.
	 * @return int
	 */
	public function getAgeInMonths() {
		if(!$this->dob) return null;
		return $this->dob->diffInMonths();
	}

	/**
	 * Checks if this person has been archived.
	 * @return bool
	 */
	public function isArchived() : bool {
		return $this->deleted_at !== null && $this->archived_reason !== null;
	}

	/**
	 * Archives the person profile.
	 * @param string $reason
	 * @throws \Exception
	 */
	public function archive(string $reason) : void {

		$this->archived_reason = $reason;
		$this->archived_by = auth()->user()->id;
		$this->save();

		$this->delete(); // soft-deletes

		$this->assignments()->delete();
		$this->attributedFlags()->delete();

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
	 * Concrete: Person has parent residence UUID.
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
	 * Concrete: Persons have type string 'person'
	 * @return string
	 */
	public function getEntityType(): string {
		return 'person';
	}

	/**
	 * Abstract: Builds a basic JSON for entity identification
	 * @return array
	 */
	public function toBasicJson(): array {
		return [
			'type' => $this->getEntityType(),
			'id' => $this->getEntityID(),
			'name' => $this->name,
			'shortcode' => $this->shortcode,
		];
	}

	/**
	 * Concrete: Search array with person basic data
	 * @return array
	 */
	public function toSearchableArray() {

		return [
			'id' => $this->id,
			'shortcode' => Sanitizers::clearForSearch($this->shortcode),
			'gis_global_id' => $this->gis_global_id,
			'sector_id' => $this->sector_id,
			'name' => $this->name,
			'nis' => $this->nis,
			'cpf' => $this->cpf,
			'rg' => $this->rg,
			'phone_number' => $this->phone_number,
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
			'Código Família' => $this->family->shortcode ?? '',
			'Código Residência' => $this->residence->shortcode ?? '',
			'Nome' => $this->name,
			'Data de Nascimento' => $this->dob ? $this->dob->toDateTimeString() : null,
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
}