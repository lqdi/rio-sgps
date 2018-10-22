<?php
/**
 * rio-sgps
 * ColpocitologyFlag.php
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

class ColpocitologyFlag extends DefaultFlag {

	/**
	 * Rules for COLPOCITOLOGY FLAG:
	 *
	 * Aplicar imediatamente
	 * Reaplicar após 1 ano da data indicada (se CE94 = S)
	 * Reaplicar após 3 anos da data indicada (se CE94 = N)
	 *
	 */

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
			// Age between 25 and 64 yo
			['CE53', 'is_filled'],
			['CE53', 'age_between', 25, 64],

			// Female
			['CE51', 'is_filled'],
			['CE51', 'eq', 2],

			['CE75', 'is_filled'], // ACS has visited

			['CE93', 'is_empty'], // Colprocitology not confirmed yet
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

		// Still has not done exam
		if(!$attribution->is_completed) return;

		$lastExamDateAnswer = $attribution->entity->getAnswerByCode('CE93');

		// Field waas cleared since last time
		if(!$lastExamDateAnswer) return;

		// Checks if person needs anual or trianual exams
		$needsAnnualExam = $attribution->entity->getAnswerByCode('CE94');
		$needsAnnualExam = $needsAnnualExam ? $needsAnnualExam->getValue() : false;

		$lastExamDate = $lastExamDateAnswer->getAnswerAsDate();
		$yearsUntilNextExam = $needsAnnualExam ? 1 : 3;

		// Still has not reached next reapply date
		if($lastExamDate->diffInYears() < $yearsUntilNextExam) return;

		$attribution->reopen($today, $attribution->deadline);

	}
}