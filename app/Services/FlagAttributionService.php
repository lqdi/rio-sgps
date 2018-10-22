<?php
/**
 * rio-sgps
 * FlagAttributionService.php
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
use SGPS\Entity\FlagAttribution;

class FlagAttributionService {

	public function isFlagAttributedToEntity(Entity $entity, Flag $flag) : bool {
		return $entity->attributedFlags()
			->where('flag_id', $flag->id)
			->where('is_completed', false)
			->where('is_cancelled', false)
			->count() > 0;
	}

	public function cancelFlagAttribution(Entity $entity, Flag $flag) {
		$attribution = $entity->attributedFlags()
			->where('flag_id', $flag->id)
			->first(); /* @var $attribution \SGPS\Entity\FlagAttribution */

		$attribution->cancel();
	}

	public function completeFlagAttribution(Entity $entity, Flag $flag) {
		$attribution = $entity->attributedFlags()
			->where('flag_id', $flag->id)
			->first(); /* @var $attribution \SGPS\Entity\FlagAttribution */

		$attribution->complete();
	}

	public function attributeFlagToEntity(Entity $entity, Flag $flag, Carbon $referenceDate, ?int $deadline = null) : FlagAttribution {

		return FlagAttribution::create([
			'flag_id' => $flag->id,
			'residence_id' => $entity->getEntityType() === 'residence' ? $entity->getEntityID() : $entity->residence_id,
			'entity_type' => $entity->getEntityType(),
			'entity_id' => $entity->getEntityID(),
			'reference_date' => $referenceDate->format('Y-m-d'),
			'is_default_deadline' => ($deadline !== null),
			'deadline' => $deadline ?? $flag->default_deadline,
		]);

	}

}