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


use SGPS\Entity\Group;
use SGPS\Entity\User;
use SGPS\Http\Controllers\Controller;

class UsersController extends Controller {

	public function index() {
		$users = User::query()->paginate(24);
		return view('admin.users_index', compact('users'));
	}

	public function create() {
		$user = new User();
		$groups = Group::all();
		$currentGroups = [];

		return view('admin.users_edit', compact('user', 'groups', 'currentGroups'));
	}

	public function show(User $user) {
		$groups = Group::all();
		$currentGroups = $user->groups()->pluck('id')->toArray();

		return view('admin.users_edit', compact('user', 'groups', 'currentGroups'));
	}

	public function save(?User $user = null) {
		if(!$user) $user = new User();

		$user->fill(request()->all());

		if(request()->has('password') && strlen(request('password')) > 0) {
			$user->setPassword(request('password'));
		}

		$user->save();

		if(request()->has('groups')) {
			$user->groups()->sync(request('groups'));
		}

		return redirect()->route('admin.users.show', [$user->id]);
	}

	public function destroy(User $user) {
		$user->delete();

		return redirect()->route('admin.users.index')
			->with('success', 'record_deleted');
	}

}