<?php
/**
 * rio-sgps
 * FlagAssignmentService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/10/2018, 19:36
 */

namespace SGPS\Services;


use Carbon\Carbon;
use SGPS\Entity\Entity;
use SGPS\Entity\Flag;

class FlagAssignmentService {

	public function doesFlagExistInEntity(Entity $entity, Flag $flag) : bool {
		return $entity->flags()->where('flag_id', $flag->id)->exists();
	}

	public function assignFlagToEntity(Entity $entity, Flag $flag, Carbon $referenceDate, ?int $deadline = null) {

		$assignmentProperties = [
			'reference_date' => $referenceDate->format('Y-m-d'),
			'is_default_deadline' => ($deadline !== null),
			'deadline' => $deadline ?? $flag->default_deadline,
		];

		$entity->flags()->syncWithoutDetaching([
			$flag->id => $assignmentProperties
		]);

	}

}