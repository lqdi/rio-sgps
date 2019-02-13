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

use Webpatser\Uuid\Uuid;

class UuidUtils {

	public static function fromSurveyGUID(string $guid) : string {
	    if(strlen($guid) !== 38) { // not a GUID, so generate one
	        return (string) Uuid::generate(3, "guid_{$guid}", Uuid::NS_DNS);
        }

		return trim(strtolower(str_replace(['{', '}'], '', $guid)));
	}

}
