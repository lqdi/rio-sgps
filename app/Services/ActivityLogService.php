<?php
/**
 * rio-sgps
 * ActivityLogService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 12/12/2018, 16:52
 */

namespace SGPS\Services;

use SGPS\Entity\Entity;
use SGPS\Entity\Family;
use Spatie\Activitylog\Models\Activity;

class ActivityLogService {

	public function fetchFamilyLog(Family $family, int $max = 32, int $offset = 0) {
		return Activity::query()
			->with(['causer'])
			->where('log_name', 'family')
			->whereIn('subject_id', [$family->id, $family->residence_id])
			->latest()
			->skip($offset)
			->take($max)
			->get();
	}

	public function writeToFamilyLog(Entity $entity, string $event, array $properties = []) : Activity {

		$targetEntity = ($entity->getEntityType() === 'person')
			? $entity->family // Members have their events attached to the parent family instead
			: $entity; // Families are the root log; residences also have their own log (which gets fetched in the family log)

		return activity('family')
			->performedOn($targetEntity)
			->withProperties($properties)
			->log($event);
	}

}