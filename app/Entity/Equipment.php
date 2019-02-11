<?php
/**
 * rio-sgps
 * Equipment.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 11/10/2018, 17:28
 */

namespace SGPS\Entity;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SGPS\Traits\IndexedByUUID;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Equipment
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $type
 * @property string $code
 * @property string $group_code
 * @property string $name
 * @property string $address
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property Sector[]|Collection $sectors
 * @property User[]|Collection $users
 */
class Equipment extends Model {

	use IndexedByUUID;
	use SoftDeletes;
	use LogsActivity;

    /**
     * Coordenadoria Regional de Educação
     */
	const TYPE_CRE = "CRE";

    /**
     * Unidade de Saúde
     */
	const TYPE_UBS = "UBS";

    /**
     * Centro de Referência em Assistência Social
     */
	const TYPE_CRAS = "CRAS";

    /**
     * Centro Municipal de Trabalho e Emprego
     */
	const TYPE_CMTE = "CMTE";

    /**
     * Secretaria Municipal da Saúde
     */
	const TYPE_SMS = "SMS";

	/**
	 * Valid equipment types
	 */
	const TYPES = [
		self::TYPE_CRE,
		self::TYPE_UBS,
		self::TYPE_CRAS,
		self::TYPE_CMTE,
		self::TYPE_SMS
	];

	protected $table = 'equipments';
	protected $fillable = [
		'type',
		'code',
		'group_code',
		'name',
		'address',
	];

	protected static $logAttributes = [
		'type',
		'code',
		'group_code',
		'name',
		'address',
	];

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Relationship: equipment with sectors
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function sectors() {
		return $this->belongsToMany(Sector::class, 'sector_equipments');
	}

	/**
	 * Relationship: equipment with users
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users() {
		return $this->belongsToMany(User::class, 'user_equipments');
	}

}
