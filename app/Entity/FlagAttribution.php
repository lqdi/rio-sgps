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
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class FlagAttribution
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $residence_id
 * @property string $sector_id
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
 * @property array|null $behavior_metadata
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Flag $flag
 * @property Residence $residence
 * @property Entity $entity
 * @property Person|null $person Only works if the target entity is a person.
 */
class FlagAttribution extends Model {

	use LogsActivity;

	protected $table = 'flag_attributions';
	protected $with = ['flag'];

	protected $fillable = [
		'residence_id',
		'sector_id',
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
		'behavior_metadata',
	];

	protected $casts = [
		'reference_date' => 'date',
		'deadline' => 'integer',
		'is_default_deadline' => 'boolean',
		'is_late' => 'boolean',
		'is_completed' => 'boolean',
		'is_cancelled' => 'boolean',
		'behavior_metadata' => 'array',
	];

	protected static $logAttributes = [
		'reference_date',
		'deadline',
		'flagged_by_operator_id',
		'is_default_deadline',
		'is_late',
		'is_completed',
		'is_cancelled',
		'behavior_metadata',
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

	public function person() {
		return $this->hasOne(Person::class, 'id', 'entity_id');
	}

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Completes the attribution.
	 */
	public function complete() : void {
		$this->is_completed = true;
		$this->is_cancelled = false;
		$this->save();
	}

	/**
	 * Cancels the attribution.
	 */
	public function cancel() : void {
		$this->is_completed = false;
		$this->is_cancelled = true;
		$this->save();
	}

	/**
	 * Reopens a previously completed flag assignment
	 * @param Carbon $referenceDate
	 * @param int $deadline
	 */
	public function reopen(Carbon $referenceDate, int $deadline) : void {
		$this->is_completed = false;
		$this->is_cancelled = false;
		$this->reference_date = $referenceDate->format('Y-m-d');
		$this->deadline = $deadline;
		$this->save();
	}

	/**
	 * Sets this attribution as late.
	 * Persists to the database.
	 */
	public function markAsLate() {
		$this->is_late = true;
		$this->save();
	}

	/**
	 * Sets this attribution as on-time (not late).
	 * Persists to the database.
	 */
	public function markAsOnTime() {
		$this->is_late = false;
		$this->save();
	}

	/**
	 * Checks if this attribution is late or not, updates it accordingly.
	 * Persists changes to the database.
	 */
	public function checkIfLate() {
		if($this->is_completed) return;

		$deadline = $this->reference_date->copy()->addDays($this->deadline);
		$isLate = $deadline->isPast();

		// If should be late, but isn't
		if($isLate && !$this->is_late) {
			$this->markAsLate();
		}

		// If should not be late, but is.
		if(!$isLate && $this->is_late) {
			$this->markAsOnTime();
		}
	}

	/**
	 * Gets how many days has this attribution has since its reference date.
	 * @param Carbon|null $today
	 * @return int
	 */
	public function getAttributionAgeInDays(?Carbon $today = null) : int {
		if(!$this->reference_date) return 0;
		return $this->reference_date->diffInDays($today);
	}

	/**
	 * Gets how many months has this attribution has since its reference date.
	 * @param Carbon|null $today
	 * @return int
	 */
	public function getAttributionAgeInMonths(?Carbon $today = null) : int {
		if(!$this->reference_date) return 0;
		return $this->reference_date->diffInMonths($today);
	}

	/**
	 * Gets a value from the behavior metadata store
	 * @param string $key
	 * @return mixed|null
	 */
	public function metaGet(string $key) {
		if(!$this->behavior_metadata) {
			return null;
		}

		if(isset($this->behavior_metadata[$key])) {
			return null;
		}

		return $this->behavior_metadata[$key];
	}

	/**
	 * Saves a value on the behavior metadata store
	 * @param string $key
	 * @param $value
	 */
	public function metaSet(string $key, $value) {
		$metadata = $this->behavior_metadata;

		if(!$metadata) {
			$metadata = [];
		}

		$metadata[$key] = $value;

		$this->behavior_metadata = $metadata;
	}

	/**
	 * Clears a value from the behavior metadata store
	 * @param string $key
	 */
	public function metaDelete(string $key) {
		if(!$this->behavior_metadata) {
			return;
		}

		if(isset($this->behavior_metadata[$key])) {
			return;
		}

		$metadata = $this->behavior_metadata;
		unset($metadata[$key]);

		$this->behavior_metadata = $metadata;
	}

	/**
	 * Creates a flag attribution from given parameters
	 * @param Flag $flag
	 * @param Entity $entity
	 * @param string|null $referenceDate
	 * @param int $deadline
	 * @return FlagAttribution
	 */
	public static function createFromAttribution(Flag $flag, Entity $entity, string $referenceDate = null, int $deadline = 30) : FlagAttribution {
		return self::create([
			 'flag_id' => $flag->id,
			 'residence_id' => $entity->getEntityResidenceID(),
			 'sector_id' => $entity->getEntitySectorID(),
			 'entity_type' => $entity->getEntityType(),
			 'entity_id' => $entity->getEntityID(),
			 'reference_date' => $referenceDate ?? date('Y-m-d'),
			 'deadline' => $deadline,
			 'is_default_deadline' => true,
			 'is_late' => false,
			 'is_completed' => false,
			 'is_cancelled' => false,
		]);
	}

	/**
	 * Fetches all flags that are eligible for daily cron (not cancelled).
	 * Will eager load flag and entity.
	 *
	 * @return FlagAttribution[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function fetchEligibleForDailyCron() {
		return self::query()
			->with(['flag', 'entity'])
			->where('is_cancelled', false)
			->get();
	}

	/**
	 * @param $groupCodes
	 * @param array $with
	 * @param int|null $perPage
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|FlagAttribution[]
	 */
	public static function fetchAllUnderGroups($groupCodes, array $with = [], ?int $perPage = null) {

		$flagsIDs = Flag::query()
			->whereHas('groups', function ($sq) use ($groupCodes) {
				return $sq->whereIn('code', $groupCodes);
			})
			->get(['id'])
			->pluck('id');

		$query = self::query()
			->with($with)
			->whereIn('flag_id', $flagsIDs)
			->where('is_completed', false)
			->where('is_cancelled', false);


		if($perPage === null) {
			return $query->get();
		}

		return $query->paginate($perPage, ['*'], 'page_bygroup');

	}

	/**
	 * @param $sectorIDs
	 * @param array $with
	 * @param int|null $perPage
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|FlagAttribution[]
	 */
	public static function fetchAllUnderSectors($sectorIDs, array $with = [], ?int $perPage = null) {

		$query = self::query()
			->with($with)
			->whereIn('sector_id', $sectorIDs)
			->where('is_completed', false)
			->where('is_cancelled', false);

		if($perPage === null) {
			return $query->get();
		}

		return $query->paginate($perPage, ['*'], 'page_bysector');

	}

}