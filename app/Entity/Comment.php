<?php
/**
 * rio-sgps
 * Comment.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 17/09/2018, 16:58
 */

namespace SGPS\Entity;


use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SGPS\Traits\IndexedByUUID;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Comment
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $entity_id
 * @property string $entity_type
 * @property string $user_id
 * @property string $message
 * @property object $metadata
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property Model $entity
 * @property User $user
 */
class Comment extends Model {

	use IndexedByUUID;
	use SoftDeletes;
	use LogsActivity;

	protected $table = 'comments';
	protected $fillable = [
		'entity_id',
		'entity_type',
		'user_id',
		'message',
	];

	protected $casts = [
		'metadata' => 'object',
	];

	protected static $logAttributes = [
		'message'
	];

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Relationship: comment with target entity
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function entity() {
		return $this->morphTo('entity');
	}

	/**
	 * Relationship: comment with user (poster)
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function user() {
		return $this->hasOne(User::class, 'id', 'user_id');
	}

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Checks if the comment is owned by a given user
	 * @param null|User|Authenticatable $user
	 * @return bool
	 */
	public function isOwnedBy(?User $user) : bool {

		if(!$this->user_id) return false;
		if(!$user) return false;

		return $this->user_id === $user->id;

	}

	// ---------------------------------------------------------------------------------------------------------------

	/**
	 * Fetches a thread of comments attached to a specific entity.
	 * @param string $type The entity type.
	 * @param string $id The entity ID.
	 * @param int $max The max records to return (default: 24)
	 * @param int $offset The records' offset (default: 0)
	 * @return Comment[]|Collection
	 */
	public static function fetchThreadFromEntity(string $type, string $id, int $max = 24, int $offset = 0) {
		return self::query()
			->where('entity_type', $type)
			->where('entity_id', $id)
			->with(['user'])
			->skip($offset)
			->take($max)
			->orderBy('created_at', 'desc')
			->get();
	}

	/**
	 * Posts a comment in an entity thread.
	 * @param string $type The entity type.
	 * @param string $id The entity ID.
	 * @param User $post The poster.
	 * @param string $message The message.
	 * @return Comment
	 */
	public static function post(string $type, string $id, User $post, string $message) : Comment {
		return self::create([
			'entity_type' => $type,
			'entity_id' => $id,
			'user_id' => $post->id,
			'message' => $message
		]);
	}

}