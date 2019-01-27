<?php
/**
 * rio-sgps
 * DateUtils.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 18/10/2018, 21:01
 */

namespace SGPS\Utils;


use Carbon\Carbon;

class DateUtils {

	public static function calculateAgeInYears(string $date) : int {
		return Carbon::parse($date)->diffInYears();
	}

	public static function calculateAgeInDays(string $date) : int {
		return Carbon::parse($date)->diffInDays();
	}

	const BR_DATE_TIME = 'd/m/Y H:i:s';
	const BR_DATE = 'd/m/Y';

}