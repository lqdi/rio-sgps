<?php
/**
 * rio-sgps
 * MammographyFlag.php
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
use SGPS\Behavior\Traits\RepeatingFlag;
use SGPS\Entity\Entity;
use SGPS\Entity\Flag;
use SGPS\Entity\FlagAttribution;

class MammographyFlag extends DefaultFlag {

	/**
	 * Rules for MAMMOGRAPHY FLAG:
	 *
	 * Aplicar imediatamente
	 * Reaplicar após 2 anos da data indicada
	 *
	 */

	use RepeatingFlag;

	/**
	 * Hook: this is called for every active entity of the same type as the flags', when answers are saved to it.
	 * This is called even when the flag is not yet attributed.
	 *
	 * @param Flag $flag The flag whose behavior is being evaluated.
	 * @param Entity $entity The target entity.
	 * @param array $answers An associative array of answers given, indexed by their code.
	 * @return bool
	 */
	public function hookAnswersUpdated(Flag $flag, Entity $entity, array $answers): bool {

		$conditions = [
			// Female
			['CE51', 'is_filled'],
			['CE51', 'eq', 2],

			// Age between 50 and 69
			['CE53', 'is_filled'],
			['CE53', 'age_between', 50, 69],

			['CE75', 'is_filled'], // ACS agent has visited

			['CE95', 'is_empty'], // Mammography date not filled yet
		];

		$shouldApplyImmediately = $this->conditionalChecker->matchesAll($conditions, $answers);

		if(!$shouldApplyImmediately) return false;

		$addedFlag = $entity->addFlagAttribution($flag, date('Y-m-d'), 30);

		return ($addedFlag !== null);

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

		parent::hookDailyCron($flag, $attribution, $today);

		// Repeats every two years
		$this->repeatEvery(24, $attribution, $today);

	}
}