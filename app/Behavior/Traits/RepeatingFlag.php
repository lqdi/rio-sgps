<?php
/**
 * rio-sgps
 * RepeatingFlag.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 22/10/2018, 00:00
 */

namespace SGPS\Behavior\Traits;


use Carbon\Carbon;
use SGPS\Entity\Flag;
use SGPS\Entity\FlagAttribution;

trait RepeatingFlag {

	/**
	 * Reopens the flag attribution if the attribution age (time since reference date) reaches a certain number of months.
	 * Will only reopen flags that have been completed already.
	 * Will reopen with the previous deadline time given.
	 *
	 * @param int $numMonths The number of months to check
	 * @param FlagAttribution $attribution The attribution to check
	 * @param Carbon $today The 'today' date to check against
	 * @return bool Returns true if the attrib was reopened, or false if not.
	 */
	public function repeatEvery(int $numMonths, FlagAttribution $attribution, Carbon $today) : bool {

		// The previous attrib cycle is not marked as completed yet
		if(!$attribution->is_completed) return false;

		// Gets how long the attrib has been set
		$attributionAge = $attribution->getAttributionAgeInMonths($today);

		// Attrib not yet old enough for reopening
		if($attributionAge <= $numMonths) return false;

		// Reopens the attrib w/ default deadline
		$attribution->reopen($today, $attribution->deadline);

		return true;

	}

}