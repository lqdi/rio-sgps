<?php
/**
 * rio-sgps
 * UuidUtils.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 26/12/2018, 14:09
 */

namespace SGPS\Utils;


class UuidUtils {

	public static function fromSurveyGUID(string $guid) : string {
		return trim(strtolower(str_replace(['{', '}'], '', $guid)));
	}

}