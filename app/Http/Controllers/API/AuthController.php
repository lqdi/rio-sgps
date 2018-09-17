<?php
/**
 * rio-sgps
 * AuthController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 17/09/2018, 18:49
 */

namespace SGPS\Http\Controllers\API;


use SGPS\Http\Controllers\Controller;

class AuthController extends Controller {

	public function authenticate() {

		$credentials = request()->only(['email', 'password']);
		$token = auth()->guard('api')->attempt($credentials);

		if(!$token) {
			return $this->api_failure('invalid_credentials', [], 401);
		}

		return $this->api_success([
			'token' => $token,
		]);
	}

	public function identity() {

		return $this->api_success([
			'user' => auth()->guard('api')->user(),
		]);

	}

}