<?php
/**
 * rio-sgps
 * QueryAnalyser.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 26/12/2018, 14:34
 */

namespace SGPS\Diagnostics;


class QueryAnalyser {

	private $queries = [];

	public function __construct() {

	}

	public function listen() {
		\DB::listen(function ($sql) {
			array_push($this->queries, $sql->sql);
		});
	}

	public function analyseTypeCount() : array {

		return collect($this->queries)
			->map(function ($sql) {
				return ['type' => strtolower(substr($sql, 0, strpos($sql, ' ')))];
			})
			->groupBy('type')
			->map(function ($type) {
				return $type->count();
			})
			->toArray();

	}

}