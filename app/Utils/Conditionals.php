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

	public function is_true($fieldValue) {
		return !!$fieldValue;
	}

	public function is_false($fieldValue) {
		return ! $fieldValue;
	}

	public function is_filled($fieldValue) {
		return ($fieldValue !== null && strval($fieldValue) !== "");
	}

	public function is_not_filled($fieldValue) {
		return !($fieldValue !== null && strval($fieldValue) !== "");
	}

	public function eq($fieldValue, $param) {
		return strval($fieldValue) === strval($param);
	}

	public function ieq($fieldValue, $param) {
		return strval($fieldValue) !== strval($param);
	}

	public function is_one_of($fieldValue, $params) {
		return collect($params)->contains(function ($p) {
			return strval($p);
		});
	}

	public function before_today($fieldValue) {
		return Carbon::parse($fieldValue)->isPast();
	}

	public function age_between($fieldValue, $paramA, $paramB) {
		$age = DateUtils::calculateAgeInYears($fieldValue);
		return $age >= $paramA && $age <= $paramB;
	}

	public function age_gt($fieldValue, $param) {
		return DateUtils::calculateAgeInYears($fieldValue) >= $param;
	}

	public function age_lt($fieldValue, $param) {
		return DateUtils::calculateAgeInYears($fieldValue) <= $param;
	}

	public function is_children($fieldValue) {
		return DateUtils::calculateAgeInYears($fieldValue) <= self::CHILDREN_MAX_AGE;
	}

}