<?php
/**
 * IndexedByUUID.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 20/07/2018, 15:30
 */

namespace SGPS\Traits;


use Webpatser\Uuid\Uuid;

trait IndexedByUUID {

	use NonIncrementingIndex;

	protected static function bootIndexedByUUID() {
		static::creating(function ($model) {
			if(isset($model->{$model->getKeyName()})) return;
			$model->{$model->getKeyName()} = Uuid::generate()->string;
		});
	}

}