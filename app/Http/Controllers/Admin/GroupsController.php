<?php
/**
 * rio-sgps
 * GroupsController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 17/09/2018, 19:35
 */

namespace SGPS\Http\Controllers\Admin;


use SGPS\Entity\Group;
use SGPS\Http\Controllers\Controller;

class GroupsController extends Controller {

	public function index() {
		$groups = Group::query()->paginate(24);
		return view('admin.groups_index', compact('groups'));
	}

	public function create() {
		$group = new Group();
		return view('admin.groups_edit', compact('group'));
	}

	public function show(Group $group) {
		return view('admin.groups_edit', compact('group'));
	}

	public function save(?Group $group = null) {
		if(!$group) $group = new Group();

		$group->fill(request()->all());
		$group->save();

		return redirect()->route('admin.groups.show', [$group->id])
			->with('success', 'record_updated');
	}

	public function destroy(Group $group) {
		$group->delete();

		return redirect()->route('admin.groups.index')
			->with('success', 'record_deleted');
	}

}