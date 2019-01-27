<?php
/**
 * rio-sgps
 * Role.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 05/09/2018, 18:59
 */

namespace SGPS\Constants;


class UserLevel {

	const ADMIN = 'admin';
	const GESTOR = 'gestor';
	const COORDENADOR = 'coordenador';
	const OPERADOR = 'operador';

	/**
	 * Map between level hierarchies.
	 * Higher levels supersede lower levels.
	 */
	const LEVEL_HIERARCHY = [
		self::OPERADOR => 1,
		self::COORDENADOR => 2,
		self::GESTOR => 3,
		self::ADMIN => 4,
	];

	/**
	 * Checks if a permission level is equal or more priviledged than another.
	 * @param string $requiredLevel The level being required.
	 * @param string $levelBeingChecked The level to test against.
	 * @return bool
	 */
	public static function check(string $requiredLevel, string $levelBeingChecked) : bool {

		if(!isset(self::LEVEL_HIERARCHY[$levelBeingChecked])) return false;
		if(!isset(self::LEVEL_HIERARCHY[$requiredLevel])) return false;

		return self::LEVEL_HIERARCHY[$levelBeingChecked] >= self::LEVEL_HIERARCHY[$requiredLevel];
	}

	/**
	 * Checks if the given user level exists
	 * @param string $level
	 * @return bool
	 */
	public static function exists(string $level) : bool {
		return isset(self::LEVEL_HIERARCHY[$level]);
	}

}