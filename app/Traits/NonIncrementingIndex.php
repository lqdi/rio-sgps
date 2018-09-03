<?php
/**
 * NonIncrementingIndex.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 20/07/2018, 15:30
 */

namespace SGPS\Traits;


trait NonIncrementingIndex {

	public function __construct() {
		$this->incrementing = false;
		call_user_func_array(['parent','__construct'], func_get_args());
	}

}