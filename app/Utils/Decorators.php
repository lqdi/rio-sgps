<?php
/**
 * rio-sgps
 * Decorators.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 17/09/2018, 15:52
 */

namespace SGPS\Utils;


use Carbon\Carbon;
use SGPS\Entity\Flag;

class Decorators {

	public static function getFlagBackgroundClass(Flag $flag) {

		if($flag->pivot->is_completed) {
			return 'text-secondary';
		}

		switch($flag->pivot->entity_type) {
			case 'family': return 'text-primary';
			case 'residence': return 'text-success';
			case 'person': return 'text-info';
			default: return '';
		}

	}

	public static function getFlagDeadline(string $referenceDate, int $deadlineInDays) {
		$deadline = Carbon::createFromFormat('Y-m-d', $referenceDate)->addDays($deadlineInDays);
		return "{$deadline->toDateString()} ({$deadline->diffForHumans()})";
	}

}