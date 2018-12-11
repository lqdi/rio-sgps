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
 * Created at: 17/09/2018, 19:50
 */

namespace SGPS\Http\Controllers\Admin;


use SGPS\Entity\Flag;
use SGPS\Http\Controllers\Controller;

class FlagsController extends Controller {

	public function index() {
		$flags = Flag::query()->paginate(24);
		return view('admin.flags_index', compact('flags'));
	}

	public function create() {
		$flag = new Flag();
		return view('admin.flags_edit', compact('flag'));
	}

	public function show(Flag $flag) {
		return view('admin.flags_edit', compact('flag'));
	}

	public function save(?Flag $flag = null) {
		if(!$flag) $flag = new Flag();

		$flag->fill(request()->all());
		$flag->conditions = json_decode(request('conditions'));
		$flag->triggers = json_decode(request('triggers'));
		$flag->save();

		return redirect()->route('admin.flags.show', [$flag->id])
			->with('success', 'record_updated');
	}

	public function destroy(Flag $flag) {
		$flag->delete();

		return redirect()->route('admin.flags.index')
			->with('success', 'record_deleted');
	}

}