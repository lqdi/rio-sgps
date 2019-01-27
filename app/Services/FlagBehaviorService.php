<?php
/**
 * rio-sgps
 * FlagBehaviorService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 18/10/2018, 20:31
 */

namespace SGPS\Services;

use Carbon\Carbon;
use SGPS\Entity\Entity;
use SGPS\Entity\Flag;
use SGPS\Entity\FlagAttribution;

class FlagBehaviorService {

	/**
	 * Evaluates the behavior handler hooks for all flags with compatible types.
	 * @param Entity $entity The entity being updated.
	 * @param array $answers The answer grid.
	 * @return bool
	 * @throws \Exception
	 */
	public function evaluateBehaviorsForAnswers(Entity $entity, array $answers) : bool {

		$flags = Flag::fetchAllForType($entity->getEntityType());
		$hasAddedFlags = false;

		foreach($flags as $flag) {
			$handler = $flag->getBehaviorHandler();
			$didAddFlag = $handler->hookAnswersUpdated($flag, $entity, $answers);

			if(!$didAddFlag) continue;

			$hasAddedFlags = true;
		}

		return $hasAddedFlags;

	}

	/**
	 * Evaluates the behavior handler hooks for all flag attributions eligibile.
	 * @param Carbon $today Today's date.
	 * @throws \Exception
	 */
	public function evaluateBehaviorsForDailyCron(Carbon $today) {

		$attributions = FlagAttribution::fetchEligibleForDailyCron();

		foreach($attributions as $attribution) {
			$handler = $attribution->flag->getBehaviorHandler();
			$handler->hookDailyCron($attribution->flag, $attribution, $today);
		}

	}

}