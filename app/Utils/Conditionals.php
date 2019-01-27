<?php
/**
 * rio-sgps
 * Conditionals.php
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

class Conditionals {

	public const CHILDREN_MAX_AGE = 14;

	public function is_true($fieldValue) : bool {
		return boolval($fieldValue);
	}

	public function is_false($fieldValue) : bool {
		return !boolval($fieldValue);
	}

	public function is_filled($fieldValue) : bool {
		if($fieldValue === null) return false;

		if(is_bool($fieldValue)) return true;
		if(is_integer($fieldValue)) return true;
		if(is_float($fieldValue)) return true;
		if(is_object($fieldValue)) return true;
		if(is_array($fieldValue)) return true;

		return strlen($fieldValue) > 0;
	}

	public function is_not_filled($fieldValue) : bool {
		return !$this->is_filled($fieldValue);
	}

	public function eq($fieldValue, $param) : bool {
		return strval($fieldValue) === strval($param);
	}

	public function ieq($fieldValue, $param) : bool {
		return strval($fieldValue) !== strval($param);
	}

	public function neq($fieldValue, $param) : bool {
		return $this->ieq($fieldValue, $param);
	}

	public function is_one_of($fieldValue, $params) : bool {
		return collect($params)->contains(function ($p) use ($fieldValue) {
			return strval($p) === strval($fieldValue);
		});
	}

	public function is_valid_date($fieldValue) : bool {
		return is_string($fieldValue) && strtotime($fieldValue) !== false;
	}

	public function before_today($fieldValue) : bool {
		if(!$this->is_valid_date($fieldValue)) return false;
		return Carbon::parse($fieldValue)->isPast();
	}

	public function age_between($fieldValue, $paramA, $paramB) : bool {
		if(!$this->is_valid_date($fieldValue)) return false;

		$age = DateUtils::calculateAgeInYears($fieldValue);
		return $age >= $paramA && $age <= $paramB;
	}

	public function age_gt($fieldValue, $param) : bool {
		if(!$this->is_valid_date($fieldValue)) return false;
		return DateUtils::calculateAgeInYears($fieldValue) >= $param;
	}

	public function age_lt($fieldValue, $param) : bool {
		if(!$this->is_valid_date($fieldValue)) return false;
		return DateUtils::calculateAgeInYears($fieldValue) <= $param;
	}

	public function days_since_gt($fieldValue, $param) : bool {
		if(!$this->is_valid_date($fieldValue)) return false;
		return DateUtils::calculateAgeInDays($fieldValue) >= $param;
	}

	public function days_since_lt($fieldValue, $param) : bool {
		if(!$this->is_valid_date($fieldValue)) return false;
		return DateUtils::calculateAgeInDays($fieldValue) <= $param;
	}

	public function is_children($fieldValue) : bool {
		if(!$this->is_valid_date($fieldValue)) return false;
		return DateUtils::calculateAgeInYears($fieldValue) <= self::CHILDREN_MAX_AGE;
	}

}