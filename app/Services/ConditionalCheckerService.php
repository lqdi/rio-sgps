<?php
/**
 * rio-sgps
 * ConditionalCheckerService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 18/10/2018, 20:51
 */

namespace SGPS\Services;


use SGPS\Utils\Conditionals;

class ConditionalCheckerService {

	private $rules;

	public function __construct() {
		$this->rules = new Conditionals();
	}

	/**
	 * Checks if a set of answers matches all given conditions
	 * @param array $conditions
	 * @param array $answers
	 * @return bool
	 */
	public function matchesAll(array $conditions, array $answers) : bool {

		if(!is_array($conditions) || sizeof($conditions) <= 0) {
			return true;
		}

		return collect($conditions)->every(function ($condition) use ($answers) {
			return $this->checkCondition($condition, $answers);
		});
	}

	/**
	 * Checks if a set of answers matches any of the given conditions
	 * @param array $conditions
	 * @param array $answers
	 * @return bool
	 */
	public function matchesAny(array $conditions, array $answers) : bool {

		if(!is_array($conditions) || sizeof($conditions) <= 0) {
			return true;
		}

		return collect($conditions)->contains(function ($condition) use ($answers) {
			return $this->checkCondition($condition, $answers);
		});
	}

	/**
	 * Checks a single condition against a set of answers
	 * @param array $condition
	 * @param array $answers
	 * @return mixed
	 */
	public function checkCondition(array $condition, array $answers) {

		$fieldCode = $condition[0];
		$ruleName = $condition[1];

		$fieldValue = $answers[$fieldCode];
		$rule = $this->rules[$ruleName];

		$params = array_slice($condition, 2);
		array_unshift($params, $fieldValue);

		return call_user_func_array($rule, $params);
	}


}