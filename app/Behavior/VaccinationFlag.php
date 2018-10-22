<?php
/**
 * rio-sgps
 * VaccinationFlag.php
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
use SGPS\Entity\Question;

class VaccinationFlag extends DefaultFlag {

	/**
	 * Rules for VACCINATION FLAG:
	 *
	 * Alerta mensal até 6 meses de idade.
	 * Novos alertas aos 9, 12 e 15 meses e aos 4 anos de idade.
	 * Transforma resposta em N na data que o alerta é reativado
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
			// Is 6yo or younger
			['CE53', 'is_filled'],
			['CE53', 'age_lt', 6],

			['CE75', 'is_filled'], // ACS has visited

			['CE90', 'eq', 0], // Has not confirmed vaccination
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

		$ageInMonths = $attribution->person->getAgeInMonths();

		if($ageInMonths > 59) return; // Skip if person older than 4yo & 11mo

		$cycleSizeInMonths = $this->calculateCycleSize($ageInMonths);
		$hasReopened = $this->repeatEvery($cycleSizeInMonths, $attribution, $today);

		if($hasReopened) { // Resets the CE90 question ('Vacinação confirmada?') to N.
			$question = Question::fetchByCode('CE90');
			$attribution->entity->setAnswer($question, 0);
		}

	}

	private function calculateCycleSize(int $personAgeInMonths) {
		if($personAgeInMonths <= 6) return 1; // Repeats monthly for children up to 6mo old
		if($personAgeInMonths <= 15) return 3; // Repeats every trimester for children up to 15mo old
		return 34; // Repeats when children reaches 4yo
	}
}