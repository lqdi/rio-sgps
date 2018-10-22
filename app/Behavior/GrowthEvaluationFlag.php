<?php
/**
 * rio-sgps
 * GrowthEvaluationFlag.php
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

class GrowthEvaluationFlag extends DefaultFlag {

	/**
	 * Rules for GROWTH EVALUATION FLAG:
	 * Alerta cíclico bimestral até 6 meses,
	 * Alerta cíclico trimestral entre 6 meses e 1 ano
	 * Alerta semestral a partir de 1 ano
	 * Transforma resposta em N em todos os casos ao fim do cíclo
	 */

	use RepeatingFlag;

	/**
	 * Hook: this is called for every active entity of the same type as the flags', when answers are saved to it.
	 * This is called even when the flag is not yet attributed.
	 *
	 * @param Flag $flag The flag whose behavior is being evaluated.
	 * @param Entity $entity The target entity.
	 * @param array $answers An associative array of answers given, indexed by their code.
	 */
	public function hookAnswersUpdated(Flag $flag, Entity $entity, array $answers): void {

		$conditions = [
			// Is 6yo or younger
			['CE53', 'is_filled'],
			['CE53', 'age_lt', 6],

			// ACS agent has visited
			['CE75', 'is_filled'],

			// Has not confirmed growth evaluation
			['CE91', 'is_filled'],
			['CE91', 'eq', 0],
		];

		$shouldApplyImmediately = $this->conditionalChecker->matchesAll($conditions, $answers);

		if(!$shouldApplyImmediately) return;

		$entity->addFlagAttribution($flag, date('Y-m-d'), 30);

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

		$cycleSizeInMonths = $this->calculateCycleSize($ageInMonths);
		$hasReopened = $this->repeatEvery($cycleSizeInMonths, $attribution, $today);

		if($hasReopened) { // Resets the CE91 question ('Avaliação confirmada?') to N.
			$question = Question::fetchByCode('CE91');
			$attribution->entity->setAnswer($question, 0);
		}

	}

	private function calculateCycleSize(int $personAgeInMonths) {
		if($personAgeInMonths <= 6) return 2; // Repeats every bimester for children up to 6mo old
		if($personAgeInMonths <= 12) return 3; // Repeats every trimester for children up to 1yo old
		return 12; // Repeats every year
	}
}