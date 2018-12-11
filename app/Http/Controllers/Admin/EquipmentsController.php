<?php
/**
 * rio-sgps
 * EquipmentsController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 11/10/2018, 19:29
 */

namespace SGPS\Http\Controllers\Admin;


use SGPS\Entity\Equipment;
use SGPS\Http\Controllers\Controller;

class EquipmentsController extends Controller {

	public function index() {
		$equipments = Equipment::query()->with(['sectors'])->paginate(24);
		return view('admin.equipments_index', compact('equipments'));
	}

	public function create() {
		$equipment = new Equipment();
		return view('admin.equipments_edit', compact('equipment'));
	}

	public function show(Equipment $equipment) {
		return view('admin.equipments_edit', compact('equipment'));
	}

	public function save(?Equipment $equipment = null) {
		if(!$equipment) $equipment = new Equipment();

		$equipment->fill(request()->all());
		$equipment->save();

		return redirect()->route('admin.equipments.show', [$equipment->id])
			->with('success', 'record_updated');
	}

	public function destroy(Equipment $equipment) {
		$equipment->delete();

		return redirect()->route('admin.equipments.index')
			->with('success', 'record_deleted');
	}

}