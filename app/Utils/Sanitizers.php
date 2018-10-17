<?php
/**
 * rio-sgps
 * Sanitizers.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 17/10/2018, 19:25
 */

namespace SGPS\Utils;


class Sanitizers {

	public static function clearForSearch($input) {
		if(!is_string($input)) return $input;
		return str_replace('-', '', $input);
	}

}