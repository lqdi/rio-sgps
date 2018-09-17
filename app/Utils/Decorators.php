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


use SGPS\Entity\Flag;

class Decorators {

	public static function getFlagBackgroundClass(Flag $flag) {

		switch($flag->pivot->entity_type) {
			case 'family': return 'text-primary';
			case 'residence': return 'text-success';
			case 'person': return 'text-info';
			default: return '';
		}

	}

}