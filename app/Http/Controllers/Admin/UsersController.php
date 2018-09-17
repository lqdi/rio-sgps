<?php
/**
 * rio-sgps
 * UsersController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 17/09/2018, 19:13
 */

namespace SGPS\Http\Controllers\Admin;


use SGPS\Entity\User;
use SGPS\Http\Controllers\Controller;

class UsersController extends Controller {

	public function index() {
		$users = User::query()->paginate(24);
		return view('admin.users_index', compact('users'));
	}

	public function create() {
		$user = new User();
		return view('admin.users_edit', compact('user'));
	}

	public function show(User $user) {
		return view('admin.users_edit', compact('user'));
	}

	public function save(?User $user = null) {
		if(!$user) $user = new User();

		$user->fill(request()->all());

		if(request()->has('password') && strlen(request('password')) > 0) {
			$user->setPassword(request('password'));
		}

		$user->save();

		return redirect()->route('admin.users.show', [$user->id]);
	}

	public function destroy(User $user) {
		$user->delete();

		return redirect()->route('admin.users.index')
			->with('success', 'record_deleted');
	}

}