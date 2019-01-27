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
 * Created at: 05/09/2018, 19:02
 */

namespace SGPS\Http\Controllers\Web;


use Auth;
use SGPS\Http\Controllers\Controller;
use SGPS\Services\CerberusAuthenticationService;

class AuthController extends Controller {

	public function index() {
		return view('auth.login');
	}

	public function login() {

		$credentials = request()->only(['email', 'password']);
		$credentials['source'] = 'sgps'; // Can only login by email if user was created on SGPS. Else we cannot check validity.

		$shouldRemember = request('remember') === 'yes';

		$user = Auth::attempt($credentials, $shouldRemember);

		if(!$user) {
			return redirect()->route('auth.index')
				->with('error', 'invalid_credentials');
		}

		return redirect()->route('dashboard.post_login');
	}

	public function loginWithCerberus(CerberusAuthenticationService $service) {

		$login = request('login', '');
		$password = request('password', '');
		$shouldRemember = request('remember') === 'yes';

		try {

			$service->authenticate($login, $password, $shouldRemember);

		} catch (\Exception $ex) {
			return redirect()->route('auth.index')
				->with('error', 'invalid_credentials')
				->with('exception', $ex->getMessage());
		}

		return redirect()->route('dashboard.post_login');

	}

	public function logout() {

		Auth::logout();

		return redirect()->route('auth.index')
			->with('success', 'logged_out');
	}

}