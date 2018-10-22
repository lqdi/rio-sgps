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

	const MULTIPLE_CONDITIONS_OPERATORS = ['and', 'or'];

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
	 * @return bool
	 * @throws \Exception if the given rule does not exist in the engine.
	 */
	public function checkCondition(array $condition, array $answers) : bool {

		if(in_array($condition[0], self::MULTIPLE_CONDITIONS_OPERATORS)) {
			$operator = $condition[0];
			$conditions = array_slice($condition, 1);

			return $this->checkMultipleConditions($operator, $conditions, $answers);
		}


		$fieldCode = $condition[0];
		$ruleName = $condition[1];

		if(!method_exists($this->rules, $ruleName)) {
			throw new \Exception("Conditional rule [{$ruleName}] does not exist in the conditional engine!");
		}

		$fieldValue = $answers[$fieldCode] ?? null;

		$params = array_slice($condition, 2);
		array_unshift($params, $fieldValue);

		return call_user_func_array([$this->rules, $ruleName], $params);
	}

	/**
	 * Checks multiple conditions according to an operator string
	 * @param string $operator The operator string ("and" or "or")
	 * @param array $conditionGroups An array with one or more condition groups (sets of conditions)
	 * @param array $answers The answers grid
	 * @return bool
	 * @throws \Exception If the operator is not recognized
	 */
	public function checkMultipleConditions(string $operator, array $conditionGroups, array $answers) : bool {

		switch (trim(strtolower($operator))) {
			case 'and':
				return collect($conditionGroups)->every(function ($conditions) use ($answers) {
					return $this->matchesAll($conditions, $answers);
				});

			case 'or':
				return collect($conditionGroups)->contains(function ($conditions) use ($answers) {
					return $this->matchesAll($conditions, $answers);
				});

			default:
				throw new \Exception("Invalid multi-conditions operator: [{$operator}]");
		}

	}


}