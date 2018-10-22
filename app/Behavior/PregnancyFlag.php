<?php
/**
 * rio-sgps
 * PregnancyFlag.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 21/10/2018, 22:21
 */

namespace SGPS\Behavior;


use Carbon\Carbon;
use SGPS\Entity\Entity;
use SGPS\Entity\Flag;
use SGPS\Entity\FlagAttribution;

class PregnancyFlag extends FlagBehavior {

	/**
	 * Hook: this is called for every active entity of the same type as the flags', when answers are saved to it.
	 * This is called even when the flag is not yet attributed.
	 *
	 * @param Flag $flag The flag whose behavior is being evaluated.
	 * @param Entity $entity The target entity.
	 * @param array $answers An associative array of answers given, indexed by their code.
	 */
	public function hookAnswersUpdated(Flag $flag, Entity $entity, array $answers): void {
		// TODO: Implement hookAnswersUpdated() method.
	}

	/**
	 * Hook: this is called daily on a cron job, on all flag attributions for this particular flag.
	 * This is called on all active and inactive flags, except for cancelled ones.
	 *
	 * @param Flag $flag The flag whose behavior is being evaluated.
	 * @param FlagAttribution $attribution The flag attribution being checked.
	 * @param Carbon $today Today's date.
	 */
	public function hookDailyCron(Flag $flag, FlagAttribution $attribution, Carbon $today): void {
		// TODO: Implement hookDailyCron() method.
	}
}