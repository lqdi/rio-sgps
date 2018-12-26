<?php
/**
 * rio-sgps
 * MapUtils.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 26/12/2018, 15:30
 */

namespace SGPS\Utils;


class MapUtils {

	public static function mapProperties(&$local, $foreign, $map) {
		foreach($map as $localKey => $foreignKey) {
			if(!isset($foreign[$foreignKey])) continue;
			$local[$localKey] = $foreign[$foreignKey];
		}
	}

}