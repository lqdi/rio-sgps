<?php
/**
 * rio-sgps
 * Reports.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 11/02/2019, 21:23
 */

namespace SGPS\Entity;


class Reports {

	public static function qtyVisits() {
		return Family::query()
			->onlyAlerts()
			->alreadyHadVisit()
			->count();
	}

	public static function qtyYoungReferredToSMDEI() {
		return Person::query()
			->withAgeUpTo(21)
			->hasAnsweredQuestionWith('CE104A', Question::TYPE_YESNO, 1)
			->count();
	}

	public static function qtyAdultReferredToSMDEI() {
		return Person::query()
			->withAgeOver(21)
			->hasAnsweredQuestionWith('CE104A', Question::TYPE_YESNO, 1)
			->count();
	}

	public static function qtyFamiliesReferredToCRAS() {
		return Family::query()
			->alreadyHadVisit()
			->count();
	}

	public static function qtyFamiliesArrivedAtCRAS() {
		return Family::query()
			->notAlerts()
			->count();
	}

	public static function qtyRecipientsBF() {
		return Family::query()
			->hasActiveFlag('F002')
			->count();
	}

	public static function qtyPersonsWithoutDocumentation() {
		return Family::query()
			->hasActiveFlag('F009')
			->count();
	}

	public static function qtyPersonsWithCadUnico() {
		return Person::query()
			->hasAnsweredQuestionWith('CE110', Question::TYPE_SELECT_ONE, 1)
			->count();
	}

	public static function qtyChildrenEnrolledAtEI() {
		return Person::query()
			->withAgeUpTo(6)
			->hasAnsweredQuestionWith('CE62B', Question::TYPE_SELECT_ONE, 2)
			->count();
	}

	public static function qtyChildrenEnrolledAtEF() {
		return Person::query()
			->withAgeOver(6)
			->hasAnsweredQuestionWith('CE62B', Question::TYPE_SELECT_ONE, 4)
			->count();
	}


}