<?php
/**
 * rio-sgps
 * Shortcode.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 14/09/2018, 16:31
 */

namespace SGPS\Utils;


class Shortcode {

	public static function generate(string $prefix = 'RJX') {
		$randomFactorA = str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
		$randomFactorB = str_pad(dechex(random_int(1, 60000)), 4, '0', STR_PAD_LEFT);

		return strtoupper($prefix . $randomFactorA . '-' . $randomFactorB);
	}

}