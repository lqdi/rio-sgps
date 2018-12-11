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


use SGPS\Entity\Equipment;
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

		$groups = Group::query()->orderBy('name')->get();
		$equipments = Equipment::query()->orderBy('name')->get();

		$currentGroups = [];
		$currentEquipments = [];

		return view('admin.users_edit', compact('user', 'groups', 'equipments', 'currentGroups', 'currentEquipments'));
	}

	public function show(User $user) {
		$groups = Group::query()->orderBy('name')->get();
		$equipments = Equipment::query()->orderBy('name')->get();

		$currentGroups = $user->groups()->pluck('id')->toArray();
		$currentEquipments = $user->equipments()->pluck('id')->toArray();

		return view('admin.users_edit', compact('user', 'groups', 'equipments', 'currentGroups', 'currentEquipments'));
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

		if(request()->has('equipments')) {
			$user->equipments()->sync(request('equipments'));
		}

		return redirect()->route('admin.users.show', [$user->id])
			->with('success', 'record_updated');
	}

	public function destroy(User $user) {
		$user->delete();

		return redirect()->route('admin.users.index')
			->with('success', 'record_deleted');
	}

}