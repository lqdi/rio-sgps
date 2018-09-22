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

class AuthController extends Controller {

	public function index() {
		return view('auth.login');
	}

	public function login() {

		$credentials = request()->only(['email', 'password']);
		$shouldRemember = request('remember') === 'yes';

		$user = Auth::attempt($credentials, $shouldRemember);

		if(!$user) {
			return redirect()->route('auth.index')
				->with('error', 'invalid_credentials');
		}

		return redirect()->route('dashboard.index');
	}

	public function logout() {

		Auth::logout();

		return redirect()->route('auth.index')
			->with('success', 'logged_out');
	}

}