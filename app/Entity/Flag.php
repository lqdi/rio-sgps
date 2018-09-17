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
use SGPS\Traits\HasShortCode;
use SGPS\Traits\IndexedByUUID;

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
 * @property string $triggers
 * @property string $is_visible
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property Family[]|Collection $families
 * @property Residence[]|Collection $residences
 * @property Person[]|Collection $persons
 */
class Flag extends Model {

	use IndexedByUUID;
	use SoftDeletes;
	use HasShortCode;

	protected $table = 'flags';
	protected $fillable = [
		'code',
		'name',
		'entity_type',
		'description',
		'triggers',
		'is_visible',
	];

	public function families() {
		return $this->morphedByMany(Family::class, 'entity', 'flagged_entities');
	}

	public function residences() {
		return $this->morphedByMany(Residence::class, 'entity', 'flagged_entities');
	}

	public function persons() {
		return $this->morphedByMany(Person::class, 'entity', 'flagged_entities');
	}

	public function delete() {
		$this->families()->sync([]);
		$this->residences()->sync([]);
		$this->persons()->sync([]);

		parent::delete();
	}

}