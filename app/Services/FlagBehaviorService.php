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
	 */
	public function evaluateBehaviorsForAnswers(Entity $entity, array $answers) {

		$flags = Flag::fetchAllForType($entity->getEntityType());

		foreach($flags as $flag) {
			$handler = $flag->getBehaviorHandler();
			$handler->hookAnswersUpdated($flag, $entity, $answers);
		}

	}

	/**
	 * Evaluates the behavior handler hooks for all flag attributions eligibile.
	 * @param Carbon $today Today's date.
	 */
	public function evaluateBehaviorsForDailyCron(Carbon $today) {

		$attributions = FlagAttribution::fetchEligibleForDailyCron();

		foreach($attributions as $attribution) {
			$handler = $attribution->flag->getBehaviorHandler();
			$handler->hookDailyCron($attribution->flag, $attribution, $today);
		}

	}

}