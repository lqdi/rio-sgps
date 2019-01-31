<?php
/**
 * rio-sgps
 * Flag.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 05/09/2018, 18:49
 */

namespace SGPS\Entity;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SGPS\Behavior\FlagBehavior;
use SGPS\Traits\HasShortCode;
use SGPS\Traits\IndexedByUUID;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Flag
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $shortcode
 * @property string $code
 * @property string $name
 * @property string $entity_type
 * @property string $description
 * @property string $behavior
 * @property array|null $conditions
 * @property array|null $triggers
 * @property string $is_visible
 * @property integer $default_deadline
 * @property string $default_assigned_group_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property Family[]|Collection $families
 * @property Residence[]|Collection $residences
 * @property Person[]|Collection $persons
 * @property Group[]|Collection $groups
 */
class Flag extends Model {

	use IndexedByUUID;
	use SoftDeletes;
	use HasShortCode;
	use LogsActivity;

	protected $table = 'flags';
	protected $fillable = [
		'code',
		'name',
		'behavior',
		'conditions',
		'entity_type',
		'description',
		'triggers',
		'is_visible',
		'default_deadline',
	];

	protected $casts = [
		'default_deadline' => 'integer',
		'conditions' => 'array',
		'triggers' => 'array',
	];

	protected static $logAttributes = [
		'code',
		'name',
		'behavior',
		'conditions',
		'entity_type',
		'description',
		'triggers',
		'is_visible',
		'default_deadline',
	];

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Relationship: flags with their attributions to target entities
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function attributions() {
		return $this->hasMany(FlagAttribution::class, 'flag_id', 'id');
	}

	/**
	 * Relationship: flag with families (through Flag Assignments)
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function families() {
		return $this->morphedByMany(Family::class, 'entity', 'flag_attributions');
	}

	/**
	 * Relationship: flag with residences (through Flag Assignments)
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function residences() {
		return $this->morphedByMany(Residence::class, 'entity', 'flag_attributions');
	}

	/**
	 * Relationship: flag with persons (through Flag Assignments)
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function persons() {
		return $this->morphedByMany(Person::class, 'entity', 'flag_attributions');
	}

	/**
	 * Relationship: flags with groups
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function groups() {
		return $this->belongsToMany(Group::class, 'flag_groups', 'flag_code', 'group_code', 'code', 'code');
	}

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Gets the behavior handler instance for this flag
	 * @return FlagBehavior
	 * @throws \Exception
	 */
	public function getBehaviorHandler() : FlagBehavior {
		return FlagBehavior::getHandler($this);
	}

	/**
	 * Deletes the flag.
	 * Will permanently remove all relationships with entities.
	 * @throws \Exception
	 */
	public function delete() {
		$this->families()->sync([]);
		$this->residences()->sync([]);
		$this->persons()->sync([]);

		return parent::delete();
	}

	/**
	 * Returns a basic JSON object with flag info
	 * @return array
	 */
	public function toBasicJson() : array {
		return [
			'id' => $this->id,
			'shortcode' => $this->shortcode,
			'name' => $this->name,
		];
	}

	// ---------------------------------------------------------------------------------------------------------------

	private static $allFlagsForType = null;

	/**
	 * Fetches all flags that target a specific entity type.
	 * @param string $entityType
	 * @return Flag[]|Collection
	 */
	public static function fetchAllForType(string $entityType) {
		if(self::$allFlagsForType !== null) {
			return self::$allFlagsForType;
		}

		return self::$allFlagsForType = self::query()
			->where('entity_type', $entityType)
			->get();
	}

}