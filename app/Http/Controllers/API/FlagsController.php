<?php
/**
 * rio-sgps
 * FlagsController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/10/2018, 20:00
 */

namespace SGPS\Http\Controllers\API;


use SGPS\Entity\Flag;
use SGPS\Http\Controllers\Controller;

class FlagsController extends Controller {

	public function index() {

		$flags = Flag::all();

		return $this->api_success([
			'flags' => $flags
		]);

	}

}