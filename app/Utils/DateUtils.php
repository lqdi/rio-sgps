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

}